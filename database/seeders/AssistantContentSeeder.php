<?php

namespace Database\Seeders;

use App\Models\AssistantMenuItem;
use App\Models\Faq;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class AssistantContentSeeder extends Seeder
{
    public function run(): void
    {
        $settings = SiteSetting::current();

        $settings->update([
            'assistant_heading' => 'Acremann Assistant',
            'assistant_subheading' => 'How can we help you today?',
            'assistant_title_body' => 'Every Acremann project comes with verified documentation and a transparent conveyancing process. Our team guides you from reservation to title registration.',
            'assistant_title_link_label' => 'View all FAQs →',
            'assistant_title_link_url' => '/faqs',
            'assistant_whatsapp_label' => 'Chat on WhatsApp',
            'assistant_consent_text' => 'I consent to Acremann contacting me.',
            'assistant_success_message' => "Thank you! We'll be in touch.",
            'assistant_buyer_types' => [
                ['value' => 'individual', 'label' => 'Individual buyer'],
                ['value' => 'diaspora', 'label' => 'Diaspora investor'],
                ['value' => 'investor', 'label' => 'Institutional investor'],
                ['value' => 'developer', 'label' => 'Developer / partner'],
            ],
            'assistant_budget_ranges' => [
                ['value' => 'under_1m', 'label' => 'Under KES 1M'],
                ['value' => '1m_3m', 'label' => 'KES 1M – 3M'],
                ['value' => '3m_10m', 'label' => 'KES 3M – 10M'],
                ['value' => 'over_10m', 'label' => 'Over KES 10M'],
            ],
        ]);

        foreach ($this->menuItems() as $item) {
            AssistantMenuItem::updateOrCreate(
                ['label' => $item['label']],
                [
                    ...$item,
                    'is_published' => true,
                    'open_in_new_tab' => $item['open_in_new_tab'] ?? true,
                ],
            );
        }

        foreach ($this->assistantFaqs() as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                [
                    ...$faq,
                    'is_published' => true,
                    'show_in_assistant' => true,
                ],
            );
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function menuItems(): array
    {
        return [
            ['label' => 'Project information', 'action' => 'faq', 'journey' => 'faq', 'sort_order' => 1],
            ['label' => 'Title & process questions', 'action' => 'title', 'journey' => 'title', 'sort_order' => 2],
            ['label' => 'Book a site visit', 'action' => 'lead', 'journey' => 'site_visit', 'lead_form_title' => 'Book a site visit', 'sort_order' => 3],
            ['label' => 'Pricing & financing', 'action' => 'lead', 'journey' => 'financing', 'lead_form_title' => 'Pricing & financing', 'sort_order' => 4],
            ['label' => 'Chat on WhatsApp', 'action' => 'whatsapp', 'sort_order' => 5],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function assistantFaqs(): array
    {
        return [
            [
                'category' => 'general',
                'question' => 'How do I buy land in Kenya safely?',
                'answer' => 'Verify the title, conduct an official search, use a qualified advocate, and work with a trusted firm like Acremann for end-to-end transparency.',
                'sort_order' => 1,
            ],
            [
                'category' => 'title',
                'question' => 'What is a clean title deed?',
                'answer' => 'A clean title has no encumbrances, disputes, or unpaid charges. Acremann provides verified documentation before you commit.',
                'sort_order' => 2,
            ],
            [
                'category' => 'diaspora',
                'question' => 'Can I buy land from abroad?',
                'answer' => 'Yes. Acremann supports diaspora buyers with virtual site visits, documented POA, and secure payment milestones.',
                'sort_order' => 3,
            ],
            [
                'category' => 'process',
                'question' => 'How long does title transfer take?',
                'answer' => 'Timelines vary by county and transaction type. After reservation, our conveyancing team typically guides you through search, transfer, and registration within the agreed schedule.',
                'sort_order' => 4,
            ],
            [
                'category' => 'payments',
                'question' => 'What payment plans do you offer?',
                'answer' => 'Many projects offer flexible instalment plans. Your payment schedule is documented upfront with clear milestones tied to verifiable progress.',
                'sort_order' => 5,
            ],
            [
                'category' => 'visits',
                'question' => 'Can I book a site visit?',
                'answer' => 'Yes. Use our Book a site visit form or WhatsApp us to arrange an on-site walkthrough or virtual tour.',
                'sort_order' => 6,
            ],
            [
                'category' => 'legal',
                'question' => 'Do you help with due diligence?',
                'answer' => 'Yes. We coordinate title searches, survey review, and advocate sign-off so you understand encumbrances and costs before you pay.',
                'sort_order' => 7,
            ],
            [
                'category' => 'invest',
                'question' => 'Is land in Kiambu and Nachu a good investment?',
                'answer' => 'Infrastructure growth along the Southern Bypass and satellite corridors has supported strong demand. We provide investor-focused documentation for each project.',
                'sort_order' => 8,
            ],
        ];
    }
}
