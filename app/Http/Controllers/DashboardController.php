<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\UnitEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $totalToday = UnitEntry::whereDate('entry_date', $today)->count();

        $totalMonth = UnitEntry::whereMonth('entry_date', $today->month)
                               ->whereYear('entry_date', $today->year)
                               ->count();

        $activeMechanics = Mechanic::where('is_active', true)->count();

        $latestEntries = UnitEntry::with(['mechanic', 'jobType'])
                                  ->orderBy('entry_date', 'desc')
                                  ->orderBy('entry_time', 'desc')
                                  ->take(5)
                                  ->get();

        $filter = $request->input('filter_date', 'month');

        $chartQuery = Mechanic::leftJoin('unit_entries', function($join) use ($today, $filter) {
            $join->on('mechanics.id', '=', 'unit_entries.mechanic_id');
            if ($filter == 'today') {
                $join->whereDate('unit_entries.entry_date', '=', $today);
            } elseif ($filter == 'week') {
                $join->whereDate('unit_entries.entry_date', '>=', $today->copy()->subDays(7));
            } elseif ($filter == 'month') {
                $join->whereMonth('unit_entries.entry_date', '=', $today->month)
                     ->whereYear('unit_entries.entry_date', '=', $today->year);
            }
        })
        ->select('mechanics.name', DB::raw('count(unit_entries.id) as total'))
        ->where('mechanics.is_active', true)
        ->groupBy('mechanics.id', 'mechanics.name')
        ->orderBy('total', 'desc')
        ->get();

        $chartLabels = $chartQuery->pluck('name');
        $chartData = $chartQuery->pluck('total');

        return view('dashboard.index', compact(
            'totalToday', 'totalMonth', 'activeMechanics', 'latestEntries',
            'chartLabels', 'chartData', 'filter'
        ));
    }
}
