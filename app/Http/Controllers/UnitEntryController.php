<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use App\Models\Mechanic;
use App\Models\UnitEntry;
use Illuminate\Http\Request;

class UnitEntryController extends Controller
{
    public function index()
    {
        $mechanics = Mechanic::where('is_active', true)->get();
        $jobTypes = JobType::all();
        
        $entries = UnitEntry::with(['mechanic', 'jobType'])
            ->whereDate('entry_date', now()->toDateString())
            ->orderBy('entry_time', 'desc')
            ->get();

        return view('unit-entry.index', compact('mechanics', 'jobTypes', 'entries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'police_number' => 'required|string|max:20',
            'motor_type' => 'required|string|max:50',
            'mechanic_id' => 'required|exists:mechanics,id',
            'job_type_id' => 'required|exists:job_types,id',
            'phone_number' => 'nullable|string|max:20',
            'reason' => 'nullable|string',
        ]);

        $validated['entry_date'] = now()->toDateString();
        $validated['entry_time'] = now()->toTimeString();
        $validated['is_daya_auto'] = $request->boolean('is_daya_auto');

        UnitEntry::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $entry = UnitEntry::findOrFail($id);

        $validated = $request->validate([
            'police_number' => 'required|string|max:20',
            'motor_type' => 'required|string|max:50',
            'mechanic_id' => 'required|exists:mechanics,id',
            'job_type_id' => 'required|exists:job_types,id',
            'phone_number' => 'nullable|string|max:20',
            'reason' => 'nullable|string',
        ]);

        $validated['is_daya_auto'] = $request->boolean('is_daya_auto');

        $entry->update($validated);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $entry = UnitEntry::findOrFail($id);
        $entry->delete();

        return redirect()->back();
    }

    public function exportPdf()
    {
        $entries = UnitEntry::with(['mechanic', 'jobType'])
            ->whereDate('entry_date', now()->toDateString())
            ->orderBy('entry_time', 'asc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('unit-entry.pdf', compact('entries'));
        
        return $pdf->download('laporan-unit-entry-' . now()->format('Y-m-d') . '.pdf');
    }
}
