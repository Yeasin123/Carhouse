<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Brand;

class BrandController extends Controller
{

    public function index()
    {
        $brand = Brand::all();
        return response()->json($brand);
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
    
            $brand = new Brand;
            $brand->name = $request->name;
            $brand->slug = Str::slug($brand->name);

            $brand->status = true;
            $imageName = rand().'.'.$request->image->getClientOriginalExtension();
    
            $request->image->move(public_path('/images/brand'), $imageName);
            $brand->image = $imageName;
            $brand->save();
            return response()->json(['message' => 'Brand Added Successfully'],200);
            
        }
    }

    public function edit($id)
    {
        $brand = Brand::find($id);

        if($brand){
            return response()->json($brand);
        }
        
    }

    public function update(Request $request,$id)
    {
        $brand = Brand::find($id);

        if($brand){

            $brand->name = $request->name;
            $brand->slug = Str::slug($brand->name);

            $brand->status = true;

            if($request->hasFile('image')){
                unlink(public_path('/images/brand/'.$brand->image));

                $imageName = rand().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('/images/brand/'), $imageName);
                $brand->image = $imageName;

           }else{
            $brand->image =$brand->image;
           }
            $brand->update();
            return response()->json(['message' => 'Brand Updated Successfully'],200);
           
        }

        else{
            return response()->json('Something went wrong');
        }
        
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if($brand){
            unlink(public_path('/images/brand/'.$brand->image));
            $brand->delete();
            return response()->json('Brand Delete Successfully');
        }
        else{
            return response()->json('Something went wrong'); 
        }
    
        
    }
}
