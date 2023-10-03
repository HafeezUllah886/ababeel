<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\products;
use App\Models\warehouses;
use Illuminate\Http\Request;
use Image;

class ProductsController extends Controller
{
    public function products(){
        $products = products::orderBy('code', 'asc')->get();
        return view('products.products')->with(compact('products'));
    }

    public function productAdd(){
        $products = products::all();
        return view('products.addProduct')->with(compact('products'));
    }

    public function productSave(request $req){
        $req->validate(
            [
                'code' => 'required',
                'color' => 'required',
                'length' => 'required',
                'width' => 'required',
                'sqf' => 'required',
                'sale_price' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png,gif',
            ]
        );

        $count = products::where('code',$req->code)->where('color',$req->color)->where('width',$req->width)->where('length', $req->length)->count();
        if($count > 0){
            return back()->with('error', 'Product Already Exists');
        }
        $image = $req->file('image');
        $image_name = $req->code.'_'.time().'.'.$image->getClientOriginalExtension();
        $image_path = public_path('/products1/'.$image_name);
        $image_path1 = '/products1/'.$image_name;
        $img = Image::make($image);
        $img->save($image_path,100);

        /* $req->image->move($image_path, $image_name); */
        products::create([
            'code' => $req->code,
            'color' => $req->color,
            'unit' => $req->base_unit,
            'length' => $req->length,
            'width' => $req->width,
            'sqf' => $req->sqf,
            'price' => $req->sale_price,
            'purchase_price' => $req->purchase_price,
            'sqf_price' => $req->sqf_price,
            'img' => $image_path1,
        ]);

        save_activity('New Product Added Code: '.$req->code);
        return redirect('/products')->with('success', 'Product added');
    }

    public function productDelete($id){
        $product = products::find($id);
        products::find($id)->delete();
        save_activity('Product Moved to Trash Code: '.$product->code);
        return back()->with('success', 'Product deleted');
    }
    public function productRestore($id){
        $product = products::withTrashed()->find($id);
        products::withTrashed()->find($id)->restore();
        save_activity('Product Restored from Trash Code: '.$product->code);
        return back()->with('success', 'Product Product Restored');
    }

    public function productsTrashed(){
        $products = products::onlyTrashed()->get();
        return view('products.trashed_products')->with(compact('products'));
    }

    public function productEdit($id){
        $product = products::find($id);
        if(!$product){
            return redirect()->back();
        }
       return view('products.editProduct')->with(compact('product'));
    }

    public function productUpdate(request $req,$id){
        $req->validate(
            [
                'color' => 'required',
                'width' => 'required',
                'length' => 'required',
                'sqf' => 'required',
                'price' => 'required',
            ]
        );
        $product = products::find($id);
        $count = products::where('code',$product->code)->where('color',$req->color)->where('width',$req->width)->where('length', $req->length)->where('id','!=',$id)->count();
        if($count > 0){
            return back()->with('error', 'Product Already Exists');
        }

        $product->color = $req->color;
        $product->width = $req->width;
        $product->length = $req->length;
        $product->price = $req->price;
        $product->sqf = $req->sqf;
        $product->unit = $req->base_unit;
        $product->purchase_price = $req->purchase_price;
        $product->sqf_price = $req->sqf_price;
        $product->save();

        save_activity('Product Edited Code: '.$product->code);
        return back()->with('msg', 'Product Updated');
    }

    public function productImageUpdate(request $req, $id){
        $req->validate(
            [
                'image' => 'required|mimes:jpg,jpeg,png,gif',
            ]
        );
        $product = products::find($id);

        if(file_exists(public_path($product->img)))
        {
            unlink(public_path($product->img));
        }
        $image = $req->file('image');
        $image_name = $product->code.'_'.time().'.'.$image->getClientOriginalExtension();
        $image_path = public_path('/products1/'.$image_name);
        $image_path1 = '/products1/'.$image_name;
        $img = Image::make($image);
        $img->save($image_path,100);

        $product->img = $image_path1;
        $product->save();

        save_activity('Product Image Changed Code: '.$product->code);
        return back()->with('msg', 'Product image Updated');
    }
}
