<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;

class IndexPageController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['category', 'subcategory'])
            ->where('is_draft', 0)
            ->whereHas('category', function ($query) {
                $query->where('slug', 'blog');
            })
            ->latest()
            ->take(6)
            ->get();

        $blogs->each(function ($blog) {
            $blog->slug = Str::slug($blog->blog_heading);
        });

        return view('index', compact('blogs'));
    }
}