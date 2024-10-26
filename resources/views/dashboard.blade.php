<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Productos Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                        Productos
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ $productCount }} productos disponibles.
                    </p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Ver Productos
                    </a>
                </div>

                <!-- Clientes Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                        Clientes
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ $clientCount }} clientes registrados.
                    </p>
                    <a href="{{ route('customers.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Ver Clientes
                    </a>
                </div>

                <!-- Órdenes Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                        Órdenes
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ $orderCount }} órdenes realizadas.
                    </p>
                    <a href="{{ route('orders.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Ver Órdenes
                    </a>
                </div>

                <!-- Artículos de Órdenes Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                        Artículos de Órdenes
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ $orderItemCount }} artículos en órdenes.
                    </p>
                </div>

                <!-- Categorías Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                        Categorías
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ $categoryCount }} categorías disponibles.
                    </p>
                    <a href="{{ route('categories.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Ver Categorías
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
