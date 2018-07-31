<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SecurityController extends Controller
{
    public function index()
    {
        $settings = Setting::all();

        return view('security')->with('settings', $settings[0]);
    }
}
