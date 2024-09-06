<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as PostRequest;
use App\Models\Stuff_name; // 今回のDB用に作成した「Edit_stuffname.php」モデル(DB内容)を参照
use Illuminate\Support\Facades\DB;

//use Carbon\Carbon; 
//use App\Student; 

class Edit_stuffnamesController extends Controller
{

/************************************************************************************************************************************************************************************************************* */
    // オペレーションページの表示
/************************************************************************************************************************************************************************************************************* */
        public function edit_stuffname_view(Request $request){
            $view = $this->db_info_get();
            return view('parts.edit_stuffname',['view' => $view]);

        }

/************************************************************************************************************************************************************************************************************* */
    // 押下されたボタン毎に処理（メソッド）を切り分け
/************************************************************************************************************************************************************************************************************* */
        public function btn_select(Request $request){
            // 使用するメソッドの切り分け
                if (PostRequest::get('add_btn')) {
                    $first_name = PostRequest::input("first_name");
                    $last_name = PostRequest::input("last_name");
                    $stuff = PostRequest::input("stuff");
                    return $this->db_insert($first_name,$last_name,$stuff);

                    return $this->db_info_get();
                } else if (PostRequest::get('del_btn')) {
        
                    $del = PostRequest::input("del");
                    return $this->db_del($del);

                    //print_r($del);
                    return view('parts.edit_stuffname');
                }            

        }


/************************************************************************************************************************************************************************************************************* */
    // DB削除用
/************************************************************************************************************************************************************************************************************* */

        public function db_del($del){
            
                $add_comment = "";
                $del_info = array();

              //  $stuff_names = DB::table('stuff_names')->get();
                // ソフトデリート以外を取得
                $stuff_names = \App\Models\Stuff_name::get();

                foreach ($stuff_names as $stuff_name) {

                    $i = 0;
                    foreach($del as $val){
                        $id[$i] = $stuff_name->sid;
                        if($val == $id[$i]){
                            $first_name[$i] = $stuff_name->first_name;
                            $last_name[$i] = $stuff_name->last_name;
                            $info[$i] = $id[$i] . "_" . $first_name[$i] . "_" . $last_name[$i];

                            \App\Models\Stuff_name::where('sid', $val)->delete();

                            $add_comment .=  $first_name[$i] . " " . $last_name[$i] ." を削除しました<br>";

                        }
                        $i++;
                    }

                }

                return view('parts.edit_stuffname',['add_comment' => $add_comment]);

        }


/************************************************************************************************************************************************************************************************************* */
    // DB登録用
/************************************************************************************************************************************************************************************************************* */

        public function db_insert($first_name,$last_name,$stuff){

                // DB登録ロジックを実施
                    $no_name = "";
                    if($first_name == "" && $last_name == ""){
                        $no_name = "ON";
                    }

                    $full_name = $first_name . " " .$last_name;

                    if($no_name != "ON"){
                        // データをDBへインサートする
                            $stuff_name = Stuff_name::insert([
                                'first_name' => $first_name,
                                'last_name' => $last_name,
                                'full_name' => $full_name,
                                'NC' => $stuff,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                            if($stuff == ""){$stuff2 = "店舗";} else {$stuff2 = "NC";}
    
                            $add_comment = "". $stuff2 . "スタッフ名登録完了：【 " . $first_name . " " . $last_name  . " 】<br>"; 
                        
                    } else {
                        if($stuff == ""){$stuff2 = "店舗";} else {$stuff2 = "NC";}
                        $add_comment = "空のスタッフ名が指定されています。やり直してください。<br>";           
                    }
                
                // ブラウザの戻るで同じ処理をしても無効化させるためセッションの削除
                    session()->flush();
    
                    return view('parts.edit_stuffname',['add_comment' => $add_comment]);
        }




/************************************************************************************************************************************************************************************************************* */
    // DB情報取得用
/************************************************************************************************************************************************************************************************************* */


        public function db_info_get(){

                    // ソフトデリート以外を取得
                    $stuff_names = \App\Models\Stuff_name::get();

                    $view = "<div style='display:flex;justify-content:space-between;'>";
                    $shop_view = "<div style='width:100%;'><div style='padding-bottom:1em;'>▼ 店舗スタッフ削除用 ▼</div>";
                    $nc_view = "<div style='width:100%;'><div style='padding-bottom:1em;'>▼ NCスタッフ削除用 ▼</div>";

                    foreach ($stuff_names as $stuff_name) {
                        $NC = $stuff_name->NC;
                        if($NC == ""){$stuff = "店舗";} else {$stuff = "NC";}
                        $id = $stuff_name->sid;
                        $first_name = $stuff_name->first_name;
                        $last_name = $stuff_name->last_name;
                        $dell = $stuff_name->dell;
                        if($stuff == "店舗"){
                            $shop_view .= "<div style='display:flex;justify-content:left; width:90%;padding-left:10%;'><div><input type='checkbox' name='del[]' value=" . $id . "></div><div style='padding:0 1em;'>" . $first_name . "</div><div>" . $last_name . "</div></div>";
                        } else {
                            $nc_view .= "<div style='display:flex;justify-content:left; width:90%;padding-left:10%;'><div><input type='checkbox' name='del[]' value=" . $id . "></div><div style='padding:0 1em;'>" . $first_name . "</div><div>" . $last_name . "</div></div>";
                        }
                    }
                    $view = $view . $shop_view . "</div>" . $nc_view . "</div></div>";

                    return $view;
        }


        


/************************************************************************************************************************************************************************************************************* */
    // フォーム情報取得用
/************************************************************************************************************************************************************************************************************* */


        public function form_info_get(Request $request){

            // 変数初期化
                $start_year = "";
                $start_month = "";
                $start_day = "";
                $end_year = "";
                $end_month = "";
                $end_day = "";
                $form_info_get = array();

                if (PostRequest::has('start_year')) {
                    $start_year = PostRequest::input('start_year');
                }
                if (PostRequest::has('start_month')) {
                    $start_month = PostRequest::input('start_month');
                }
                if (PostRequest::has('start_day')) {
                    $start_day = PostRequest::input('start_day');
                }
                if (PostRequest::has('end_year')) {
                    $end_year = PostRequest::input('end_year');
                }
                if (PostRequest::has('end_month')) {
                    $end_month = PostRequest::input('end_month');
                }
                if (PostRequest::has('end_day')) {
                    $end_day = PostRequest::input('end_day');
                }


                // 現在から遡って3年の西暦年を取得（フォーム表示用）
                    $this_year = date('Y');
                    $last_year = date("Y", strtotime('-1 year'));
                    $two_years_ago = date("Y", strtotime('-2 year'));


                $form_info_get = [
                    'start_year'=> $start_year,
                    'start_month'=> $start_month,
                    'start_day'=> $start_day,
                    'end_year'=> $end_year,
                    'end_month'=> $end_month,
                    'end_day'=> $end_day,
                    'this_year'=> $this_year,
                    'last_year'=> $last_year,
                    'two_years_ago'=> $two_years_ago
                    ];

                return $form_info_get;


        }


}
