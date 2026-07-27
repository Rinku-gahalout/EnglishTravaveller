<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryController extends Controller
{
    protected function authorizeAdmin(): void
    {
        if (!auth('admin')->user()?->isAdmin()) {
            abort(403);
        }
    }
    public function listCategory()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(12);

        return view('wl-admin.category.listCategory', compact('categories'));
    }

    public function add_category()
    {
        return view('wl-admin.category.add_category');
    }

    public function store_category(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.categories.listCategory')
            ->with('success', 'Category created successfully.');
    }

    public function edit_category($id)
    {
        $category = Category::findOrFail($id);

        return view('wl-admin.category.edit_category', compact('category'));
    }

    public function update_category(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($category->id),
            ],
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.categories.listCategory')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy_category($id)
    {
        $this->authorizeAdmin();

        $category = Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
