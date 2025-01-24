<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller {
    public function index()
    {
        return view('backend.dashboard');
    }

    public function AddPost()
    {
        return view('backend.add-post');
    }

    public function ListPost()
    {
        return view('backend.list-post');
    }
    
    //Website Logo
    public function AddLogo()
    {
        return view('backend.add-logo');
    }
    public function AddLogoSubmit(Request $request)
    {
        if($request && !empty($request->file('thumbnail'))){
            $file      = $request->file('thumbnail');
            $thumbnail =  $this->uploadFile($file);
            $date     = date('Y-m-d H:i:s');
            $post = DB::table('logo')->insert([
                'thumbnail'  =>$thumbnail,
                'created_at' => $date,
                'updated_at' => $date
            ]);
            if($post){
                $this->logActivity('logo','logo','Insert',$date);
                return redirect('admin/add-logo')->with('message', 'Insert Success');
            }
        }
    }

    public function ListLogo()
    {
        $logo = DB::table('logo')
                    // ->join('users','logo.author', 'users.id')
                    // ->select('users.name', 'logo.*') 
                    ->orderBy('id','DESC') 
                    ->get();
        return view('backend.list-logo', ['logo' => $logo]);
    }

    public function UpdateLogo($id){
        $logo = DB::table('logo') 
                    ->find($id);
        return view('backend.update-logo',['logo'=>$logo]);
    }
    public function UpdateLogoSubmit(Request $request){
        if(!empty($request->file('thumbnail'))){
            $file      = $request->file('thumbnail');
            $thumbnail =  $this->uploadFile($file);
        }else{
            $thumbnail = $request->old_thumbnail;
        }
        $logo = DB::table('logo')
                    ->where('id',$request->id)
                    ->update([
                        'thumbnail'  =>$thumbnail,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
        if($logo){
            $this->logActivity('logo','logo','Update',date('Y-m-d H:i:s'));
            return redirect('admin/list-logo')->with('message', 'Updated');
        }
    }

    public function RemoveLogoSubmit(Request $request){
        $logo = DB::table('logo')
                    ->where('id',$request->remove_id)
                    ->delete();
        if($logo){
            $this->logActivity('Logo','Logo','Remove', date('Y-m-d H:i:s'));
            return redirect('admin/list-logo')->with('message', 'Romove Success');
        }
        // return $request;
    }

    //View Logo
    public function ViewLog()
    {
        $logs= DB::table('activity_log')
                        ->join('users','users.id','activity_log.author')
                        ->select('users.name','activity_log.*')
                        ->orderBy('activity_log.id','DESC')
                        ->get();
        return view('backend.list-log',['logs' =>$logs]);
    }
    
}
