<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
    public function index()
    {
        $jobTypes = JobType::orderBy('code', 'asc')->get();
        return view('job-type.index', compact('jobTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:job_types,code',
            'name' => 'required|string|max:255',
        ]);

        JobType::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $jobType = JobType::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:job_types,code,' . $jobType->id,
            'name' => 'required|string|max:255',
        ]);

        $jobType->update($validated);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $jobType = JobType::findOrFail($id);
        $jobType->delete();

        return redirect()->back();
    }
}
