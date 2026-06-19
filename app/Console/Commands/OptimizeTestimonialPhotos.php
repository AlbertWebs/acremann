<?php

namespace App\Console\Commands;

use App\Models\Testimonial;
use App\Support\TestimonialPhotoProcessor;
use Illuminate\Console\Command;

class OptimizeTestimonialPhotos extends Command
{
    protected $signature = 'testimonials:optimize-photos';

    protected $description = 'Generate sharp WebP display variants for testimonial photos';

    public function handle(): int
    {
        $testimonials = Testimonial::query()
            ->whereNotNull('photo_path')
            ->where('photo_path', '!=', '')
            ->get();

        if ($testimonials->isEmpty()) {
            $this->info('No testimonial photos found.');

            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($testimonials->count());
        $bar->start();

        foreach ($testimonials as $testimonial) {
            TestimonialPhotoProcessor::deleteVariants($testimonial->photo_path);
            TestimonialPhotoProcessor::process($testimonial->photo_path);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Optimized {$testimonials->count()} testimonial photo(s).");

        return self::SUCCESS;
    }
}
