<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalles del Cliente: {{ $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg px-6 py-6">
                <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Información del Cliente</h3>
                <ul class="mb-6 text-gray-700 dark:text-gray-300">
                    <li><strong>Nombre:</strong> {{ $customer->name }}</li>
                    <li><strong>Email:</strong> {{ $customer->email }}</li>
                    <li><strong>Fecha de Registro:</strong> {{ $customer->created_at->format('d M Y') }}</li>
                </ul>

                <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-4">Órdenes del Cliente</h3>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-900">
                            <th class="p-3">ID Orden</th>
                            <th class="p-3">Fecha</th>
                            <th class="p-3">Estado</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b dark:border-gray-600 text-gray-700 dark:text-gray-300">
                                <td class="p-3">{{ $order->id }}</td>
                                <td class="p-3">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="p-3">
                                    @if($order->status == \App\Models\Order::STATUS_COMPLETED)
                                        <span class="text-green-600">Completada</span>
                                    @elseif($order->status == \App\Models\Order::STATUS_CANCELLED)
                                        <span class="text-red-600">Cancelada</span>
                                    @else
                                        <span class="text-yellow-600">Pendiente</span>
                                    @endif
                                </td>
                                <td class="p-3">${{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <button onclick="toggleOrderDetails({{ $order->id }})"
                                        class="bg-blue-500 hover:bg-blue-600 text-white rounded px-2 py-1 text-sm">
                                        Ver Detalles
                                    </button>
                                </td>
                            </tr>
                            <tr id="order-details-{{ $order->id }}" class="hidden">
                                <td colspan="5" class="bg-gray-50 dark:bg-gray-700">
                                    <table class="w-full mt-2 mb-4 text-sm">
                                        <thead>
                                            <tr class="text-left text-gray-700 dark:text-gray-300">
                                                <th class="p-3">Producto</th>
                                                <th class="p-3">Precio al momento</th>
                                                <th class="p-3">Cantidad</th>
                                                <th class="p-3">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                                <tr class="border-b dark:border-gray-600 text-gray-800 dark:text-gray-200">
                                                    <td class="p-3">{{ $item->product->name }}</td>
                                                    <td class="p-3">${{ number_format($item->price, 0, ',', '.') }}</td>
                                                    <td class="p-3">{{ $item->quantity }}</td>
                                                    <td class="p-3">${{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleOrderDetails(orderId) {
            const detailsRow = document.getElementById(`order-details-${orderId}`);
            detailsRow.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
