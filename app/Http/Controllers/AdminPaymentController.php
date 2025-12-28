<?php

namespace App\Http\Controllers;

use App\Models\payment;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()->with(['client', 'freelancer', 'postProject'])->orderBy('id', 'desc')->paginate(15);

        return view('Admin.payments.index', compact('payments'));
    }

}

