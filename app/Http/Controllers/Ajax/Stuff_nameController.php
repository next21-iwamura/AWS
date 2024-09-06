<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stuff_name;

class Stuff_nameController extends Controller
{
    public function index(Request $request) {

        if($request->filled('q')) {

            $keywords = explode(' ', trim(mb_convert_kana($request->q, 's')));

            foreach($keywords as $keyword) {
                //モデルでの論理削除が効かないので直接指定$query = DB::table('stuff_names')->where("last_name","like",'%'. $request->q .'%')->get();
                //$query = DB::table('stuff_names')->where("full_name","like",'%'. $request->q .'%')->where('deleted_at', NULL)->get();
                $query = DB::table('stuff_names')->where("full_name","like",'%'. $request->q .'%')->where('NC', NULL)->where('deleted_at', NULL)->get();
            }

        } else {
            //モデルでの論理削除が効かないので直接指定$query = DB::table('stuff_names')->get();
            //$query = DB::table('stuff_names')->where('deleted_at', NULL)->get();
            $query = DB::table('stuff_names')->where('NC', NULL)->where('deleted_at', NULL)->get();
        }

        return response()->json($query);

    }
    
}

