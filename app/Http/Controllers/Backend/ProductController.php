<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $Product = Product::all();
        return response()->json($Product);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            // 'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors(),202);
        }
        else{
    
            $Product = new Product;
            $Product->name = $request->name;
            $Product->category_id = $request->category_id;
            $Product->stock = $request->stock;
            $Product->model = $request->model;
            $Product->color = $request->color;
            $Product->price = $request->price;
            $Product->description = $request->description;
            $Product->status = true;
            $Product->slug = Str::slug($Product->name);

            $Product->status = true;

            $imageName = rand().'.'.$request->image->getClientOriginalExtension();
    
            $request->image->move(public_path('/images/product'), $imageName);
            $Product->image = $imageName;
            $Product->save();
            return response()->json(['message' => 'Product Added Successfully'],200);
            
        }
    }

    public function edit($id)
    {
        $Product = Product::find($id);

        if($Product){
            return response()->json($Product);
        }
        
    }

    public function update(Request $request,$id)
    {
        $Product = Product::find($id);

        if($Product){

            $Product->name = $request->name;
            $Product->category_id = $request->category_id;
            $Product->stock = $request->stock;
            $Product->model = $request->model;
            $Product->color = $request->color;
            $Product->price = $request->price;
            $Product->description = $request->description;
            $Product->status = true;
            $Product->slug = Str::slug($Product->name);
            $Product->status = true;

            if($request->hasFile('image')){
                unlink(public_path('/images/product/'.$Product->image));

                $imageName = rand().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('/images/product'), $imageName);
                $Product->image = $imageName;

           }else{
            $Product->image =$Product->image;
           }
            $Product->update();
            return response()->json(['message' => 'Product Updated Successfully'],200);
           
        }

        else{
            return response()->json('Something went wrong');
        }
        
    }

    public function destroy($id)
    {
        $Product = Product::find($id);

        if($Product){
            
            unlink(public_path('/images/product/'.$Product->image));
            $Product->delete();
            return response()->json('Product Delete Successfully');
        }
        else{
            return response()->json('Something went wrong'); 
        }
    
        
    }
}
