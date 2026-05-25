<?php

namespace App\Console\Commands;

use Database\Seeders\AssistantContentSeeder;
use Illuminate\Console\Command;

class RestoreAssistantContent extends Command
{
    protected $signature = 'acremann:restore-assistant';

    protected $description = 'Restore Acremann Assistant menu buttons, FAQs, and widget copy from the demo seeder';

    public function handle(): int
    {
        $this->call(AssistantContentSeeder::class);

        $this->info('Acremann Assistant content restored.');
        $this->line('  • Admin → Acremann Assistant → Assistant content');
        $this->line('  • Admin → Acremann Assistant → Menu buttons');
        $this->line('  • Admin → Acremann Assistant → FAQs (show in assistant)');

        return self::SUCCESS;
    }
}
