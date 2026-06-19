<?php

namespace App\Observers;

use App\Models\Testimonial;
use App\Support\TestimonialPhotoProcessor;

class TestimonialObserver
{
    public function saved(Testimonial $testimonial): void
    {
        if (! $testimonial->wasChanged('photo_path')) {
            return;
        }

        $previousPath = $testimonial->getOriginal('photo_path');

        if (filled($previousPath) && $previousPath !== $testimonial->photo_path) {
            TestimonialPhotoProcessor::deleteVariants($previousPath);
        }

        if (filled($testimonial->photo_path)) {
            TestimonialPhotoProcessor::process($testimonial->photo_path);
        }
    }

    public function deleted(Testimonial $testimonial): void
    {
        TestimonialPhotoProcessor::deleteVariants($testimonial->photo_path);
    }
}
