<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ordenes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 sm:rounded-lg px-4 py-4">
                <div class="flex justify-between mb-4 ">
                    <div>
                        @if (Auth::user()->type == \App\Models\User::TYPE_ADMIN)
                            <form method="GET" action="{{ route('orders.index') }}">
                                <input type="text" name="search" placeholder="Buscar"
                                    class="border rounded px-3 py-2 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
                                    value="{{ request('search') }}">
                                <select name="status"
                                    class="border rounded px-3 py-2 ml-2 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                    <option value="">Seleccionar estado</option>
                                    <option value="{{ \App\Models\Order::STATUS_PENDING }}"
                                        {{ request('status') == \App\Models\Order::STATUS_PENDING ? 'selected' : '' }}>
                                        Pendiente</option>
                                    <option value="{{ \App\Models\Order::STATUS_COMPLETED }}"
                                        {{ request('status') == \App\Models\Order::STATUS_COMPLETED ? 'selected' : '' }}>
                                        Completado</option>
                                    <option value="{{ \App\Models\Order::STATUS_CANCELLED }}"
                                        {{ request('status') == \App\Models\Order::STATUS_CANCELLED ? 'selected' : '' }}>
                                        Cancelado</option>
                                </select>
                                <button type="submit"
                                    class="bg-blue-500 dark:bg-gray-900 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Buscar</button>
                                <a href="{{ route('orders.index') }}"
                                    class="bg-gray-500 dark:bg-gray-700 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Limpiar
                                    filtros</a>
                                <a href="{{ route('orders.export', request()->only('search', 'status')) }}"
                                    class="bg-green-500 dark:bg-green-700 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Exportar
                                    Excel</a>
                            </form>
                        @else
                            <a href="{{ route('orders.export', request()->only('search', 'status')) }}"
                                class="bg-green-500 dark:bg-green-700 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Exportar
                                Excel</a>
                        @endif
                    </div>
                </div>
                <table class="table-auto w-full text-sm">
                    <thead>
                        <tr class="text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900">
                            <th class="px-4 py-2">
                                ID</th>
                            <th class="px-4 py-2">
                                Nombre</th>
                            <th class="px-4 py-2">
                                Correo</th>
                            <th class="px-4 py-2">
                                Cantidad de Ítems</th>
                            <th class="px-4 py-2">
                                Total de Orden</th>
                            <th class="px-4 py-2">
                                Fecha de Última Actualización</th>
                            <th class="px-4 py-2">
                                Estado</th>
                            <th class="px-4 py-2">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $order->id }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $order->user->name }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $order->user->email }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $order->items->count() }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    ${{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $order->updated_at->format('Y M d') }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    @if ($order->status == \App\Models\Order::STATUS_PENDING)
                                        Pendiente
                                    @elseif($order->status == \App\Models\Order::STATUS_CANCELLED)
                                        Cancelada
                                    @elseif($order->status == \App\Models\Order::STATUS_COMPLETED)
                                        Completada
                                    @endif
                                </td>
                                <td class="border px-4 py-2 text-center text-sm">
                                    <div class="flex justify-center">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white dark:bg-blue-700 dark:hover:bg-blue-800 rounded px-2 py-1 text-xs transition duration-200">
                                            Detalles
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $orders->onEachSide(2)->links() }}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
