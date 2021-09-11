<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(),202);
        }
        else{
    
            $category = new Category;
            $category->name = $request->name;
            $category->slug = Str::slug($category->name);

            $category->status = true;
            $imageName = rand().'.'.$request->image->getClientOriginalExtension();
    
            $request->image->move(public_path('/images/category'), $imageName);
            $category->image = $imageName;
            $category->save();
            return response()->json(['message' => 'category Added Successfully'],200);
            
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);

        if($category){
            return response()->json($category);
        }
        
    }

    public function update(Request $request,$id)
    {
        $category = Category::find($id);

        if($category){

            $category->name = $request->name;
            $category->slug = Str::slug($category->name);

            $category->status = true;

            if($request->hasFile('image')){
                unlink(public_path('/images/category/'.$category->image));

                $imageName = rand().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('/images/category/'), $imageName);
                $category->image = $imageName;

           }else{
            $category->image =$category->image;
           }
            $category->update();
            return response()->json(['message' => 'category Updated Successfully'],200);
           
        }

        else{
            return response()->json('Something went wrong');
        }
        
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if($category){
            
            unlink(public_path('/images/category/'.$category->image));
            $category->delete();
            return response()->json('category Delete Successfully');
        }
        else{
            return response()->json('Something went wrong'); 
        }
    
        
    }
}
