<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Productos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 sm:rounded-lg px-4 py-4">
                <div class="flex justify-between mb-4 ">
                    <div>
                        <form method="GET" action="{{ route('products.index') }}">
                            <input type="text" name="search" placeholder="Buscar"
                                class="border rounded px-3 py-2 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
                                value="{{ request('search') }}">
                            <select name="status"
                                class="border rounded px-3 py-2 ml-2 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                <option value="">Seleccionar estado</option>
                                <option value="{{ \App\Models\Product::STATUS_ACTIVE }}"
                                    {{ request('status') == \App\Models\Product::STATUS_ACTIVE ? 'selected' : '' }}>
                                    Activos</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                    Inactivos</option>
                            </select>
                            <button type="submit"
                                class="bg-blue-500 dark:bg-gray-900 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Buscar</button>
                            <a href="{{ route('products.index') }}"
                                class="bg-gray-500 dark:bg-gray-700 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Limpiar
                                filtros</a>

                            <a href="{{ route('products.export', request()->only('search', 'status')) }}"
                                class="bg-green-500 dark:bg-green-700 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Exportar
                                Excel</a>
                        </form>
                    </div>
                    <div>
                        <a href="{{ route('products.create') }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white dark:bg-blue-700 dark:hover:bg-blue-800 rounded px-4 py-2">Crear
                            Producto</a>
                    </div>
                </div>
                <table class="table-auto w-full text-sm">
                    <thead>
                        <tr class="text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900">
                            <th class="px-4 py-2">
                                ID</th>
                            <th class="px-4 py-2 w-40">
                                Imagen</th>
                            <th class="px-4 py-2">
                                Nombre</th>
                            <th class="px-4 py-2">
                                Categoria</th>
                            <th class="px-4 py-2">
                                Descripcion</th>
                            <th class="px-4 py-2">
                                Precio Unitario</th>
                            <th class="px-4 py-2">
                                Cantidad Disponible</th>
                            <th class="px-4 py-2">
                                Estado</th>
                            <th class="px-4 py-2">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $product->id }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    @if (filter_var($product->image, FILTER_VALIDATE_URL))
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                            class="object-cover rounded">
                                    @else
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}" class="object-cover rounded">
                                    @endif
                                </td>

                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $product->name }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $product->category->name }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $product->description }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $product->stock }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    @if ($product->status == \App\Models\Product::STATUS_ACTIVE)
                                        Activo
                                    @elseif($product->status == \App\Models\Product::STATUS_INACTIVE)
                                        Inactivo
                                    @endif
                                </td>
                                <td class="border px-4 py-2 text-center text-sm">
                                    <div class="flex flex-col items-center space-y-2">
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white dark:bg-blue-700 dark:hover:bg-blue-800 rounded px-2 py-1 text-xs transition duration-200">
                                            Detalles
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="bg-green-500 hover:bg-green-600 text-white dark:bg-green-700 dark:hover:bg-green-800 rounded px-2 py-1 text-xs transition duration-200">
                                            Editar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $products->onEachSide(2)->links() }}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
