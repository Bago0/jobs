<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    
    public function index()
    {
       
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in to view applications.');
        }

        $user = Auth::user();


        if (!$user->employer) {
            return redirect('/')->with('error', 'Employer information not found.');
        }
        $jobs = $user->employer->jobs;

        $applications = [];

        foreach ($jobs as $job) {
            $applications = array_merge($applications, $job->applications->all());
        }

        return view('applications.index', [
            'applications' => $applications,
        ]);
    }
}
