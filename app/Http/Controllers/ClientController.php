<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostProject;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class ClientController extends Controller
{
    public function index()
    {
        // Fetch pending projects
        $pendingProjects = PostProject::where('freelancer_id', Auth::id())
            ->where('status', 'pending')
            ->with('client')
            ->get();

        // Fetch accepted projects
        $acceptedProjects = PostProject::where('freelancer_id', Auth::id())
            ->where('status', 'accepted')
            ->with('client')
            ->get();

        return view('clients.index', [
            'pendingProjects' => $pendingProjects,
            'acceptedProjects' => $acceptedProjects,
        ]);
    }
        // $freelancerId = Auth::id();

        // $projects = PostProject::where('freelancer_id', $freelancerId)
        //     ->where('status', 'pending') // Only show unaccepted projects
        //     ->get();

        // return view('clients.index', compact('projects'));


    public function accept($id)
    {
        $project = PostProject::where('id', $id)
            ->where('freelancer_id', Auth::id())
            ->firstOrFail();

        $project->update(['status' => 'accepted']);

        return redirect()->route('freelancer.projects')->with('success', 'Project accepted successfully!');
    }

    public function reject($id)
    {
        $project = PostProject::where('id', $id)
            ->where('freelancer_id', Auth::id())
            ->firstOrFail();

        $project->update(['status' => 'rejected']);

        return redirect()->route('freelancer.projects')->with('error', 'Project rejected.');
    }

    public function showTransactions()
    {
        $clientId = Auth::id();
        $transactions = Payment::where('paid_by', $clientId)
            ->join('post_projects', 'payments.post_project_id', '=', 'post_projects.id')
            ->join('users', 'payments.paid_to', '=', 'users.id')
            ->select('payments.created_at', 'payments.amount', 'post_projects.project_name', 'users.name as recipient_name')
            ->get();

        return view('ClientsContact.transactions', compact('transactions'));
    }
    public function delete($id)
    {
        $project = PostProject::where('id', $id)
            ->where('freelancer_id', Auth::id())
            ->firstOrFail();

        $project->delete();

        return redirect()->route('freelancer.projects')->with('success', 'Project deleted successfully!');
    }
}
