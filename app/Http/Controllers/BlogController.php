<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    /**
     * Display a listing of the published blog posts.
     */
    public function index(): View
    {
        $featured = Blog::published()
            ->latest()
            ->take(3)
            ->get();

        $articles = Blog::published()
            ->when($featured->count() >= 3, fn ($query) => $query->whereNotIn('id', $featured->pluck('id')))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('blog.index', [
            'heroPost' => $featured->first(),
            'secondaryFeatured' => $featured->skip(1),
            'articles' => $articles,
        ]);
    }

    /**
     * Display the specified blog post.
     */
    public function show(string $slug): View
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        return view('blog.show', [
            'blog' => $blog,
            'related' => $related,
        ]);
    }
}
