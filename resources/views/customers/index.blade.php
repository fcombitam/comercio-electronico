<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 sm:rounded-lg px-4 py-4">
                <div class="flex justify-between mb-4 ">
                    <div>
                        <form method="GET" action="{{ route('customers.index') }}">
                            <input type="text" name="search" placeholder="Buscar"
                                class="border rounded px-3 py-2 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="bg-blue-500 dark:bg-gray-900 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Buscar</button>
                            <a href="{{ route('customers.index') }}"
                                class="bg-gray-500 dark:bg-gray-700 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Limpiar
                                filtros</a>

                            <a href="{{ route('customers.export', request()->only('search')) }}"
                                class="bg-green-500 dark:bg-green-700 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Exportar
                                Excel</a>
                        </form>
                    </div>
                </div>
                <table class="table-auto w-full text-sm">
                    <thead>
                        <tr class="text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900">
                            <th class="px-4 py-2">
                                ID</th>
                            <th class="px-4 py-2 w-40">
                                Nombre</th>
                            <th class="px-4 py-2">
                                Correo</th>
                            <th class="px-4 py-2">
                                Fecha de Registro</th>
                            <th class="px-4 py-2">
                                Ordenes Completadas</th>
                            <th class="px-4 py-2">
                                Total Comprado</th>
                            <th class="px-4 py-2">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $customer->id }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $customer->name }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $customer->email }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $customer->created_at->format('d M Y') }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    {{ $customer->orders()->whereStatus(\App\Models\Order::STATUS_COMPLETED)->count() }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">
                                    ${{ number_format($customer->orders()->whereStatus(\App\Models\Order::STATUS_COMPLETED)->sum('total_amount'), 0, ',', '.') }}
                                </td>
                                <td class="border px-4 py-2 text-center text-sm">
                                    <div class="flex flex-col items-center space-y-2">
                                        <a href="{{ route('customers.show', $customer->id) }}"
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
                    {{ $customers->onEachSide(2)->links() }}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
