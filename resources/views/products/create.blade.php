<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Producto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 sm:rounded-lg px-6 py-6 shadow-md">
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 dark:text-gray-100">Categoría</label>
                        <select name="category_id" id="category_id"
                            class="border rounded px-3 py-2 w-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                            <option value="">Seleccionar categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-100">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="border rounded px-3 py-2 w-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 dark:text-gray-100">Descripción</label>
                        <textarea name="description" id="description" rows="4"
                            class="border rounded px-3 py-2 w-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 dark:text-gray-100">Precio</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                            class="border rounded px-3 py-2 w-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        @error('price')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="stock" class="block text-gray-700 dark:text-gray-100">Cantidad en Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                            class="border rounded px-3 py-2 w-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        @error('stock')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 dark:text-gray-100">Imagen</label>
                        <input type="file" name="image" id="image"
                            class="border rounded px-3 py-2 w-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        @error('image')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 dark:text-gray-100">Estado</label>
                        <select name="status" id="status"
                            class="border rounded px-3 py-2 w-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                            <option value="{{ \App\Models\Product::STATUS_ACTIVE }}">Activo</option>
                            <option value="{{ \App\Models\Product::STATUS_INACTIVE }}">Inactivo</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Crear Producto</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
