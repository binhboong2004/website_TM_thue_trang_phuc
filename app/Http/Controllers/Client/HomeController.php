<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the public storefront homepage.
     */
    public function index(): View
    {
        return view('client.pages.home');
    }
}
