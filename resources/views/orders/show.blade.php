<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Productos de Orden
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 sm:rounded-lg px-4 py-4">
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
                                Descripcion</th>
                            <th class="px-4 py-2">
                                Precio Unitario</th>
                            <th class="px-4 py-2">
                                Cantidad en el Pedido</th>
                            <th class="px-4 py-2">
                                Precio total</th>
                            <th class="px-4 py-2">
                                Estado</th>
                            @if (Auth::user()->type == \App\Models\User::TYPE_ADMIN)
                                <th class="px-4 py-2">
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $item->product->id }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    @if (filter_var($item->product->image, FILTER_VALIDATE_URL))
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                            class="object-cover rounded">
                                    @else
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $product->name }}" class="object-cover rounded">
                                    @endif
                                </td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $item->product->name }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $item->product->description }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    ${{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $item->quantity }}
                                </td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    ${{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    @if ($item->product->status == \App\Models\Product::STATUS_ACTIVE)
                                        Activo
                                    @elseif($item->product->status == \App\Models\Product::STATUS_INACTIVE)
                                        Inactivo
                                    @endif
                                </td>
                                @if (Auth::user()->type == \App\Models\User::TYPE_ADMIN)
                                    <td class="border px-4 py-2 text-center text-sm">
                                        <div class="flex justify-center">
                                            <a href="{{ route('products.show', $item->product->id) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white dark:bg-blue-700 dark:hover:bg-blue-800 rounded px-2 py-1 text-xs transition duration-200">
                                                Detalles
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
