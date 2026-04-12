<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    /**
     * Display the category listing page.
     */
    public function index()
    {
        return view('admin.category.category');
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.category.category_add');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'sort' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ]);

        $validated['name'] = $validated['title'];
        $validated['slug'] = Str::slug($validated['title']);
        $validated['parent_id'] = $request->input('parent_id', 0);
        $validated['sort'] = $request->input('sort', 0);
        $validated['is_active'] = $request->boolean('is_active', true);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('categories', 'public');
        }

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('categories/icons', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.category')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.category.category_edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'sort' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ]);

        $validated['name'] = $validated['title'];
        $validated['slug'] = Str::slug($validated['title']);
        $validated['parent_id'] = $request->input('parent_id', 0);
        $validated['sort'] = $request->input('sort', 0);
        $validated['is_active'] = $request->boolean('is_active', true);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            if ($category->thumbnail) {
                Storage::disk('public')->delete($category->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('categories', 'public');
        }

        // Handle icon upload
        if ($request->hasFile('icon')) {
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            $validated['icon'] = $request->file('icon')->store('categories/icons', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.category')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Prevent deleting parent that has children
        if (Category::where('parent_id', $category->id)->count() > 0) {
            return back()->with('error', 'Cannot delete a category that has subcategories. Delete the subcategories first.');
        }

        if ($category->thumbnail) {
            Storage::disk('public')->delete($category->thumbnail);
        }
        if ($category->icon) {
            Storage::disk('public')->delete($category->icon);
        }

        $category->delete();

        return redirect()->route('admin.category')->with('success', 'Category deleted successfully.');
    }
}
