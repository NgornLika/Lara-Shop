<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function AddProduct() {
        $category   = DB::table('category')
                        ->orderBy('id','DESC')
                        ->get();
        $colors     = DB::table('attribute')
                        ->where('type','color')
                        ->orderBy('id','DESC')
                        ->get();
        $sizes      = DB::table('attribute')
                        ->where('type','size')
                        ->orderBy('id','DESC')
                        ->get();              
        return view('backend.add-product',[
            'category'=>$category,
            'colors'   => $colors,
            'sizes'    =>$sizes
        ]);
    }
    public function AddProductSubmit(Request $request){
        // Get local timezone
        date_default_timezone_set("Asia/Bangkok");

        $name           = $request->name;
        $slug           = $this->GenerateSlug($name);
        $qty            = $request->qty;
        $regular_price  = $request->regular_price;
        $sale_price     = $request->sale_price != '' ? $request->sale_price : 0;
        $category_id    = $request->category;
        $description    = $request->description;
        $date           = date('Y-m-d H:i:s');
        $file           = $request->file('thumbnail');
        $thumbnail = $this->uploadFile($file);

//implode=>array->string
        $size = $request->size;
        $sizeVal = implode(", ",$size);
        $color= $request->color;
        $colorVal = implode(", ",$color);

        $product = DB::table('product')->insert([
                        'name'=>$name,
                        'slug'=>$slug,
                        'qty'=>$qty,
                        'regular_price'=>$regular_price,
                        'sale_price'=>$sale_price,
                        'color'=>$colorVal,
                        'size' =>$sizeVal,
                        'author'=>Auth::user()->id,
                        'category'=>$category_id,
                        'viewer'=>0,
                        'thumbnail'=>$thumbnail,
                        'description'=>$description,
                        'created_at' => $date,
                        'updated_at' => $date
                    ]);
        if($product){
            $this->logActivity($name,'Product','Insert',$date);
            return redirect('/admin/add-product')->with('message','Product Inserted');
        }
    }

    public function ListProduct() {
        $products = DB::table('product')
                        ->leftJoin('users', 'users.id', 'product.author')
                        ->leftJoin('category', 'category.id', 'product.category')
                        ->select('users.name AS username', 'category.name AS category_name', 'product.*')
                        ->orderByDesc('product.id')
                        ->get();
        return view('backend.list-product',[
            'products' => $products
        ]);
    }

    public function UpdateProduct($id){
        $category   = DB::table('category')
                        ->orderBy('id','DESC')
                        ->get();
        $attrColor  = DB::table('attribute')
                        ->where('type','color')
                        ->orderBy('id','DESC')
                        ->get();
        $attrSize     = DB::table('attribute')
                        ->where('type','size')
                        ->select('value')
                        ->orderBy('id','DESC')
                        ->get(); 
        $product    = DB::table('product')
                    ->find($id);

        $size = str_replace(" ", "", $product->size) ;
        $color = str_replace(" ", "", $product->color) ;

        return view('backend.update-product',[
            'product'  =>$product,
            'category' =>$category,
            'attrSize' =>$attrSize,
            'attrColor'=>$attrColor,
            'size'     =>explode("," , $size),
            'color'    =>explode("," , $color),

        ]);
    }
    
    public function UpdateProductSubmit(Request $request){
        if(!empty($request->file('thumbnail'))){
            $file      = $request->file('thumbnail');
            $thumbnail =  $this->uploadFile($file);
        }else{
            $thumbnail = $request->old_thumbnail;
        }
        $size = $request->size;
        $sizeVal = implode(", ",$size);
        $color= $request->color;
        $colorVal = implode(", ",$color);

        $product = DB::table('product')
                        ->where('id',$request->id)
                        ->update([
                        'name'=>$request->name,
                        'slug'=>$this->GenerateSlug($request->name),
                        'qty'=>$request->qty,
                        'regular_price'=>$request->regular_price,
                        'sale_price'=>$request->sale_price != '' ? $request->sale_price : 0,
                        'color'=>$colorVal,
                        'size' =>$sizeVal,
                        'author'=>Auth::user()->id,
                        'category'=>$request->category,
                        'viewer'=>0,
                        'thumbnail'=>$thumbnail,
                        'description'=>$request->description,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
        if($product){
            $this->logActivity($request->name,'Product','Update',date('Y-m-d H:i:s'));
            return redirect('admin/list-product')->with('message', 'message', 'Updated');
        }
    }

    public function RemoveProductSubmit(Request $request){
        $product = DB::table('product')
                    ->where('id',$request->remove_id)
                    ->delete();
        if($product){
            $this->logActivity($request->name,'Product','Remove',date('Y-m-d H:i:s'));
            return redirect('admin/list-product');
        } 
    }
}

