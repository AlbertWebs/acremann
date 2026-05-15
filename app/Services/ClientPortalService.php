<?php

namespace App\Services;

use App\Models\ClientLookup;

class ClientPortalService
{
    public function lookupTitle(string $reference, ?string $phone = null, ?string $email = null): ?ClientLookup
    {
        return $this->find('title', $reference, $phone, $email);
    }

    public function lookupPayment(string $reference, ?string $phone = null, ?string $email = null): ?ClientLookup
    {
        return $this->find('payment', $reference, $phone, $email);
    }

    protected function find(string $type, string $reference, ?string $phone, ?string $email): ?ClientLookup
    {
        $query = ClientLookup::where('lookup_type', $type)
            ->where('reference_number', strtoupper(trim($reference)));

        if ($phone) {
            $query->where(function ($q) use ($phone) {
                $q->whereNull('client_phone')
                    ->orWhere('client_phone', preg_replace('/\D/', '', $phone));
            });
        }

        if ($email) {
            $query->where(function ($q) use ($email) {
                $q->whereNull('client_email')
                    ->orWhere('client_email', strtolower(trim($email)));
            });
        }

        return $query->first();
    }
}
