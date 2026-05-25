<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

foreach (['users', 'properties', 'leads', 'site_visit_bookings', 'client_lookups', 'posts', 'team_members', 'site_settings'] as $table) {
    try {
        echo $table.': '.DB::table($table)->count().PHP_EOL;
    } catch (Throwable $e) {
        echo $table.': (error)'.PHP_EOL;
    }
}
