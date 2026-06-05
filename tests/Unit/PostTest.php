<?php

namespace Tests\Unit;

use App\Models\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function test_rendered_body_wraps_tables_for_styling(): void
    {
        $post = new Post([
            'body' => '<p>Intro</p><table><thead><tr><th>Col</th></tr></thead><tbody><tr><td>Val</td></tr></tbody></table>',
        ]);

        $html = $post->renderedBody();

        $this->assertStringContainsString('<div class="insight-table-wrap"><table>', $html);
        $this->assertStringContainsString('</table></div>', $html);
    }

    public function test_rendered_body_leaves_content_without_tables_unchanged(): void
    {
        $body = '<p>No table here.</p>';
        $post = new Post(['body' => $body]);

        $this->assertSame($body, $post->renderedBody());
    }
}
