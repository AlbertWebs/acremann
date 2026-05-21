<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class AssistantSession extends Model
{
    public const STATUS_EXPLORING = 'exploring';

    public const STATUS_LEAD_SUBMITTED = 'lead_submitted';

    public const STATUS_WHATSAPP = 'whatsapp_clicked';

    protected $fillable = [
        'session_id', 'status', 'journey', 'last_step', 'name', 'email', 'phone',
        'buyer_type', 'budget', 'message', 'page_url', 'property_id', 'lead_id',
        'event_count', 'transcript', 'metadata', 'user_agent', 'ip_address',
        'started_at', 'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'transcript' => 'array',
            'metadata' => 'array',
            'started_at' => 'datetime',
            'last_activity_at' => 'datetime',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_LEAD_SUBMITTED => 'Lead submitted',
            self::STATUS_WHATSAPP => 'WhatsApp',
            default => 'Exploring',
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            self::STATUS_LEAD_SUBMITTED => 'success',
            self::STATUS_WHATSAPP => 'info',
            default => 'gray',
        };
    }

    public function journeyLabel(): string
    {
        return match ($this->journey) {
            'site_visit' => 'Book a site visit',
            'financing' => 'Pricing & financing',
            'faq' => 'Project information',
            'title' => 'Title & process',
            default => $this->journey ? ucfirst(str_replace('_', ' ', $this->journey)) : '—',
        };
    }

    public function contactDisplayName(): string
    {
        return $this->name ?: $this->email ?: $this->phone ?: 'Anonymous visitor';
    }

    public function hasContactDetails(): bool
    {
        return filled($this->name) || filled($this->email) || filled($this->phone);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function transcriptEntries(): array
    {
        $transcript = $this->transcript;

        if (is_string($transcript)) {
            $transcript = json_decode($transcript, true);
        }

        if (! is_array($transcript)) {
            return [];
        }

        return collect($transcript)
            ->filter(fn (mixed $entry): bool => is_array($entry))
            ->values()
            ->all();
    }

    /**
     * @return array{icon: string, color: string, title: string}
     */
    public static function eventMeta(string $event): array
    {
        return match ($event) {
            'widget_open' => ['icon' => 'heroicon-o-chat-bubble-left-right', 'color' => 'gray', 'title' => 'Opened assistant'],
            'widget_close' => ['icon' => 'heroicon-o-x-mark', 'color' => 'gray', 'title' => 'Closed assistant'],
            'menu_select' => ['icon' => 'heroicon-o-cursor-arrow-rays', 'color' => 'primary', 'title' => 'Menu choice'],
            'faq_expand' => ['icon' => 'heroicon-o-question-mark-circle', 'color' => 'info', 'title' => 'FAQ opened'],
            'form_field' => ['icon' => 'heroicon-o-pencil-square', 'color' => 'warning', 'title' => 'Form input'],
            'lead_submit' => ['icon' => 'heroicon-o-check-circle', 'color' => 'success', 'title' => 'Lead submitted'],
            'whatsapp_click' => ['icon' => 'heroicon-o-chat-bubble-oval-left-ellipsis', 'color' => 'success', 'title' => 'WhatsApp clicked'],
            'session_start' => ['icon' => 'heroicon-o-play', 'color' => 'gray', 'title' => 'Session started'],
            'link_click' => ['icon' => 'heroicon-o-link', 'color' => 'info', 'title' => 'Link clicked'],
            'consent_toggle' => ['icon' => 'heroicon-o-shield-check', 'color' => 'gray', 'title' => 'Consent updated'],
            default => ['icon' => 'heroicon-o-bolt', 'color' => 'gray', 'title' => ucfirst(str_replace('_', ' ', $event))],
        };
    }

    public static function formatEventTime(?string $iso): string
    {
        if (blank($iso)) {
            return '';
        }

        try {
            return Carbon::parse($iso)->format('M j, Y · g:i A');
        } catch (\Throwable) {
            return $iso;
        }
    }

    public static function formatBuyerType(?string $value): string
    {
        if (blank($value)) {
            return '—';
        }

        return ucfirst(str_replace('_', ' ', $value));
    }

    public static function formatBudget(?string $value): string
    {
        return match ($value) {
            'under_1m' => 'Under KES 1M',
            '1m_3m' => 'KES 1M – 3M',
            '3m_10m' => 'KES 3M – 10M',
            'over_10m' => 'Over KES 10M',
            default => $value ? ucfirst(str_replace('_', ' ', $value)) : '—',
        };
    }
}
