<?php

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$users = User::all(['id', 'name', 'email']);
echo 'Users: '.$users->count().PHP_EOL;
foreach ($users as $user) {
    echo "  #{$user->id} {$user->email} ({$user->name})".PHP_EOL;
}
