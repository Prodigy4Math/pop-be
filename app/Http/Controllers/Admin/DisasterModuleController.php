<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisasterMaterial;
use App\Models\DisasterSimulation;
use Illuminate\Http\Request;

class DisasterModuleController extends Controller
{
    // MATERIALS MANAGEMENT
    public function indexMaterials()
    {
        $materials = DisasterMaterial::paginate(15);
        return view('admin.disaster.materials.index', compact('materials'));
    }

    public function createMaterial()
    {
        return view('admin.disaster.materials.create');
    }

    public function storeMaterial(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'disaster_type' => 'required|in:Gempa Bumi,Banjir,Longsor,Tsunami,Angin Puting Beliung,Kebakaran',
            'file_url' => 'nullable|string|max:500',
            'is_active' => 'nullable'
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        DisasterMaterial::create($validated);
        return redirect()->route('admin.disaster.materials.index')
            ->with('success', 'Materi bencana berhasil dibuat');
    }

    public function editMaterial(DisasterMaterial $material)
    {
        return view('admin.disaster.materials.edit', compact('material'));
    }

    public function updateMaterial(Request $request, DisasterMaterial $material)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'disaster_type' => 'required|in:Gempa Bumi,Banjir,Longsor,Tsunami,Angin Puting Beliung,Kebakaran',
            'file_url' => 'nullable|string|max:500',
            'is_active' => 'nullable'
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $material->update($validated);
        return redirect()->route('admin.disaster.materials.index')
            ->with('success', 'Materi bencana berhasil diperbarui');
    }

    public function destroyMaterial(DisasterMaterial $material)
    {
        $material->delete();
        return redirect()->route('admin.disaster.materials.index')
            ->with('success', 'Materi bencana berhasil dihapus');
    }

    // SIMULATIONS MANAGEMENT
    public function indexSimulations()
    {
        $simulations = DisasterSimulation::paginate(15);
        return view('admin.disaster.simulations.index', compact('simulations'));
    }

    public function createSimulation()
    {
        return view('admin.disaster.simulations.create');
    }

    public function storeSimulation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'disaster_type' => 'required|in:Gempa Bumi,Banjir,Longsor,Tsunami,Angin Puting Beliung,Kebakaran',
            'simulation_date' => 'required|date',
            'location' => 'required|string|max:255',
            'max_participants' => 'required|integer|min:10|max:500',
            'is_active' => 'nullable'
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        DisasterSimulation::create($validated);
        return redirect()->route('admin.disaster.simulations.index')
            ->with('success', 'Simulasi bencana berhasil dibuat');
    }

    public function editSimulation(DisasterSimulation $simulation)
    {
        return view('admin.disaster.simulations.edit', compact('simulation'));
    }

    public function updateSimulation(Request $request, DisasterSimulation $simulation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'disaster_type' => 'required|in:Gempa Bumi,Banjir,Longsor,Tsunami,Angin Puting Beliung,Kebakaran',
            'simulation_date' => 'required|date',
            'location' => 'required|string|max:255',
            'max_participants' => 'required|integer|min:10|max:500',
            'is_active' => 'nullable'
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $simulation->update($validated);
        return redirect()->route('admin.disaster.simulations.index')
            ->with('success', 'Simulasi bencana berhasil diperbarui');
    }

    public function destroySimulation(DisasterSimulation $simulation)
    {
        $simulation->delete();
        return redirect()->route('admin.disaster.simulations.index')
            ->with('success', 'Simulasi bencana berhasil dihapus');
    }
}
