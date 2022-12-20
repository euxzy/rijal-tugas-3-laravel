<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query()->get();
        return view("products.list", ["products" => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("products.upload");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->hashName();
            $file->move('images/products', $fileName);
            $request->image = $fileName;
        }
        $payload = [
            "name" => $request->input("name"),
            "image" => $request->image,
            "price" => $request->input("price"),
            "stock" => $request->input("stock"),
            "description" => $request->input("description")
        ];
        Product::query()->create($payload);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::query()->find($id);

        $payload = [
            "name" => $request->input("name"),
            "price" => $request->input("price"),
            "stock" => $request->input("stock"),
            "description" => $request->input("description")
        ];
        if ($request->hasFile('image')) {
            $oldImage = $product->image;
            if (file_exists(public_path('images/products/' . $oldImage))) {
                unlink(public_path('images/products/' . $oldImage));
            }

            $file = $request->file('image');
            $fileName = $file->hashName();
            $file->move('images/products', $fileName);
            $request->image = $fileName;

            $payload = Arr::prepend($payload, $request->image, 'image');
            $product->update($payload);
        } else {
            $product->update($payload);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::query()->find($id);
        $oldImage = $product->image;
        if (file_exists(public_path('images/products/' . $oldImage))) {
            unlink(public_path('images/products/' . $oldImage));
        }
        $product->delete();
        return redirect()->back();
    }
}
