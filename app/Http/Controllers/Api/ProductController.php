<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //show products
    public function show()
    {
        $products = Product::with(["category","images"])->get();
        // dd($products);
        return response()->json([
            "message" => "Products List",
            "products" => $products
        ]);
    }

    // store products
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "price" => "required",
            "description" => "nullable",
            "quantity" => "required",
            "category_id" => "required",
            "image_id" => "required",

        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ]);
        }

        $product = Product::create([
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "quantity" => $request->quantity,
            "category_id" => $request->category_id,
            "image_id" => $request->image_id,
        ]);

        return response()->json([
            "message" => "Product create success!",
            "product" => $product
        ]);
    }

    // update product
    public function update(Product $product, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "price" => "required",
            "description" => "nullable",
            "quantity" => "required",
            "category_id" => "required",
            "image_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ]);
        }

        $product->update([
            "name" => $request->name,
            "price" => $request->price,
            "description" => $request->description,
            "quantity" => $request->quantity,
            "category_id" => $request->category_id,
            "image_id" => $request->image_id,
        ]);

        return response()->json(
            [
                "message" => "Product Update success",
                "product"=>$product
            ]
        );
    }

    // detaail product
    public function detail(Product $product){
        $result = Product::where("id",$product->id)->with("category","images")->first();
        return response()->json([
            "message"=>"detail product",
            "product"=>$result
        ]);
    }

    // delete product
    public function delete(Product $product){
        $product->delete();
        return response()->json([
            "message"=>"delete product scuuess!",
        ]);
    }

    // all product delete
    public function deleteAll(){
        // DB::table('products')->delete();
        Product::truncate();
        return response()->json([
            "message"=>" Delete All product "
        ]);
    }

    // Product imageUpload
    public function imageUpload(Request $request, Product $product){
        $validator = Validator::make($request->all(), [
            "url" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ]);
        }

        $uploadImages = $request->file("url");
        $urls= [];
        if(gettype($uploadImages) == "array"){
            foreach($uploadImages as $image){
                if(gettype($image)== "string"){
                    $fileName= $image->getClientOriginalName();
                    $urls[] = $fileName;
                }else{
                    $fileName= $image->getClientOriginalName();
                    $uploadImages->move(public_path()."/api/productImage/",$fileName); //new
                    $urls[] = $fileName;
                }
            }
        }else{
            $fileName= $uploadImages->getClientOriginalName();
            $urls[] = $fileName;
            $uploadImages->move(public_path()."/api/productImage/",$fileName);
        }

        if(count($urls) >1){
            $product->images()->delete();
        }

        foreach($urls as $url){
            Image::create([
                "url"=>$url,
                "product_id"=>$product->id,
            ]);
        }

        return response()->json([
            "message"=>"product images upload success",
        ]);
    }


}
