<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_name = \request()->category;
        if($category_name){
            $products = Product::whereHas('category',function ($q) use($category_name){
                $q->where('name',$category_name);
            })->orderBy('id', 'DESC')->paginate(10);
        } else {
            $products = Product::orderBy('id', 'DESC')->paginate(10);
        }
        return $this->response('Products retrieved successfully.', $products,200 );

    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'category_id'=>'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required|boolean',
            'images' => 'required|array', // Adjust the validation rules as needed
        ]);

        // Generate a unique ID for the images
        $uniqueId = uniqid();

        // Initialize an array to store the generated filenames
        $imagePaths = [];

        // Loop through each uploaded image
        foreach ($request->file('images') as $index => $image) {
            // Generate a unique filename by appending the unique ID to the original filename
            $filename = 'image_' . $index . '_' . $uniqueId . '.' . $image->getClientOriginalExtension();

            // Store the image in the storage directory
            Storage::putFileAs('/products', $image, $filename);

            // Store the path or filename in the array
            $imagePaths[] = $filename;
        }
        $product = Product::create([
            'category_id'=>$request->category_id,
            'title'=>$request->title,
            'description'=>$request->description,
            'price'=>$request->price,
            'stock'=>$request->stock,
            'status'=>$request->status,
            'images'=>json_encode($imagePaths),
        ]);
        return $this->response('Products store successfully.', $product,201);

    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $this->response('Product retrieve successfully.', $product,201);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required|boolean',
            'images' => 'required|array',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validatedData);
        return $this->response('Products update successfully.', $product,200);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return $this->response(['product deleted successfully.',null],200);
    }

}
