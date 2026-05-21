<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssistantMenuItem extends Model
{
    public const ACTION_FAQ = 'faq';

    public const ACTION_TITLE = 'title';

    public const ACTION_LEAD = 'lead';

    public const ACTION_WHATSAPP = 'whatsapp';

    public const ACTION_LINK = 'link';

    protected $fillable = [
        'label', 'action', 'journey', 'lead_form_title', 'url',
        'open_in_new_tab', 'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'open_in_new_tab' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function step(): string
    {
        return match ($this->action) {
            self::ACTION_FAQ => 'faq',
            self::ACTION_TITLE => 'title',
            self::ACTION_LEAD => 'lead',
            default => 'menu',
        };
    }

    public function resolvesUrl(SiteSetting $settings, ?Property $property = null): ?string
    {
        if ($this->action === self::ACTION_WHATSAPP) {
            $message = $property
                ? "Hello Acremann, I'm interested in {$property->title} at {$property->location}."
                : null;

            return $settings->whatsappUrl($message);
        }

        if ($this->action === self::ACTION_LINK && filled($this->url)) {
            return $this->url;
        }

        return null;
    }
}
