<?php

namespace App\Http\Controllers;

use App\Services\ClientPortalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientPortalController extends Controller
{
    public function __construct(protected ClientPortalService $portalService) {}

    public function index()
    {
        return view('pages.client-portal', [
            'settings' => $this->settings(),
        ]);
    }

    public function titleStatus(Request $request)
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $result = $this->portalService->lookupTitle(
            $validated['reference'],
            $validated['phone'] ?? null,
            $validated['email'] ?? null,
        );

        return back()->with(
            $result ? 'portal_success' : 'portal_error',
            $result?->status_message ?? 'Reference not found. Please contact Acremann for assistance.'
        );
    }

    public function paymentStatus(Request $request)
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $result = $this->portalService->lookupPayment(
            $validated['reference'],
            $validated['phone'] ?? null,
            $validated['email'] ?? null,
        );

        if ($result && $result->statement_path && Storage::disk('public')->exists($result->statement_path)) {
            return Storage::disk('public')->download($result->statement_path, 'statement-'.$result->reference_number.'.pdf');
        }

        return back()->with(
            $result ? 'portal_success' : 'portal_error',
            $result?->status_message ?? 'Reference not found. Please contact Acremann for assistance.'
        );
    }
}
