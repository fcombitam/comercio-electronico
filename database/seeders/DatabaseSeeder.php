<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Usuario Administrador',
            'email' => 'admin@example.com',
            'type' => User::TYPE_ADMIN
        ]);

        $clients = User::factory()->state(['type' => User::TYPE_CLIENT])->count(30)->create();

        Category::factory()->count(10)->create();

        Product::factory()->state(['status' => Product::STATUS_ACTIVE])->count(300)->create();

        foreach ($clients as $client) {
            $orderCount = rand(1, 5);
            for ($o = 0; $o < $orderCount; $o++) {
                if ($o == 0) {
                    $order = Order::create([
                        'user_id' => $client->id,
                        'total_amount' => 0,
                        'status' => Order::STATUS_PENDING,
                    ]);
                } else {
                    $order = Order::factory()->create([
                        'user_id' => $client->id,
                        'total_amount' => 0
                    ]);
                }

                $randProducts = rand(1, 5);

                $total = 0;
                for ($p = 0; $p < $randProducts; $p++) {
                    do {
                        $product = Product::inRandomOrder()->first();
                    } while ($order->items()->where('product_id', $product->id)->exists());

                    $quantity = rand(1, 5);
                    $price = $quantity * $product->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price
                    ]);

                    $total += $price;
                }

                $order->total_amount = $total;
                $order->save();
            }
        }
    }
}
