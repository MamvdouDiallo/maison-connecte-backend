<?php

namespace App\Http\Controllers;

class QuoteController extends Controller
{
    public function index()
    {
        return Quote::with('service', 'user')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'custom_request' => 'nullable',
            'status' => 'string',
        ]);

        return Quote::create($data);
    }

    public function show(Quote $quote)
    {
        return $quote->load('user', 'service');
    }

    public function update(Request $request, Quote $quote)
    {
        $data = $request->validate([
            'status' => 'string',
        ]);

        $quote->update($data);
        return $quote;
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return ['message' => 'Deleted'];
    }
}
