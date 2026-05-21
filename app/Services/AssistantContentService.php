<?php

namespace App\Services;

use App\Models\AssistantMenuItem;
use App\Models\Faq;
use App\Models\Property;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;

class AssistantContentService
{
    /**
     * @return Collection<int, AssistantMenuItem>
     */
    public function menuItems(): Collection
    {
        return AssistantMenuItem::query()->published()->get();
    }

    /**
     * @return Collection<int, Faq>
     */
    public function faqs(): Collection
    {
        return Faq::query()
            ->where('is_published', true)
            ->where('show_in_assistant', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * @return array<string, mixed>
     */
    public function config(SiteSetting $settings, ?Property $property = null): array
    {
        $leadTitles = $this->menuItems()
            ->where('action', AssistantMenuItem::ACTION_LEAD)
            ->mapWithKeys(fn (AssistantMenuItem $item): array => [
                $item->journey ?? 'general' => $item->lead_form_title ?: $item->label,
            ])
            ->all();

        return [
            'heading' => $settings->assistant_heading ?: 'Acremann Assistant',
            'subheading' => $settings->assistant_subheading ?: 'How can we help you today?',
            'title_body' => $settings->assistant_title_body ?: 'Every Acremann project comes with verified documentation and a transparent conveyancing process. Our team guides you from reservation to title registration.',
            'title_link_label' => $settings->assistant_title_link_label ?: 'View all FAQs →',
            'title_link_url' => $settings->assistant_title_link_url ?: route('faqs'),
            'whatsapp_label' => $settings->assistant_whatsapp_label ?: 'Chat on WhatsApp',
            'consent_text' => $settings->assistant_consent_text ?: 'I consent to Acremann contacting me.',
            'success_message' => $settings->assistant_success_message ?: "Thank you! We'll be in touch.",
            'buyer_types' => $settings->assistantBuyerTypes(),
            'budget_ranges' => $settings->assistantBudgetRanges(),
            'lead_titles' => $leadTitles,
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function menuItemsForFrontend(SiteSetting $settings, ?Property $property = null): array
    {
        return $this->menuItems()
            ->map(fn (AssistantMenuItem $item): array => [
                'label' => $item->label,
                'action' => $item->action,
                'step' => $item->step(),
                'journey' => $item->journey ?? 'general',
                'lead_title' => $item->lead_form_title,
                'url' => $item->resolvesUrl($settings, $property),
                'open_in_new_tab' => $item->open_in_new_tab,
            ])
            ->values()
            ->all();
    }
}
