<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $clients = User::where('role', 'client')->count();
        $freelancers = User::where('role', 'freelancer')->count();
        $payments = Payment::sum('amount'); // Adjust based on your database structure

        // Get all users and apply the role filter if needed
        $query = User::query();

        if ($request->has('role') && in_array($request->role, ['client', 'freelancer'])) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10); // Adjust pagination as needed

        return view('admin.dashboard', compact('clients', 'freelancers', 'payments', 'users'));
    }
}
