<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function ayuda()
    {
        return view('footer.ayuda');
    }

    public function terminos()
    {
        return view('footer.terminos');
    }

    public function privacidad()
    {
        return view('footer.privacidad');
    }
}
