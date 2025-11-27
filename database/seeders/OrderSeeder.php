<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     //
    // }
    public function run()
    {
        $orders = Order::factory(10)->create();

        foreach ($orders as $order) {
            OrderItem::factory(rand(1, 4))->create([
                'order_id' => $order->id,
            ]);
        }
    }
}
