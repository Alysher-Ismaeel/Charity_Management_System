<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function Add(Request $request)
    {
        $input=$request->all();
        $category=Category::query()->create($input);
        return  response()->json([
            'message'=>' category added successfully',$category]);
    }
    
    public function show(){
        return Category::query()->get()->all();
     }
     
    public function delete(Category $category){
     $category->delete();
     return response()->json(['category have been deleted']);
     }
     
     public function update(Category $category,Request $request){
         $category->update($request->all());
         return response()->json(
             ['message'=>'updated successfully',$category]
         );
     }
}
