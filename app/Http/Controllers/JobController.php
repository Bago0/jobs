<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class JobController extends Controller
{

    public function index()
    {
        $jobs = Job::latest()->with(['employer', 'tags'])->get()->groupBy('featured');

        return view('jobs.index', [
            'jobs' => $jobs->get(0, collect()), 
            'featuredJobs' => $jobs->get(1, collect()),
            'tags' => Tag::all(),
        ]);
    }


    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required'],
            'salary' => ['required'],
            'location' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'active_url'],
            'tags' => ['nullable'],
            'expiration_date' => ['required', 'date'],
        ]);

        $attributes['salary'] = intval($attributes['salary'] * 100);

        $attributes['featured'] = $request->has('featured');

        $job = Auth::user()->employer->jobs()->create(Arr::except($attributes, 'tags'));

        if ($attributes['tags'] ?? false) {
            foreach (explode(',', $attributes['tags']) as $tag) {
                $job->tag($tag);
            }
        }

        return redirect('/');
    }

    public function showApplicationForm(Job $job)
    {
        if (!Auth::check() || Auth::id() === $job->employer_id) {
            return redirect('/')->with('error', 'You are not authorized to apply for this job.');
        }

        return view('jobs.apply', ['job' => $job]);
    }

    public function storeApplication(Request $request, Job $job)
    {
        if (!Auth::check() || Auth::id() === $job->employer_id) {
            return redirect('/')->with('error', 'You are not authorized to apply for this job.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'motivational_letter' => 'required|string',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'private');

        $application = $job->applications()->create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'email' => $validated['email'],
            'cv_path' => $cvPath,
            'motivational_letter' => $validated['motivational_letter'],
        ]);

        return redirect('/')->with('status', 'Your application has been submitted successfully!');
    }

    public function applications($jobId)
    {
        $job = Job::where('employer_id', Auth::user()->employer->id)
                   ->findOrFail($jobId);

        $applications = Application::where('job_id', $jobId)->get();

        return view('jobs.applications', [
            'job' => $job,
            'applications' => $applications,
        ]);
    }

   public function downloadCv($applicationId)
    {
        $application = Application::findOrFail($applicationId);

       
        $job = $application->job;
        if (Auth::user()->id !== $job->employer_id) {
            abort(403, 'Unauthorized action.');
        }

        $cvPath = storage_path("app/public/{$application->cv_path}");

        if (!file_exists($cvPath)) {
            abort(404, 'File not found.');
        }

        return response()->download($cvPath);
    }

    
}
