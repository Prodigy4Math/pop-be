<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\EquipmentLoanRequest;
use App\Models\Sport;
use Illuminate\Http\Request;

class EquipmentLoanController extends Controller
{
    public function index()
    {
        $requests = EquipmentLoanRequest::where('user_id', auth('peserta')->id())
            ->with('sport')
            ->latest()
            ->paginate(10);

        return view('peserta.loans.index', compact('requests'));
    }

    public function create()
    {
        $sports = Sport::orderBy('name')->get();
        return view('peserta.loans.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => ['required', 'exists:sports,id'],
            'item_name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
            'needed_date' => ['required', 'date'],
            'return_date' => ['nullable', 'date', 'after_or_equal:needed_date'],
            'purpose' => ['required', 'string'],
        ]);

        EquipmentLoanRequest::create([
            'user_id' => auth('peserta')->id(),
            'sport_id' => $validated['sport_id'],
            'item_name' => $validated['item_name'],
            'quantity' => $validated['quantity'],
            'needed_date' => $validated['needed_date'],
            'return_date' => $validated['return_date'] ?? null,
            'purpose' => $validated['purpose'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('peserta.loans.index')
            ->with('success', 'Permintaan peminjaman alat berhasil dikirim.');
    }
}
