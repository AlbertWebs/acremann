<?php

namespace Database\Seeders;

use App\Models\AssistantMenuItem;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class AssistantContentSeeder extends Seeder
{
    public function run(): void
    {
        $settings = SiteSetting::current();

        $settings->update([
            'assistant_heading' => $settings->assistant_heading ?: 'Acremann Assistant',
            'assistant_subheading' => $settings->assistant_subheading ?: 'How can we help you today?',
            'assistant_title_body' => $settings->assistant_title_body ?: 'Every Acremann project comes with verified documentation and a transparent conveyancing process. Our team guides you from reservation to title registration.',
            'assistant_title_link_label' => $settings->assistant_title_link_label ?: 'View all FAQs →',
            'assistant_title_link_url' => $settings->assistant_title_link_url ?: '/faqs',
            'assistant_whatsapp_label' => $settings->assistant_whatsapp_label ?: 'Chat on WhatsApp',
            'assistant_consent_text' => $settings->assistant_consent_text ?: 'I consent to Acremann contacting me.',
            'assistant_success_message' => $settings->assistant_success_message ?: "Thank you! We'll be in touch.",
            'assistant_buyer_types' => $settings->assistant_buyer_types ?: [
                ['value' => 'individual', 'label' => 'Individual buyer'],
                ['value' => 'diaspora', 'label' => 'Diaspora investor'],
                ['value' => 'investor', 'label' => 'Institutional investor'],
                ['value' => 'developer', 'label' => 'Developer / partner'],
            ],
            'assistant_budget_ranges' => $settings->assistant_budget_ranges ?: [
                ['value' => 'under_1m', 'label' => 'Under KES 1M'],
                ['value' => '1m_3m', 'label' => 'KES 1M – 3M'],
                ['value' => '3m_10m', 'label' => 'KES 3M – 10M'],
                ['value' => 'over_10m', 'label' => 'Over KES 10M'],
            ],
        ]);

        if (AssistantMenuItem::query()->exists()) {
            return;
        }

        foreach ([
            ['label' => 'Project information', 'action' => 'faq', 'journey' => 'faq', 'sort_order' => 1],
            ['label' => 'Title & process questions', 'action' => 'title', 'journey' => 'title', 'sort_order' => 2],
            ['label' => 'Book a site visit', 'action' => 'lead', 'journey' => 'site_visit', 'lead_form_title' => 'Book a site visit', 'sort_order' => 3],
            ['label' => 'Pricing & financing', 'action' => 'lead', 'journey' => 'financing', 'lead_form_title' => 'Pricing & financing', 'sort_order' => 4],
            ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp', 'sort_order' => 5],
        ] as $item) {
            AssistantMenuItem::create([
                ...$item,
                'is_published' => true,
                'open_in_new_tab' => true,
            ]);
        }
    }
}
