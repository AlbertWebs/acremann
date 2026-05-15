<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\NewsletterSubscriber;
use App\Models\Property;
use Illuminate\Database\Seeder;

class AnalyticsSeeder extends Seeder
{
    public function run(): void
    {
        $property = Property::first();
        $sources = ['contact', 'site_visit', 'property_enquiry', 'brochure_download', 'chatbot'];
        $buyerTypes = ['end-user', 'investor', 'diaspora', 'jv', null];
        $names = ['James Kariuki', 'Mary Wanjiku', 'David Omondi', 'Grace Njeri', 'Peter Kamau'];

        if (Lead::count() < 15) {
            for ($day = 45; $day >= 0; $day--) {
                $count = random_int(0, 3);
                for ($i = 0; $i < $count; $i++) {
                    Lead::create([
                        'source' => $sources[array_rand($sources)],
                        'name' => $names[array_rand($names)],
                        'email' => 'demo'.uniqid().'@example.com',
                        'phone' => '07'.random_int(10000000, 99999999),
                        'property_id' => $property?->id,
                        'buyer_type' => $buyerTypes[array_rand($buyerTypes)],
                        'budget' => '1m-3m',
                        'status' => ['new', 'contacted', 'converted'][array_rand(['new', 'contacted', 'converted'])],
                        'consent_callback' => true,
                        'consent_email' => true,
                        'created_at' => now()->subDays($day)->subHours(random_int(0, 12)),
                        'updated_at' => now()->subDays($day),
                    ]);
                }
            }
        }

        NewsletterSubscriber::firstOrCreate(
            ['email' => 'demo-subscriber@example.com'],
            ['consent_marketing' => true, 'preferences' => []]
        );
    }
}
