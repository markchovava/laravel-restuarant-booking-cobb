<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    
    public function store(Request $request) {
        $data = new Contact();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->message = $request->message;
        $data->updated_at = now();
        $data->created_at = now();
        $data->save();

        Mail::to(env('ADMIN_EMAIL'))->send(new ContactMail($data));

        return response()->json([
            'status' => 1,
            'data' => new ContactResource($data),
            'message' => 'Message sent successfully.'
        ]);
    }
}
