<?php

namespace App\Http\Controllers;

use App\Models\UnitEntry;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = UnitEntry::select('entry_date', DB::raw('count(*) as total'))
                          ->groupBy('entry_date')
                          ->orderBy('entry_date', 'desc');

        if ($request->filled('start_date')) {
            $query->whereDate('entry_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('entry_date', '<=', $request->end_date);
        }

        $histories = $query->paginate(15)->withQueryString();

        return view('history.index', compact('histories'));
    }

    public function exportPdfByDate($date)
    {
        $entries = UnitEntry::with(['mechanic', 'jobType'])
            ->whereDate('entry_date', $date)
            ->orderBy('entry_time', 'asc')
            ->get();

        $pdf = Pdf::loadView('unit-entry.pdf', compact('entries', 'date'));
        
        return $pdf->download('laporan-ahass-' . $date . '.pdf');
    }

    public function destroyByDate($date)
    {
        UnitEntry::whereDate('entry_date', $date)->delete();

        return redirect()->back();
    }
}
