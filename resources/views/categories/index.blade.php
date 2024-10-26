<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Categorías
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 sm:rounded-lg px-4 py-4">
                <div class="flex justify-between mb-4">
                    <div>
                        <form method="GET" action="{{ route('categories.index') }}">
                            <input type="text" name="search" placeholder="Buscar"
                                class="border rounded px-3 py-2 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="bg-blue-500 dark:bg-gray-900 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Buscar</button>
                            <a href="{{ route('categories.index') }}"
                                class="bg-gray-500 dark:bg-gray-700 dark:text-gray-100 text-white rounded px-4 py-2 ml-2">Limpiar
                                filtros</a>
                        </form>
                    </div>

                    <button id="openModal" class="bg-green-500 dark:bg-green-700 text-white px-4 py-2 rounded">
                        Crear Categoría
                    </button>
                </div>

                <table class="table-auto w-full text-sm">
                    <thead>
                        <tr class="text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2 w-40">Nombre</th>
                            <th class="px-4 py-2">Productos Relacionados</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">{{ $category->id }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">{{ $category->name }}</td>
                                <td class="border px-4 py-2 text-center text-sm text-gray-800 dark:text-gray-200">{{ $category->products->count() }}</td>
                                <td class="border px-4 py-2 text-center text-sm">
                                    <div class="flex flex-col items-center space-y-2">
                                        <a href="{{ route('categories.edit', $category->id) }}"
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
                    {{ $categories->onEachSide(2)->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="modal" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl max-w-md w-full">
            <div class="px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Crear Nueva Categoría</h3>
                <form method="POST" action="{{ route('categories.store') }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de la Categoría</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="closeModal" class="bg-gray-500 dark:bg-gray-700 text-white font-semibold px-4 py-2 rounded-md mr-2">Cancelar</button>
                        <button type="submit" class="bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white font-semibold px-4 py-2 rounded-md transition duration-200">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('modal').classList.add('hidden');
        });
    </script>
</x-app-layout>
