<?php

namespace App\Services;

use App\Enums\ClientLookupType;
use App\Models\ClientLookup;

class ClientPortalService
{
    public const GENERIC_FAILURE_MESSAGE = 'We could not verify your details. Please check your reference number and contact information, or reach out to Acremann for assistance.';

    public function lookupTitle(string $reference, ?string $phone = null, ?string $email = null): ?ClientLookup
    {
        return $this->find(ClientLookupType::Title, $reference, $phone, $email);
    }

    public function lookupPayment(string $reference, ?string $phone = null, ?string $email = null): ?ClientLookup
    {
        return $this->find(ClientLookupType::Payment, $reference, $phone, $email);
    }

    protected function find(ClientLookupType $type, string $reference, ?string $phone, ?string $email): ?ClientLookup
    {
        $reference = strtoupper(trim($reference));

        if ($reference === '') {
            return null;
        }

        $record = ClientLookup::query()
            ->where('lookup_type', $type->value)
            ->where('reference_number', $reference)
            ->first();

        if (! $record || ! $this->identityMatches($record, $phone, $email)) {
            return null;
        }

        return $record;
    }

    protected function identityMatches(ClientLookup $record, ?string $phone, ?string $email): bool
    {
        if (! $record->requiresIdentityCheck()) {
            return true;
        }

        if (filled($record->client_phone) && filled($record->client_email)) {
            return $this->phonesMatch($record->client_phone, $phone)
                && $this->emailsMatch($record->client_email, $email);
        }

        if (filled($record->client_phone)) {
            return $this->phonesMatch($record->client_phone, $phone);
        }

        if (filled($record->client_email)) {
            return $this->emailsMatch($record->client_email, $email);
        }

        return true;
    }

    protected function phonesMatch(string $stored, ?string $provided): bool
    {
        if (blank($provided)) {
            return false;
        }

        $storedNorm = ClientLookup::normalizePhone($stored);
        $providedNorm = ClientLookup::normalizePhone($provided);

        return filled($storedNorm) && $storedNorm === $providedNorm;
    }

    protected function emailsMatch(string $stored, ?string $provided): bool
    {
        if (blank($provided)) {
            return false;
        }

        return strtolower(trim($stored)) === strtolower(trim($provided));
    }
}
