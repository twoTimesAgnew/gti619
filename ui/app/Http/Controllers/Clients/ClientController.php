<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function residentialIndex()
    {
        return view('clients/residential');
    }

    public function businessIndex()
    {
        return view('clients/business');
    }
}
