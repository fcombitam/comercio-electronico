<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Carrito de Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                @if ($cart && $cart->items->isNotEmpty())
                    <div class="mb-8 p-4 bg-gray-200 dark:bg-gray-700 rounded-lg text-right">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                            Total del Carrito: ${{ number_format($cart->total_amount, 0, ',', '.') }}
                        </h3>
                        <div class="mt-4 flex justify-end gap-4">
                            <form action="{{ route('cart.purchase') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Comprar Carrito
                                </button>
                            </form>
                            <form action="{{ route('cart.delete') }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Eliminar Carrito
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($cart->items as $item)
                            <div class="border rounded-lg p-4 bg-gray-100 dark:bg-gray-900">
                                <div class="flex flex-col items-center">
                                    @if (filter_var($item->product->image, FILTER_VALIDATE_URL))
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                            class="w-full object-cover rounded-md mb-4">
                                    @else
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-full object-cover rounded-md mb-4">
                                    @endif
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                        {{ $item->product->name }}
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Cantidad: {{ $item->quantity }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Precio: ${{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-sm text-gray-800 dark:text-gray-200 font-semibold mt-2">
                                        Subtotal: ${{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </p>

                                    <form action="{{ route('cart.remove', $item->product->id) }}" method="POST" class="mt-4">
                                        @csrf
                                        @method('POST')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            Eliminar Ítem
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-gray-800 dark:text-gray-200 py-12">
                        <h3 class="text-2xl font-semibold">Tu carrito está vacío.</h3>
                        <p class="mt-4">Agrega productos al carrito para proceder con la compra.</p>
                        <a href="/"
                            class="mt-6 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Ir a Productos
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
