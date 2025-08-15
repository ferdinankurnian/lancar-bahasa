<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function settings()
    {
        return view('admin.settings.settings');

    }
}
