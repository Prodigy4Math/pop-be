<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingGallery;
use Illuminate\Http\Request;

class LandingGalleryController extends Controller
{
    public function index()
    {
        $gallery = LandingGallery::orderByDesc('created_at')
            ->paginate(15);

        return view('admin.landing.gallery.index', compact('gallery'));
    }

    public function create()
    {
        return view('admin.landing.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:photo,video'],
            'media_url' => ['required', 'url', 'max:2048'],
            'thumbnail_url' => ['nullable', 'url', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        LandingGallery::create($validated);

        return redirect()->route('admin.landing.gallery.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(LandingGallery $gallery)
    {
        return view('admin.landing.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, LandingGallery $gallery)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:photo,video'],
            'media_url' => ['required', 'url', 'max:2048'],
            'thumbnail_url' => ['nullable', 'url', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        $gallery->update($validated);

        return redirect()->route('admin.landing.gallery.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(LandingGallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.landing.gallery.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}
