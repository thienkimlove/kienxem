<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function landing1()
    {
        return view('frontend.landing1');
    }

    public function landing2()
    {
        return view('frontend.landing2');
    }

    public function saveContact(Request $request)
    {
        Contact::create($request->all());
        return redirect('/');
    }
}
