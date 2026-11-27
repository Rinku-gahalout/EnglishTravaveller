<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\Category;

class AdminController extends Controller
{
    public function login() {
        return view('wl-admin.wl-auth.login');
    }

    public function authentication(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {

            $user = Auth::guard('admin')->user();

            // Allow only admin
            if (!in_array($user->role, ['admin', 'user'])) {
                Auth::guard('admin')->logout();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $request->session()->regenerate();

            return response()->json([
                'status' => 'success',
                'redirect' => route('admin.dashboard')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials'
        ], 401);
    }

  public function dashboard(Request $request)
{
    $search   = trim((string) $request->query('search'));
    $category = $request->query('category');

    // Home dashboard:
    // Show ONLY blogs created on or after 10 September 2026
    $blogsQuery = Blog::with(['category', 'subcategory'])
        ->where('is_draft', 0)
        ->where('created_at', '>=', '2026-09-10 00:00:00')
        ->orderBy('created_at', 'desc');

    if (!empty($category)) {
        $blogsQuery->where('category_id', $category);
    }

    if (!empty($search)) {
        $blogsQuery->where(function ($q) use ($search) {
            $q->where('blog_heading', 'like', '%' . $search . '%')
              ->orWhere('meta_title', 'like', '%' . $search . '%')
              ->orWhere('meta_keywords', 'like', '%' . $search . '%');
        });
    }

    $blogs = $blogsQuery
        ->paginate(10)
        ->withQueryString();

    $categories = Category::orderBy('name')->get();

    // Statistics — also based on 10 September 2026 onwards
    $totalBlogs = Blog::where('created_at', '>=', '2026-09-10 00:00:00')
        ->count();

    $publishedBlogs = Blog::where('is_draft', 0)
        ->where('created_at', '>=', '2026-09-10 00:00:00')
        ->count();

    $draftBlogs = Blog::where('is_draft', 1)
        ->where('created_at', '>=', '2026-09-10 00:00:00')
        ->count();

    $totalCategories = Category::count();

    return view('wl-admin.dashboard', compact(
        'blogs',
        'categories',
        'totalBlogs',
        'publishedBlogs',
        'draftBlogs',
        'totalCategories',
        'search',
        'category'
    ));
}


    public function logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}