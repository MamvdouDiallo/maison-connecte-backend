<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Commande;
use App\Mail\CommandeAdminNotification;
use App\Mail\CommandeClientConfirmation;

class CommandeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'phone'             => 'required|string|max:50',
            'message'           => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.title'     => 'required|string',
            'items.*.price'     => 'required|string',
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.lineTotal' => 'required|string',
            'total'             => 'required|string',
        ]);

        $commande = Commande::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'phone'   => $validated['phone'],
            'message' => $validated['message'] ?? null,
            'total'   => $validated['total'],
        ]);

        foreach ($validated['items'] as $item) {
            $commande->items()->create([
                'title'      => $item['title'],
                'price'      => $item['price'],
                'quantity'   => $item['quantity'],
                'line_total' => $item['lineTotal'],
            ]);
        }

        $commande->load('items');

        $adminAddress = config('mail.admin_address');
        if ($adminAddress) {
            Mail::to($adminAddress)->send(new CommandeAdminNotification($commande));
        }

        Mail::to($commande->email)->send(new CommandeClientConfirmation($commande));

        return response()->json([
            'success' => true,
            'message' => 'Commande enregistrée',
        ], 201);
    }
}
