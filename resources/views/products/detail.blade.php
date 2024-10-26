<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 mb-4 md:mb-0">
                        @if (filter_var($product->image, FILTER_VALIDATE_URL))
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                class="w-full object-cover rounded-md">
                        @else
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full object-cover rounded-md">
                        @endif
                    </div>
                    <div class="md:w-2/3 md:pl-6">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $product->name }}</h3>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                            Stock: <span class="font-semibold">{{ $product->stock }}</span>
                        </p>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                            Descripción: <span class="font-semibold">{{ $product->description }}</span>
                        </p>
                        <p class="text-lg text-gray-800 dark:text-gray-200 mt-4">
                            Precio: ${{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        @auth
                            @if (!$validate)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    <label for="quantity"
                                        class="block text-gray-600 dark:text-gray-400 mb-2">Cantidad</label>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                                        max="{{ $product->stock }}"
                                        class="w-20 p-2 border border-gray-300 rounded-md text-center dark:bg-gray-700 dark:border-gray-600">

                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150 ml-4">
                                        Agregar al Carrito
                                    </button>
                                </form>
                            @else
                                <div class="mt-4">
                                    <a href="{{ url('/cart') }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150 ml-4">
                                        Ya hace parte de tu carrito
                                    </a>
                                </div>
                            @endif
                        @else
                            <button onclick="alert('Por favor, inicia sesión para agregar productos al carrito.')"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150">
                                Agregar al Carrito
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
