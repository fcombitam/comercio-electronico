<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemsPerPage = 10;

        $search = $request->input('search');
        $status = $request->input('status');

        $query = Product::query();

        if ($status || $status == '0') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $products = $query->paginate($itemsPerPage)->appends([
            'search' => $search,
            'status' => $status,
        ])->onEachSide(2);

        return view('products.index', compact('products'));
    }

    public function export(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Product::query();

        if ($status || $status == '0') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $products = $query->get();

        return Excel::download(new ProductExport($products), 'productos.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'integer', 'max_digits:10'],
            'stock' => ['required', 'integer', 'max_digits:10'],
            'image' => ['nullable', 'image'],
            'status' => ['required', 'in:' . Product::STATUS_ACTIVE . ',' . Product::STATUS_INACTIVE],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        }

        $product = Product::create($validatedData);

        return redirect()->route('products.edit', $product->id)->with('success', 'Producto creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $sales = $product->orderItems()->whereHas('order', function ($query) {
            $query->where('status', Order::STATUS_COMPLETED);
        })->get();
        return view('products.show', compact('product', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'integer', 'max_digits:10'],
            'stock' => ['required', 'integer', 'max_digits:10'],
            'image' => ['nullable', 'image'],
            'status' => ['required', 'in:' . Product::STATUS_ACTIVE . ',' . Product::STATUS_INACTIVE],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $path;
        } else {
            $validatedData['image'] = $product->image;
        }

        $product->update($validatedData);

        return redirect()->back()->with('success', 'Producto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
