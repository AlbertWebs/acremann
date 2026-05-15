<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;

abstract class Controller
{
    protected function settings(): SiteSetting
    {
        return SiteSetting::current();
    }
}
