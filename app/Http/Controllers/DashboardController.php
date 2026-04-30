<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\UnitEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
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

        return view('dashboard.index', compact('totalToday', 'totalMonth', 'activeMechanics', 'latestEntries'));
    }
}
