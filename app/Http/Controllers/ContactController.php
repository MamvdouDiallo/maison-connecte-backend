<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return Contact::with('user')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name'    => 'required',
            'email'   => 'required|email',
            'message' => 'required',
        ]);

        return Contact::create($data);
    }

    public function show(Contact $contact)
    {
        return $contact->load('user');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return ['message' => 'Deleted'];
    }
}
