<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index():View
    {
        if(auth()->check()) {
            $user = auth()->user();
        } else {
            $user = false;
        }



        return view('home', [
                'user' => $user
            ]
        );
    }
}
