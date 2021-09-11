<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductImage;

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
            $Product->brand_id = $request->brand_id;
            $Product->stock = $request->stock;
            $Product->model = $request->model;
            $Product->color = $request->color;
            $Product->price = $request->price;
            $Product->year = $request->year;
            $Product->description = $request->description;
            $Product->status = true;
            $Product->slug = Str::slug($Product->name);
            $Product->save();

            if ( $request->hasfile('product_image'))
                {
                    $files = $request->file('product_image');
                    foreach( $files  as $image )
                    {
                        $img = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/images/product'), $img);
                        $p_image = new ProductImage;
                        $p_image->product_id = $Product->id;
                        $p_image->product_image = $img;
                        $p_image->save();
                    }
        
                }
                else{

                }
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

            if($request->hasFile('product_image')){
                unlink(public_path('/images/product/'.$Product->image));

                $files = $request->file('product_image');
                    foreach( $files  as $image )
                    {
                        $img = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/images/product'), $img);
                        $p_image = new ProductImage;
                        $p_image->product_id = $Product->id;
                        $p_image->product_image = $img;
                        $p_image->save();
                    }
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

            $productimaged = ProductImage::where('product_id',  $Product->id)->get();
            foreach ($productimaged as $productimageId) {
                // unlink(public_path('/images/product/'.$Product->image));
                $productimageId = ProductImage::find($productimageId->id);
                $productimageId->delete();
            }
            $Product->delete();
            return response()->json('Product Delete Successfully');
        }
        else{
            return response()->json('Something went wrong'); 
        }
    
        
    }
}
