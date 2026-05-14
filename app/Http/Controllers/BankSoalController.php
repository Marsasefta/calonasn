<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankSoalController extends Controller
{
    public function createBankSoal(Request $request)
    {
        return view('admin.create_bank_soal');
    }
}