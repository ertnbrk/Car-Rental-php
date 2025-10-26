<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageStoreRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     */
    public function index(): View
    {
        return view('contact.index');
    }

    /**
     * Store a contact message.
     */
    public function store(ContactMessageStoreRequest $request): RedirectResponse
    {
        try {
            $message = ContactMessage::create($request->validated());

            Log::info('Contact message received', [
                'message_id' => $message->id,
                'email' => $message->email,
            ]);

            // TODO: Dispatch ContactMessageReceived event for email notification
            // event(new ContactMessageReceived($message));

            return redirect()
                ->route('contact.index')
                ->with('success', __('Thank you for contacting us! We will get back to you soon.'));

        } catch (\Exception $e) {
            Log::error('Failed to store contact message', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withErrors(['error' => __('Failed to send message. Please try again.')])
                ->withInput();
        }
    }
}
