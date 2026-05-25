<?php

use App\Models\SiteSetting;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$s = SiteSetting::current();
echo 'id='.$s->id.PHP_EOL;
echo 'heading='.($s->assistant_heading ?? 'null').PHP_EOL;
echo 'buyer_types='.json_encode($s->assistant_buyer_types).PHP_EOL;
echo 'budget_ranges='.json_encode($s->assistant_budget_ranges).PHP_EOL;
