<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategoryController extends Controller
{
    protected function authorizeAdmin(): void
    {
        if (!auth('admin')->user()?->isAdmin()) {
            abort(403);
        }
    }
    public function listSubcategory()
    {
        $subcategories = Subcategory::with('category')->orderBy('created_at', 'desc')->paginate(12);

        return view('wl-admin.subcategory.listSubcategory', compact('subcategories'));
    }

    public function add_subcategory()
    {
        $categories = Category::orderBy('name')->get();

        return view('wl-admin.subcategory.add_subcategory', compact('categories'));
    }

    public function store_subcategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategories,slug',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        $originalSlug = $slug;
        $count = 1;
        while (Subcategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subcategories.list')
            ->with('success', 'Subcategory created successfully.');
    }

    public function edit_subcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('wl-admin.subcategory.edit_subcategory', compact('subcategory', 'categories'));
    }

    public function update_subcategory(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('subcategories', 'slug')->ignore($subcategory->id),
            ],
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        $originalSlug = $slug;
        $count = 1;
        while (Subcategory::where('slug', $slug)->where('id', '!=', $subcategory->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subcategories.list')
            ->with('success', 'Subcategory updated successfully.');
    }

    public function destroy_subcategory($id)
    {
        $this->authorizeAdmin();

        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();

        return back()->with('success', 'Subcategory deleted successfully.');
    }
}
