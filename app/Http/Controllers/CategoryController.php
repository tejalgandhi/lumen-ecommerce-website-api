<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return $this->response('category retrieved successfully.', $categories,200 );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($request->all());
        return $this->response('Category store successfully.', $category,201);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return $this->response('Category retrieve successfully.', $category,201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return $this->response('Category update successfully.', $category,200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return $this->response(['category deleted successfully.',null],200);
    }
}
