<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalles del Producto: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row md:space-x-6">
                    <div class="md:w-1/3">
                        @if (filter_var($product->image, FILTER_VALIDATE_URL))
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                class="object-cover rounded h-32 mb-4"> <!-- Imagen pequeña -->
                        @else
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="object-cover rounded h-32 mb-4"> <!-- Imagen pequeña -->
                        @endif
                    </div>
                    <div class="md:w-2/3">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $product->name }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $product->description }}</p>
                        <p class="mt-2 text-gray-800 dark:text-gray-200">
                            <span class="font-semibold">Precio: </span>
                            ${{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="mt-2 text-gray-800 dark:text-gray-200">
                            <span class="font-semibold">Cantidad Disponible: </span>
                            {{ $product->stock }}
                        </p>
                        <p class="mt-2 text-gray-800 dark:text-gray-200">
                            <span class="font-semibold">Categoría: </span>
                            {{ $product->category->name }}
                        </p>
                        <p class="mt-2 text-gray-800 dark:text-gray-200">
                            <span class="font-semibold">Estado: </span>
                            {{ $product->status == \App\Models\Product::STATUS_ACTIVE ? 'Activo' : 'Inactivo' }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Ventas Activas</h4>
                    @if ($sales->isEmpty())
                        <p class="text-gray-700 dark:text-gray-300">No hay ventas activas para este producto.</p>
                    @else
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead>
                                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200">
                                    <th class="py-2 px-4 text-left">Orden ID</th>
                                    <th class="py-2 px-4 text-left">Cliente</th>
                                    <th class="py-2 px-4 text-left">Cantidad</th>
                                    <th class="py-2 px-4 text-left">Precio de Venta</th>
                                    <th class="py-2 px-4 text-left">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr class="border-b dark:border-gray-600 text-gray-600 dark:text-gray-200">
                                        <td class="py-2 px-4">
                                            <a href="{{ route('orders.show', $sale->order->id) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600 underline">
                                                {{ $sale->order->id }}
                                            </a>
                                        </td>
                                        <td class="py-2 px-4">
                                            <a href="{{ route('customers.show', $sale->order->user->id) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600 underline">
                                                {{ $sale->order->user->name }}
                                            </a>
                                        </td>
                                        <td class="py-2 px-4">{{ $sale->quantity }}</td>
                                        <td class="py-2 px-4">${{ number_format($sale->price, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4">{{ $sale->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="mt-6">
                    <a href="{{ route('products.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white rounded px-4 py-2">
                        Regresar a la lista de productos
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
