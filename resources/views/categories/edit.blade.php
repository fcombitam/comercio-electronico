<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalles de Categoría
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 sm:rounded-lg px-6 py-6">

                <div class="mb-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Información de la Categoría
                    </h3>
                    <p><strong>ID:</strong> {{ $category->id }}</p>
                    <p><strong>Nombre Actual:</strong> {{ $category->name }}</p>
                    <p><strong>Productos Relacionados:</strong> {{ $category->products->count() }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Productos en esta Categoría
                    </h3>
                    @if ($category->products->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">No hay productos asociados a esta categoría.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($category->products as $product)
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-md">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><a
                                            href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-400">Precio:
                                        ${{ number_format($product->price, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Editar Nombre de la
                        Categoría</h3>
                    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('POST')

                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $category->name) }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 
                                       text-white font-semibold px-4 py-2 rounded-md transition duration-200">
                                Actualizar Nombre
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
