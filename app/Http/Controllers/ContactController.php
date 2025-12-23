<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:10',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Send confirmation email to the user who submitted the form
            Mail::to($request->email)->send(new ContactForm(
                $request->name,
                $request->email,
                $request->phone ?? '',
                $request->country_code ?? '',
                $request->message
            ));

            return back()->with('success', __('template.contact.success_message'));
        } catch (\Exception $e) {
            return back()
                ->with('error', __('template.contact.error_message'))
                ->withInput();
        }
    }
}

