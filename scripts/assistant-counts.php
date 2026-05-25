<?php

use App\Models\AssistantMenuItem;
use App\Models\SiteSetting;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$tables = [
    'assistant_menu_items',
    'assistant_sessions',
    'faqs',
];

foreach ($tables as $table) {
    try {
        echo $table.': '.DB::table($table)->count().PHP_EOL;
    } catch (Throwable $e) {
        echo $table.': (missing)'.PHP_EOL;
    }
}

$settings = SiteSetting::current();
echo 'assistant_heading: '.($settings->assistant_heading ?: '(empty)').PHP_EOL;
echo 'assistant_menu via model: '.AssistantMenuItem::count().PHP_EOL;
