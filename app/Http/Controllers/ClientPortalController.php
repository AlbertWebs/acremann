<?php

namespace App\Http\Controllers;

use App\Models\ClientLookup;
use App\Services\ClientPortalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ClientPortalController extends Controller
{
    public function __construct(protected ClientPortalService $portalService) {}

    public function index()
    {
        return view('pages.client-portal', [
            'settings' => $this->settings(),
        ]);
    }

    public function titleStatus(Request $request): JsonResponse|Response|RedirectResponse
    {
        return $this->handleLookup($request, 'title');
    }

    public function paymentStatus(Request $request): JsonResponse|Response|RedirectResponse
    {
        return $this->handleLookup($request, 'payment');
    }

    public function downloadStatement(ClientLookup $lookup): Response
    {
        if (! $lookup->hasStatement() || ! Storage::disk('public')->exists($lookup->statement_path)) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $lookup->statement_path,
            'statement-'.$lookup->reference_number.'.pdf',
        );
    }

    protected function handleLookup(Request $request, string $type): JsonResponse|Response|RedirectResponse
    {
        $validated = $this->validateLookup($request);

        $result = $type === 'title'
            ? $this->portalService->lookupTitle($validated['reference'], $validated['phone'] ?? null, $validated['email'] ?? null)
            : $this->portalService->lookupPayment($validated['reference'], $validated['phone'] ?? null, $validated['email'] ?? null);

        if ($type === 'payment' && $result && $request->expectsJson()) {
            return $this->lookupResponse($request, $result, $this->signedStatementUrl($result));
        }

        if ($type === 'payment' && $result && $result->hasStatement() && Storage::disk('public')->exists($result->statement_path)) {
            return Storage::disk('public')->download(
                $result->statement_path,
                'statement-'.$result->reference_number.'.pdf',
            );
        }

        return $this->lookupResponse($request, $result);
    }

    /**
     * @return array<string, mixed>
     */
    protected function validateLookup(Request $request): array
    {
        return $request->validate([
            'reference' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9\-]+$/'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
        ], [
            'reference.regex' => 'Please enter a valid reference number (letters, numbers, and hyphens only).',
        ]);
    }

    protected function lookupResponse(Request $request, ?ClientLookup $result, ?string $downloadUrl = null): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            if (! $result) {
                return response()->json([
                    'success' => false,
                    'message' => ClientPortalService::GENERIC_FAILURE_MESSAGE,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => $result->status_message,
                'download_url' => $downloadUrl,
            ]);
        }

        if (! $result) {
            return back()
                ->withInput()
                ->with('portal_error', ClientPortalService::GENERIC_FAILURE_MESSAGE);
        }

        return back()->with('portal_success', $result->status_message);
    }

    protected function signedStatementUrl(ClientLookup $lookup): ?string
    {
        if (! $lookup->hasStatement() || ! Storage::disk('public')->exists($lookup->statement_path)) {
            return null;
        }

        return URL::temporarySignedRoute(
            'client-portal.statement',
            now()->addMinutes(10),
            ['lookup' => $lookup->id],
        );
    }
}
