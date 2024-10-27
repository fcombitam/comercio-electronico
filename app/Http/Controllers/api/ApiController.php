<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function getToken(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 403,
                'message' => 'Informacion Invalida',
                'errors' => $validator->errors()
            ], 403);
        }

        if (!Auth::attempt($request->only('email', 'password')) || !User::where('email', $request->email)->first()) {
            return response()->json([
                'code' => '403',
                'message' => 'Informacion Invalida'
            ], 403);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        if (User::TYPE_ADMIN != $user->type) {
            return response()->json([
                'code' => 403,
                'message' => 'No tienes permisos para acceder a esta información'
            ], 403);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth-token', ['admin-logged']);

        return response()->json([
            'code' => '200',
            'message' => 'Informacion Correcta, No olvides usar este bearer token para autenticarte en las demas rutas Api,DESARROLLADO CON LARAVEL SANCTUM',
            'accessToken' => $token->plainTextToken,
            'token_type' => 'Bearer'
        ], 200);
    }

    public function getProducts(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        $products = Product::paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'code' => 200,
            'message' => 'Productos obtenidos correctamente',
            'data' => $products
        ], 200);
    }

    public function updateProduct(Request $request)
    {
        $validator = validator($request->all(), [
            'product_id' => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer'],
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'integer'],
            'stock' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 403,
                'message' => 'Información Inválida',
                'errors' => $validator->errors()
            ], 403);
        }

        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'code' => 404,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $product->update($request->only([
            'category_id',
            'name',
            'description',
            'price',
            'stock',
            'status'
        ]));

        return response()->json([
            'code' => 200,
            'message' => 'Producto actualizado correctamente',
            'data' => $product
        ], 200);
    }
}
