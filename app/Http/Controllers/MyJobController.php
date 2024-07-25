<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;

class MyJobController extends Controller
{
    public function index()
    {
 
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in to view your jobs.');
        }

        $userId = Auth::id();
        $user = Auth::user();

        if (!$user->employer) {
            return redirect('/')->with('error', 'Employer information not found.');
        }

        $jobs = Job::latest()
                   ->where('employer_id', $userId)
                   ->with(['employer', 'tags'])
                   ->get();

        $groupedJobs = $jobs->groupBy('featured');

        return view('jobs.myjobs', [
            'jobs' => $groupedJobs->get(0, collect()), 
            'featuredJobs' => $groupedJobs->get(1, collect()),
            'tags' => Tag::all(),
        ]);
    }
}
