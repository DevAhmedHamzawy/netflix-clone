<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:categories-read')->only(['index']);
        $this->middleware('permission:categories-create')->only(['create','store']);
        $this->middleware('permission:categories-update')->only(['edit', 'update']);
        $this->middleware('permission:categories-delete')->only(['destroy']);

    }

    public function index()
    {
        $categories = Category::whenSearch(request()->search)->withCount('movies')->paginate(5);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create($request->all());
        session()->flash('success', 'Data Added Successfully');

        return redirect()->route('dashboard.categories.index');
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        $category->update($request->all());

        session()->flash('success', 'Data Updated Successfully');
        return redirect()->route('dashboard.categories.index');

    }

    public function destroy(Category $category)
    {
        $category->delete();

        session()->flash('success', 'Data Deleted Successfully');

        return redirect()->route('dashboard.categories.index');

    }

}
