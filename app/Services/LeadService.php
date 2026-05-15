<?php

namespace App\Services;

use App\Jobs\SendLeadToCrm;
use App\Mail\LeadNotification;
use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class LeadService
{
    public function store(array $data): Lead
    {
        foreach (['consent_callback', 'consent_whatsapp', 'consent_email', 'consent_marketing'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = (bool) $data[$field];
            }
        }

        $lead = Lead::create($data);

        Mail::to(config('acremann.lead_notification_email'))->queue(new LeadNotification($lead));

        if (config('acremann.crm_webhook_url')) {
            SendLeadToCrm::dispatch($lead);
        }

        return $lead;
    }

    public function sendToCrm(Lead $lead): void
    {
        $url = config('acremann.crm_webhook_url');
        if (! $url) {
            return;
        }

        Http::timeout(10)->post($url, [
            'source' => $lead->source,
            'name' => $lead->name,
            'email' => $lead->email,
            'phone' => $lead->phone,
            'property_id' => $lead->property_id,
            'buyer_type' => $lead->buyer_type,
            'budget' => $lead->budget,
            'message' => $lead->message,
            'metadata' => $lead->metadata,
            'created_at' => $lead->created_at?->toIso8601String(),
        ]);
    }
}
