<?php

namespace App\Http\Controllers;

use App\Models\LandingGallery;
use App\Models\LandingNews;
use App\Models\LandingSchedule;
use App\Models\LandingStanding;
use App\Models\Sport;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $sportId = $request->query('sport_id');

        $sports = Sport::orderBy('name')->get();

        $scheduleQuery = LandingSchedule::with('sport')
            ->orderBy('match_date');

        if ($sportId) {
            $scheduleQuery->where('sport_id', $sportId);
        }

        $schedules = $scheduleQuery->limit(12)->get();

        $liveMatches = LandingSchedule::with('sport')
            ->where('status', 'live')
            ->when($sportId, function ($query) use ($sportId) {
                $query->where('sport_id', $sportId);
            })
            ->orderBy('match_date')
            ->limit(3)
            ->get();

        $standings = LandingStanding::with('sport')
            ->when($sportId, function ($query) use ($sportId) {
                $query->where('sport_id', $sportId);
            })
            ->orderBy('sport_id')
            ->orderBy('position')
            ->limit(10)
            ->get();

        $news = LandingNews::where('is_active', true)
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        $gallery = LandingGallery::where('is_active', true)
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $selectedSport = $sportId ? $sports->firstWhere('id', (int) $sportId) : null;

        return view('welcome', compact(
            'sports',
            'schedules',
            'liveMatches',
            'standings',
            'news',
            'gallery',
            'sportId',
            'selectedSport'
        ));
    }
}
