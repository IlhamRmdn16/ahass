<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index()
    {
        $mechanics = Mechanic::orderBy('name', 'asc')->get();
        return view('mechanic.index', compact('mechanics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Mechanic::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $mechanic = Mechanic::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $mechanic->update($validated);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $mechanic = Mechanic::findOrFail($id);
        $mechanic->delete();

        return redirect()->back();
    }
}
