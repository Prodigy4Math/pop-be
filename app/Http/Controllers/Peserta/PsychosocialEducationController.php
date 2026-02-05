<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\PsychosocialActivity;
use Illuminate\Http\Request;

class PsychosocialEducationController extends Controller
{
    public function index()
    {
        $activities = PsychosocialActivity::where('is_active', true)
            ->paginate(10);
        return view('peserta.psychosocial.index', compact('activities'));
    }

    public function show(PsychosocialActivity $activity)
    {
        return view('peserta.psychosocial.show', compact('activity'));
    }

    public function resources()
    {
        return view('peserta.psychosocial.resources');
    }
}
