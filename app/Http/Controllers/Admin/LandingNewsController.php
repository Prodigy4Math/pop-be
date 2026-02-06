<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingNews;
use Illuminate\Http\Request;

class LandingNewsController extends Controller
{
    public function index()
    {
        $news = LandingNews::orderByDesc('published_at')
            ->paginate(15);

        return view('admin.landing.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.landing.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        LandingNews::create($validated);

        return redirect()->route('admin.landing.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(LandingNews $news)
    {
        return view('admin.landing.news.edit', compact('news'));
    }

    public function update(Request $request, LandingNews $news)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        $news->update($validated);

        return redirect()->route('admin.landing.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(LandingNews $news)
    {
        $news->delete();

        return redirect()->route('admin.landing.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
