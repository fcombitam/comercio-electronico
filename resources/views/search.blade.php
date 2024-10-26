<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Resultados de la Búsqueda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    {{ __('Volver a Inicio') }}
                </a>
            </div>

            @if ($products->isEmpty())
                <p class="text-center text-gray-600 dark:text-gray-400">{{ __('No se encontraron productos.') }}</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-indigo-50 dark:bg-gray-800 rounded-2xl flex flex-col items-center p-4">
                            @if (filter_var($product->image, FILTER_VALIDATE_URL))
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                    class="w-full object-cover rounded-md mb-2">
                            @else
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full object-cover rounded-md mb-2">
                            @endif
                            <h4 class="mt-2 text-sm font-semibold text-gray-800 dark:text-gray-200 text-center">
                                {{ $product->name }}
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                                ${{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <h4 class="mt-2 text-sm font-semibold text-gray-800 dark:text-gray-200 text-center">
                                Disponibles: {{ $product->stock }}
                            </h4>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                Categoría: {{ $product->category->name }}
                            </p>
                            <a href="{{ route('product.detail', $product->id) }}"
                                class="mt-4 inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Ver Detalles
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
