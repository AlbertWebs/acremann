<?php

namespace Database\Seeders;

use App\Models\AssistantMenuItem;
use App\Models\Certification;
use App\Models\ClientLookup;
use App\Models\Lead;
use App\Models\Faq;
use App\Models\NewsletterSubscriber;
use App\Models\Page;
use App\Models\Plot;
use App\Models\Post;
use App\Models\Property;
use App\Models\PropertyFaq;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class AcremannSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->delete();
        SiteSetting::create([
            'company_name' => 'Acremann Properties',
            'tagline' => 'Trusted guidance. Transparent process. Sustainable value.',
            'hero_eyebrow' => 'Trusted real estate company Kenya',
            'hero_headline' => 'Trusted guidance. Transparent process. Sustainable value.',
            'hero_description' => 'Clean title deeds, verified plots, and professional property advisory across Nairobi, Kiambu, Kikuyu and Nachu. Buy land in Kenya with confidence — including diaspora-friendly remote purchase support.',
            'hero_cta_primary_label' => 'View properties',
            'hero_cta_primary_url' => '/properties',
            'hero_cta_secondary_label' => 'Book a site visit',
            'hero_cta_secondary_url' => '/book-visit',
            'hero_show_whatsapp_cta' => true,
            'hero_whatsapp_label' => 'WhatsApp us',
            'hero_media_mode' => 'featured_properties',
            'mission' => 'To deliver legally-grounded, financially-disciplined land and property solutions that build lasting legacy for our clients.',
            'vision' => 'To be Kenya\'s most trusted advisory-led real estate firm for clean-title land investment.',
            'about_summary' => 'Acremann Properties is a professional real estate firm specialising in verified residential and commercial plots across Nairobi, Kiambu, Kikuyu and Nachu.',
            'whatsapp' => '254115874901',
            'phone' => '0115 874 901',
            'email' => 'info@acremannproperties.com',
            'address' => 'Nairobi, Kenya',
            'youtube_url' => 'https://youtube.com',
            'podcast_url' => 'https://podcasts.google.com',
            'csr_statement' => 'We invest in community tree planting, drainage improvements, and ethical land stewardship across every project.',
            'referral_program' => 'Refer a friend to Acremann and earn rewards when they complete a purchase. Our loyalty program recognises clients who grow with us.',
            'sustainability_intro' => 'Responsible land use, green open spaces, solar-ready planning, and long-term community value guide every Acremann development. Beyond marketing claims, we plan tree planting, drainage improvements, and protected open space from the earliest master-plan stage — so infrastructure, access, and environmental choices support families and investors for decades. Whether you are buying to build, hold, or pass land to the next generation, our sustainability markers are documented on every project we represent across Nairobi, Kiambu, Kikuyu and Nachu.',
            'investment_intro' => 'Whether you are an end-user, investor, or diaspora buyer, Acremann provides transparent advisory from site visit to title handover.',
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

        $nachu = Property::create([
            'title' => 'Acremann Nachu Gardens',
            'slug' => 'acremann-nachu-gardens',
            'status' => 'available',
            'project_status' => 'selling',
            'price_from' => 850000,
            'price_label' => 'From KES 850,000',
            'plot_size' => '50 x 100 ft',
            'location' => 'Nachu, Kikuyu',
            'county' => 'Kiambu',
            'category' => 'residential',
            'title_type' => 'freehold',
            'listing_type' => 'sale',
            'summary' => 'Prime serviced plots near Southern Bypass with clean freehold titles.',
            'description' => 'Acremann Nachu Gardens offers affordable plots in Nachu Kikuyu with verified titles, graded access roads, and proximity to key infrastructure including the Southern Bypass and SGR Kikuyu corridor.',
            'amenities' => ['Water', 'Electricity nearby', 'Graded roads', 'Security', 'Drainage'],
            'distance_notes' => "15 min to Kikuyu town\n20 min to Southern Bypass\n25 min to SGR Kikuyu station",
            'title_process' => 'All plots come with clean freehold title deeds. Our conveyancing team handles search, transfer, and registration with full transparency.',
            'investor_angle' => 'Strong capital appreciation corridor driven by infrastructure growth and Nairobi satellite expansion.',
            'sustainability_markers' => ['500+ trees planted', '15% open green space', 'Solar-ready infrastructure', 'Community drainage'],
            'is_featured' => true,
            'is_published' => true,
            'sort_order' => 1,
            'meta_title' => 'Plots for sale in Nachu Kikuyu | Acremann Nachu Gardens',
            'meta_description' => 'Affordable plots in Nachu Kikuyu with clean title deeds. Land near Southern Bypass Nairobi. Acremann verified plots.',
        ]);

        foreach (['A-01' => 'available', 'A-02' => 'available', 'A-03' => 'reserved', 'A-04' => 'sold'] as $num => $status) {
            Plot::create(['property_id' => $nachu->id, 'plot_number' => $num, 'status' => $status, 'size' => '50x100', 'price' => 850000]);
        }

        PropertyFaq::create(['property_id' => $nachu->id, 'question' => 'Is the title clean?', 'answer' => 'Yes. Every plot has a verified freehold title with full search documentation available before purchase.', 'sort_order' => 1]);
        PropertyFaq::create(['property_id' => $nachu->id, 'question' => 'Can diaspora buyers purchase remotely?', 'answer' => 'Yes. We support remote land purchase Kenya with documented power of attorney and video walkthroughs.', 'sort_order' => 2]);

        Property::create([
            'title' => 'Acremann Kiambu Heights',
            'slug' => 'acremann-kiambu-heights',
            'status' => 'available',
            'project_status' => 'selling',
            'price_from' => 1200000,
            'plot_size' => '1/4 acre',
            'location' => 'Kiambu Road',
            'county' => 'Kiambu',
            'category' => 'residential',
            'title_type' => 'freehold',
            'listing_type' => 'sale',
            'summary' => 'Serene living near Nairobi on prime Kiambu plots.',
            'description' => 'Kiambu Heights delivers serviced residential plots for families and investors seeking serene living near Nairobi.',
            'amenities' => ['Water', 'Perimeter wall', 'Street lighting'],
            'is_featured' => true,
            'is_published' => true,
            'sort_order' => 2,
        ]);

        Property::create([
            'title' => 'Acremann Commercial Ridge',
            'slug' => 'acremann-commercial-ridge',
            'status' => 'available',
            'project_status' => 'launching',
            'price_from' => 3500000,
            'location' => 'Nairobi outskirts',
            'county' => 'Nairobi',
            'category' => 'commercial',
            'title_type' => 'leasehold',
            'listing_type' => 'sale',
            'summary' => 'Commercial land for sale Kenya — ideal for retail and mixed use.',
            'description' => 'Strategic commercial parcels with strong visibility and access for business development.',
            'is_featured' => true,
            'is_published' => true,
            'sort_order' => 3,
        ]);

        $this->seedTeamMembers();

        $this->seedTestimonials($nachu);

        $this->seedCertifications();

        $this->seedServices();

        Faq::insert([
            ['category' => 'general', 'question' => 'How do I buy land in Kenya safely?', 'answer' => 'Verify the title, conduct an official search, use a qualified advocate, and work with a trusted firm like Acremann for end-to-end transparency.', 'sort_order' => 1, 'is_published' => true, 'show_in_assistant' => true, 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'title', 'question' => 'What is a clean title deed?', 'answer' => 'A clean title has no encumbrances, disputes, or unpaid charges. Acremann provides verified documentation before you commit.', 'sort_order' => 2, 'is_published' => true, 'show_in_assistant' => true, 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'diaspora', 'question' => 'Can I buy land from abroad?', 'answer' => 'Yes. Acremann supports diaspora buyers with virtual site visits, documented POA, and secure payment milestones.', 'sort_order' => 3, 'is_published' => true, 'show_in_assistant' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Post::insert([
            [
                'title' => 'How to Buy Land in Kenya Safely: A Complete Guide',
                'slug' => 'how-to-buy-land-in-kenya-safely',
                'excerpt' => 'Essential steps for secure land investment in Kenya — from title search to handover.',
                'body' => '<p>Buying land in Kenya requires due diligence, title verification, and professional advisory. Here is what every buyer should know...</p>',
                'author' => 'Acremann Team',
                'published_at' => now()->subDays(10),
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Diaspora Land Purchase: What to Expect Remotely',
                'slug' => 'diaspora-land-purchase-kenya',
                'excerpt' => 'Video walkthroughs, milestone payments, and documented POA — how remote buyers stay in control.',
                'body' => '<p>Investing from abroad does not mean compromising on due diligence. Acremann structures diaspora purchases with clear milestones and verified title packs at every stage.</p>',
                'author' => 'Acremann Team',
                'published_at' => now()->subDays(5),
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Understanding Clean Title Deeds in Kenya',
                'slug' => 'clean-title-deeds-kenya',
                'excerpt' => 'What a clean title means, how encumbrances are checked, and why verification matters before you pay.',
                'body' => '<p>A clean title deed is the foundation of every secure plot purchase. Learn how official searches, survey confirmations, and advocate review protect your investment.</p>',
                'author' => 'Acremann Team',
                'published_at' => now()->subDay(),
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Page::create(['slug' => 'invest', 'title' => 'Why Invest With Acremann', 'subtitle' => 'Future-focused land investment', 'content' => '<p>Land remains one of Kenya\'s most resilient asset classes. Acremann combines legal precision, financial discipline, and sustainability thinking to protect your investment.</p>']);
        Page::create(['slug' => 'privacy', 'title' => 'Privacy Notice', 'content' => '<p>Acremann Properties collects personal data when you submit enquiries, subscribe to our newsletter, or use our client portal. We use this data to respond to your requests, improve our services, and — with consent — send marketing communications. You may request access, correction, or deletion of your data by contacting <a href="mailto:info@acremannproperties.com">info@acremannproperties.com</a>. We retain data only as long as necessary for these purposes.</p>']);
        Page::create(['slug' => 'terms', 'title' => 'Terms and Conditions', 'content' => '<p>These terms govern your use of the Acremann Properties website and services. By submitting an enquiry, booking a site visit, or engaging our advisory team, you agree to receive communications related to your request and to provide accurate information. Property availability, pricing, and title status are subject to verification at the time of transaction. Acremann does not guarantee outcomes of third-party searches or financing. For questions about these terms, contact <a href="mailto:info@acremannproperties.com">info@acremannproperties.com</a>.</p>']);

        ClientLookup::create(['reference_number' => 'ACR-TITLE-001', 'lookup_type' => 'title', 'status_message' => 'Title search complete. Transfer in progress — estimated completion 14 days.']);
        ClientLookup::create(['reference_number' => 'ACR-PAY-001', 'lookup_type' => 'payment', 'status_message' => 'Account current. Next installment due 1 June 2026.']);

        $this->seedAnalyticsData($nachu);
    }

    protected function seedTeamMembers(): void
    {
        $members = [
            [
                'name' => 'Grace Wanjiku',
                'role' => 'Managing Director',
                'bio' => '15+ years in Kenyan real estate advisory.',
                'is_leadership' => true,
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'name' => 'James Ochieng',
                'role' => 'Head of Conveyancing',
                'bio' => 'Legal precision in every title transfer.',
                'is_leadership' => true,
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'name' => 'Sarah Muthoni',
                'role' => 'Diaspora Relations',
                'bio' => 'Supporting buyers abroad with confidence.',
                'is_leadership' => false,
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'name' => 'Peter Kamau',
                'role' => 'Project Sales Lead',
                'bio' => 'Guiding clients from enquiry to handover.',
                'is_leadership' => false,
                'sort_order' => 4,
                'is_published' => true,
            ],
        ];

        foreach ($members as $data) {
            TeamMember::updateOrCreate(
                [
                    'name' => $data['name'],
                    'sort_order' => $data['sort_order'],
                ],
                $data
            );
        }
    }

    protected function seedTestimonials(Property $nachu): void
    {
        $testimonials = [
            [
                'quote' => 'Acremann made buying land in Kenya safe and transparent. The title process was clear from day one.',
                'client_name' => 'Mary K.',
                'client_detail' => 'Nachu plot owner',
                'property_id' => $nachu->id,
                'is_featured' => true,
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'quote' => 'As a diaspora investor, I appreciated the regular updates and verified documentation.',
                'client_name' => 'David N.',
                'client_detail' => 'Diaspora buyer — UK',
                'is_featured' => true,
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'quote' => 'Professional advisory from site visit to title handover. We felt informed at every step.',
                'client_name' => 'James & Grace W.',
                'client_detail' => 'Kiambu Heights buyers',
                'is_featured' => true,
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'quote' => 'The team answered every legal question patiently. Our plot purchase was smooth and well documented.',
                'client_name' => 'Peter O.',
                'client_detail' => 'End-user buyer',
                'is_featured' => true,
                'sort_order' => 4,
                'is_published' => true,
            ],
            [
                'quote' => 'We compared several projects; Acremann stood out for clean titles and honest pricing.',
                'client_name' => 'Sarah M.',
                'client_detail' => 'Investor — Nairobi',
                'is_featured' => true,
                'sort_order' => 5,
                'is_published' => true,
            ],
            [
                'quote' => 'Remote purchase support worked brilliantly. Video updates and signed documents gave us real peace of mind.',
                'client_name' => 'Ahmed R.',
                'client_detail' => 'Diaspora buyer — UAE',
                'is_featured' => true,
                'sort_order' => 6,
                'is_published' => true,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::updateOrCreate(
                [
                    'client_name' => $data['client_name'],
                    'sort_order' => $data['sort_order'],
                ],
                $data
            );
        }
    }

    protected function seedCertifications(): void
    {
        $certifications = [
            [
                'title' => 'Estate Agents Registration',
                'description' => 'Registered real estate practitioners operating under Kenyan regulatory standards.',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Green Building Council Affiliate',
                'description' => 'Aligned with sustainable development and responsible land-use practices.',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Law Society of Kenya — Partner Advocates',
                'description' => 'Conveyancing and title verification supported by qualified legal counsel.',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'NCA Development Compliance',
                'description' => 'Projects planned with infrastructure and compliance considerations from the outset.',
                'sort_order' => 4,
                'is_published' => true,
            ],
        ];

        foreach ($certifications as $data) {
            Certification::updateOrCreate(['title' => $data['title']], $data);
        }
    }

    protected function seedServices(): void
    {
        $services = [
            [
                'slug' => 'land-sales',
                'title' => 'Land Sales',
                'icon' => 'land',
                'summary' => 'Residential and commercial plots with clean title deeds across Nairobi, Kiambu, Kikuyu and Nachu.',
                'body' => '<p>Acremann lists verified land for sale in Kenya with transparent pricing and documented title status. Every plot is presented with location context, access notes, and payment plan options where applicable.</p><p>Whether you are building a family home or securing a growth-corridor plot, our team guides you from shortlist to site visit and reservation — with no hidden encumbrances.</p><h2>What you can expect</h2><ul><li>Clean-title focus and official search coordination</li><li>On-ground or virtual site visits</li><li>Clear pricing and milestone-based payments</li></ul>',
                'local_summary' => 'Walk plots in Nairobi, Kiambu, Kikuyu or Nachu with our sales team. We verify access, beacons, and title packs before you pay a deposit.',
                'diaspora_summary' => 'Shortlist plots remotely with video walkthroughs, verified documentation, and milestone updates until registration — ideal for UK, US, UAE and other diaspora buyers.',
                'meta_title' => 'Land for sale Kenya | Clean title plots Nairobi & Kiambu',
                'meta_description' => 'Buy verified land in Kenya with clean title deeds. Residential & commercial plots in Nairobi, Kiambu, Kikuyu & Nachu — local & diaspora buyers welcome.',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'slug' => 'investment-advisory',
                'title' => 'Investment Advisory',
                'icon' => 'advisory',
                'summary' => 'Data-led land investment guidance for Kenyan investors and diaspora capital.',
                'body' => '<p>Our investment advisory service helps you match budget, horizon, and risk profile to verified opportunities — not generic listings. We focus on growth corridors, title clarity, and realistic exit or hold strategies.</p><p>From first-time investors to experienced portfolio builders, you receive a curated shortlist and documented due diligence before capital is committed.</p><h2>Advisory includes</h2><ul><li>Market and location context for each plot</li><li>Title and encumbrance summaries</li><li>Coordination with advocates and surveyors</li></ul>',
                'local_summary' => 'Kenya-based investors receive growth-corridor shortlists, site visits, and handover support aligned with your investment goals.',
                'diaspora_summary' => 'Invest from abroad with structured remote due diligence, currency-aware payment planning, and regular progress reports through to title registration.',
                'meta_title' => 'Land investment advisory Kenya | Diaspora & local investors',
                'meta_description' => 'Professional land investment advisory in Kenya. Curated plots, title verification & diaspora-friendly remote purchase support in Nairobi, Kiambu & beyond.',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'slug' => 'conveyancing',
                'title' => 'Conveyancing',
                'icon' => 'legal',
                'summary' => 'Title search, sale agreements, transfer and registration — legally grounded conveyancing in Kenya.',
                'body' => '<p>Conveyancing is where many land deals succeed or fail. Acremann coordinates qualified advocates, official searches, and sale agreement structures so you understand every step before signing.</p><p>We explain charges, timelines, and registration requirements in plain language — for local buyers and those purchasing through power of attorney from abroad.</p><h2>Our conveyancing support</h2><ul><li>Official title and encumbrance searches</li><li>Sale agreement review and milestone schedules</li><li>Transfer and registration tracking to completion</li></ul>',
                'local_summary' => 'Work with advocates we trust for searches, agreements, and registration — with Acremann keeping your file coordinated through handover.',
                'diaspora_summary' => 'Remote purchasers receive documented POA guidance, encrypted document packs, and milestone alerts so legal steps complete correctly while you are overseas.',
                'meta_title' => 'Conveyancing Kenya | Title transfer & registration support',
                'meta_description' => 'Transparent conveyancing in Kenya — title search, sale agreements & registration. Support for local buyers and diaspora land purchases.',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'slug' => 'diaspora-support',
                'title' => 'Diaspora Support',
                'icon' => 'global',
                'summary' => 'Buy land in Kenya from abroad — documented remote purchase, virtual visits, and milestone updates.',
                'body' => '<p>Acremann\'s diaspora support is built for Kenyans and friends of Kenya purchasing from the UK, US, Europe, the Gulf, and beyond. Time zones do not reduce the standard of due diligence.</p><p>We combine video walkthroughs, verified title packs, advocate coordination, and payment milestones you can track from anywhere.</p><h2>How we support remote buyers</h2><ul><li>Virtual site visits and beacon checks</li><li>Documented sale agreements and POA guidance</li><li>Regular updates until title registration</li></ul>',
                'local_summary' => 'Relatives or representatives on the ground can attend visits we coordinate — while you retain full visibility of the file.',
                'diaspora_summary' => 'Purpose-built for overseas buyers: secure processes, plain-language milestones, and a direct advisory contact from enquiry to registered title.',
                'meta_title' => 'Buy land in Kenya from abroad | Diaspora property support',
                'meta_description' => 'Diaspora land purchase Kenya — virtual visits, clean titles, documented milestones & remote conveyancing. Trusted advisory for buyers abroad.',
                'sort_order' => 4,
                'is_published' => true,
            ],
        ];

        $canonicalSlugs = array_column($services, 'slug');

        Service::query()
            ->whereNotIn('slug', $canonicalSlugs)
            ->where(function ($query) use ($canonicalSlugs) {
                foreach ($canonicalSlugs as $slug) {
                    $query->orWhere('slug', 'like', $slug.'-%');
                }
            })
            ->delete();

        foreach ($services as $data) {
            Service::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }

    protected function seedAnalyticsData(Property $nachu): void
    {
        $sources = ['contact', 'site_visit', 'property_enquiry', 'brochure_download', 'chatbot', 'newsletter'];
        $buyerTypes = ['end-user', 'investor', 'diaspora', 'jv', null];
        $names = ['James Kariuki', 'Mary Wanjiku', 'David Omondi', 'Grace Njeri', 'Peter Kamau', 'Sarah Muthoni', 'John Otieno', 'Faith Akinyi'];

        for ($day = 45; $day >= 0; $day--) {
            $count = random_int(0, 3);
            for ($i = 0; $i < $count; $i++) {
                Lead::create([
                    'source' => $sources[array_rand($sources)],
                    'name' => $names[array_rand($names)],
                    'email' => 'lead'.uniqid().'@example.com',
                    'phone' => '07'.random_int(10000000, 99999999),
                    'property_id' => random_int(0, 1) ? $nachu->id : null,
                    'buyer_type' => $buyerTypes[array_rand($buyerTypes)],
                    'budget' => ['under-1m', '1m-3m', '3m-5m', '5m-plus'][array_rand(['under-1m', '1m-3m', '3m-5m', '5m-plus'])],
                    'status' => ['new', 'contacted', 'converted'][array_rand(['new', 'contacted', 'converted'])],
                    'consent_callback' => true,
                    'consent_whatsapp' => (bool) random_int(0, 1),
                    'consent_email' => true,
                    'created_at' => now()->subDays($day)->subHours(random_int(0, 12)),
                    'updated_at' => now()->subDays($day),
                ]);
            }
        }

        foreach (['alerts@example.com', 'investor@example.com', 'diaspora@example.com'] as $email) {
            NewsletterSubscriber::firstOrCreate(
                ['email' => $email],
                ['consent_marketing' => true, 'preferences' => ['project_updates' => true]]
            );
        }
    }
}
