<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Mail\ContactClientConfirmation;

class ContactController extends Controller
{
    public function index()
    {
        return Contact::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($validated);

        $adminAddress = config('mail.admin_address');
        if ($adminAddress) {
            Mail::to($adminAddress)->send(
                new ContactMail($contact->name, $contact->email, $contact->message)
            );
        }

        Mail::to($contact->email)->send(new ContactClientConfirmation($contact));

        return response()->json(['success' => true]);
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
