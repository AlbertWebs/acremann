<?php

namespace Database\Seeders;

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
            'mission' => 'To deliver legally-grounded, financially-disciplined land and property solutions that build lasting legacy for our clients.',
            'vision' => 'To be Kenya\'s most trusted advisory-led real estate firm for clean-title land investment.',
            'about_summary' => 'Acremann Properties is a professional real estate firm specialising in verified residential and commercial plots across Nairobi, Kiambu, Kikuyu and Nachu.',
            'whatsapp' => '254712345678',
            'phone' => '+254 712 345 678',
            'email' => 'info@acremann.co.ke',
            'address' => 'Nairobi, Kenya',
            'youtube_url' => 'https://youtube.com',
            'podcast_url' => 'https://podcasts.google.com',
            'csr_statement' => 'We invest in community tree planting, drainage improvements, and ethical land stewardship across every project.',
            'referral_program' => 'Refer a friend to Acremann and earn rewards when they complete a purchase. Our loyalty program recognises clients who grow with us.',
            'sustainability_intro' => 'Responsible land use, green open spaces, solar-ready planning, and long-term community value guide every Acremann development.',
            'investment_intro' => 'Whether you are an end-user, investor, or diaspora buyer, Acremann provides transparent advisory from site visit to title handover.',
        ]);

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

        TeamMember::insert([
            ['name' => 'Grace Wanjiku', 'role' => 'Managing Director', 'bio' => '15+ years in Kenyan real estate advisory.', 'is_leadership' => true, 'sort_order' => 1, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'James Ochieng', 'role' => 'Head of Conveyancing', 'bio' => 'Legal precision in every title transfer.', 'is_leadership' => true, 'sort_order' => 2, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sarah Muthoni', 'role' => 'Diaspora Relations', 'bio' => 'Supporting buyers abroad with confidence.', 'is_leadership' => false, 'sort_order' => 3, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Peter Kamau', 'role' => 'Project Sales Lead', 'bio' => 'Guiding clients from enquiry to handover.', 'is_leadership' => false, 'sort_order' => 4, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Testimonial::create(['quote' => 'Acremann made buying land in Kenya safe and transparent. The title process was clear from day one.', 'client_name' => 'Mary K.', 'client_detail' => 'Nachu plot owner', 'property_id' => $nachu->id, 'is_featured' => true, 'sort_order' => 1]);
        Testimonial::create(['quote' => 'As a diaspora investor, I appreciated the regular updates and verified documentation.', 'client_name' => 'David N.', 'client_detail' => 'Diaspora buyer — UK', 'is_featured' => true, 'sort_order' => 2]);

        Certification::insert([
            ['title' => 'Estate Agents Registration', 'description' => 'Registered real estate practitioners', 'sort_order' => 1, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Green Building Council Affiliate', 'description' => 'Sustainable development standards', 'sort_order' => 2, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Service::insert([
            ['title' => 'Land Sales', 'icon' => 'land', 'summary' => 'Residential and commercial plots with clean titles.', 'sort_order' => 1, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Investment Advisory', 'icon' => 'advisory', 'summary' => 'Data-led guidance for investors and end-users.', 'sort_order' => 2, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Conveyancing', 'icon' => 'legal', 'summary' => 'Full title search, transfer and registration support.', 'sort_order' => 3, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Diaspora Support', 'icon' => 'global', 'summary' => 'Remote purchase Kenya with documented processes.', 'sort_order' => 4, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Faq::insert([
            ['category' => 'general', 'question' => 'How do I buy land in Kenya safely?', 'answer' => 'Verify the title, conduct an official search, use a qualified advocate, and work with a trusted firm like Acremann for end-to-end transparency.', 'sort_order' => 1, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'title', 'question' => 'What is a clean title deed?', 'answer' => 'A clean title has no encumbrances, disputes, or unpaid charges. Acremann provides verified documentation before you commit.', 'sort_order' => 2, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'diaspora', 'question' => 'Can I buy land from abroad?', 'answer' => 'Yes. Acremann supports diaspora buyers with virtual site visits, documented POA, and secure payment milestones.', 'sort_order' => 3, 'is_published' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Post::create([
            'title' => 'How to Buy Land in Kenya Safely: A Complete Guide',
            'slug' => 'how-to-buy-land-in-kenya-safely',
            'excerpt' => 'Essential steps for secure land investment in Kenya.',
            'body' => '<p>Buying land in Kenya requires due diligence, title verification, and professional advisory. Here is what every buyer should know...</p>',
            'author' => 'Acremann Team',
            'published_at' => now()->subDays(3),
            'is_published' => true,
        ]);

        Page::create(['slug' => 'invest', 'title' => 'Why Invest With Acremann', 'subtitle' => 'Future-focused land investment', 'content' => '<p>Land remains one of Kenya\'s most resilient asset classes. Acremann combines legal precision, financial discipline, and sustainability thinking to protect your investment.</p>']);
        Page::create(['slug' => 'privacy', 'title' => 'Privacy Notice', 'content' => '<p>Acremann Properties collects personal data when you submit enquiries, subscribe to our newsletter, or use our client portal. We use this data to respond to your requests, improve our services, and — with consent — send marketing communications. You may request access, correction, or deletion of your data by contacting info@acremann.co.ke. We retain data only as long as necessary for these purposes.</p>']);

        ClientLookup::create(['reference_number' => 'ACR-TITLE-001', 'lookup_type' => 'title', 'status_message' => 'Title search complete. Transfer in progress — estimated completion 14 days.']);
        ClientLookup::create(['reference_number' => 'ACR-PAY-001', 'lookup_type' => 'payment', 'status_message' => 'Account current. Next installment due 1 June 2026.']);

        $this->seedAnalyticsData($nachu);
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
