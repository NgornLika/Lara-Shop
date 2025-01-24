<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    // LOGO
    public function GetWebSiteLogo(){
        $logo = DB::table('logo')
                    ->orderBy('id','DESC') 
                    ->get();
        if($logo) {
            return $this->ApiResponse(200, $logo);
        }
        else {
            return $this->ApiResponse(500, []);
        }
    }

    public function AddWebSiteLogo(Request $request){
        $file      = $request->thumbnail;
        $thumbnail = $this->uploadFile($file);
        $date = date('Y-m-d H:i:s');
        $Logo = DB::table('logo')->insert([
                'thumbnail' => $thumbnail,
                'created_at'  => $date,
                'updated_at'  => $date       
            ]);
        if($Logo){
            return $this->ApiResponse(200, 'Post Success');
        }else {
            return $this->ApiResponse(500, []);
        }
        
    }

    public function UpdateWebSiteLogo(Request $request){
        if(!empty($request)){
            $id = $request->id;
            $file = $request->file('thumbnail');
            $thumbnail =  $this->uploadFile($file);
            $Logo = DB::table('logo')
                    ->where('id',$id)
                    ->update([
                        'thumbnail'  =>$thumbnail,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            if($Logo){
                return $this->ApiResponse(200, 'Post updated');
            }else {
                return $this->ApiResponse(500, 'Post update fail');
            }
        }
    }
    public function RemoveLogo(Request $request){
        $Logo = DB::table('logo')
                    ->where('id',$request->id)
                    ->delete();
        if($Logo) {
            return $this->ApiResponse(200, 'Post Remove');
        }
        else {
            return $this->ApiResponse(500, 'Post remove fail');
        } 
    }

    // Product
    public function addProduct(Request $request){
        if(!empty($request)){
            date_default_timezone_set("Asia/Bangkok");
            $name           = $request->name;
            $slug           = $this->GenerateSlug($name);
            $qty            = $request->qty;
            $regular_price  = $request->regular_price;
            $sale_price     = $request->sale_price != '' ? $request->sale_price : 0;
            $category       = $request->category;
            $description    = $request->description;
            $date           = date('Y-m-d H:i:s');
            $file = $request->file('thumbnail');
            $thumbnail =  $this->uploadFile($file);
            $size = $request->size;
            $color= $request->color;
            $products = DB::table('product')
                        ->insert([
                            'name'=>$name,
                            'slug'=>$slug,
                            'qty'=>$qty,
                            'regular_price'=>$regular_price,
                            'sale_price'=>$sale_price,
                            'color'=>$color,
                            'size' =>$size,
                            'author'=>Auth::user()->id,
                            'category'=>$category,
                            'viewer'=>0,
                            'thumbnail'=>$thumbnail,
                            'description'=>$description,
                            'created_at' => $date,
                            'updated_at' => $date
                        ]);
            if($products){
                return $this->ApiResponse(200, 'Post Success');
            }else {
                return $this->ApiResponse(500, 'Post  fail');
            }
        }
    }

    public function listProducts() {
        $products = DB::table('product')
                        ->orderByDesc('id')
                        ->get();
        if($products) {
            return $this->ApiResponse(200, $products);
        }
        else {
            return $this->ApiResponse(500, []);
        }
    }
    public function UpdateProduct(Request $request){
        if(!empty($request)){
            $file      = $request->file('thumbnail');
            $thumbnail =  $this->uploadFile($file);

            $size = $request->size;
            $color= $request->color;
            $products = DB::table('product')
                        ->where('id',$request->id)
                        ->update([
                            'name'=>$request->name,
                            'slug'=>$this->GenerateSlug($request->name),
                            'qty'=>$request->qty,
                            'regular_price'=>$request->regular_price,
                            'sale_price'=>$request->sale_price != '' ? $request->sale_price : 0,
                            'color'=>$color,
                            'size' =>$size,
                            'author'=>Auth::user()->id,
                            'category'=>$request->category,
                            'viewer'=>0,
                            'thumbnail'=>$thumbnail,
                            'description'=>$request->description,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
            if($products){
                return $this->ApiResponse(200, 'Post updated');
            }else {
                return $this->ApiResponse(500, 'Post update fail');
            }
        }
    }
    public function RemoveProduct(Request $request){
        $product = DB::table('product')
                    ->where('id',$request->id)
                    ->delete();
        if($product) {
            return $this->ApiResponse(200, 'Post Remove');
        }
        else {
            return $this->ApiResponse(500, 'Post remove fail');
        } 
    }

    public function productDetail($slug) {
        $product = DB::table('product')
                        ->where('slug', $slug)
                        ->get();
        if($product) {
            return $this->ApiResponse(200, $product);
        }
        else {
            return $this->ApiResponse(500, []);
        }
    }

    public function userLogin(Request $request) {
        if(!empty($request)) {
            $name     = $request->name;
            $password = $request->password;
            if(Auth::attempt([
                'name'     => $name,
                'password' => $password
            ])) {
                $user  = Auth::user();
                $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
                return $this->ApiResponse(200, $token);
            }
            else {
                return $this->ApiResponse(500, 'invalid user');
            }
        }
    }

    public function addNews(Request $request) {
        if(!empty($request)) {
            $title = $request->title;
            $slug  = rand(1,999).'-'.$this->GenerateSlug($title);
            $user  = Auth::user()->id;
            $viewer = 0;
            $description = $request->description;
            $date = date('Y-m-d H:i:s');

            $file      = $request->thumbnail;
            $thumbnail = $this->uploadFile($file);
            
            $news = DB::table('news')->insert([
                        'title' => $title,
                        'slug'  => $slug,
                        'author' => $user,
                        'viewer' => $viewer,
                        'thumbnail' => $thumbnail,
                        'description' => $description,
                        'created_at'  => $date,
                        'updated_at'  => $date
                    ]);

            if($news) {
                $this->logActivity($title, 'News', 'Insert', $date);
                return $this->ApiResponse(200, 'Post Created');
            }
            else {
                return $this->ApiResponse(500, 'Post Create fail');
            }

        }
    }


    public function listNews() {
        $news = DB::table('news')
                    ->orderByDesc('id')
                    ->get();
        if($news) {
            return $this->ApiResponse(200, $news);
        }
        else {
            return $this->ApiResponse(500, []);
        }
    }
    public function newsDetail($slug){
        $news = DB::table('news')
                    ->where('slug',$slug)
                    ->get();
        if($news) {
            return $this->ApiResponse(200, $news);
        }
        else {
            return $this->ApiResponse(500, []);
        }
    }

    public function updateNews(Request $request) {
        if(!empty($request)) {
            $id    = $request->id;
            $title = $request->title;
            $date  = date('Y-m-d H:i:s');
            $description = $request->description;

            $file      = $request->thumbnail;
            $thumbnail = $this->uploadFile($file);
            
            $news = DB::table('news')
                            ->where('id', $id)
                            ->update([
                                'title'       => $title,
                                'thumbnail'   => $thumbnail,
                                'description' => $description,
                                'updated_at'  => $date
                            ]);

            if($news) {
                $this->logActivity($title, 'News', 'Update', $date);
                return $this->ApiResponse(200, 'Post updated');
            }
            else {
                return $this->ApiResponse(500, 'Post update fail');
            }

        }
    }

    public function RemoveNews(Request $request){
        $news = DB::table('news')
                ->where('id',$request->id)
                ->delete();
        if($news) {
            $this->logActivity('Remove', 'News', 'Remove', date('Y-m-d H:i:s'));
            return $this->ApiResponse(200, 'Post Remove');
        }
        else {
            return $this->ApiResponse(500, 'Post remove fail');
        }    
    }

    // @Get Category
    public function getCategory() {
        $cate = DB::table('category')
                    ->orderByDesc('id')
                    ->get();
        if($cate) {
            return $this->ApiResponse(200, $cate);
        }
        else {
            return $this->ApiResponse(500, 'Error');
        }    
    }

    // @Get Attribute
    public function getAttribute($type) {
        $attr = DB::table('attribute')
                    ->where('type', $type)
                    ->orderByDesc('id')
                    ->get();
        if($attr) {
            return $this->ApiResponse(200, $attr);
        }
        else {
            return $this->ApiResponse(500, 'Error');
        }    
    }
}
