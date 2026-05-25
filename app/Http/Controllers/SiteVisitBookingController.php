<?php

namespace App\Http\Controllers;

use App\Services\SiteVisitBookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SiteVisitBookingController extends Controller
{
    public const SUCCESS_MESSAGE = 'Thank you. We have received your site visit request and will confirm by phone or email within one business day.';

    public function __construct(protected SiteVisitBookingService $bookings) {}

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'property_id' => ['nullable', 'exists:properties,id'],
            'buyer_type' => ['nullable', 'string', 'max:50'],
            'budget' => ['nullable', 'string', 'max:50'],
            'property_interest' => ['nullable', 'string', 'max:255'],
            'visit_format' => ['nullable', 'string', 'in:on_site,virtual'],
            'message' => ['nullable', 'string', 'max:5000'],
            'consent_callback' => ['accepted'],
            'consent_whatsapp' => ['nullable', 'boolean'],
            'consent_email' => ['nullable', 'boolean'],
            'consent_marketing' => ['nullable', 'boolean'],
        ]);

        if (filled($validated['visit_format'] ?? null)) {
            $formatLabel = $validated['visit_format'] === 'virtual' ? 'Virtual visit' : 'On-site visit';
            $validated['message'] = trim($formatLabel.($validated['message'] ? "\n\n".$validated['message'] : ''));
        }

        unset($validated['visit_format']);

        $this->bookings->store($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => self::SUCCESS_MESSAGE,
            ]);
        }

        return back()->with('success', self::SUCCESS_MESSAGE);
    }
}
