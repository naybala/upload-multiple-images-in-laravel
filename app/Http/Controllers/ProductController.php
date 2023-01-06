<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        // dd($request['images']);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:855',
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        foreach ($request->file('images') as $imagefile) { //image come from frontend was array like images[]
            $image = new Image;
            $path = $imagefile->store('/images/resource', ['disk' => 'my_files']);
            $image->url = $path;
            $image->product_id = $product->id;
            $image->save();
        }
    }
}