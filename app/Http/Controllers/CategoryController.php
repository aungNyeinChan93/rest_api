<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller


{
    // create category
    public function store(Request $request){


        $validated = $request->validate([
            "name" => "required",
        ]);

        $category = Category::create($validated);

        return response()->json([
            "message"=>"category create success",
            "category"=>$category
        ]);
    }

    // update category
    public function update(Category $category,Request $request){
        $validated = $request->validate([
            "name" => "required",
        ]);

        $category->update($validated);

        return response()->json([
            "message"=>"category update success",
            "category"=>$category
        ]);
    }

    // delete category
    public function delete(Category $category){
        $category->delete();
        return response()->json([
            "message"=>"category delete success",
        ]);
    }

    // show category
    public function show(){
        $categories = Category::all();
        if($categories->first() == null){
            return response()->json([
                "errors"=>"Categories list is empty!"
            ]);
        }
        return response()->json([
            "message"=>"Categories List ",
            "categories"=>$categories
        ]);
    }
}
