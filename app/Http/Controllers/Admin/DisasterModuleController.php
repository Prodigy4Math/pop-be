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
        $request->merge([
            'content_text' => $request->input('content_text', $request->input('content')),
            'content_url' => $request->input('content_url', $request->input('file_url')),
            'category' => $request->input('category', $request->input('disaster_type')),
            'type' => $request->input('type', 'teks'),
            'difficulty_level' => $request->input('difficulty_level', 1),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content_text' => 'nullable|string',
            'content_url' => 'nullable|string|max:500',
            'type' => 'required|in:teks,video,infografis,pdf',
            'category' => 'required|in:Gempa Bumi,Banjir,Longsor,Tsunami,Angin Puting Beliung,Kebakaran',
            'difficulty_level' => 'required|integer|min:1|max:5',
            'is_active' => 'nullable',
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
        $request->merge([
            'content_text' => $request->input('content_text', $request->input('content')),
            'content_url' => $request->input('content_url', $request->input('file_url')),
            'category' => $request->input('category', $request->input('disaster_type')),
            'type' => $request->input('type', $material->type ?? 'teks'),
            'difficulty_level' => $request->input('difficulty_level', $material->difficulty_level ?? 1),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content_text' => 'nullable|string',
            'content_url' => 'nullable|string|max:500',
            'type' => 'required|in:teks,video,infografis,pdf',
            'category' => 'required|in:Gempa Bumi,Banjir,Longsor,Tsunami,Angin Puting Beliung,Kebakaran',
            'difficulty_level' => 'required|integer|min:1|max:5',
            'is_active' => 'nullable',
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'disaster_type' => 'required|in:Gempa Bumi,Banjir,Longsor,Tsunami,Angin Puting Beliung,Kebakaran',
            'simulation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'disaster_type' => 'required|in:Gempa Bumi,Banjir,Longsor,Tsunami,Angin Puting Beliung,Kebakaran',
            'simulation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
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
