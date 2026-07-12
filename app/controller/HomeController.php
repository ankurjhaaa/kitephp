<?php

namespace App\Controller;

use Kite\Core\Request;

class HomeController
{
    public function index(Request $request)
    {
        return view('home', ['title' => 'Welcome to KitePHP']);
    }

    public function about(Request $request)
    {
        return view('about', ['title' => 'About KitePHP']);
    }

    public function submit(Request $request)
    {
        $name = $request->input('name', 'Guest');
        session()->flash('message', "Hello, {$name}! Form submitted via AJAX.");
        return redirect(route('home'));
    }
}
