<x-app-layout>
    <div class='py-8'>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <x-slot name='header' class="text-2xl font-semibold mb-4">{{ __('cart.show.title') }}</x-slot>

                <div class="bg-white p-4 shadow-md rounded-md mb-4">
                    <table class="cart-table w-full">
                        <thead>
                            <tr>
                                <th class="py-2">{{ __('cart.Product') }}</th>
                                <th class="py-2">{{ __('cart.Price') }}</th>
                                <th class="py-2">{{ __('cart.Quantity') }}</th>
                                <th class="py-2">{{ __('cart.Total') }}</th>
                                <th class="py-2">{{ __('cart.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through cart items -->
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td class="py-2 text-center"><a
                                        href="{{ route('products.show', $item->product_id) }}">{{ $item->product->name }}</a>
                                    </td>

                                    <td class="py-2 text-center">
                                        {{ formatCurrency($item->product->price) }}
                                    </td>
                                    <form action="{{ route('cart.update', ['cart' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <td class="py-2 text-center">
                                            <button class="minus-btn w-1/12 p-1 bg-gray-300 hover:bg-gray-400 rounded-l">
                                                <span class="text-sm font-semibold">-</span>
                                            </button>
                                            <input name="quantity" data-max="{{ $item->product->number_in_stock }}" type="text"
                                                class="quantity-input w-1/5 text-center border border-gray-300 px-2 py-1" value="{{ $item->quantity }}" readonly>
                                            <button class="plus-btn w-1/12 p-1 bg-gray-300 hover:bg-gray-400 rounded-r">
                                                <span class="text-sm font-semibold">+</span>
                                            </button>
                                        </td>
                                    </form>

                                    <td class="py-2 text-center">
                                        {{ formatCurrency($item->total_price) }}
                                    </td>

                                    <form method="POST" action="{{ route('cart.destroy', ['cart' => $item->id]) }}" class="button delete">
                                        @csrf
                                        @method('DELETE')

                                        <td class="py-2 text-center">
                                            <button class="text-red-500 hover:text-red-700">{{ __('Remove') }}</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class='p-4 pt-0 rounded-md'>
                    <div class="text-right">
                        <strong>{{ __('Total') }}:
                            {{ formatCurrency($cartItems->sum('total_price')) }}
                        </strong>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('orders.create') }}"
                            class="button edit @if ($cartItems->count() <= 0) disabled @endif">
                            {{ __('Checkout') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
