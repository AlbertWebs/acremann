<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use App\Models\Property;
use App\Services\LeadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    public function __construct(protected LeadService $leadService) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'source' => ['required', 'string', 'max:50'],
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'property_id' => ['nullable', 'exists:properties,id'],
            'buyer_type' => ['nullable', 'string', 'max:50'],
            'budget' => ['nullable', 'string', 'max:50'],
            'location_preference' => ['nullable', 'string', 'max:255'],
            'property_interest' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:5000'],
            'consent_callback' => ['accepted'],
            'consent_whatsapp' => ['nullable', 'boolean'],
            'consent_email' => ['nullable', 'boolean'],
            'consent_marketing' => ['nullable', 'boolean'],
        ]);

        $this->leadService->store($validated);

        return back()->with('success', 'Thank you. Our team will contact you shortly.');
    }

    public function newsletter(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('newsletter_subscribers', 'email')],
            'consent_marketing' => ['accepted'],
            'preferences' => ['nullable', 'array'],
        ]);

        NewsletterSubscriber::create([
            'email' => $validated['email'],
            'preferences' => $validated['preferences'] ?? [],
            'consent_marketing' => true,
        ]);

        return back()->with('success', 'You are subscribed to Acremann updates.');
    }

    public function brochure(Request $request, Property $property)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'consent_email' => ['accepted'],
        ]);

        $this->leadService->store([
            'source' => 'brochure_download',
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'property_id' => $property->id,
            'consent_email' => true,
            'consent_callback' => true,
        ]);

        $media = $property->getFirstMedia('brochure');
        if ($media) {
            return response()->download($media->getPath(), $property->slug.'-brochure.'.$media->extension);
        }

        if ($property->brochure_path && Storage::disk('public')->exists($property->brochure_path)) {
            return Storage::disk('public')->download($property->brochure_path);
        }

        return back()->with('success', 'Thank you. We will email your brochure shortly.');
    }

    public function chatbot(Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
            'journey' => ['required', 'string', 'max:100'],
            'consent_callback' => ['nullable'],
        ]);

        $this->leadService->store([
            'source' => 'chatbot',
            'name' => $validated['name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'message' => $validated['message'] ?? null,
            'metadata' => ['journey' => $validated['journey']],
            'consent_callback' => true,
        ]);

        return response()->json(['success' => true]);
    }
}
