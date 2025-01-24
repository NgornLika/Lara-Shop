<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoriesController extends Controller
{
    // Category
    public function AddCategory() {
        return view('backend.add-category');
    }
    public function AddCategorySubmit(Request $request) {
        if($request){
            $name     = $request->name;
            $date     = date('Y-m-d H:i:s');
            $slug = $this ->GenerateSlug($name) ;
            $Category = DB::table('category')->insert([
                            'name'=>$name,
                            'slug'=>$slug,
                            'created_at' => $date,
                            'updated_at' => $date
                        ]);
            if($Category){
                $this->logActivity('category','category','Insert',$date);
                return redirect('admin/add-category')->with('message', 'Insert Success');
            }
        }
        
    }
    public function ListCategory() {
        $category=DB::table('category')
                        ->orderBy('id','DESC')
                        ->get();
        return view('backend.list-category',['category'=>$category]);
    }
    public function UpdateCategory($id){
        $category = DB::table('category')
                        ->find($id);
        return view('backend.update-category',['category'=>$category]);
    }

    public function UpdateCategorySubmit(Request $request){
        if($request){
            $name     = $request->name;
            $slug     = $this ->GenerateSlug($name) ;
            $date     = date('Y-m-d H:i:s');
            $category =DB::table('category')
                            ->where('id',$request->id)
                            ->update([
                                'name' => $name,
                                'slug'=>$slug,
                                'updated_at' => $date
                            ]);
            if($category){
                $this->logActivity('category','category','Update',$date);
                // return redirect('admin/update-category')->with('message', 'Edit Success');
                return redirect('admin/list-category');
            }
        }
    }
    public function RemoveCategorySubmit(Request $request){
        if($request){
            $category = DB::table('category')
                        ->where('id',$request->remove_id)
                        ->delete();
            if($category){
                return redirect('admin/list-category');
            }
        }
    }

    // Attribute
    public function AddAttribute() {
        return view('backend.add-attribute');
    }
    public function AddAttributeSubmit(Request $request) {
        if($request){
            $type     = $request->type;
            $value    = $request->value;
            $date     = date('Y-m-d H:i:s');
            $attr =DB::table('attribute')
                            ->insert([
                                'type' => $type,
                                'value'=>$value,
                                'created_at' => $date,
                                'updated_at' => $date
                            ]);
            if($attr){
                $this->logActivity($type,'attribute','Insert',$date);
                return redirect('admin/add-attribute')->with('message', 'Insert Success');
            }
        }
    }
    
    public function ListAttribute(){
        $attrs=DB::table('attribute')
                        ->orderBy('id','DESC')
                        ->get();
        return view('backend.list-attribute',['attrs'=>$attrs]);
    }
    public function UpdateAttribute($id){
        $attribute = DB::table('attribute')
                ->find($id);
        return view('backend.update-attribute', ['attribute'=>$attribute]);
    }
    public function UpdateAttributeSubmit(Request $request){
        if($request){
            $type     = $request->type;
            $value    = $request->value;
            $date     = date('Y-m-d H:i:s');
            $attr =DB::table('attribute')
                            ->where('id',$request->id)
                            ->update([
                                'type' => $type,
                                'value'=>$value,
                                'updated_at' => $date
                            ]);
            if($attr){
                $this->logActivity($type,'attribute','Update',$date);
                return redirect('admin/list-attribute');
            }
        }
    }
    public function RemoveAttributeSubmit(Request $request){
        if($request){
            $attr =DB::table('attribute')
                    ->where('id',$request->remove_id)
                    ->delete();
            if($attr){
                return redirect('admin/list-attribute')->with('message', 'Removed');
            }
        }
    }
}
