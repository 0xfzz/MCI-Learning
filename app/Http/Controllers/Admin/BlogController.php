<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::query()
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blog = new Blog([
            'status' => 'draft',
        ]);

        return view('dashboard.admin.blogs.create', compact('blog'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        try {
            Blog::create([
                'title' => $validated['title'],
                'slug' => $this->generateUniqueSlug($validated['title']),
                'author' => optional($request->user())->name ?? 'Admin',
                'content' => $validated['content'],
                'status' => $validated['status'],
            ]);

            session()->flash('success', 'Artikel blog berhasil dibuat.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', 'Terjadi kesalahan saat menyimpan artikel blog.');

            return back()->withInput();
        }

        return redirect()->route('dashboard.blogs.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('dashboard.admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $validated = $this->validateData($request);

        try {
            $blog->update([
                'title' => $validated['title'],
                'slug' => $this->generateUniqueSlug($validated['title'], $blog->id),
                'content' => $validated['content'],
                'status' => $validated['status'],
            ]);

            session()->flash('success', 'Artikel blog berhasil diperbarui.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', 'Terjadi kesalahan saat memperbarui artikel blog.');

            return back()->withInput();
        }

        return redirect()->route('dashboard.blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        try {
            $blog->delete();
            session()->flash('success', 'Artikel blog berhasil dihapus.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', 'Terjadi kesalahan saat menghapus artikel blog.');
        }

        return redirect()->route('dashboard.blogs.index');
    }

    /**
     * Validate the incoming request data.
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'content' => ['required', 'string'],
        ]);
    }

    /**
     * Generate a unique slug based on the provided title.
     */
    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        if ($baseSlug === '') {
            $baseSlug = 'blog';
        }
        $slug = $baseSlug;
        $counter = 1;

        while (
            Blog::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
