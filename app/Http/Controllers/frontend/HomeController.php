<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function Home() {
        $newProducts = DB::table('product')
                            ->orderByDesc('id')
                            ->limit(4)
                            ->get();
        $promotion   = DB::table('product')
                            ->where('sale_price','<>','0')
                            ->where('qty','>',0)
                            ->orderByDesc('id')
                            ->limit(4)
                            ->get();
        $popularProduct = DB::table('product')
                            ->orderBy('viewer','DESC')
                            ->limit(4)
                            ->get();

        return view('frontend.home',[
            'newProducts' => $newProducts,
            'promotion'   => $promotion,
            'popularProduct' =>$popularProduct
        ]);
    }

    public function Shop(Request $request) {

        if(empty($request->page)) {
            $currentPage = 1;
        }else {
            $currentPage = $request->page;
        }
        $postPerPage = 3;

        // get offset
        $offset = ($currentPage - 1) * $postPerPage;

        //Asign Object from Model
        $query = DB::table('product');

        // In case user filter product by category
        if(!empty($request->cate)) {
            $cateSlug = $request->cate;
            $cate     = DB::table('category')
                            ->where('slug', $cateSlug)
                            ->get();
            $cateId   = $cate[0]->id; 
            $query->where('category', $cateId);
            $query->orderByDesc('id');

            // count all product by category id
            $allPost = DB::table('product')
                        ->where('category', $cateId)
                        ->count('id');
        }

        // In case user sort product by price
        if(!empty($request->price)) {
            $type = $request->price;
            if($type == "max") {
                $query->orderBy('regular_price', 'DESC');
            }
            else {
                $query->orderBy('regular_price', 'ASC');
            }
            $allPost = DB::table('product')->count('id');
        }

        // In case user filter promotion product
        if(!empty($request->promotion) && $request->promotion == 'true') {
            $query->where('sale_price', '<>', 0);
            $query->orderByDesc('id');
            $allPost = DB::table('product')
                        ->where('sale_price', '<>', 0)
                        ->count('id');
        }

        // In case user just show all product and sort by DESC-------------------------
        if(
            empty($request->cate) &&
            empty($request->price) &&
            empty($request->promotion)
        ) {
            $query->orderByDesc('id');
            $allPost = DB::table('product')->count('id');
        }
        
        $products = $query->offset($offset)
                            ->limit($postPerPage)
                            ->get();

        // get total post for pagination lists
        $totalPage  = ceil($allPost / $postPerPage);
        
        // Get list category
        $listCategory = DB::table('category')
                            ->orderByDesc('id')
                            ->get();

        return view('frontend.shop',[
            'products'  => $products,
            'totalPage' => $totalPage,
            'allCategory' => $listCategory
        ]);
    }

    public function Product($slug) {   
        //Product Detail 
        $productDetail = DB::table('product')
                        ->where('slug',$slug) 
                        ->get();     
        $releteProduct =  DB::table('product')
                        ->where('id','<>',$productDetail[0]->id)
                        ->where('category',$productDetail[0]->category)  
                        ->orderByDesc('id')   
                        ->limit(4) 
                        ->get();

        $currentId      = $productDetail[0]->id;
        $currentViewer  = $productDetail[0]->viewer;
        $newViewer      = $currentViewer +1 ;
        DB::table('product')
            ->where('id', $currentId)
            ->update([
                'viewer' => $newViewer
            ]);

        return view('frontend.product',[
                'productDetail'=>$productDetail,
                'releteProduct'=>$releteProduct
            ]);
    }

    public function News() {
        $news = DB::table('news')
                    ->orderByDesc('id')
                    ->get();
        return view('frontend.news',['news'=>$news]);
    }

    // count view news-detail
    public function Article($slug){
        $news = DB::table('news')
                    ->where('slug',$slug)
                    ->get();
        $currentId      = $news[0]->id;
        $currentViewer  = $news[0]->viewer;
        $newViewer      = $currentViewer +1 ;
        DB::table('news')
            ->where('id', $currentId)
            ->update([
                'viewer' => $newViewer
            ]);

        return view('frontend.news-detail',['news'=>$news]);
    }

    public function Search(Request $request) {
        $s = $request->s;
        $products = DB::table('product')
                        ->where('name', 'LIKE', '%'.$s.'%')
                        ->get();
        $news = DB::table('news')
                        ->where('title', 'LIKE', '%'.$s.'%')
                        ->get();
        return view('frontend.search',[
            'news' =>$news,
            'products' => $products
        ]);
    }

}
