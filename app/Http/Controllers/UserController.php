<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Location;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    const DEFAULT_LIMIT = 10;

    public function __construct()
    {
        $this->middleware(['auth', 'checkAdmin'], ['only' => ['index', 'create', 'store']]);
    }

    public function index(Request $request)
    {
        $page = $request->input('page');
        $users = User::orderBy('created_at', 'desc')->paginate(self::DEFAULT_LIMIT, ['*'], 'page', $page ?? 1);

        return view('users.index')->with('users', $users);
    }

    public function showUserProducts(User $user, Request $request)
    {
        $page = $request->input('page');

        if ($user->role === UserRole::ROLE_ADMIN) {
            $products = DB::table('products')->where('number_in_stock', '>', '-1')
                ->orderBy('id', 'desc')
                ->paginate(config('app.pagination.per_page'));
        } else if ($user->role === UserRole::ROLE_SALESMAN) {
            $storeId = $user->store->id;
            $products = DB::table('products')
                ->where('store_id', '=', $storeId)
                ->where('number_in_stock', '>', '-1')
                ->orderBy('id')->paginate(self::DEFAULT_LIMIT);
        }

        return view('users.products')->with('products', $products);
    }

    public function create(Request $request)
    {
        $defaultRole = $request->input('role');
        $defaultRole = Str::upper($defaultRole);
        if (!UserRole::isContain($defaultRole)) {
            $defaultRole = UserRole::ROLE_USER;
        }

        return view('users.create')->with('selectedRole', $defaultRole);
    }

    public function store(CreateUserRequest $request)
    {
        $user = new User;
        $validated = $request->validated();
        $user->fullName = $validated['fullname'];
        $user->email = $validated['email'];
        $user->username = $validated['username'];
        $user->password = bcrypt($validated['password']);
        $user->role = $validated['role'];
        $user->is_active = true;

        $user->save();

        if ($user->role == UserRole::ROLE_SALESMAN) {
            $coordinates = new Point(explode(',', $validated['location'])[0], explode(',', $validated['location'])[1]);
            $location = Location::create(['detail' => $validated['address'], 'coordinates' => $coordinates]);
            $store = Store::create(['name' => $validated['name'], 'location_id' => $location->id, 'owner_id' => $user->id]);
            $location->save();
            $store->save();
        }

        return redirect()->route('users.index')->with('success', trans('user.store.success'));
    }

    public function show(User $user)
    {
        $user->load('contacts');
        $orders = Order::whereIn('contact_id', $user->contacts->pluck('id'))->with('orderItems')->get();

        return view('users.show')->with('user', $user)->with('orders', $orders);
    }

    public function edit(User $user)
    {
        return view('users.edit')->with('user', $user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->fill($validated);
        $user->save();

        return redirect()->route('users.show', ['user' => $user->id])->with('success', trans('user.update.success'));
    }

    public function destroy(DeleteUserRequest $request, User $user)
    {
        DB::transaction(function () use ($user) {
            $user->load('contacts');
            $user->contacts()->delete();
            $user->delete();
        });

        return redirect()->route('users.index')->with('success', trans('user.destroy.success'));
    }
}
