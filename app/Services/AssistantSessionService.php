<?php

namespace App\Services;

use App\Models\AssistantSession;
use App\Models\Lead;
use Illuminate\Support\Arr;

class AssistantSessionService
{
    public function recordEvent(array $data): AssistantSession
    {
        $session = AssistantSession::query()->firstOrNew([
            'session_id' => $data['session_id'],
        ]);

        if (! $session->exists) {
            $session->fill([
                'page_url' => $data['page_url'] ?? null,
                'property_id' => $data['property_id'] ?? null,
                'user_agent' => request()->userAgent(),
                'ip_address' => request()->ip(),
                'started_at' => now(),
                'status' => AssistantSession::STATUS_EXPLORING,
                'transcript' => [],
            ]);
        }

        $transcript = $session->transcript ?? [];
        $transcript[] = array_filter([
            'event' => $data['event'],
            'label' => $data['label'] ?? null,
            'step' => $data['step'] ?? null,
            'journey' => $data['journey'] ?? null,
            'data' => ! empty($data['data']) ? $data['data'] : null,
            'at' => now()->toIso8601String(),
        ]);

        $session->transcript = $transcript;
        $session->event_count = count($transcript);
        $session->last_activity_at = now();

        if (! empty($data['journey'])) {
            $session->journey = $data['journey'];
        }

        if (! empty($data['step'])) {
            $session->last_step = $data['step'];
        }

        if (! empty($data['page_url'])) {
            $session->page_url = $data['page_url'];
        }

        if (! empty($data['property_id'])) {
            $session->property_id = $data['property_id'];
        }

        if ($data['event'] === 'whatsapp_click') {
            $session->status = AssistantSession::STATUS_WHATSAPP;
        }

        if ($data['event'] === 'form_field' && ! empty($data['data'])) {
            foreach (['name', 'email', 'phone', 'message', 'buyer_type', 'budget'] as $field) {
                if (! empty($data['data'][$field])) {
                    $session->{$field} = $data['data'][$field];
                }
            }
        }

        $session->save();

        return $session;
    }

    public function attachLead(string $sessionId, Lead $lead, array $payload = []): ?AssistantSession
    {
        $session = AssistantSession::query()->where('session_id', $sessionId)->first();

        if (! $session) {
            $session = $this->recordEvent([
                'session_id' => $sessionId,
                'event' => 'lead_submit',
                'journey' => Arr::get($payload, 'journey'),
                'step' => 'lead',
                'page_url' => Arr::get($payload, 'page_url'),
                'property_id' => Arr::get($payload, 'property_id'),
                'data' => $payload,
            ]);
        }

        $transcript = $session->transcript ?? [];
        $transcript[] = [
            'event' => 'lead_submit',
            'label' => 'Contact form submitted',
            'step' => 'lead',
            'journey' => Arr::get($payload, 'journey', $session->journey),
            'data' => $payload,
            'at' => now()->toIso8601String(),
        ];

        $session->fill([
            'lead_id' => $lead->id,
            'status' => AssistantSession::STATUS_LEAD_SUBMITTED,
            'name' => $lead->name,
            'email' => $lead->email,
            'phone' => $lead->phone,
            'buyer_type' => $lead->buyer_type,
            'budget' => $lead->budget,
            'message' => $lead->message,
            'journey' => Arr::get($lead->metadata, 'journey', $session->journey),
            'transcript' => $transcript,
            'event_count' => count($transcript),
            'last_activity_at' => now(),
        ]);

        $session->save();

        return $session;
    }
}
