<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full flex flex-row">
            <div class="basis-2/3 sm:px-6 lg:px-8">
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="w-full h-full">
                            @if (strpos($product->photo, 'https://via.placeholder.com/') === 0)
                                <img src="{{ $product->photo }}" alt="Card image">
                            @else
                                <img src="{{ asset($product->photo) }}" alt="Card image">
                            @endif
                        </div>
                        <div class="w-full justify-items-center">

                            <input type="hidden" name="id" value="{{ $product->id }}" />

                            <div class="font-bold text-5xl mb-4">{{ $product->name }}</div>

                            <div class="grid grid-cols-3">
                                <div class="border-r-2 border-gray-500 text-gray-500 text-base mb-4">
                                    <p class="text-center">{{ __('product.show.ratePoint') }}</p>
                                    <div class="text-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if($i < $product->rate)
                                                <i class="fa fa-solid fa-star text-yellow-500"></i>
                                            @elseif($i > $product->rate && $i - 1 < $product->rate)
                                                <i class="fa fa-solid fa-star-half-stroke text-yellow-500"></i>
                                            @else
                                                <i class="fa fa-regular fa-star text-yellow-500"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="border-r-2 border-gray-500 text-gray-500 text-base mb-4">
                                    <p class="text-center">{{ __('product.show.comment') }}</p>
                                    <p class="text-center">{{ $product->review }}</p>
                                </div>
                                <div class="text-gray-500 text-base mb-4">
                                    <p class="text-center">{{ __('product.show.sold') }}</p>
                                    <p class="text-center">{{ $product->number_of_purchase }}</p>
                                </div>
                            </div>

                            <div class="font-bold text-5xl text-red-600 mb-4">{{ $product->price }} $</div>

                            <div>
                                <div class="font-bold text-xl mb-4">{{ __('product.show.description') }}</div>
                                <div class="w-full h-32 bg-gray-200 text-gray-700 rounded-l border-2 border-gray-300 p-4 ">
                                    {{ $product->description }}
                                </div>
                            </div>

                            <div class="flex items-center mt-4">
                                <div class="text-gray-500 text-base mr-2">{{ __('product.show.quantity') }}</div>

                                <button type="button" class="minus-btn w-1/12 p-1 bg-gray-300 hover:bg-gray-400 rounded-l">
                                    <span class="text-sm font-semibold">-</span>
                                </button>
                                <input name="quantity" data-max="{{ $product->number_in_stock }}" type="text"
                                    class="quantity-input w-1/6 text-center border border-gray-300 px-2 py-1" value="1" readonly>
                                <button type="button" class="plus-btn w-1/12 p-1 bg-gray-300 hover:bg-gray-400 rounded-r">
                                    <span class="text-sm font-semibold">+</span>
                                </button>

                                <div class="text-gray-500 text-base ml-2">{{ __('product.show.outOff') }}{{ $product->number_in_stock }}{{ __('product.show.productAvailable') }}</div>
                            </div>

                            <div class="w-full">
                                <button id="addToCartBtn" type="submit" class="px-6 mt-2 container p-2 bg-red-200 h-12 border-2 border-red-400">
                                    <i class="fa fa-cart-plus"></i>
                                    {{ __('product.show.addCart') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mt-12 bg-white p-4 rounded">
                    <div class="font-bold text-2xl mb-8">{{ __('product.show.comment') }}</div>
                    <form method="post" action="{{ route('product.review.store', ['id' => $product->id]) }}" class="flex space-x-4 pb-4">
                        @csrf    
                        <img class="w-8 h-8" src="https://cdn-icons-png.flaticon.com/512/64/64572.png" alt="user profile">
                        <div class="flex flex-col w-full">
                            <input class="w-full border-0 focus:shadow-none border-b-2 border-gray-400" type="text" name="review" placeholder="{{ __('product.show.comment') }}"/>
                            <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
                            <div class="mt-2 flex justify-between items-center">
                                <div id="ratingStars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-regular fa-star text-yellow-500"></i>
                                    @endfor
                                </div>
                                <button type="submit" class="rounded px-4 bg-blue-400 h-12">
                                    {{ __('product.show.comment') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @foreach ($reviews as $index => $review)
                        <div class="flex space-x-4 p-4 border-t border-gray-200">
                            <img class="w-8 h-8" src="https://cdn-icons-png.flaticon.com/512/64/64572.png" alt="user profile">
                            <div class="flex flex-col">
                                <div class="text-xl font-bold">{{ $review->user->username }}</div>
                                <div class="text-base text-gray-500">{{ __('product.show.qualityRating') }}
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($i > $review->rate)
                                            <i class="fa fa-regular fa-star text-yellow-500"></i>
                                        @else
                                            <i class="fa fa-solid fa-star text-yellow-500"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="mt-4 text-base pr-4 mb-4">{{ $review->content }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($sameUserProducts->isEmpty())
                <div class="text-xl text-gray-500">{{ __('product.show.message') }}</div>
            @else
                <div class="flex flex-col basis-1/3">
                    @foreach ($sameUserProducts as $index => $sameUserProduct)
                        <a href="{{ route('products.show', ['product' => $sameUserProduct->id]) }}">
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf

                                <div class="w-screen-1280 h-32 mr-8 p-4 bg-white mb-4 shadow-lg flex justify-between">
                                    <div class="flex">
                                        <div class="flex items-center">
                                            @if (strpos($sameUserProduct->photo, 'https://via.placeholder.com/') === 0)
                                                <img class="w-28 h-28 mb-2" src="{{ $sameUserProduct->photo }}" alt="Card image">
                                            @else
                                                <img class="w-28 h-28 mb-2" src="{{ asset($sameUserProduct->photo) }}" alt="Card image">
                                            @endif
                                        </div>
                                        <div class="ml-4 flex flex-col justify-between">
                                            <input type="hidden" name="id" value="{{ $sameUserProduct->id }}" />
                                            <div class="flex justify-between items-center">
                                                <div class="text-xl font-bold">{{ $sameUserProduct->name }}</div>
                                                <div class="text-3xl text-red-600 font-bold">{{ $sameUserProduct->price }} $</div>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="max-h-14 text-ellipsis overflow-hidden text-sm text-gray-500 mr-2">{{ $sameUserProduct->description }}</div>
                                                <button class="rounded-full h-10 bg-blue-300 hover:bg-blue-400" type="submit">
                                                    <i class="fa fa-cart-plus w-10"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="px-6 mb-4" type="submit">
                                        <i class="fa fa-cart-plus"></i>
                                    </button>
                                </div>
                            </form>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- Handle star -->
    <script>
        const ratingStars = document.getElementById('ratingStars');
        const stars = ratingStars.getElementsByTagName('i');
        let selectedRating = 0;

        for (let i = 0; i < stars.length; i++) {
            stars[i].addEventListener('click', function() {
                // Đặt class fa-solid cho thẻ được click và thẻ trước đó
                for (let j = 0; j <= i; j++) {
                    stars[j].classList.remove('fa-regular');
                    stars[j].classList.add('fa-solid');
                }
                // Đặt class fa-regular cho các thẻ sau đó
                for (let j = i + 1; j < stars.length; j++) {
                    stars[j].classList.remove('fa-solid');
                    stars[j].classList.add('fa-regular');
                }
                // Lưu giá trị rate
                selectedRating = i + 1;
                document.getElementById('rating').value = selectedRating;
            });
        }
    </script>
</x-app-layout>
