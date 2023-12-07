<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                @if (Auth::user()->role === App\Enums\UserRole::ROLE_ADMIN)
                    <div class="grid grid-cols-3 gap-5">
                        <div class="col-span-2 h-64 bg-white shadow-md rounded-md">
                            <a href="{{ route('admin.orders.index') }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Orders') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-span-1 h-64 bg-white shadow-md rounded-md">
                            <a href="{{ route('users.index') }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Users') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-span-3 h-64 bg-white shadow-md rounded-md">
                            <a href="{{ route('user.products', ['user' => Auth::user()->id]) }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Products') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                @elseif (Auth::user()->role === App\Enums\UserRole::ROLE_SALESMAN)
                    <div class="grid grid-cols-3 gap-5">
                        <div class="col-span-2 h-64 bg-white shadow-md rounded-">
                            <a href="{{ route('salesman.orders.index') }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Orders') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-span-1 h-64 bg-white shadow-md rounded-md">
                            <a href="{{ route('user.products', ['user' => Auth::user()->id]) }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Products') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<a href="{{ route('admin.map') }}" class="fixed bottom-10 right-10 font-extrabold p-4 rounded-full bg-green-400">
    <?xml version="1.0" encoding="UTF-8"?>
    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
    <svg width="30px" height="30px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink">
        <title>analyze</title>
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="add" fill="#000000" transform="translate(42.666667, 64.000000)">
                <path
                    d="M266.666667,128 C331.468077,128 384,180.531923 384,245.333333 C384,270.026519 376.372036,292.938098 363.343919,311.840261 L423.228475,371.725253 L393.058586,401.895142 L333.173594,342.010585 C314.271431,355.038703 291.359852,362.666667 266.666667,362.666667 C201.865256,362.666667 149.333333,310.134744 149.333333,245.333333 C149.333333,180.531923 201.865256,128 266.666667,128 Z M266.666667,170.666667 C225.429405,170.666667 192,204.096072 192,245.333333 C192,286.570595 225.429405,320 266.666667,320 C307.903928,320 341.333333,286.570595 341.333333,245.333333 C341.333333,204.096072 307.903928,170.666667 266.666667,170.666667 Z M128.404239,234.665576 C128.136379,238.186376 128,241.743928 128,245.333333 C128,256.34762 129.284152,267.061976 131.710904,277.334851 L7.10542736e-15,277.333333 L7.10542736e-15,234.666667 L128.404239,234.665576 Z M85.3333333,1.42108547e-14 L85.3333333,213.333333 L21.3333333,213.333333 L21.3333333,1.42108547e-14 L85.3333333,1.42108547e-14 Z M170.666667,85.3333333 L170.663947,145.273483 C151.733734,163.440814 137.948238,186.928074 131.710904,213.331815 L106.666667,213.333333 L106.666667,85.3333333 L170.666667,85.3333333 Z M256,42.6666667 L255.999596,107.070854 C232.554315,108.854436 210.738728,116.46829 191.999452,128.465799 L192,42.6666667 L256,42.6666667 Z M341.333333,64 L341.333983,128.465865 C322.594868,116.468435 300.779487,108.854588 277.334424,107.070906 L277.333333,64 L341.333333,64 Z"
                    id="Combined-Shape">
                </path>
            </g>
        </g>
    </svg>
</a>
