<?php

namespace App\Http\Controllers;

use App\Services\AssistantSessionService;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    public function __construct(protected AssistantSessionService $assistantSessions) {}

    public function track(Request $request)
    {
        $validated = $request->validate([
            'session_id' => ['required', 'string', 'max:64'],
            'event' => ['required', 'string', 'max:50'],
            'label' => ['nullable', 'string', 'max:255'],
            'step' => ['nullable', 'string', 'max:50'],
            'journey' => ['nullable', 'string', 'max:100'],
            'data' => ['nullable', 'array'],
            'page_url' => ['nullable', 'string', 'max:500'],
            'property_id' => ['nullable', 'exists:properties,id'],
        ]);

        $this->assistantSessions->recordEvent($validated);

        return response()->json(['success' => true]);
    }
}
