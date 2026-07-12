<?php

namespace App\Controller;

use Kite\Core\Request;

class HomeController
{
    public function index(Request $request)
    {
        return view('welcome', ['title' => 'KitePHP Documentation']);
    }
}
