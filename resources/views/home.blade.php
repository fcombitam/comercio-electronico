<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($categories as $category)
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200 mb-4">
                        {{ $category->name }}
                    </h3>

                    <div class="swiper multiple-slide-carousel">
                        <div class="swiper-wrapper">
                            @foreach ($category->products as $product)
                                <div class="swiper-slide">
                                    <div
                                        class="bg-indigo-50 dark:bg-gray-800 rounded-2xl flex flex-col items-center p-4">
                                        @if (filter_var($product->image, FILTER_VALIDATE_URL))
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                                class="w-full object-cover rounded-md mb-2">
                                        @else
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="w-full object-cover rounded-md mb-2">
                                        @endif
                                        <h4
                                            class="mt-2 text-sm font-semibold text-gray-800 dark:text-gray-200 text-center">
                                            {{ $product->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                                            ${{ number_format($product->price, 0, ',', '.') }}</p>
                                        <h4
                                            class="mt-2 text-sm font-semibold text-gray-800 dark:text-gray-200 text-center">
                                            Disponibles: {{ $product->stock }}</h4>
                                        <a href="{{ route('product.detail', $product->id) }}"
                                            class="mt-4 inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>

    <script>
        const swiper = new Swiper('.multiple-slide-carousel', {
            slidesPerView: 3,
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
    </script>
</x-app-layout>
