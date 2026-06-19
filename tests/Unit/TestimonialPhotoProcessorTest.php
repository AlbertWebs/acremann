<?php

namespace Tests\Unit;

use App\Models\Testimonial;
use App\Support\TestimonialPhotoProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TestimonialPhotoProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_variant_path_uses_webp_suffix(): void
    {
        $this->assertSame(
            'testimonials/client-1200w.webp',
            TestimonialPhotoProcessor::variantPath('testimonials/client.jpg', 1200)
        );
    }

    public function test_process_creates_display_variants(): void
    {
        if (! function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('GD extension is not available.');
        }

        Storage::fake('public');

        $image = imagecreatetruecolor(1600, 2000);
        $path = Storage::disk('public')->path('testimonials/client.jpg');
        mkdir(dirname($path), 0777, true);
        imagejpeg($image, $path, 90);
        imagedestroy($image);

        TestimonialPhotoProcessor::process('testimonials/client.jpg');

        $this->assertTrue(Storage::disk('public')->exists('testimonials/client-600w.webp'));
        $this->assertTrue(Storage::disk('public')->exists('testimonials/client-1200w.webp'));

        $dimensions = getimagesize(Storage::disk('public')->path('testimonials/client-1200w.webp'));
        $this->assertNotFalse($dimensions);
        $this->assertSame(1200, $dimensions[0]);
    }

    public function test_testimonial_photo_srcset_uses_generated_variants(): void
    {
        if (! function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('GD extension is not available.');
        }

        Storage::fake('public');

        $image = imagecreatetruecolor(1600, 2000);
        $path = Storage::disk('public')->path('testimonials/client.jpg');
        mkdir(dirname($path), 0777, true);
        imagejpeg($image, $path, 90);
        imagedestroy($image);

        $testimonial = Testimonial::create([
            'quote' => 'Great experience.',
            'client_name' => 'Jane Doe',
            'photo_path' => 'testimonials/client.jpg',
            'is_featured' => true,
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $srcset = $testimonial->photoSrcset();

        $this->assertNotNull($srcset);
        $this->assertStringContainsString('600w', $srcset);
        $this->assertStringContainsString('1200w', $srcset);
        $this->assertStringContainsString('/storage/testimonials/client-600w.webp', $srcset);
    }

    public function test_delete_variants_removes_generated_files(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('testimonials/client-600w.webp', 'x');
        Storage::disk('public')->put('testimonials/client-1200w.webp', 'x');

        TestimonialPhotoProcessor::deleteVariants('testimonials/client.jpg');

        $this->assertFalse(Storage::disk('public')->exists('testimonials/client-600w.webp'));
        $this->assertFalse(Storage::disk('public')->exists('testimonials/client-1200w.webp'));
    }
}
