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
        Contact::create($validated);
        // Envoyer le mail
        Mail::to(config('mail.admin_email'))->send(
            new ContactMail($validated['name'], $validated['email'], $validated['message'])
        );
        return response()->json([
            'message' => 'Votre message a été envoyé avec succès !'
        ]);
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
