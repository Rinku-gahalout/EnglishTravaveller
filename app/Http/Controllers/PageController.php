<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }
    public function contact()
    {
        return view('pages.contact');
    }
    public function disclaimer()
    {
        return view('pages.disclaimer');
    }
    public function privacyPolicy()
    {
        return view('pages.privacy_policy');
    }
    public function term_conditions()
    {
        return view('pages.term_conditions');
    }
}
