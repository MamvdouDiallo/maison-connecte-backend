<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Pack;
use App\Models\User;

class OrderController extends Controller
{
    // Liste toutes les commandes avec leurs relations
    public function index()
    {
        return Order::with('items.product', 'items.pack', 'user')->get();
    }

    // Crée une nouvelle commande
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'string',
            'items' => 'required|array',
        ]);

        $order = Order::create([
            'user_id' => $data['user_id'],
            'status' => $data['status'] ?? 'pending',
            'total_amount' => 0,
        ]);

        $total = 0;

        foreach ($data['items'] as $item) {
            $orderItem = $order->items()->create([
                'product_id' => $item['product_id'] ?? null,
                'pack_id' => $item['pack_id'] ?? null,
                'quantity' => $item['quantity'] ?? 1,
                'price' => $item['price'] ?? 0,
            ]);

            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        $order->update(['total_amount' => $total]);

        return $order->load('items.product', 'items.pack', 'user');
    }

    // Détails d’une commande
    public function show(Order $order)
    {
        return $order->load('items.product', 'items.pack', 'user');
    }

    // Met à jour le statut d’une commande
    public function update(Request $request, Order $order)
    {
        $order->update($request->only('status'));
        return $order;
    }

    // Supprime une commande
    public function destroy(Order $order)
    {
        $order->delete();
        return ['message' => 'Deleted'];
    }
}