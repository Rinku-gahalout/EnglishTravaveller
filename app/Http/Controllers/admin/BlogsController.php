<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\BlogFaq;
use App\Models\Category;
use App\Models\Subcategory;

class BlogsController extends Controller
{
    protected function authorizeAdmin(): void
    {
        if (!auth('admin')->user()?->isAdmin()) {
            abort(403);
        }
    }
// Blog page — 10 September 2026 onwards
public function index()
{
    $blogs = Blog::with(['category', 'subcategory'])
        ->where('is_draft', 0)
        ->where('created_at', '>=', '2026-09-10 00:00:00')
        ->orderBy('updated_at', 'desc')
        ->paginate(12);

    return view('wl-admin.blog.index', compact('blogs'));
}

// Old Blogs — before 10 September 2026
public function oldBlogs()
{
    $blogs = Blog::with(['category', 'subcategory'])
        ->where('is_draft', 0)
        ->where('created_at', '<', '2026-09-10 00:00:00')
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    return view('wl-admin.blog.old.index', compact('blogs'));
}





    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $subcategories = Subcategory::orderBy('name')->get();

        return view('wl-admin.blog.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'language' => 'required|string|max:10',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'blog_heading' => 'required|string|max:255',
            'blog_description' => 'required|string',
            'blog_url' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'alt_tag' => 'nullable|string|max:255',
            'is_draft' => 'required|boolean',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs|string|max:255',
            'faqs.*.answer' => 'required_with:faqs|string',
        ]);

$imagePath = null;

if ($request->hasFile('image')) {

    $image = $request->file('image');

    // public_html/blogimage
    $uploadPath = base_path('../blogimage');

    // Create directory if it doesn't exist
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }

    // Original filename
    $imageName = $image->getClientOriginalName();

    // Move image
    $image->move($uploadPath, $imageName);

    // Store this in database
    $imagePath = 'blogimage/' . $imageName;
}

        $blog = Blog::create([
            'language' => $data['language'],
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'] ?? null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
            'blog_heading' => $data['blog_heading'],
            'blog_description' => $data['blog_description'],
            'blog_url' => $data['blog_url'],
            'image' => $imagePath,
            'alt_tag' => $data['alt_tag'] ?? null,
            'is_draft' => $data['is_draft'],
        ]);

        if (!empty($data['faqs'])) {
            foreach ($data['faqs'] as $faqData) {
                if (!empty($faqData['question']) && !empty($faqData['answer'])) {
                    $blog->faqs()->create([
                        'question' => $faqData['question'],
                        'answer' => $faqData['answer'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }
    
    
public function BlogDetails($cate_subcate, $blog_slug)
{
    /*
    |--------------------------------------------------------------------------
    | Find Category
    |--------------------------------------------------------------------------
    */

    $category = Category::whereRaw(
        'LOWER(name) = ?',
        [
            str_replace(
                '-',
                ' ',
                strtolower($cate_subcate)
            )
        ]
    )->first();

    abort_if(!$category, 404);


    /*
    |--------------------------------------------------------------------------
    | Find Blog
    |--------------------------------------------------------------------------
    */

    $blog = Blog::with([
        'category',
        'subcategory',
        'faqs'
    ])
        ->where('category_id', $category->id)
        ->get()
        ->first(function ($item) use ($blog_slug) {

            return Str::slug($item->blog_heading) === $blog_slug;

        });


    abort_if(!$blog, 404);


    /*
    |--------------------------------------------------------------------------
    | DRAFT PROTECTION
    |--------------------------------------------------------------------------
    |
    | Draft blogs can only be viewed by logged-in admins.
    |
    */

    if (
        (int) $blog->is_draft === 1 &&
        !auth('admin')->check()
    ) {
        abort(404);
    }


    /*
    |--------------------------------------------------------------------------
    | BLOG VIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'wl-admin.blog.preview',
        compact('blog')
    );
}



    public function edit($id)
    {
        $blog = Blog::with('faqs')->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $subcategories = Subcategory::orderBy('name')->get();

        return view('wl-admin.blog.edit', compact('blog', 'categories', 'subcategories'));
    }

public function update(Request $request, $id)
{
    $blog = Blog::with('faqs')->findOrFail($id);

    $data = $request->validate([
        'language' => 'required|string|max:10',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'nullable|exists:subcategories,id',

        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'meta_keywords' => 'nullable|string',

        'blog_heading' => 'required|string|max:255',
        'blog_url' => 'required|string|max:255',
        'blog_description' => 'required|string',

        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        'alt_tag' => 'nullable|string|max:255',

        'is_draft' => 'required|boolean',

        'faqs' => 'nullable|array',
        'faqs.*.id' => 'nullable|exists:blog_faqs,id',
        'faqs.*.question' => 'required_with:faqs|string|max:255',
        'faqs.*.answer' => 'required_with:faqs|string',
    ]);

    /*DraftBlogDetails
    |--------------------------------------------------------------------------
    | Image Upload
    |--------------------------------------------------------------------------
    */

    $imagePath = $blog->image;

    if ($request->hasFile('image')) {

        $image = $request->file('image');

        // public_html/blogimage
        $uploadPath = base_path('../blogimage');

        // Create folder if it doesn't exist
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Delete old image
        if (!empty($blog->image)) {

            $oldImagePath = base_path('../' . $blog->image);

            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Generate unique filename
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Move image
        $image->move($uploadPath, $imageName);

        // Store relative path in database
        $imagePath = 'blogimage/' . $imageName;
    }

    /*
    |--------------------------------------------------------------------------
    | Update Blog
    |--------------------------------------------------------------------------
    */

    $blog->language = $data['language'];
    $blog->category_id = $data['category_id'];
    $blog->subcategory_id = $data['subcategory_id'] ?? null;

    $blog->meta_title = $data['meta_title'] ?? null;
    $blog->meta_description = $data['meta_description'] ?? null;
    $blog->meta_keywords = $data['meta_keywords'] ?? null;

    $blog->blog_heading = $data['blog_heading'];

    // Explicitly update blog URL
    $blog->blog_url = $data['blog_url'];

    $blog->blog_description = $data['blog_description'];

    $blog->image = $imagePath;
    $blog->alt_tag = $data['alt_tag'] ?? null;

    $blog->is_draft = $data['is_draft'];

    $blog->save();

    /*
    |--------------------------------------------------------------------------
    | FAQ Update
    |--------------------------------------------------------------------------
    */

    $existingFaqIds = $blog->faqs->pluck('id')->toArray();

    $submittedFaqIds = [];

    if (!empty($data['faqs'])) {

        foreach ($data['faqs'] as $faqData) {

            // Existing FAQ
            if (!empty($faqData['id'])) {

                $submittedFaqIds[] = $faqData['id'];

                $faq = $blog->faqs()->find($faqData['id']);

                if ($faq) {
                    $faq->update([
                        'question' => $faqData['question'],
                        'answer' => $faqData['answer'],
                    ]);
                }

            }
            // New FAQ
            elseif (
                !empty($faqData['question']) &&
                !empty($faqData['answer'])
            ) {

                $blog->faqs()->create([
                    'question' => $faqData['question'],
                    'answer' => $faqData['answer'],
                ]);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Removed FAQs
    |--------------------------------------------------------------------------
    */

    $toDelete = array_diff(
        $existingFaqIds,
        $submittedFaqIds
    );

    if (!empty($toDelete)) {
        BlogFaq::whereIn('id', $toDelete)->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('admin.blogs.index')
        ->with('success', 'Blog updated successfully.');
}

    public function drafts()
    {
        $blogs = Blog::with(['category', 'subcategory'])
            ->where('is_draft', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('wl-admin.blog.drafts', compact('blogs'));
    }

    public function trash()
    {
        $this->authorizeAdmin();

        $blogs = Blog::onlyTrashed()
            ->with(['category', 'subcategory'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(12);

        return view('wl-admin.blog.trash', compact('blogs'));
    }

    public function restore($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        $blog->restore();

        return redirect()->route('admin.blogs.trash')->with('success', 'Blog restored successfully.');
    }

    public function forceDelete($id)
    {
        $this->authorizeAdmin();

        $blog = Blog::onlyTrashed()->findOrFail($id);

        if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }

        $blog->forceDelete();

        return redirect()->route('admin.blogs.trash')->with('success', 'Blog permanently deleted successfully.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $blog = Blog::findOrFail($id);
        $blog->delete();

        return back()->with('success', 'Blog deleted successfully.');
    }
    
    
public function DraftBlogDetails($cate_subcate, $blog_slug)
{
    $cateSlug = Str::slug($cate_subcate);
    $postSlug = Str::slug($blog_slug);

    $blog = Blog::with(['category', 'subcategory', 'faqs'])
        ->where('is_draft', 1)
        ->get()
        ->first(function ($item) use ($cateSlug, $postSlug) {

            // Category: subcategory slug first, category slug as fallback
            $catSlug = optional($item->subcategory)->slug
                ?? optional($item->category)->slug;

            // Post: blog_url first, blog_heading as fallback
            return Str::slug($catSlug) === $cateSlug
                && $item->preview_slug === $postSlug;
        });

    abort_if(!$blog, 404);

    return response()
        ->view('wl-admin.blog.preview', compact('blog'))
        ->header('X-Robots-Tag', 'noindex, nofollow');
}

}
