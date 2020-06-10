<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function changeLanguage($language) {
        \Session::put('website_language', $language);

        return redirect()->back();
    }
}
