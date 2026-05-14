<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateTryoutController extends Controller
{
    public function createTryout(Request $request)
    {
        return view('admin.create_tryout');
    }
}