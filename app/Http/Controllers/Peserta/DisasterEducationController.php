<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\DisasterMaterial;
use Illuminate\Http\Request;

class DisasterEducationController extends Controller
{
    public function materials()
    {
        $materials = DisasterMaterial::where('is_active', true)
            ->paginate(10);
        return view('peserta.disaster.materials', compact('materials'));
    }

    public function show(DisasterMaterial $material)
    {
        return view('peserta.disaster.show', compact('material'));
    }

    public function quiz()
    {
        return view('peserta.disaster.quiz');
    }
}
