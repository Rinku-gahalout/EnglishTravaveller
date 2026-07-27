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
    public function index()
    {
        $blogs = Blog::with(['category', 'subcategory'])->orderBy('created_at', 'desc')->paginate(12);

        return view('wl-admin.blog.index', compact('blogs'));
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

    $imageName = time() . '_' . $image->getClientOriginalName();

    $image->move(public_path('blogimage'), $imageName);

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
            'blog_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'alt_tag' => 'nullable|string|max:255',
            'is_draft' => 'required|boolean',
            'faqs' => 'nullable|array',
            'faqs.*.id' => 'nullable|exists:blog_faqs,id',
            'faqs.*.question' => 'required_with:faqs|string|max:255',
            'faqs.*.answer' => 'required_with:faqs|string',
        ]);

        // Upload new image if selected
$imagePath = $blog->image;

if ($request->hasFile('image')) {

    if ($blog->image && file_exists(public_path($blog->image))) {
        unlink(public_path($blog->image));
    }

    $image = $request->file('image');
    $imageName = time() . '_' . $image->getClientOriginalName();
    $image->move(public_path('blogimage'), $imageName);

    $imagePath = 'blogimage/' . $imageName;
}

        $blog->update([
            'language' => $data['language'],
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'] ?? null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
            'blog_heading' => $data['blog_heading'],
            'blog_description' => $data['blog_description'],
            'image' => $imagePath,
            'alt_tag' => $data['alt_tag'] ?? null,
            'is_draft' => $data['is_draft'],
        ]);

        $existingFaqIds = $blog->faqs->pluck('id')->toArray();
        $submittedFaqIds = [];

        if (!empty($data['faqs'])) {
            foreach ($data['faqs'] as $faqData) {
                if (!empty($faqData['id'])) {
                    $submittedFaqIds[] = $faqData['id'];
                    $faq = $blog->faqs()->find($faqData['id']);
                    if ($faq) {
                        $faq->update([
                            'question' => $faqData['question'],
                            'answer' => $faqData['answer'],
                        ]);
                    }
                } elseif (!empty($faqData['question']) && !empty($faqData['answer'])) {
                    $blog->faqs()->create([
                        'question' => $faqData['question'],
                        'answer' => $faqData['answer'],
                    ]);
                }
            }
        }

        $toDelete = array_diff($existingFaqIds, $submittedFaqIds);
        if (!empty($toDelete)) {
            BlogFaq::whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
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
}
