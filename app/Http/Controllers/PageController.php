<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }
    public function contact()
    {
        return view('pages.contact');
    }
    public function disclaimer()
    {
        return view('pages.disclaimer');
    }
    public function privacyPolicy()
    {
        return view('pages.privacy_policy');
    }
    public function term_conditions()
    {
        return view('pages.term_conditions');
    }
    
    
    
/**
     * Author Blogs
     */
  public function authorBlogs(Request $request, $authorName)
{
    $author     = 'Gabriel Potter';
    $authorSlug = Str::slug($author);

    if (Str::lower($authorName) !== $authorSlug) {
        abort(404);
    }

    /*
    | Pagination / search come in as ?page= or ?search=.
    | Flash them to the session and redirect to the clean URL.
    */
    if ($request->has('page') || $request->has('search')) {
        return redirect()
            ->route('author.blogs', ['authorName' => $authorSlug])
            ->with('author_state', [
                'page'   => max(1, (int) $request->query('page', 1)),
                'search' => trim((string) $request->query('search', '')),
            ]);
    }

    // Read the one-time state (defaults on a normal visit)
    $state  = session('author_state', ['page' => 1, 'search' => '']);
    $page   = $state['page'];
    $search = $state['search'];

    $blogs = Blog::with(['category', 'subcategory'])
        ->where('is_draft', 0)
        ->whereDate('created_at', '>=', '2026-09-10')
        ->whereHas('category', function ($query) {
            $query->whereNotIn('slug', ['articulos', 'espanol']);
        })
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('meta_title', 'LIKE', "%{$search}%")
                  ->orWhere('blog_heading', 'LIKE', "%{$search}%")
                  ->orWhere('blog_url', 'LIKE', "%{$search}%");
            });
        })
        ->orderBy('updated_at', 'desc')
        ->paginate(9, ['*'], 'page', $page)
        ->appends(['search' => $search]);   // keeps search when clicking page 2, 3...

    return view('author.author', [
        'author'     => $author,
        'authorSlug' => $authorSlug,
        'blogs'      => $blogs,
        'search'     => $search,
    ]);
}
}
