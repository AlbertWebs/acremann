<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Services\LeadService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendLeadToCrm implements ShouldQueue
{
    use Queueable;

    public function __construct(public Lead $lead) {}

    public function handle(LeadService $leadService): void
    {
        $leadService->sendToCrm($this->lead);
    }
}
