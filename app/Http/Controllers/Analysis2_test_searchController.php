<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as PostRequest;
use Illuminate\Support\Facades\DB;

use DateTime;


/************************************************************************************************ */
    // 在庫・月別 
/************************************************************************************************ */

//class Analysis2_searchController extends Controller
class Analysis2_test_searchController extends Controller
{
        /************************************************************************************************************************************************************************************************************* */
            // 定数管理用メソッド
        /************************************************************************************************************************************************************************************************************* */
                public function define(){

                    $define = array();

                    // 本番 or テスト用フォルダの切り替え変数
                        $change = "_test";
                        $change2 = "test_";
                        //$change = "";
                        //$change2 = "";
                    
                        $bladename = "parts.analysis2" .$change . "_search";
                        $file_pass = "../storage/app/public/csv/op/analysis2" .$change . "_search/";
                        $file_pass2 = "public/csv/op/analysis2" .$change . "_search/";
                        $file_name = "zaiko_data" . $change . ".csv";
                        $table_name = "analysises2";
                        
                        array_push($define,$bladename);
                        array_push($define,$file_pass);
                        array_push($define,$file_pass2);
                        array_push($define,$file_name);
                        array_push($define,$table_name);

                        return $define;

                }



        /************************************************************************************************************************************************************************************************************* */
            // 売り上げ分析ページの表示
        /************************************************************************************************************************************************************************************************************* */
                public function Analysis2_search_view(Request $request){


                    // FORMから指定した情報を取得
                        $form_info_get = $this->form_info_get($request);
                            $i=0;
                            foreach($form_info_get as $var){
                                if($i == 0){$start_year = $var;}
                                if($i == 1){$start_month = $var;}
                                if($i == 2){$start_day = $var;}
                                if($i == 3){$end_year = $var;}
                                if($i == 4){$end_month = $var;}
                                if($i == 5){$end_day = $var;}
                                if($i == 6){$this_year = $var;}
                                if($i == 7){$last_year = $var;}
                                if($i == 8){$two_years_ago = $var;}
                                if($i == 9){$three_years_ago = $var;}
                                if($i == 10){$next_year = $var;}
                                if($i == 11){$first_day = $var;}
                                if($i == 12){$last_day = $var;}
                                if($i == 13){$output = $var;}
                                if($i == 14){$out1 = $var;}
                                if($i == 15){$out2 = $var;}
                                if($i == 16){$out3 = $var;}
                                if($i == 17){$search = $var;}
                                if($i == 18){$order_select = $var;}
                                $i++;
                            }


                        // 1月1日～3月31日の場合のスタート年は去年
                            $nowdate = strtotime(date('Y-m-d H:i:s'));
                            if(strtotime(date("Y").'-01-01 00:00:00') <= $nowdate && $nowdate < strtotime(date("Y").'-04-01 00:00:00')) {
                                // デフォルトの期間は月初から月末までを指定
                                    if($start_year == ""){$start_year = date("Y") - 1;}
                                    if($start_month == ""){$start_month = 04;}
                                    if($start_day == ""){$start_day = 01;}
                                    if($end_year == ""){$end_year = date("Y");}
                                    if($end_month == ""){$end_month = 03;}
                                    if($end_day == ""){$end_day = 31;}

                        // それ以外の場合のスタート年は今年
                            } else {
                                // デフォルトの期間は月初から月末までを指定
                                    if($start_year == ""){$start_year = date("Y");}
                                    if($start_month == ""){$start_month = 04;}
                                    if($start_day == ""){$start_day = 01;}
                                    if($end_year == ""){$end_year = $start_year + 1;}
                                    if($end_month == ""){$end_month = 03;}
                                    if($end_day == ""){$end_day = 31;}
                            }         

                        $output = "";
                        $out1 = "";
                        $out2 = "";
                        $out3 = "";

                   
                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）start
                    /************************************************************************************************************.date'************************************************************************************************* */
                            $define = $this->define();
                            $def_i = 0;
                            // 各変数にパスやファイル名を代入
                                foreach($define as $def){
                                    if($def_i == 0){ $bladename = $def; }
                                    if($def_i == 1){ $file_pass = $def; }
                                    if($def_i == 2){ $file_pass2 = $def; }
                                    if($def_i == 3){ $file_name = $def; }
                                    if($def_i == 4){ $table_name = $def; }
                                    $def_i++;
                                }
                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）end
                    /************************************************************************************************************************************************************************************************************* */

                    /************************************************************************************************************************************************************************************************************* */
                        // DB内登録済期間を取得 start
                    /************************************************************************************************************************************************************************************************************* */

                                // DB検索（月ごとのブランドのみ取得し配列化用）スタート
                                        $db_term = DB::table($table_name) 
                                // 月毎にグループ化して値を分けるための処理
                                            ->select([
                                                $table_name . '.date',
                                            ])
                                            ->orderBy('date', 'asc')
                                            ->get();


                                // クエリビルダスタート
                                        $i = 0;
                                        $first_day = "";
                                        $last_day = "";
                                        foreach ($db_term as $db_term2) {
                                            $date = $db_term2->date;
                                            list($year, $month, $day) = explode('-', $date);
                                            if(checkdate($month, $day, $year) && strpos($year,'0022') === false && strpos($year,'0023') === false){
                                                $i++;
                                                if($i == 1){
                                                    $first_day = $date; 
                                                }
                                                $last_day = $date;
                                            }
                                        }


                    /************************************************************************************************************************************************************************************************************* */
                        // DB内登録済期間を取得 end
                    /************************************************************************************************************************************************************************************************************* */


                    return view($bladename,['first_day' => $first_day,'last_day' => $last_day,'next_year' => $next_year,'this_year' => $this_year,'last_year' => $last_year,'two_years_ago' => $two_years_ago,'start_year' => $start_year,'start_month' => $start_month,'start_day' => $start_day,'end_year' => $end_year,'end_month' => $end_month,'end_day' => $end_day,'output' => $output,'out1' => $out1,'out2' => $out2,'out3' => $out3,'three_years_ago' => $three_years_ago,'order_select' => $order_select]);
                }


        /************************************************************************************************************************************************************************************************************* */
            // 押下されたボタン毎に処理（メソッド）を切り分け
        /************************************************************************************************************************************************************************************************************* */
                public function btn_select(Request $request){

                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）start
                    /************************************************************************************************************************************************************************************************************* */
                            $define = $this->define();
                            $def_i = 0;
                            // 各変数にパスやファイル名を代入
                                foreach($define as $def){
                                    if($def_i == 0){ $bladename = $def; }
                                    if($def_i == 1){ $file_pass = $def; }
                                    if($def_i == 2){ $file_pass2 = $def; }
                                    if($def_i == 3){ $file_name = $def; }
                                    if($def_i == 4){ $table_name = $def; }

                                    $def_i++;
                                }
                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）end
                    /************************************************************************************************************************************************************************************************************* */
                    

                    if (PostRequest::get('search') || PostRequest::get('search2') || PostRequest::get('search3') || PostRequest::get('output')) {
                        // アップロード用メソッドの実行
                            // FORMから指定した情報を取得
                                $form_info_get = $this->form_info_get($request);
                                $i=0;
                                foreach($form_info_get as $var){
                                    if($i == 0){$start_year = $var;}
                                    if($i == 1){$start_month = $var;}
                                    if($i == 2){$start_day = $var;}
                                    if($i == 3){$end_year = $var;}
                                    if($i == 4){$end_month = $var;}
                                    if($i == 5){$end_day = $var;}
                                    if($i == 6){$this_year = $var;}
                                    if($i == 7){$last_year = $var;}
                                    if($i == 8){$two_years_ago = $var;}
                                    if($i == 9){$three_years_ago = $var;}
                                    if($i == 10){$next_year = $var;}
                                    if($i == 11){$first_day = $var;}
                                    if($i == 12){$last_day = $var;}
                                    if($i == 13){$output = $var;}
                                    if($i == 14){$out1 = $var;}
                                    if($i == 15){$out2 = $var;}
                                    if($i == 16){$out3 = $var;}
                                    if($i == 17){$search = $var;}
                                    if($i == 18){$order_select = $var;}
                                    $i++;
                                }
    

                        // 1月1日～3月31日の場合のスタート年は去年
                            $nowdate = strtotime(date('Y-m-d H:i:s'));
                            if(strtotime(date("Y").'-01-01 00:00:00') <= $nowdate && $nowdate < strtotime(date("Y").'-04-01 00:00:00')) {
                                // デフォルトの期間は月初から月末までを指定
                                    if($start_year == ""){$start_year = date("Y") - 1;}
                                    if($start_month == ""){$start_month = 04;}
                                    if($start_day == ""){$start_day = 01;}
                                    if($end_year == ""){$end_year = date("Y");}
                                    if($end_month == ""){$end_month = 03;}
                                    if($end_day == ""){$end_day = 31;}

                        // それ以外の場合のスタート年は今年
                            } else {
                                // デフォルトの期間は月初から月末までを指定
                                    if($start_year == ""){$start_year = date("Y");}
                                    if($start_month == ""){$start_month = 04;}
                                    if($start_day == ""){$start_day = 01;}
                                    if($end_year == ""){$end_year = $start_year + 1;}
                                    if($end_month == ""){$end_month = 03;}
                                    if($end_day == ""){$end_day = 31;}
                            }         
                        

                            $search = "";
                            if (PostRequest::has('search') || PostRequest::has('search2') || PostRequest::has('search3')) {
                                $search = "ON";
                            }


                        // FORM情報より指定されたDB情報の取得
                            $restock_comment = "";
                            // [売上]サマリ用 
                                if (PostRequest::has('search')){
                                    return $this->db_info_get($start_year,$start_month,$start_day,$end_year,$end_month,$end_day,$this_year,$last_year,$two_years_ago,$output,$out1,$out2,$out3,$search,$three_years_ago,/*$order_select,*/$next_year,$first_day,$last_day);
                            // [売上]ジャック区分用 
                                } else if (PostRequest::has('search2')){
                                    return $this->db_info_get2($start_year,$start_month,$start_day,$end_year,$end_month,$end_day,$this_year,$last_year,$two_years_ago,$output,$out1,$out2,$out3,$search,$three_years_ago,/*$order_select,*/$next_year,$first_day,$last_day);
                            // [売上]扱い部門用 
                                } else if (PostRequest::has('search3')){
                                    return $this->db_info_get3($start_year,$start_month,$start_day,$end_year,$end_month,$end_day,$this_year,$last_year,$two_years_ago,$output,$out1,$out2,$out3,$search,$three_years_ago,/*$order_select,*/$next_year,$first_day,$last_day);
                            // ブランド用 
                                } else if (PostRequest::has('search5')){
                                        // 選択したブランドの情報を取得（JS表示用）
                                        if (PostRequest::has('brandselect')) {
                                            $brandselect = PostRequest::input('brandselect');
                                        } else {
                                            $brandselect = "";
                                        }
                                        if (PostRequest::has('brandselect_b')) {
                                            $brandselect_b= PostRequest::input('brandselect_b');
                                        } else {
                                            $brandselect_b = "";
                                        }
                                        if (PostRequest::has('brandselect_jw')) {
                                            $brandselect_jw = PostRequest::input('brandselect_jw');
                                        } else {
                                            $brandselect_jw = "";
                                        }
                            // 「売上」or「点数」表示切り替え用フラグ
                                        if (PostRequest::has('order_select')) {
                                            $order_select = PostRequest::input('order_select');
                                        } else {
                                            $order_select = "";
                                        }
                                    return $this->db_info_get5($start_year,$start_month,$start_day,$end_year,$end_month,$end_day,$this_year,$last_year,$two_years_ago,$output,$out1,$out2,$out3,$search,$three_years_ago,$brandselect,$brandselect_b,$brandselect_jw,$order_select,$next_year,$first_day,$last_day);
                            // 検索前の表示用 
                                } else {
                                    // フォームのデフォルト値を付与
                                        $out1_a = "ON";
                                        $out1_b = "ON";
                                        $out1_c = "ON";
                                        $out2_a = "ON";
                                        $out2_b = "ON";
                                        $out2_c = "ON";
                                        $out3_a = "ON";
                                        $out3_b = "OFF";
                                        $out3_c = "OFF";


                            return view($bladename,['first_day' => $first_day,'last_day' => $last_day,'next_year' => $next_year,'this_year' => $this_year,'last_year' => $last_year,'two_years_ago' => $two_years_ago,'start_year' => $start_year,'start_month' => $start_month,'start_day' => $start_day,'end_year' => $end_year,'end_month' => $end_month,'end_day' => $end_day,'output' => $output,'out1' => $out1,'out2' => $out2,'out3' => $out3,'three_years_ago' => $three_years_ago,'out1_a' => $out1_a,'out1_b' => $out1_b,'out1_c' => $out1_c,'out2_a' => $out2_a,'out2_b' => $out2_b,'out2_c' => $out2_c,'out3_a' => $out3_a,'out3_b' => $out3_b,'out3_c' => $out3_c,'order_select' => $order_select]);
                                }
                    } else if (PostRequest::get('db_insert')) {
                        // CSVデータをデータベースへ登録用メソッドの実行
                            return $this->db_insert($request);
                    } 
                }


/************************************************************************************************************************************************************************************************************* */
    // フォーム情報取得用
/************************************************************************************************************************************************************************************************************* */


    public function form_info_get(Request $request){

        // 変数初期化
            $start_year = "";
            $start_month = "01";
            $start_day = "";
            $end_year = "";
            $end_month = "";
            $end_day = "01";
            $select_stuff = "";
            $output = "";
            $out1 = "";
            $search = "";
            $three_years_ago = "";
            $out1 = "";
            $out2 = "";
            $out3 = "";
            $order_select = "";

            $form_info_get = array();


                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）start
                    /************************************************************************************************************************************************************************************************************* */
                            $define = $this->define();
                            $def_i = 0;
                            // 各変数にパスやファイル名を代入
                                foreach($define as $def){
                                    if($def_i == 4){ $table_name = $def; }
                                    $def_i++;
                                }
                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）end
                    /************************************************************************************************************************************************************************************************************* */
            

                    /************************************************************************************************************************************************************************************************************* */
                        // DB内登録済期間を取得 start
                    /************************************************************************************************************************************************************************************************************* */

                                // DB検索（月ごとのブランドのみ取得し配列化用）スタート
                                $db_term = DB::table($table_name) 
                                // 月毎にグループ化して値を分けるための処理
                                            ->select([
                                                $table_name . '.date',
                                            ])
                                            ->orderBy('date', 'asc')
                                            ->get();

                                // クエリビルダスタート
                                        $i = 0;
                                        $first_day = "";
                                        $last_day = "";
                                        foreach ($db_term as $db_term2) {
                                            $date = $db_term2->date;
                                            list($year, $month, $day) = explode('-', $date);
                                            if(checkdate($month, $day, $year) && strpos($year,'0022') === false && strpos($year,'0023') === false){
                                                $i++;
                                                if($i == 1){
                                                    $first_day = $date; 
                                                }
                                                $last_day = $date;
                                            }
                                        }



                    /************************************************************************************************************************************************************************************************************* */
                        // DB内登録済期間を取得 end
                    /************************************************************************************************************************************************************************************************************* */


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
                        if (PostRequest::has('output')) {
                            $output = PostRequest::input('output');
                        }
                        if (PostRequest::has('out1')) {
                            $out1 = PostRequest::input('out1');
                        }
                        if (PostRequest::has('out2')) {
                            $out2 = PostRequest::input('out2');
                            //print_r($out2);
                        }
                        if (PostRequest::has('out3')) {
                            $out3 = PostRequest::input('out3');
                        }
                        if (PostRequest::has('order_select')) {
                            $order_select = PostRequest::input('order_select');
                        }


                        // 現在から遡って4年の西暦年を取得（フォーム表示用）
                            $next_year = date("Y", strtotime('+1 year'));
                            $this_year = date('Y');
                            $last_year = date("Y", strtotime('-1 year'));
                            $two_years_ago = date("Y", strtotime('-2 year'));
                            $three_years_ago = date("Y", strtotime('-3 year'));

                        $form_info_get = [
                            'start_year'=> $start_year,
                            'start_month'=> $start_month,
                            'start_day'=> $start_day,
                            'end_year'=> $end_year,
                            'end_month'=> $end_month,
                            'end_day'=> $end_day,
                            'this_year'=> $this_year,
                            'last_year'=> $last_year,
                            'two_years_ago'=> $two_years_ago,
                            'three_years_ago' => $three_years_ago,
                            'next_year'=> $next_year,
                            'first_day' => $first_day,
                            'last_day' => $last_day,
                            'output'=> $output,
                            'out1'=> $out1,
                            'out2'=> $out2,
                            'out3'=> $out3,
                            'search'=> $search,
                            'order_select'=> $order_select,
                            ];

                        return $form_info_get;

    }
                

/************************************************************************************************************************************************************************************************************* */
    // DB情報取得（[売上]サマリ用）
/************************************************************************************************************************************************************************************************************* */


    public function db_info_get($a,$b,$c,$d,$e,$f,$g,$h,$j,$k,$l,$m,$n,$o,$p,$q,$r,$s){

        // 「groupBy」にロジックで作成した名称を指定した際のエラー対応（本番だとDB上のカラムに無い名称を「groupBy」するとエラーとなる。このエラーの場合selectに名称指定すると解決するらしいが、恐らくDBに無い名称だと別のエラーとなる。以下の二行を追記する事で対応）
                config(['database.connections.mysql.strict' => false]);
                DB::reconnect();

                $start_year = $a;
                $start_month = $b;
                $start_day = $c;
                $end_year = $d;
                $end_month = $e;
                $end_day = $f;
                $this_year = $g;
                $last_year = $h;
                $two_years_ago = $j;
                $output = $k;
                $out1 = $l;
                $out2 = $m;
                $out3 = $n;
                $search = $o;
                $three_years_ago = $p;
                $next_year = $q;
                $first_day = $r;
                $last_day = $s;


            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // DB登録ロジックを実施
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                

                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）start
                    /************************************************************************************************************************************************************************************************************* */
                            $define = $this->define();
                            $def_i = 0;
                            // 各変数にパスやファイル名を代入
                                foreach($define as $def){
                                    if($def_i == 0){ $bladename = $def; }
                                    if($def_i == 1){ $file_pass = $def; }
                                    if($def_i == 2){ $file_pass2 = $def; }
                                    if($def_i == 3){ $file_name = $def; }
                                    if($def_i == 4){ $table_name = $def; }

                                    $def_i++;
                                }
                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）end
                    /************************************************************************************************************************************************************************************************************* */
                
                    /************************************************************************************************************************************************************************************************************* */
                        // フォームボタン押下時情報の受け取り start
                    /************************************************************************************************************************************************************************************************************* */

                            // 検索期間を変数に代入
                                /*$between_start = $start_year . "/" . $start_month . "/" . $start_day ." 00-00:00";
                                $between_end = $end_year . "/" . $end_month . "/" . $end_day ." 23-59:59";
                                $between_start_view = $start_year . "/" . $start_month . "/" . $start_day;
                                $between_end_view = $end_year . "/" . $end_month . "/" . $end_day;*/
                                $between_start = date("Y-m-d", strtotime($start_year. "-" . $start_month. "-" . $start_day));
                                //$between_end = $end_year . "-" . $end_month . "-" . $end_day;
                                $between_end = date("Y-m-d", strtotime($end_year. "-" . $end_month. "-" . $end_day));
                                $between_start_view = $start_year . "-" . $start_month . "-" . $start_day;
                                $between_end_view = $end_year . "-" . $end_month . "-" . $end_day;


                                $diff_start1 = new DateTime($between_start_view);
                                $diff_end1 = new DateTime($between_end_view);

                                $interval1 = $diff_end1 -> diff($diff_start1);

                                $diff_year1= $interval1 -> y;
                                $diff_month1 = $interval1 -> m;
                                $diff_month1 = $diff_year1 * 12 + $diff_month1;

                            // 「フォーム表示ボタン」フラグ
                                if (PostRequest::has('form_view')) {
                                    $form_view = PostRequest::input('form_view');
                                } else {$form_view = "OFF";}
                            

                            // 「扱い部門」フラグ
                                $out1_a = "ON";
                                $out1_b = "ON";
                                $out1_c = "ON";
                                
                            // 新中アンフラグ
                                $out2_a = "OFF";
                                $out2_b = "OFF";
                                $out2_c = "OFF";
                                if($out2 <> "" && in_array('1',$out2)){ $out2_a = "ON";}
                                if($out2 <> "" && in_array('2',$out2)){ $out2_b = "ON";}
                                if($out2 <> "" && in_array('3',$out2)){ $out2_c = "ON";}

                            // 条件
                                $out3_a = "OFF";
                                $out3_b = "OFF";
                                $out3_c = "OFF";

                                if($out3 <> "" && in_array('1',$out3)){ $out3_a = "ON";}
                                if($out3 <> "" && in_array('2',$out3)){ $out3_b = "ON";}
                                if($out3 <> "" && in_array('3',$out3)){ $out3_c = "ON";}


                    /************************************************************************************************************************************************************************************************************* */
                        // フォームボタン押下時情報の受け取り end
                    /************************************************************************************************************************************************************************************************************* */


                    /************************************************************************************************************************************************************************************************************* */
                        // 検索期間の月数だけ遡った過去の期間を取得 start
                    /************************************************************************************************************************************************************************************************************* */

                            // 開始と終了期間の差分（～カ月）を取得                        
                                $start = $start_year . "-" . $start_month . "-" . $start_day;
                                $end = $end_year . "-" . $end_month . "-" . $end_day;
                                $diff_start = new DateTime($start);
                                $diff_end = new DateTime($end);

                                $interval = $diff_end -> diff($diff_start);

                                $diff_year = $interval -> y;
                                $diff_month = $interval -> m;
                                $diff_month = $diff_year * 12 + $diff_month;
                            // 差分の月だけ遡った過去の期間を取得
                                // 検索開始日                
                                    $start_now = date($start_year. "-" . $start_month. "-" . $start_day);
                                // 過去開始日
                                    $past_between_start = date("Y-m-d", strtotime($start_now . " -" . ($diff_month + 1) . " month"));
                                    $past_between_start_view = date("Y-m", strtotime($start_now . " -" . ($diff_month +1) . " month"));
                                // 検索終了日
                                    $end_now = date($end_year. "-" . $end_month. "-" . $end_day);
                                // 過去終了日
                                    //$past_between_end = date("Y-m-d", strtotime($start_now . " -1 day"));
                                    $past_between_end = date("Y-m-01", strtotime($start_now . " -1 day"));
                                    $past_between_end_view = date("Y-m", strtotime($start_now . " -1 month"));

                                // 過去期間の月初日を配列へ代入（該当月のデータ登録が無い場合、JS代入値が空になってグラフがズレてしまう事を回避するため0代入ロジックに使う）
                                    // 配列版
                                        $manth_now_array = array();
                                        $manth_past_array = array();
                                    // カンマ区切りの文字列版
                                        $temp1_jack_manthly_data = "";
                                        $temp1_jack_manthly_data2 = "";
                                        $past_temp1_jack_manthly_data = "";
                                        $past_temp1_jack_manthly_data2 = "";
                                        $temp1_betty_manthly_data = "";
                                        $temp1_betty_manthly_data2 = "";
                                        $past_temp1_betty_manthly_data = "";
                                        $past_temp1_betty_manthly_data2 = "";
                                        $temp1_jewelry_manthly_data = "";
                                        $temp1_jewelry_manthly_data2 = "";
                                        $past_temp1_jewelry_manthly_data = "";
                                        $past_temp1_jewelry_manthly_data2 = "";
                                    for($past_ii = 0;  $past_ii <= $diff_month; $past_ii++){
                                        if($past_ii == 0){
                                            // 現在用
                                                $manth_now = date("Y-m", strtotime($start_now));
                                            // 過去用
                                                $past_manth = $past_between_start;
                                                $past_manth2 = mb_substr($past_between_start,0,-3);
                                        } else {
                                            // 現在用
                                                $manth_now = date("Y-m", strtotime($manth_now . " 1 month"));
                                            // 過去用
                                                $past_manth = date("Y-m-d", strtotime($past_manth . " 1 month"));
                                                $past_manth2 = date("Y-m", strtotime($past_manth2 . " 1 month"));
                                        }
                                        // 現在用
                                            array_push($manth_now_array,$manth_now);
                                        // 過去用
                                            array_push($manth_past_array,$past_manth);
                                            $temp1_jack_manthly_data .= $manth_now . ",";
                                            $temp1_jack_manthly_data2 .= $manth_now . ",";
                                            $past_temp1_jack_manthly_data .= $past_manth2 . ",";
                                            $past_temp1_jack_manthly_data2 .= $past_manth2 . ",";
                                            $temp1_betty_manthly_data .= $manth_now . ",";
                                            $temp1_betty_manthly_data2 .= $manth_now . ",";
                                            $past_temp1_betty_manthly_data .= $past_manth2 . ",";
                                            $past_temp1_betty_manthly_data2 .= $past_manth2 . ",";
                                            $temp1_jewelry_manthly_data .= $manth_now . ",";
                                            $temp1_jewelry_manthly_data2 .= $manth_now . ",";
                                            $past_temp1_jewelry_manthly_data .= $past_manth2 . ",";
                                            $past_temp1_jewelry_manthly_data2 .= $past_manth2 . ",";

                                    }
                                    $temp1_jack_manthly_data = trim($temp1_jack_manthly_data ,",");
                                    $temp1_jack_manthly_data2 = trim($temp1_jack_manthly_data2 ,",");
                                    $past_temp1_jack_manthly_data = trim($past_temp1_jack_manthly_data ,",");
                                    $past_temp1_jack_manthly_data2 = trim($past_temp1_jack_manthly_data2 ,",");
                                    $temp1_betty_manthly_data = trim($temp1_betty_manthly_data ,",");
                                    $temp1_betty_manthly_data2 = trim($temp1_betty_manthly_data2 ,",");
                                    $past_temp1_betty_manthly_data = trim($past_temp1_betty_manthly_data ,",");
                                    $past_temp1_betty_manthly_data2 = trim($past_temp1_betty_manthly_data2 ,",");
                                    $temp1_jewelry_manthly_data = trim($temp1_jewelry_manthly_data ,",");
                                    $temp1_jewelry_manthly_data2 = trim($temp1_jewelry_manthly_data2 ,",");
                                    $past_temp1_jewelry_manthly_data = trim($past_temp1_jewelry_manthly_data ,",");
                                    $past_temp1_jewelry_manthly_data2 = trim($past_temp1_jewelry_manthly_data2 ,",");


                    /************************************************************************************************************************************************************************************************************* */
                        // 検索期間の月数だけ遡った過去の期間を取得 end
                    /************************************************************************************************************************************************************************************************************* */


// 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
    // 当月の最終日
        $last_day2 = date('Y-m-d', strtotime('last day of' . $last_day));
    // データ格納最終日がその月の最終日と一致するか否かでフラグを作成（一致しない場合は平均の計算に含めないようにするため）
        if($last_day2 <> $last_day){ $last_nodata_flag = "ON"; } else { $last_nodata_flag = "OFF"; }


// 【進捗率の取得】
                                        

                                        /************************************************************************************************************************************************************************************************************* */
                                            // 検索期間の最初の日を求める（最終データ格納月の月初日）start
                                        /************************************************************************************************************************************************************************************************************* */
                                                    $last_day_array = explode('-',$last_day);
                                                    $i = 0;
                                                    $last_day_top = "";
                                                    foreach($last_day_array as $var){
                                                        // 年月
                                                            if($i <> 2){
                                                                $last_day_top .= $var . "-";
                                                            }
                                                        // 年
                                                            if($i == 0){
                                                                $last_year_last = $var;
                                                            }
                                                        // 月
                                                            if($i == 1){
                                                                $last_month_last = $var;
                                                            }
                                                        // 日
                                                            if($i == 2){
                                                                // 最終登録年月の月末日を取得する
                                                                    //$last_day_last = $var;
                                                                    // 20240225 最後のデータの日にちを取得したいが、在庫は1日でしか登録がないので以下のロジックにて取得
                                                                    $last_day_last = date("d", strtotime($last_day_top . "01" . " +1 month -1day"));
                                                            }
                                                        $i++;
                                                    }
                                                    // 年月に月初日を加える
                                                        $last_day_top .= "01";

                                                    // 当月の最終日
                                                        $last_day_last2 = date("d", strtotime($last_day_top . " +1 month -1day"));


                                        /************************************************************************************************************************************************************************************************************* */
                                            // 検索期間の最初の日を求める（最終データ格納月の月初日）end
                                        /************************************************************************************************************************************************************************************************************* */

                                        /************************************************************************************************************************************************************************************************************* */
                                            // 比較年月取得（最終データ格納年月の先月） start
                                        /************************************************************************************************************************************************************************************************************* */
                                                // 先月初日
                                                    $last_month_top = date("Y-m-d", strtotime($last_day_top . " -1 month"));
                                                // 先月最終日
                                                    $last_month = date("Y-m-d", strtotime($last_day_top . " -1day"));
                                        
                                        /************************************************************************************************************************************************************************************************************* */
                                            // 比較年月取得（最終データ格納年月の先月） end
                                        /************************************************************************************************************************************************************************************************************* */

                                        /************************************************************************************************************************************************************************************************************* */
                                            // 比較年月取得（最終データ格納年月から検索期間の月数だけ遡った年月） start
                                        /************************************************************************************************************************************************************************************************************* */

                                                // 差分の月だけ遡った過去の期間を取得
                                                    // 過去開始日（最終データ格納年月から検索期間を遡った年月日を取得）
                                                        $past_between_start_progress = date("Y-m-d", strtotime($last_day_top . " -" . ($diff_month + 1) . " month"));
                                                    // 過去終了日（上記年月日の月末日を取得）
                                                        //$past_between_end_progress = date("Y-m-d", strtotime($past_between_start_progress . " +1 month -1day"));
                                                        $past_between_end_progress = date("Y-m-01", strtotime($past_between_start_progress . " +1 month -1day"));
                                        
                                        /************************************************************************************************************************************************************************************************************* */
                                            // 比較年月取得（最終データ格納年月から検索期間の月数だけ遡った年月） end
                                        /************************************************************************************************************************************************************************************************************* */


                                       
                                        
                                        /************************************************************************************************************************************************************************************************************* */
                                            // 最終データ格納月のデータ取得　start
                                        /************************************************************************************************************************************************************************************************************* */


                                                            // DB検索（ベティー値）スタート
                                                                $betty_progress = DB::table($table_name) 
                                                                // 月毎にグループ化して値を分けるための処理
                                                                    ->select([
                                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS betty_month'),
                                                                        \DB::raw("SUM(zaikokingaku) AS betty_uriage"),
                                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS betty_number"),
                                                                    ])
                                                                    // 条件（売上部門がベティー）
                                                                        ->where('bumon','Bettyroad')
                                                                    // 条件（期間の指定）
                                                                        ->whereBetween($table_name . '.date', [$last_day_top, $last_day])
                                                                        
                                                                    // 条件（分類名）
                                                                        ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
                                                                            // 条件（商品区分分類名が新品）
                                                                                if($out2_a == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%新品%");
                                                                                }
                                                                            // 条件（商品区分分類名が中古）
                                                                                if($out2_b == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%中古%");
                                                                                }
                                                                            // 条件（商品区分分類名がアンティーク）
                                                                                if($out2_c == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
                                                                                }
                                                                   
                                                                        })

                                                                    // 条件
                                                                        ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                                            // 条件（修理預かりか否か）
                                                                                if($out3_a == "ON"){
                                                                                    $query->orwhere("souko_name","not like","%修理預%");
                                                                                }
                                                                            // 条件（ブランド名無しか否か）
                                                                                if($out3_b == "ON"){
                                                                                    $query->orwhere("brand_name","<>","");
                                                                                }
                                                                            // 条件（商品ID無しか否か）
                                                                                if($out3_c == "ON"){
                                                                                    $query->orwhere("tag","<>","");
                                                                                }
                                                                   
                                                                        })
                                                                        

                                                                // ソート順指定
                                                                    ->orderBy('date', 'asc')
                                                                    ->get();
                                                                // クエリビルダスタート
                                                                    // 変数リセット
                                                                        $betty_sum_uriage_progress = "";
                                                                        $i2 = 0;
                                                                        foreach ($betty_progress as $betty_buy_progress) {
                                                                            // 各月ジュエリー売上
                                                                            $betty_sum_uriage_progress = $betty_buy_progress -> betty_uriage;
                                                                            $betty_sum_number_progress = $betty_buy_progress -> betty_number;
                                                                            $i2++;
                                                                        }

                                                            // DB検索（ベティー値）スタート
                                                                $jack_progress = DB::table($table_name) 
                                                                // 月毎にグループ化して値を分けるための処理
                                                                    ->select([
                                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jack_month'),
                                                                        \DB::raw("SUM(zaikokingaku) AS jack_uriage"),
                                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS jack_number"),
                                                                ])
                                                                    // 条件（売上部門がWEB）
                                                                        ->where('bumon','Jackroad')
                                                                    // 条件（期間の指定）
                                                                        ->whereBetween($table_name
                                                                        
                                                                        . '.date', [$last_day_top, $last_day])
                                                                        
                                                                    // 条件（分類名）
                                                                        ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
                                                                            // 条件（商品区分分類名が新品）
                                                                                if($out2_a == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%新品%");
                                                                                }
                                                                            // 条件（商品区分分類名が中古）
                                                                                if($out2_b == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%中古%");
                                                                                }
                                                                            // 条件（商品区分分類名がアンティーク）
                                                                                if($out2_c == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
                                                                                }
                                                                    
                                                                        })

                                                                    // 条件
                                                                        ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                                            // 条件（修理預かりか否か）
                                                                                if($out3_a == "ON"){
                                                                                    $query->orwhere("souko_name","not like","%修理預%");
                                                                                }
                                                                            // 条件（ブランド名無しか否か）
                                                                                if($out3_b == "ON"){
                                                                                    $query->orwhere("brand_name","<>","");
                                                                                }
                                                                            // 条件（商品ID無しか否か）
                                                                                if($out3_c == "ON"){
                                                                                    $query->orwhere("tag","<>","");
                                                                                }
                                                                   
                                                                        })


                                                                // ソート順指定
                                                                    ->orderBy('date', 'asc')
                                                                    ->get();
                                                                // クエリビルダスタート
                                                                    // 変数リセット
                                                                        $jack_sum_uriage_progress = "";
                                                                        $i2 = 0;
                                                                        foreach ($jack_progress as $jack_buy_progress) {
                                                                            // 各月ジュエリー売上
                                                                            $jack_sum_uriage_progress = $jack_buy_progress -> jack_uriage;
                                                                            $jack_sum_number_progress = $jack_buy_progress -> jack_number;
                                                                            $i2++;
                                                                        }




                                                            // DB検索（ジュエリー値）スタート
                                                                $jewelry_sum_uriage_progress = "";
                                                                $jewelry_sum_number_progress = "";

                                                                if($out1_c == "ON"){
                                                                        $jewelry_progress = DB::table($table_name) 
                                                                        // 月毎にグループ化して値を分けるための処理
                                                                            ->select([
                                                                                \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jewelry_month'),
                                                                                \DB::raw("SUM(zaikokingaku) AS jewelry_uriage"),
                                                                                \DB::raw("SUM(tougetsumizaikosuuryou) AS jewelry_number"),
                                                                        ])

                                                                        // 条件（売上部門がジュエリー）
                                                                            ->where('bumon','Jewelry')
 
                                                                        // 条件（期間の指定）
                                                                            ->whereBetween($table_name . '.date', [$last_day_top, $last_day])
                                                                                
                                                                            // 条件（分類名）
                                                                                ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
                                                                                    // 条件（商品区分分類名が新品）
                                                                                        if($out2_a == "ON"){
                                                                                            $query->orwhere("shouhinkubunbunrui_name","like","%新品%");
                                                                                        }
                                                                                    // 条件（商品区分分類名が中古）
                                                                                        if($out2_b == "ON"){
                                                                                            $query->orwhere("shouhinkubunbunrui_name","like","%中古%");
                                                                                        }
                                                                                    // 条件（商品区分分類名がアンティーク）
                                                                                        if($out2_c == "ON"){
                                                                                            $query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
                                                                                        }
                                                                            
                                                                                })


                                                                            // 条件
                                                                                ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                                                    // 条件（修理預かりか否か）
                                                                                        if($out3_a == "ON"){
                                                                                            $query->orwhere("souko_name","not like","%修理預%");
                                                                                        }
                                                                                    // 条件（ブランド名無しか否か）
                                                                                        if($out3_b == "ON"){
                                                                                            $query->orwhere("brand_name","<>","");
                                                                                        }
                                                                                    // 条件（商品ID無しか否か）
                                                                                        if($out3_c == "ON"){
                                                                                            $query->orwhere("tag","<>","");
                                                                                        }
                                                                        
                                                                                })
 
                                                                        // ソート順指定
                                                                            ->orderBy('date', 'asc')
                                                                            ->get();
                                                                        // クエリビルダスタート
                                                                            // 変数リセット
                                                                                $jewelry_sum_uriage_progress = "";
                                                                                $i2 = 0;
                                                                                foreach ($jewelry_progress as $jewelry_buy_progress) {
                                                                                    // 各月ジュエリー売上
                                                                                    $jewelry_sum_uriage_progress = $jewelry_buy_progress -> jewelry_uriage;
                                                                                    $jewelry_sum_number_progress = $jewelry_buy_progress -> jewelry_number;
                                                                                    $i2++;
                                                                                }
                                                                }


                                        /************************************************************************************************************************************************************************************************************* */
                                            // 最終データ格納月のデータ取得　end
                                        /************************************************************************************************************************************************************************************************************* */
                                                    
                                        
                                        /************************************************************************************************************************************************************************************************************* */
                                            // 先月のデータ取得（最終データ格納年月比) start
                                        /************************************************************************************************************************************************************************************************************* */
                                        
                                                            // DB検索（ベティー値）スタート
                                                                $betty_progress2 = DB::table($table_name) 
                                                                // 月毎にグループ化して値を分けるための処理
                                                                    ->select([
                                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS betty_month2'),
                                                                        \DB::raw("SUM(zaikokingaku) AS betty_uriage2"),
                                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS betty_number2"),
                                                                    ])
                                                                    // 条件（売上部門がベティー）
                                                                        ->where('bumon','Bettyroad')
                                                                    // 条件（期間の指定）
                                                                        ->whereBetween($table_name . '.date', [$last_month_top, $last_month])
                                                                        
                                                                    // 条件（分類名）
                                                                        ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
                                                                            // 条件（商品区分分類名が新品）
                                                                                if($out2_a == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%新品%");
                                                                                }
                                                                            // 条件（商品区分分類名が中古）
                                                                                if($out2_b == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%中古%");
                                                                                }
                                                                            // 条件（商品区分分類名がアンティーク）
                                                                                if($out2_c == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
                                                                                }
                                                                    
                                                                        })

                                                                    // 条件
                                                                        ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                                            // 条件（修理預かりか否か）
                                                                                if($out3_a == "ON"){
                                                                                    $query->orwhere("souko_name","not like","%修理預%");
                                                                                }
                                                                            // 条件（ブランド名無しか否か）
                                                                                if($out3_b == "ON"){
                                                                                    $query->orwhere("brand_name","<>","");
                                                                                }
                                                                            // 条件（商品ID無しか否か）
                                                                                if($out3_c == "ON"){
                                                                                    $query->orwhere("tag","<>","");
                                                                                }
                                                                   
                                                                        })
                                                                        

                                                                // ソート順指定
                                                                    ->orderBy('date', 'asc')
                                                                    ->get();
                                                                // クエリビルダスタート
                                                                    // 変数リセット
                                                                        $betty_sum_uriage_progress2 = "";
                                                                        $i2 = 0;
                                                                        foreach ($betty_progress2 as $betty_buy_progress2) {
                                                                            // 各月ジュエリー売上
                                                                            $betty_sum_uriage_progress2 = $betty_buy_progress2 -> betty_uriage2;
                                                                            $betty_sum_number_progress2 = $betty_buy_progress2 -> betty_number2;
                                                                            $i2++;
                                                                        }

                                                            // DB検索（ベティー値）スタート
                                                                $jack_progress2 = DB::table($table_name) 
                                                                // 月毎にグループ化して値を分けるための処理
                                                                    ->select([
                                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jack_month2'),
                                                                        \DB::raw("SUM(zaikokingaku) AS jack_uriage2"),
                                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS jack_number2"),
                                                                ])
                                                                    // 条件（売上部門がWEB）
                                                                        ->where('bumon','Jackroad')
                                                                    // 条件（期間の指定）
                                                                        ->whereBetween($table_name . '.date', [$last_month_top, $last_month])
                                                                        
                                                                    // 条件（分類名）
                                                                        ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
                                                                            // 条件（商品区分分類名が新品）
                                                                                if($out2_a == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%新品%");
                                                                                }
                                                                            // 条件（商品区分分類名が中古）
                                                                                if($out2_b == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%中古%");
                                                                                }
                                                                            // 条件（商品区分分類名がアンティーク）
                                                                                if($out2_c == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
                                                                                }
                                                                    
                                                                    })


                                                                    // 条件
                                                                        ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                                            // 条件（修理預かりか否か）
                                                                                if($out3_a == "ON"){
                                                                                    $query->orwhere("souko_name","not like","%修理預%");
                                                                                }
                                                                            // 条件（ブランド名無しか否か）
                                                                                if($out3_b == "ON"){
                                                                                    $query->orwhere("brand_name","<>","");
                                                                                }
                                                                            // 条件（商品ID無しか否か）
                                                                                if($out3_c == "ON"){
                                                                                    $query->orwhere("tag","<>","");
                                                                                }
                                                                   
                                                                        })

                                                                // ソート順指定
                                                                    ->orderBy('date', 'asc')
                                                                    ->get();
                                                                // クエリビルダスタート
                                                                    // 変数リセット
                                                                        $jack_sum_uriage_progress2 = "";
                                                                        $i2 = 0;
                                                                        foreach ($jack_progress2 as $jack_buy_progress2) {
                                                                            // 各月ジュエリー売上
                                                                            $jack_sum_uriage_progress2 = $jack_buy_progress2 -> jack_uriage2;
                                                                            $jack_sum_number_progress2 = $jack_buy_progress2 -> jack_number2;
                                                                            $i2++;
                                                                        }




                                                            // DB検索（ジュエリー値）スタート
                                                                $jewelry_sum_uriage_progress2 = "";
                                                                $jewelry_sum_number_progress2 = "";
                                                       
                                                                if($out1_c == "ON"){                                                                
                                                                        $jewelry_progress2 = DB::table($table_name) 
                                                                        // 月毎にグループ化して値を分けるための処理
                                                                            ->select([
                                                                                \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jewelry_month2'),
                                                                                \DB::raw("SUM(zaikokingaku) AS jewelry_uriage2"),
                                                                                \DB::raw("SUM(tougetsumizaikosuuryou) AS jewelry_number2"),
                                                                        ])
                                                                    // 条件（売上部門がジュエリー）
                                                                        ->where('bumon','Jewelry')
                                                                    // 条件（期間の指定）
                                                                        ->whereBetween($table_name . '.date', [$last_month_top, $last_month])
                                                                                
                                                                    // 条件（分類名）
                                                                        ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
                                                                                // 条件（商品区分分類名が新品）
                                                                                    if($out2_a == "ON"){
                                                                                        $query->orwhere("shouhinkubunbunrui_name","like","%新品%");
                                                                                    }
                                                                                // 条件（商品区分分類名が中古）
                                                                                    if($out2_b == "ON"){
                                                                                        $query->orwhere("shouhinkubunbunrui_name","like","%中古%");
                                                                                    }
                                                                                // 条件（商品区分分類名がアンティーク）
                                                                                    if($out2_c == "ON"){
                                                                                        $query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
                                                                                    }
                                                                        
                                                                        })


                                                                    // 条件
                                                                        ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                                            // 条件（修理預かりか否か）
                                                                                if($out3_a == "ON"){
                                                                                    $query->orwhere("souko_name","not like","%修理預%");
                                                                                }
                                                                            // 条件（ブランド名無しか否か）
                                                                                if($out3_b == "ON"){
                                                                                    $query->orwhere("brand_name","<>","");
                                                                                }
                                                                            // 条件（商品ID無しか否か）
                                                                                if($out3_c == "ON"){
                                                                                    $query->orwhere("tag","<>","");
                                                                                }
                                                                   
                                                                        })

                                                                        // ソート順指定
                                                                            ->orderBy('date', 'asc')
                                                                            ->get();
                                                                        // クエリビルダスタート
                                                                            // 変数リセット
                                                                                $jewelry_sum_uriage_progress2 = "";
                                                                                $i2 = 0;
                                                                                foreach ($jewelry_progress2 as $jewelry_buy_progress2) {
                                                                                    // 各月ジュエリー売上
                                                                                    $jewelry_sum_uriage_progress2 = $jewelry_buy_progress2 -> jewelry_uriage2;
                                                                                    $jewelry_sum_number_progress2 = $jewelry_buy_progress2 -> jewelry_number2;
                                                                                    $i2++;
                                                                                }
                                                                }
                                        
                                        
                                        /************************************************************************************************************************************************************************************************************* */
                                            // 先月のデータ取得（最終データ格納年月比) 　end
                                        /************************************************************************************************************************************************************************************************************* */
                                        



                                        /************************************************************************************************************************************************************************************************************* */
                                            // 検索期間の月数だけ遡った年月のデータ取得（最終データ格納年月比) start
                                        /************************************************************************************************************************************************************************************************************* */
                                        
                                                            // DB検索（ベティー値）スタート
                                                                $betty_progress3 = DB::table($table_name) 
                                                                // 月毎にグループ化して値を分けるための処理
                                                                    ->select([
                                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS betty_month3'),
                                                                        \DB::raw("SUM(zaikokingaku) AS betty_uriage3"),
                                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS betty_number3"),
                                                                    ])
                                                                    // 条件（売上部門がベティー）
                                                                        ->where('bumon','Bettyroad')
                                                                    // 条件（期間の指定）
                                                                        ->whereBetween($table_name . '.date', [$past_between_start_progress, $past_between_end_progress])
                                                                        
                                                                    // 条件（分類名）
                                                                        ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
                                                                            // 条件（商品区分分類名が新品）
                                                                                if($out2_a == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%新品%");
                                                                                }
                                                                            // 条件（商品区分分類名が中古）
                                                                                if($out2_b == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%中古%");
                                                                                }
                                                                            // 条件（商品区分分類名がアンティーク）
                                                                                if($out2_c == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
                                                                                }
                                                                    
                                                                        })

                                                                    // 条件
                                                                        ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                                            // 条件（修理預かりか否か）
                                                                                if($out3_a == "ON"){
                                                                                    $query->orwhere("souko_name","not like","%修理預%");
                                                                                }
                                                                            // 条件（ブランド名無しか否か）
                                                                                if($out3_b == "ON"){
                                                                                    $query->orwhere("brand_name","<>","");
                                                                                }
                                                                            // 条件（商品ID無しか否か）
                                                                                if($out3_c == "ON"){
                                                                                    $query->orwhere("tag","<>","");
                                                                                }
                                                                   
                                                                        })
  
                                                                // ソート順指定
                                                                    ->orderBy('date', 'asc')
                                                                    ->get();
                                                                // クエリビルダスタート
                                                                    // 変数リセット
                                                                        $betty_sum_uriage_progress3 = "";
                                                                        $i2 = 0;
                                                                        foreach ($betty_progress3 as $betty_buy_progress3) {
                                                                            // 各月ジュエリー売上
                                                                            $betty_sum_uriage_progress3 = $betty_buy_progress3 -> betty_uriage3;
                                                                            $betty_sum_number_progress3 = $betty_buy_progress3 -> betty_number3;
                                                                            $i2++;
                                                                        }

                                                            // DB検索（ベティー値）スタート
                                                                $jack_progress3 = DB::table($table_name) 
                                                                // 月毎にグループ化して値を分けるための処理
                                                                    ->select([
                                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jack_month3'),
                                                                        \DB::raw("SUM(zaikokingaku) AS jack_uriage3"),
                                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS jack_number3"),
                                                                ])
                                                                    // 条件（売上部門がWEB）
                                                                        ->where('bumon','Jackroad')
                                                                    // 条件（期間の指定）
                                                                        ->whereBetween($table_name . '.date', [$past_between_start_progress, $past_between_end_progress])
                                                                        
                                                                    // 条件（分類名）
                                                                        ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
                                                                            // 条件（商品区分分類名が新品）
                                                                                if($out2_a == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%新品%");
                                                                                }
                                                                            // 条件（商品区分分類名が中古）
                                                                                if($out2_b == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%中古%");
                                                                                }
                                                                            // 条件（商品区分分類名がアンティーク）
                                                                                if($out2_c == "ON"){
                                                                                    $query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
                                                                                }
                                                                    
                                                                    })

                                                                    // 条件
                                                                        ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                                            // 条件（修理預かりか否か）
                                                                                if($out3_a == "ON"){
                                                                                    $query->orwhere("souko_name","not like","%修理預%");
                                                                                }
                                                                            // 条件（ブランド名無しか否か）
                                                                                if($out3_b == "ON"){
                                                                                    $query->orwhere("brand_name","<>","");
                                                                                }
                                                                            // 条件（商品ID無しか否か）
                                                                                if($out3_c == "ON"){
                                                                                    $query->orwhere("tag","<>","");
                                                                                }
                                                                   
                                                                        })

                                                                // ソート順指定
                                                                    ->orderBy('date', 'asc')
                                                                    ->get();
                                                                // クエリビルダスタート
                                                                    // 変数リセット
                                                                        $jack_sum_uriage_progress3 = "";
                                                                        $i2 = 0;
                                                                        foreach ($jack_progress3 as $jack_buy_progress3) {
                                                                            // 各月ジュエリー売上
                                                                            $jack_sum_uriage_progress3 = $jack_buy_progress3 -> jack_uriage3;
                                                                            $jack_sum_number_progress3 = $jack_buy_progress3 -> jack_number3;
                                                                            $i2++;
                                                                        }




                                                            // DB検索（ジュエリー値）スタート
                                                                $jewelry_sum_uriage_progress3 = "";
                                                                $jewelry_sum_number_progress3 = "";
                                                                if($out1_c == "ON"){                                                                
                                                                        $jewelry_progress3 = DB::table($table_name) 
                                                                        // 月毎にグループ化して値を分けるための処理
                                                                            ->select([
                                                                                \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jewelry_month3'),
                                                                                \DB::raw("SUM(zaikokingaku) AS jewelry_uriage3"),
                                                                                \DB::raw("SUM(tougetsumizaikosuuryou) AS jewelry_number3"),
                                                                        ])
                                                                        // 条件（売上部門がジュエリー）
                                                                            ->where('bumon','Jewelry')
                                                                        // 条件（期間の指定）
                                                                            ->whereBetween($table_name . '.date', [$past_between_start_progress, $past_between_end_progress])
                                                                                
                                                                            // 条件（分類名）
                                                                                ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
                                                                                    // 条件（商品区分分類名が新品）
                                                                                        if($out2_a == "ON"){
                                                                                            $query->orwhere("shouhinkubunbunrui_name","like","%新品%");
                                                                                        }
                                                                                    // 条件（商品区分分類名が中古）
                                                                                        if($out2_b == "ON"){
                                                                                            $query->orwhere("shouhinkubunbunrui_name","like","%中古%");
                                                                                        }
                                                                                    // 条件（商品区分分類名がアンティーク）
                                                                                        if($out2_c == "ON"){
                                                                                            $query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
                                                                                        }
                                                                            
                                                                            })

                                                                            // 条件
                                                                                ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                                                    // 条件（修理預かりか否か）
                                                                                        if($out3_a == "ON"){
                                                                                            $query->orwhere("souko_name","not like","%修理預%");
                                                                                        }
                                                                                    // 条件（ブランド名無しか否か）
                                                                                        if($out3_b == "ON"){
                                                                                            $query->orwhere("brand_name","<>","");
                                                                                        }
                                                                                    // 条件（商品ID無しか否か）
                                                                                        if($out3_c == "ON"){
                                                                                            $query->orwhere("tag","<>","");
                                                                                        }
                                                                        
                                                                                })

                                                                        // ソート順指定
                                                                            ->orderBy('date', 'asc')
                                                                            ->get();
                                                                        // クエリビルダスタート
                                                                            // 変数リセット
                                                                                $jewelry_sum_uriage_progress3 = "";
                                                                                $i2 = 0;
                                                                                foreach ($jewelry_progress3 as $jewelry_buy_progress3) {
                                                                                    // 各月ジュエリー売上
                                                                                    $jewelry_sum_uriage_progress3 = $jewelry_buy_progress3 -> jewelry_uriage3;
                                                                                    $jewelry_sum_number_progress3 = $jewelry_buy_progress3 -> jewelry_number3;
                                                                                    $i2++;
                                                                                }

                                                                }
                                      
                                        
                                        
                                        /************************************************************************************************************************************************************************************************************* */
                                            // 検索期間の月数だけ遡った年月のデータ取得（最終データ格納年月比) 　end
                                        /************************************************************************************************************************************************************************************************************* */
                                        

                                        /************************************************************************************************************************************************************************************************************* */
                                            // 各月間予測値と過去比を取得 start
                                        /************************************************************************************************************************************************************************************************************* */

                                                // 予測値
                                                        // ベティー・月間売上額予測
                                                            if($betty_sum_uriage_progress <> "" && $betty_sum_uriage_progress <> 0){
                                                                $betty_sum_uriage_progress_pre = (float)((int)$betty_sum_uriage_progress / (int)$last_day_last) * (int)$last_day_last2;
                                                            } else {
                                                                $betty_sum_uriage_progress_pre = "";
                                                            }
                                                        // ベティー・月間売上点数予測
                                                            if($betty_sum_number_progress <> "" && $betty_sum_number_progress <> 0){
                                                                $betty_sum_number_progress_pre = (float)((int)$betty_sum_number_progress / (int)$last_day_last) * (int)$last_day_last2;
                                                            } else {
                                                                $betty_sum_number_progress_pre = "";
                                                            }



                                                        // WEB・月間売上額予測
                                                            if($jack_sum_uriage_progress <> "" && $jack_sum_uriage_progress <> 0){
                                                                $jack_sum_uriage_progress_pre = (float)((int)$jack_sum_uriage_progress / (int)$last_day_last) * (int)$last_day_last2;
                                                            } else {
                                                                $jack_sum_uriage_progress_pre = "";
                                                            }
                                                        // WEB・月間売上点数予測
                                                            if($jack_sum_number_progress <> "" && $jack_sum_number_progress <> 0){
                                                                $jack_sum_number_progress_pre = (float)((int)$jack_sum_number_progress / (int)$last_day_last) * (int)$last_day_last2;
                                                            } else {
                                                                $jack_sum_number_progress_pre = "";
                                                            }

                                                        $jewelry_sum_uriage_progress_pre = "";
                                                        $jewelry_sum_number_progress_pre = "";
                                                        if($out1_c == "ON"){ 
                                                            // ジュエリー・月間売上額予測
                                                                if($jewelry_sum_uriage_progress <> "" && $jewelry_sum_uriage_progress <> 0){
                                                                    $jewelry_sum_uriage_progress_pre = (float)((int)$jewelry_sum_uriage_progress / (int)$last_day_last) * (int)$last_day_last2;
                                                                } else {
                                                                    $jewelry_sum_uriage_progress_pre = "";
                                                                }
                                                            // ジュエリー・月間売上点数予測
                                                                if($jewelry_sum_number_progress <> "" && $jewelry_sum_number_progress <> 0){
                                                                    $jewelry_sum_number_progress_pre = (float)((int)$jewelry_sum_number_progress / (int)$last_day_last) * (int)$last_day_last2;
                                                                } else {
                                                                    $jewelry_sum_number_progress_pre = "";
                                                                }

                                                        }

                                                    
                                                // 先月比
                                                        // ベティー・売上額予測・先月比
                                                            if($betty_sum_uriage_progress_pre <> "" && $betty_sum_uriage_progress_pre <> 0 && $betty_sum_uriage_progress2 <> "" && $betty_sum_uriage_progress2 <> 0){
                                                                $betty_sum_uriage_progress_pre2 = (floor(((float)$betty_sum_uriage_progress_pre / (float)$betty_sum_uriage_progress2) * 100 * 10)) / 10;
                                                            } else {
                                                                $betty_sum_uriage_progress_pre2 = "---";
                                                            }

                                                        // ベティー・売上点数予測・先月比
                                                            if($betty_sum_number_progress_pre <> "" && $betty_sum_number_progress_pre <> 0 && $betty_sum_number_progress2 <> "" && $betty_sum_number_progress2 <> 0){
                                                                $betty_sum_number_progress_pre2 = (floor(((float)$betty_sum_number_progress_pre / (float)$betty_sum_number_progress2) * 100 * 10)) / 10;
                                                            } else {
                                                                $betty_sum_number_progress_pre2 = "---";
                                                            }

                                                        // WEB・売上額予測・先月比
                                                            if($jack_sum_uriage_progress_pre <> "" && $jack_sum_uriage_progress_pre <> 0 && $jack_sum_uriage_progress2 <> "" && $jack_sum_uriage_progress2 <> 0){
                                                                $jack_sum_uriage_progress_pre2 = (floor(((float)$jack_sum_uriage_progress_pre / (float)$jack_sum_uriage_progress2) * 100 * 10)) / 10;
                                                            } else {
                                                                $jack_sum_uriage_progress_pre2 = "---";
                                                            }

                                                        // WEB・売上点数予測・先月比
                                                            if($jack_sum_number_progress_pre <> "" && $jack_sum_number_progress_pre <> 0 && $jack_sum_number_progress2 <> "" && $jack_sum_number_progress2 <> 0){
                                                                $jack_sum_number_progress_pre2 = (floor(((float)$jack_sum_number_progress_pre / (float)$jack_sum_number_progress2) * 100 * 10)) / 10;
                                                            } else {
                                                                $jack_sum_number_progress_pre2 = "---";
                                                            }
                                                        $jewelry_sum_uriage_progress_pre2 = "";
                                                        $jewelry_sum_number_progress_pre2 = "";
                                                        if($out1_c == "ON"){ 
                                                            // ジュエリー・売上額予測・先月比
                                                                if($jewelry_sum_uriage_progress_pre <> "" && $jewelry_sum_uriage_progress_pre <> 0 && $jewelry_sum_uriage_progress2 <> "" && $jewelry_sum_uriage_progress2 <> 0){
                                                                    $jewelry_sum_uriage_progress_pre2 = (floor(((float)$jewelry_sum_uriage_progress_pre / (float)$jewelry_sum_uriage_progress2) * 100 * 10)) / 10;
                                                                } else {
                                                                    $jewelry_sum_uriage_progress_pre2 = "---";
                                                                }

                                                            // ジュエリー・売上点数予測・先月比
                                                                if($jewelry_sum_number_progress_pre <> "" && $jewelry_sum_number_progress_pre <> 0 && $jewelry_sum_number_progress2 <> "" && $jewelry_sum_number_progress2 <> 0){
                                                                    $jewelry_sum_number_progress_pre2 = (floor(((float)$jewelry_sum_number_progress_pre / (float)$jewelry_sum_number_progress2) * 100 * 10)) / 10;
                                                                } else {
                                                                    $jewelry_sum_number_progress_pre2 = "---";
                                                                }

                                                        }
                                                // 過去比
                                                        // ベティー・売上額予測・過去比
                                                            if($betty_sum_uriage_progress_pre <> "" && $betty_sum_uriage_progress_pre <> 0 && $betty_sum_uriage_progress3 <> "" && $betty_sum_uriage_progress3 <> 0){
                                                                $betty_sum_uriage_progress_pre3 = (floor(((float)$betty_sum_uriage_progress_pre / (float)$betty_sum_uriage_progress3) * 100 * 10)) / 10;
                                                            } else {
                                                                $betty_sum_uriage_progress_pre3 = "---";
                                                            }
                                                        // ベティー・売上点数予測・過去比
                                                            if($betty_sum_number_progress_pre <> "" && $betty_sum_number_progress_pre <> 0 && $betty_sum_number_progress3 <> "" && $betty_sum_number_progress3 <> 0){
                                                                $betty_sum_number_progress_pre3 = (floor(((float)$betty_sum_number_progress_pre / (float)$betty_sum_number_progress3) * 100 * 10)) / 10;
                                                            } else {
                                                                $betty_sum_number_progress_pre3 = "---";
                                                            }
                                                        // WEB・売上額予測・過去比
                                                            if($jack_sum_uriage_progress_pre <> "" && $jack_sum_uriage_progress_pre <> 0 && $jack_sum_uriage_progress3 <> "" && $jack_sum_uriage_progress3 <> 0){
                                                                $jack_sum_uriage_progress_pre3 = (floor(((float)$jack_sum_uriage_progress_pre / (float)$jack_sum_uriage_progress3) * 100 * 10)) / 10;
                                                            } else {
                                                                $jack_sum_uriage_progress_pre3 = "---";
                                                            }
                                                        // WEB・売上点数予測・過去比
                                                            if($jack_sum_number_progress_pre <> "" && $jack_sum_number_progress_pre <> 0 && $jack_sum_number_progress3 <> "" && $jack_sum_number_progress3 <> 0){
                                                                $jack_sum_number_progress_pre3 = (floor(((float)$jack_sum_number_progress_pre / (float)$jack_sum_number_progress3) * 100 * 10)) / 10;
                                                            } else {
                                                                $jack_sum_number_progress_pre3 = "---";
                                                            }
                                                        $jewelry_sum_uriage_progress_pre3 = "";
                                                        $jewelry_sum_number_progress_pre3 = "";
                                                        if($out1_c == "ON"){ 
                                                            // ジュエリー・売上額予測・過去比
                                                                if($jewelry_sum_uriage_progress_pre <> "" && $jewelry_sum_uriage_progress_pre <> 0 && $jewelry_sum_uriage_progress3 <> "" && $jewelry_sum_uriage_progress3 <> 0){
                                                                    $jewelry_sum_uriage_progress_pre3 = (floor(((float)$jewelry_sum_uriage_progress_pre / (float)$jewelry_sum_uriage_progress3) * 100 * 10)) / 10;
                                                                } else {
                                                                    $jewelry_sum_uriage_progress_pre3 = "---";
                                                                }
                                                            // ジュエリー・売上点数予測・過去比
                                                                if($jewelry_sum_number_progress_pre <> "" && $jewelry_sum_number_progress_pre <> 0 && $jewelry_sum_number_progress3 <> "" && $jewelry_sum_number_progress3 <> 0){
                                                                    $jewelry_sum_number_progress_pre3 = (floor(((float)$jewelry_sum_number_progress_pre / (float)$jewelry_sum_number_progress3) * 100 * 10)) / 10;
                                                                } else {
                                                                    $jewelry_sum_number_progress_pre3 = "---";
                                                                }
                                                        }

                                                // 合計値
                                                        // データ格納最終月・売上額進捗合計
                                                            $all_sum_uriage_progress = (int)$betty_sum_uriage_progress + (int)$jack_sum_uriage_progress + (int)$jewelry_sum_uriage_progress;
                                                        // データ格納最終月・売上点数進捗合計
                                                            $all_sum_number_progress = (int)$betty_sum_number_progress + (int)$jack_sum_number_progress + (int)$jewelry_sum_number_progress;
                                                        // データ格納最終月・売上額・着地予測合計
                                                            $all_sum_uriage_progress_pre = (int)$betty_sum_uriage_progress_pre + (int)$jack_sum_uriage_progress_pre + (int)$jewelry_sum_uriage_progress_pre;
                                                        // データ格納最終月・売上点数・着地予測合計
                                                            $all_sum_number_progress_pre = (int)$betty_sum_number_progress_pre + (int)$jack_sum_number_progress_pre + (int)$jewelry_sum_number_progress_pre;

                                                        // 進捗合計に対する先月比
                                                            if($all_sum_uriage_progress_pre <> "" && $all_sum_uriage_progress_pre <> "" && ((int)$betty_sum_uriage_progress2 + (int)$jack_sum_uriage_progress2 + (int)$jewelry_sum_uriage_progress2) <> "" && ((int)$betty_sum_uriage_progress2 + (int)$jack_sum_uriage_progress2 + (int)$jewelry_sum_uriage_progress2) <> "" && $all_sum_uriage_progress_pre <> 0 && $all_sum_uriage_progress_pre <> 0 && ((int)$betty_sum_uriage_progress2 + (int)$jack_sum_uriage_progress2 + (int)$jewelry_sum_uriage_progress2) <> 0 && ((int)$betty_sum_uriage_progress2 + (int)$jack_sum_uriage_progress2 + (int)$jewelry_sum_uriage_progress2) <> 0
                                                            ){
                                                                $all_sum_uriage_progress2 = (floor(((int)$all_sum_uriage_progress_pre / ((int)$betty_sum_uriage_progress2 + (int)$jack_sum_uriage_progress2 + (int)$jewelry_sum_uriage_progress2)) * 100 * 10)) / 10;
                                                            } else {
                                                                $all_sum_uriage_progress2 = "---";
                                                            }
                                                            if($all_sum_number_progress_pre <> "" && $all_sum_number_progress_pre <> "" && ((int)$betty_sum_number_progress2 + (int)$jack_sum_number_progress2 + (int)$jewelry_sum_number_progress2) <> "" && ((int)$betty_sum_number_progress2 + (int)$jack_sum_number_progress2 + (int)$jewelry_sum_number_progress2) <> "" && $all_sum_number_progress_pre <> 0 && $all_sum_number_progress_pre <> 0 && ((int)$betty_sum_number_progress2 + (int)$jack_sum_number_progress2 + (int)$jewelry_sum_number_progress2) <> 0 && ((int)$betty_sum_number_progress2 + (int)$jack_sum_number_progress2 + (int)$jewelry_sum_number_progress2) <> 0
                                                            ){
                                                                $all_sum_number_progress2 = (floor(((int)$all_sum_number_progress_pre / ((int)$betty_sum_number_progress2 + (int)$jack_sum_number_progress2 + (int)$jewelry_sum_number_progress2)) * 100 * 10)) / 10;
                                                            } else {
                                                                $all_sum_number_progress2 = "---";
                                                            }
                                                        // 進捗合計に対する過去比
                                                            if($all_sum_uriage_progress_pre <> "" && $all_sum_uriage_progress_pre <> "" && ((int)$betty_sum_uriage_progress3 + (int)$jack_sum_uriage_progress3 + (int)$jewelry_sum_uriage_progress3) <> "" && ((int)$betty_sum_uriage_progress3 + (int)$jack_sum_uriage_progress3 + (int)$jewelry_sum_uriage_progress3) <> "" && $all_sum_uriage_progress_pre <> 0 && $all_sum_uriage_progress_pre <> 0 && ((int)$betty_sum_uriage_progress3 + (int)$jack_sum_uriage_progress3 + (int)$jewelry_sum_uriage_progress3) <> 0 && ((int)$betty_sum_uriage_progress3 + (int)$jack_sum_uriage_progress3 + (int)$jewelry_sum_uriage_progress3) <> 0){
                                                                $all_sum_uriage_progress3 = (floor(((int)$all_sum_uriage_progress_pre / ((int)$betty_sum_uriage_progress3 + (int)$jack_sum_uriage_progress3 + (int)$jewelry_sum_uriage_progress3)) * 100 * 10)) / 10;
                                                            } else {
                                                                $all_sum_uriage_progress3 = "---";
                                                            }
                                                            if($all_sum_number_progress_pre <> "" && $all_sum_number_progress_pre <> "" && ((int)$betty_sum_number_progress3 + (int)$jack_sum_number_progress3 + (int)$jewelry_sum_number_progress3) <> "" && ((int)$betty_sum_number_progress3 + (int)$jack_sum_number_progress3 + (int)$jewelry_sum_number_progress3) <> "" && $all_sum_number_progress_pre <> 0 && $all_sum_number_progress_pre <> 0 && ((int)$betty_sum_number_progress3 + (int)$jack_sum_number_progress3 + (int)$jewelry_sum_number_progress3) <> 0 && ((int)$betty_sum_number_progress3 + (int)$jack_sum_number_progress3 + (int)$jewelry_sum_number_progress3) <> 0){
                                                                $all_sum_number_progress3 = (floor(((int)$all_sum_number_progress_pre / ((int)$betty_sum_number_progress3 + (int)$jack_sum_number_progress3 + (int)$jewelry_sum_number_progress3)) * 100 * 10)) / 10;
                                                            } else {
                                                                $all_sum_number_progress3 = "---";
                                                            }
                                                            
                                                        // HTML作成
                                                            ($betty_sum_uriage_progress == 0 || $betty_sum_uriage_progress == "") ? $betty_uriage_view1 = $betty_sum_uriage_progress : $betty_uriage_view1 = number_format((int)$betty_sum_uriage_progress);
                                                            ($betty_sum_uriage_progress_pre == 0 || $betty_sum_uriage_progress_pre == "") ? $betty_uriage_view2 = $betty_sum_uriage_progress_pre : $betty_uriage_view2 = number_format((int)$betty_sum_uriage_progress_pre);
                                                            ($betty_sum_uriage_progress_pre2 == 0 || $betty_sum_uriage_progress_pre2 == "") ? $betty_uriage_view3 = $betty_sum_uriage_progress_pre2 : $betty_uriage_view3 = number_format((int)$betty_sum_uriage_progress_pre2,1);
                                                            ($betty_sum_uriage_progress_pre3 == 0 || $betty_sum_uriage_progress_pre3 == "") ? $betty_uriage_view4 = $betty_sum_uriage_progress_pre3 : $betty_uriage_view4 = number_format((int)$betty_sum_uriage_progress_pre3,1);
                                                            ($jack_sum_uriage_progress == 0 || $jack_sum_uriage_progress == "") ? $jack_uriage_view1 = $jack_sum_uriage_progress : $jack_uriage_view1 = number_format((int)$jack_sum_uriage_progress);
                                                            ($jack_sum_uriage_progress_pre == 0 || $jack_sum_uriage_progress_pre == "") ? $jack_uriage_view2 = $jack_sum_uriage_progress_pre : $jack_uriage_view2 = number_format((int)$jack_sum_uriage_progress_pre);
                                                            ($jack_sum_uriage_progress_pre2 == 0 || $jack_sum_uriage_progress_pre2 == "") ? $jack_uriage_view3 = $jack_sum_uriage_progress_pre2 : $jack_uriage_view3 = number_format((int)$jack_sum_uriage_progress_pre2,1);
                                                            ($jack_sum_uriage_progress_pre3 == 0 || $jack_sum_uriage_progress_pre3 == "") ? $jack_uriage_view4 = $jack_sum_uriage_progress_pre3 : $jack_uriage_view4 = number_format((int)$jack_sum_uriage_progress_pre3,1);
                                                            ($jewelry_sum_uriage_progress == 0 || $jewelry_sum_uriage_progress == "") ? $jewelry_uriage_view1 = $jewelry_sum_uriage_progress : $jewelry_uriage_view1 = number_format((int)$jewelry_sum_uriage_progress);
                                                            ($jewelry_sum_uriage_progress_pre == 0 || $jewelry_sum_uriage_progress_pre == "") ? $jewelry_uriage_view2 = $jewelry_sum_uriage_progress_pre : $jewelry_uriage_view2 = number_format((int)$jewelry_sum_uriage_progress_pre);
                                                            ($jewelry_sum_uriage_progress_pre2 == 0 || $jewelry_sum_uriage_progress_pre2 == "") ? $jewelry_uriage_view3 = $jewelry_sum_uriage_progress_pre2 : $jewelry_uriage_view3 = number_format((int)$jewelry_sum_uriage_progress_pre2,1);
                                                            ($jewelry_sum_uriage_progress_pre3 == 0 || $jewelry_sum_uriage_progress_pre3 == "") ? $jewelry_uriage_view4 = $jewelry_sum_uriage_progress_pre3 : $jewelry_uriage_view4 = number_format((int)$jewelry_sum_uriage_progress_pre3,1);
                                                            ($all_sum_uriage_progress == 0 || $all_sum_uriage_progress == "") ? $all_uriage_view1 = $all_sum_uriage_progress : $all_uriage_view1 = number_format((int)$all_sum_uriage_progress);
                                                            ($all_sum_uriage_progress_pre == 0 || $all_sum_uriage_progress_pre == "") ? $all_uriage_view2 = $all_sum_uriage_progress_pre : $all_uriage_view2 = number_format((int)$all_sum_uriage_progress_pre);
                                                            ($all_sum_uriage_progress2 == 0 || $all_sum_uriage_progress2 == "") ? $all_uriage_view3 = $all_sum_uriage_progress2 : $all_uriage_view3 = number_format((int)$all_sum_uriage_progress2,1);
                                                            ($all_sum_uriage_progress3 == 0 || $all_sum_uriage_progress3 == "") ? $all_uriage_view4 = $all_sum_uriage_progress3 : $all_uriage_view4 = number_format((int)$all_sum_uriage_progress3,1);
                                                            
                                                            
                                                            ($betty_sum_number_progress == 0 || $betty_sum_number_progress == "") ? $betty_number_view1 = $betty_sum_number_progress : $betty_number_view1 = number_format((int)$betty_sum_number_progress);
                                                            ($betty_sum_number_progress_pre == 0 || $betty_sum_number_progress_pre == "") ? $betty_number_view2 = $betty_sum_number_progress_pre : $betty_number_view2 = number_format((int)$betty_sum_number_progress_pre);
                                                            ($betty_sum_number_progress_pre2 == 0 || $betty_sum_number_progress_pre2 == "") ? $betty_number_view3 = $betty_sum_number_progress_pre2 : $betty_number_view3 = number_format((int)$betty_sum_number_progress_pre2,1);
                                                            ($betty_sum_number_progress_pre3 == 0 || $betty_sum_number_progress_pre3 == "") ? $betty_number_view4 = $betty_sum_number_progress_pre3 : $betty_number_view4 = number_format((int)$betty_sum_number_progress_pre3,1);
                                                            ($jack_sum_number_progress == 0 || $jack_sum_number_progress == "") ? $jack_number_view1 = $jack_sum_number_progress : $jack_number_view1 = number_format((int)$jack_sum_number_progress);
                                                            ($jack_sum_number_progress_pre == 0 || $jack_sum_number_progress_pre == "") ? $jack_number_view2 = $jack_sum_number_progress_pre : $jack_number_view2 = number_format((int)$jack_sum_number_progress_pre);
                                                            ($jack_sum_number_progress_pre2 == 0 || $jack_sum_number_progress_pre2 == "") ? $jack_number_view3 = $jack_sum_number_progress_pre2 : $jack_number_view3 = number_format((int)$jack_sum_number_progress_pre2,1);
                                                            ($jack_sum_number_progress_pre3 == 0 || $jack_sum_number_progress_pre3 == "") ? $jack_number_view4 = $jack_sum_number_progress_pre3 : $jack_number_view4 = number_format((int)$jack_sum_number_progress_pre3,1);
                                                            ($jewelry_sum_number_progress == 0 || $jewelry_sum_number_progress == "") ? $jewelry_number_view1 = $jewelry_sum_number_progress : $jewelry_number_view1 = number_format((int)$jewelry_sum_number_progress);
                                                            ($jewelry_sum_number_progress_pre == 0 || $jewelry_sum_number_progress_pre == "") ? $jewelry_number_view2 = $jewelry_sum_number_progress_pre : $jewelry_number_view2 = number_format((int)$jewelry_sum_number_progress_pre);
                                                            ($jewelry_sum_number_progress_pre2 == 0 || $jewelry_sum_number_progress_pre2 == "") ? $jewelry_number_view3 = $jewelry_sum_number_progress_pre2 : $jewelry_number_view3 = number_format((int)$jewelry_sum_number_progress_pre2,1);
                                                            ($jewelry_sum_number_progress_pre3 == 0 || $jewelry_sum_number_progress_pre3 == "") ? $jewelry_number_view4 = $jewelry_sum_number_progress_pre3 : $jewelry_number_view4 = number_format((int)$jewelry_sum_number_progress_pre3,1);
                                                            ($all_sum_number_progress == 0 || $all_sum_number_progress == "") ? $all_number_view1 = $all_sum_number_progress : $all_number_view1 = number_format((int)$all_sum_number_progress);
                                                            ($all_sum_number_progress_pre == 0 || $all_sum_number_progress_pre == "") ? $all_number_view2 = $all_sum_number_progress_pre : $all_number_view2 = number_format((int)$all_sum_number_progress_pre);
                                                            ($all_sum_number_progress2 == 0 || $all_sum_number_progress2 == "") ? $all_number_view3 = $all_sum_number_progress2 : $all_number_view3 = number_format((int)$all_sum_number_progress2,1);
                                                            ($all_sum_number_progress3 == 0 || $all_sum_number_progress3 == "") ? $all_number_view4 = $all_sum_number_progress3 : $all_number_view4 = number_format((int)$all_sum_number_progress3,1);
                                                            

                                                            ($betty_uriage_view3 < 100) ? $betty_uriage_view3 = "<div class='sinchoku fc_blue'>" . $betty_uriage_view3 . "%</div>" : $betty_uriage_view3 = "<div class='sinchoku fc_red'>" . $betty_uriage_view3 . "%</div>";
                                                            ($betty_uriage_view4 < 100) ? $betty_uriage_view4 = "<div class='sinchoku fc_blue'>" . $betty_uriage_view4 . "%</div>" : $betty_uriage_view4 = "<div class='sinchoku fc_red'>" . $betty_uriage_view4 . "%</div>";
                                                            ($jack_uriage_view3 < 100) ? $jack_uriage_view3 = "<div class='sinchoku fc_blue'>" . $jack_uriage_view3 . "%</div>" : $jack_uriage_view3 = "<div class='sinchoku fc_red'>" . $jack_uriage_view3 . "%</div>";
                                                            ($jack_uriage_view4 < 100) ? $jack_uriage_view4 = "<div class='sinchoku fc_blue'>" . $jack_uriage_view4 . "%</div>" : $jack_uriage_view4 = "<div class='sinchoku fc_red'>" . $jack_uriage_view4 . "%</div>";
                                                            ($jewelry_uriage_view3 < 100) ? $jewelry_uriage_view3 = "<div class='sinchoku fc_blue'>" . $jewelry_uriage_view3 . "%</div>" : $jewelry_uriage_view3 = "<div class='sinchoku fc_red'>" . $jewelry_uriage_view3 . "%</div>";
                                                            ($jewelry_uriage_view4 < 100) ? $jewelry_uriage_view4 = "<div class='sinchoku fc_blue'>" . $jewelry_uriage_view4 . "%</div>" : $jewelry_uriage_view4 = "<div class='sinchoku fc_red'>" . $jewelry_uriage_view4 . "%</div>";
                                                            ($all_uriage_view3 < 100) ? $all_uriage_view3 = "<div class='sinchoku bg_grey fc_blue'>" . $all_uriage_view3 . "%</div>" : $all_uriage_view3 = "<div class='sinchoku bg_grey fc_red'>" . $all_uriage_view3 . "%</div>";
                                                            ($all_uriage_view4 < 100) ? $all_uriage_view4 = "<div class='sinchoku bg_grey fc_blue'>" . $all_uriage_view4 . "%</div>" : $all_uriage_view4 = "<div class='sinchoku bg_grey fc_red'>" . $all_uriage_view4 . "%</div>";
                                                            ($betty_number_view3 < 100) ? $betty_number_view3 = "<div class='sinchoku fc_blue'>" . $betty_number_view3 . "%</div>" : $betty_number_view3 = "<div class='sinchoku fc_red'>" . $betty_number_view3 . "%</div>";
                                                            ($betty_number_view4 < 100) ? $betty_number_view4 = "<div class='sinchoku fc_blue'>" . $betty_number_view4 . "%</div>" : $betty_number_view4 = "<div class='sinchoku fc_red'>" . $betty_number_view4 . "%</div>";
                                                            ($jack_number_view3 < 100) ? $jack_number_view3 = "<div class='sinchoku fc_blue'>" . $jack_number_view3 . "%</div>" : $jack_number_view3 = "<div class='sinchoku fc_red'>" . $jack_number_view3 . "%</div>";
                                                            ($jack_number_view4 < 100) ? $jack_number_view4 = "<div class='sinchoku fc_blue'>" . $jack_number_view4 . "%</div>" : $jack_number_view4 = "<div class='sinchoku fc_red'>" . $jack_number_view4 . "%</div>";
                                                            ($jewelry_number_view3 < 100) ? $jewelry_number_view3 = "<div class='sinchoku fc_blue'>" . $jewelry_number_view3 . "%</div>" : $jewelry_number_view3 = "<div class='sinchoku fc_red'>" . $jewelry_number_view3 . "%</div>";
                                                            ($jewelry_number_view4 < 100) ? $jewelry_number_view4 = "<div class='sinchoku fc_blue'>" . $jewelry_number_view4 . "%</div>" : $jewelry_number_view4 = "<div class='sinchoku fc_red'>" . $jewelry_number_view4 . "%</div>";
                                                            ($all_number_view3 < 100) ? $all_number_view3 = "<div class='sinchoku bg_grey fc_blue'>" . $all_number_view3 . "%</div>" : $all_number_view3 = "<div class='sinchoku bg_grey fc_red'>" . $all_number_view3 . "%</div>";
                                                            ($all_number_view4 < 100) ? $all_number_view4 = "<div class='sinchoku bg_grey fc_blue'>" . $all_number_view4 . "%</div>" : $all_number_view4 = "<div class='sinchoku bg_grey fc_red'>" . $all_number_view4 . "%</div>";


                                        /************************************************************************************************************************************************************************************************************* */
                                            // 各予測値と過去比を取得 end
                                        /************************************************************************************************************************************************************************************************************* */
                                        



                    /************************************************************************************************************************************************************************************************************* */
                        // DB情報の受け取り（過去の期間）start
                    /************************************************************************************************************************************************************************************************************* */
                    
                            $past_temp1_title2 = "";
                            //$past_js_month = "";
                            $past_i = 0;

                            /************************************************************************************************************************************************************************************************************* */
                                // ジャック用（過去の期間）
                            /************************************************************************************************************************************************************************************************************* */
                                    
                                    if($out1_b == "ON"){
                                            // DB検索（ジャック値）スタート
                                                $past_jack_buys = DB::table($table_name) 
                                                // 月毎にグループ化して値を分けるための処理
                                                    ->select([
                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jack_month'),
                                                        \DB::raw("SUM(zaikokingaku) AS jack_uriage"),
                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS jack_number"),
                                                    ])
                                                    ->groupBy('jack_month')
                                                // 条件（売上部門がジャック）
                                                    ->where('bumon','Jackroad')
                                                // 条件（期間の指定）
                                                    ->whereBetween($table_name . '.date', [$past_between_start, $past_between_end])
                                                // 条件（分類名）
                                                    ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
															// 条件（商品区分分類名が新品）
																if($out2_a == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%新品%");
																}
															// 条件（商品区分分類名が中古）
																if($out2_b == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%中古%");
																}
															// 条件（商品区分分類名がアンティーク）
																if($out2_c == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
																}
                                                    })

                                                // 条件
                                                    ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                        // 条件（修理預かりか否か）
                                                            if($out3_a == "ON"){
                                                                $query->orwhere("souko_name","not like","%修理預%");
                                                            }
                                                        // 条件（ブランド名無しか否か）
                                                            if($out3_b == "ON"){
                                                                $query->orwhere("brand_name","<>","");
                                                            }
                                                        // 条件（商品ID無しか否か）
                                                            if($out3_c == "ON"){
                                                                $query->orwhere("tag","<>","");
                                                            }
                                                
                                                    })

                                                // ソート順指定
                                                    ->orderBy('date', 'asc')
                                                    ->get();

                                            // クエリビルダスタート
                                                $past_i = 0;
                                                // 変数リセット
                                                    $past_jack_sum_uriage = "";
                                                    $past_jack_sum_number = "";
                                                    foreach ($past_jack_buys as $past_jack_buy) {
                                                        // 各月名
                                                            $past_jack_month[$past_i]= $past_jack_buy->jack_month;
                                                        // 各月ジャック売上
                                                            $past_jack_uriage[$past_i]= $past_jack_buy->jack_uriage;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($past_temp1_jack_manthly_data, $past_jack_month[$past_i] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $past_temp1_jack_manthly_data = str_replace($past_jack_month[$past_i], $past_jack_uriage[$past_i], $past_temp1_jack_manthly_data);
                                                                }

                                                        // 全期間ジャック売上合計
                                                            $past_jack_sum_uriage = (int)$past_jack_sum_uriage + (int)$past_jack_uriage[$past_i];

                                                        // 各月ジャック点数
                                                            $past_jack_number[$past_i]= $past_jack_buy->jack_number;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($past_temp1_jack_manthly_data2, $past_jack_month[$past_i] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $past_temp1_jack_manthly_data2 = str_replace($past_jack_month[$past_i], $past_jack_number[$past_i], $past_temp1_jack_manthly_data2);
                                                                }

                                                        // 全期間ジャック点数合計
                                                            $past_jack_sum_number = (int)$past_jack_sum_number + (int)$past_jack_number[$past_i];


                                                        $past_i++;
                                                    }
                                                // 全期間ジャック売上合計とその平均値のHTML作成
                                                    $past_temp1_jack_sum = "";
                                                    if($past_jack_sum_uriage <> 0 && $past_jack_sum_uriage <> ""){
                                                        $past_jack_sum_uriage_c = number_format((int)$past_jack_sum_uriage); 
                                                        $past_jack_sum_uriage_ave = number_format(floor((int)$past_jack_sum_uriage / $past_i));
                                                        $past_jack_sum_uriage_ave2 = floor((int)$past_jack_sum_uriage / $past_i);
                                                    } else {
                                                        $past_jack_sum_uriage_c = $past_jack_sum_uriage; 
                                                        $past_jack_sum_uriage_ave = 0;
                                                        $past_jack_sum_uriage_ave2 = 0;
                                                    }
                                                    //$past_temp1_jack_sum = "<div class='title4 ta_r'>" . number_format((int)$past_jack_sum_uriage) . "</div><div class='title4 ta_r'>" . number_format(floor((int)$past_jack_sum_uriage / $past_i)) . "</div></div>";
                                                    $past_temp1_jack_sum = "<div class='title4 ta_r'>" . $past_jack_sum_uriage_c . "</div><div class='title4 ta_r'>" . $past_jack_sum_uriage_ave . "</div></div>";
                                                // 全期間ジャック売上点数合計とその平均値のHTML作成
                                                    $past_temp1_jack_sum2 = "";
                                                    if($past_jack_sum_number <> 0 && $past_jack_sum_number <> ""){
                                                        $past_jack_sum_number_c = number_format((int)$past_jack_sum_number); 
                                                        $past_jack_sum_number_ave = number_format(floor((int)$past_jack_sum_number / $past_i));
                                                        $past_jack_sum_number_ave2 = floor((int)$past_jack_sum_number / $past_i);
                                                    } else {
                                                        $past_jack_sum_number_c = $past_jack_sum_number; 
                                                        $past_jack_sum_number_ave = 0;
                                                        $past_jack_sum_number_ave2 = 0;
                                                    }
                                                    $past_temp1_jack_sum2 = "<div class='title4 ta_r'>" . $past_jack_sum_number_c . "</div><div class='title4 ta_r'>" . $past_jack_sum_number_ave . "</div></div>";

                                    }
        

                            /************************************************************************************************************************************************************************************************************* */
                                // ベティー用（過去の期間）
                            /************************************************************************************************************************************************************************************************************* */
                                    if($out1_a == "ON"){
                                            // DB検索（ベティー値）スタート
                                                $past_betty_buys = DB::table($table_name) 
                                                // 月毎にグループ化して値を分けるための処理
                                                    ->select([
                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS betty_month'),
                                                        \DB::raw("SUM(zaikokingaku) AS betty_uriage"),
                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS betty_number"),
                                                    ])
                                                    ->groupBy('betty_month')
                                                // 条件（売上部門がベティー）
                                                    ->where('bumon','Bettyroad')
                                                // 条件（期間の指定）
                                                    ->whereBetween($table_name . '.date', [$past_between_start, $past_between_end])
                                                // 条件（分類名）
                                                    ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
															// 条件（商品区分分類名が新品）
																if($out2_a == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%新品%");
																}
															// 条件（商品区分分類名が中古）
																if($out2_b == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%中古%");
																}
															// 条件（商品区分分類名がアンティーク）
																if($out2_c == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
																}
                                                    
                                                    })
                                                // 条件
                                                    ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                        // 条件（修理預かりか否か）
                                                            if($out3_a == "ON"){
                                                                $query->orwhere("souko_name","not like","%修理預%");
                                                            }
                                                        // 条件（ブランド名無しか否か）
                                                            if($out3_b == "ON"){
                                                                $query->orwhere("brand_name","<>","");
                                                            }
                                                        // 条件（商品ID無しか否か）
                                                            if($out3_c == "ON"){
                                                                $query->orwhere("tag","<>","");
                                                            }
                                                
                                                    })

                                                // ソート順指定
                                                    ->orderBy('date', 'asc')
                                                    ->get();

                                            // クエリビルダスタート
                                                $past_i = 0;
                                                // 変数リセット
                                                    $past_betty_sum_uriage = "";
                                                    $past_betty_sum_number = "";
                                                    foreach ($past_betty_buys as $past_betty_buy) {
                                                        // 各月名
                                                            $past_betty_month[$past_i]= $past_betty_buy->betty_month;
                                                        // 各月ベティー売上
                                                            $past_betty_uriage[$past_i]= $past_betty_buy->betty_uriage;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($past_temp1_betty_manthly_data, $past_betty_month[$past_i] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $past_temp1_betty_manthly_data = str_replace($past_betty_month[$past_i], $past_betty_uriage[$past_i], $past_temp1_betty_manthly_data);
                                                                }
                                                        // 全期間ベティー売上合計
                                                            $past_betty_sum_uriage = (int)$past_betty_sum_uriage + (int)$past_betty_uriage[$past_i];
                                                        
                                                        // 各月ベティー点数
                                                            $past_betty_number[$past_i]= $past_betty_buy->betty_number;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($past_temp1_betty_manthly_data2, $past_betty_month[$past_i] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $past_temp1_betty_manthly_data2 = str_replace($past_betty_month[$past_i], $past_betty_number[$past_i], $past_temp1_betty_manthly_data2);
                                                                }
                                                        // 全期間ベティー点数合計
                                                            $past_betty_sum_number = (int)$past_betty_sum_number + (int)$past_betty_number[$past_i];
                                                          
                                                            
                                                            
                                                        $past_i++;
                                                    }
                                                // 全期間ベティー売上合計とその平均値のHTML作成
                                                    $past_temp1_betty_sum = "";
                                                    if($past_betty_sum_uriage <> 0 && $past_betty_sum_uriage <> ""){
                                                        $past_betty_sum_uriage_c = number_format((int)$past_betty_sum_uriage); 
                                                        $past_betty_sum_uriage_ave = number_format(floor((int)$past_betty_sum_uriage / $past_i));
                                                        $past_betty_sum_uriage_ave2 = floor((int)$past_betty_sum_uriage / $past_i);
                                                    } else {
                                                        $past_betty_sum_uriage_c = $past_betty_sum_uriage; 
                                                        $past_betty_sum_uriage_ave = 0;
                                                        $past_betty_sum_uriage_ave2 = 0;
                                                    }
                                                    //$past_temp1_betty_sum = "<div class='title4 ta_r'>" . number_format((int)$past_betty_sum_uriage) . "</div><div class='title4 ta_r'>" . number_format(floor((int)$past_betty_sum_uriage / $past_i)) . "</div></div>";
                                                    $past_temp1_betty_sum = "<div class='title4 ta_r'>" . $past_betty_sum_uriage_c . "</div><div class='title4 ta_r'>" . $past_betty_sum_uriage_ave . "</div></div>";
                                                // 全期間ベティー売上点数合計とその平均値のHTML作成
                                                    $past_temp1_betty_sum2 = "";
                                                    if($past_betty_sum_number <> 0 && $past_betty_sum_number <> ""){
                                                        $past_betty_sum_number_c = number_format((int)$past_betty_sum_number); 
                                                        $past_betty_sum_number_ave = number_format(floor((int)$past_betty_sum_number / $past_i));
                                                        $past_betty_sum_number_ave2 = floor((int)$past_betty_sum_number / $past_i);
                                                    } else {
                                                        $past_betty_sum_number_c = $past_betty_sum_number; 
                                                        $past_betty_sum_number_ave = 0;
                                                        $past_betty_sum_number_ave2 = 0;
                                                    }
                                                    $past_temp1_betty_sum2 = "<div class='title4 ta_r'>" . $past_betty_sum_number_c . "</div><div class='title4 ta_r'>" . $past_betty_sum_number_ave . "</div></div>";
                                    }

     

                            /************************************************************************************************************************************************************************************************************* */
                                // ジュエリー用（過去の期間）
                            /************************************************************************************************************************************************************************************************************* */
                                    if($out1_c == "ON"){
                                            // DB検索（ジュエリー）スタート
                                                $past_jewelry_buys = DB::table($table_name) 
                                                // 月毎にグループ化して値を分けるための処理
                                                    ->select([
                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jewelry_month'),
                                                        \DB::raw("SUM(zaikokingaku) AS jewelry_uriage"),
                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS jewelry_number"),
                                                    ])
                                                    ->groupBy('jewelry_month')
                                                // 条件（売上部門がジュエリー）
                                                    ->where('bumon','Jewelry')
                                                // 条件（期間の指定）
                                                    ->whereBetween($table_name . '.date', [$past_between_start, $past_between_end])
                                                // 条件（分類名）
                                                    ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
															// 条件（商品区分分類名が新品）
																if($out2_a == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%新品%");
																}
															// 条件（商品区分分類名が中古）
																if($out2_b == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%中古%");
																}
															// 条件（商品区分分類名がアンティーク）
																if($out2_c == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
																}
                                                    
                                                    })

                                                // 条件
                                                    ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                        // 条件（修理預かりか否か）
                                                            if($out3_a == "ON"){
                                                                $query->orwhere("souko_name","not like","%修理預%");
                                                            }
                                                        // 条件（ブランド名無しか否か）
                                                            if($out3_b == "ON"){
                                                                $query->orwhere("brand_name","<>","");
                                                            }
                                                        // 条件（商品ID無しか否か）
                                                            if($out3_c == "ON"){
                                                                $query->orwhere("tag","<>","");
                                                            }
                                                
                                                    })
                                                    

                                                // ソート順指定
                                                    ->orderBy('date', 'asc')
                                                    ->get();

                                            // クエリビルダスタート
                                                // 以下の変数は月数フラグとして後のロジックで使用するが、フォームにて「免税のみ」を選択した場合「ジュエリー」は全月一つも無いので、上でロジックが止まってしまい月数カウントの変数も0のままとなる。「ジュエリー」のみ独立した変数名として、カウント用はベティー用で対応
                                                $past_i2 = 0;
                                                // 変数リセット
                                                    $past_jewelry_sum_uriage = 0;
                                                    $past_jewelry_sum_number = 0;
                                                    foreach ($past_jewelry_buys as $past_jewelry_buy) {
                                                        // 各月名
                                                            $past_jewelry_month[$past_i2]= $past_jewelry_buy->jewelry_month;
                                                        // 各月ジュエリー売上
                                                            $past_jewelry_uriage[$past_i2]= $past_jewelry_buy->jewelry_uriage;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($past_temp1_jewelry_manthly_data, $past_jewelry_month[$past_i2] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $past_temp1_jewelry_manthly_data = str_replace($past_jewelry_month[$past_i2], $past_jewelry_uriage[$past_i2], $past_temp1_jewelry_manthly_data);
                                                                }
                                                        // 全期間ジュエリー売上合計
                                                            $past_jewelry_sum_uriage = (int)$past_jewelry_sum_uriage + (int)$past_jewelry_uriage[$past_i2];
                                                        // 各月ジュエリー点数
                                                            $past_jewelry_number[$past_i2]= $past_jewelry_buy->jewelry_number;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($past_temp1_jewelry_manthly_data2, $past_jewelry_month[$past_i2] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $past_temp1_jewelry_manthly_data2 = str_replace($past_jewelry_month[$past_i2], $past_jewelry_number[$past_i2], $past_temp1_jewelry_manthly_data2);
                                                                }
                                                        // 全期間ジュエリー点数合計
                                                            $past_jewelry_sum_number = (int)$past_jewelry_sum_number + (int)$past_jewelry_number[$past_i2];
                                                           
                                                            $past_i2++;
                                                    }
                                                // 全期間ジュエリー売上合計とその平均値のHTML作成
                                                    $past_temp1_jewelry_sum = "";
                                                    if($past_jewelry_sum_uriage <> 0 && $past_jewelry_sum_uriage <> ""){
                                                        $past_jewelry_sum_uriage_c = number_format((int)$past_jewelry_sum_uriage); 
                                                        $past_jewelry_sum_uriage_ave = number_format(floor((int)$past_jewelry_sum_uriage / $past_i2));
                                                        $past_jewelry_sum_uriage_ave2 = floor((int)$past_jewelry_sum_uriage / $past_i);
                                                    } else {
                                                        $past_jewelry_sum_uriage_c = $past_jewelry_sum_uriage; 
                                                        $past_jewelry_sum_uriage_ave = 0;
                                                        $past_jewelry_sum_uriage_ave2 = 0;
                                                    }
                                                    //$past_temp1_jewelry_sum .= "<div class='title4 ta_r'>" . number_format((int)$past_jewelry_sum_uriage) . "</div><div class='title4 ta_r'>" . number_format(floor((int)$past_jewelry_sum_uriage / $past_i2)) . "</div></div>";
                                                    $past_temp1_jewelry_sum .= "<div class='title4 ta_r'>" . $past_jewelry_sum_uriage_c . "</div><div class='title4 ta_r'>" . $past_jewelry_sum_uriage_ave . "</div></div>";
                                                // 全期間ジュエリー売上点数合計とその平均値のHTML作成
                                                    $past_temp1_jewelry_sum2 = "";
                                                    if($past_jewelry_sum_number <> 0 && $past_jewelry_sum_number <> ""){
                                                        $past_jewelry_sum_number_c = number_format((int)$past_jewelry_sum_number); 
                                                        $past_jewelry_sum_number_ave = number_format(floor((int)$past_jewelry_sum_number / $past_i2));
                                                        $past_jewelry_sum_number_ave2 = floor((int)$past_jewelry_sum_number / $past_i);
                                                    } else {
                                                        $past_jewelry_sum_number_c = $past_jewelry_sum_number; 
                                                        $past_jewelry_sum_number_ave = 0;
                                                        $past_jewelry_sum_number_ave2 = 0;
                                                    }
                                                    $past_temp1_jewelry_sum2 = "<div class='title4 ta_r'>" . $past_jewelry_sum_number_c . "</div><div class='title4 ta_r'>" . $past_jewelry_sum_number_ave . "</div></div>";

                                    }

                                            
                            /************************************************************************************************************************************************************************************************************* */
                                // 全件用
                            /************************************************************************************************************************************************************************************************************* */

                                        // 各月の全部門売上合計の先頭（1列目）部分のタイトルHTML
                                            //$past_all_sum_uriage = "<div class='wid100 ul3'><div class='title5 ta_c'>合計</div>";
                                            $past_all_sum_number = "<div class='wid100 ul3'><div class='title5 ta_c'>合計</div>";
                                        // 各月のタイトル表示用HTMLを作成
                                            $js_month = "";
                                            foreach($manth_now_array as $val){
                                                // JSグラフ用
                                                    $js_month .= "'" . $val . "(" . date("Y-m", strtotime($val. " -" . ($diff_month + 1) . " month")) . ")'" . ",";
                                            }
                                            $past_temp1_title2 = "";
                                            $past_temp1_title3 = "";
                                            $past_temp1_title4 = "";
                                            $past_temp1_title5 = "";
                                            foreach($manth_past_array as $val){
                                                // 表示用
                                                    $val = mb_substr($val,0,-3);
                                                    $past_temp1_title2 .= "<div class='title2 ta_c'>" . $val . "</div>";
                                                    $past_temp1_title3 .= "<div class='title7 ta_c'>" . $val . "</div>";
                                                    $past_temp1_title4 .= "<div class='title7 ta_c'>" . $val . "</div>";
                                                    $past_temp1_title5 .= "<div class='title7 ta_c'>" . $val . "</div>";
                                            }
                                
                                            $past_temp1_title = "<div class='wid100 ul2'><div class='title5 ta_c'>" . $past_between_start_view. "～<br>" .$past_between_end_view . "</div>" .$past_temp1_title2 ."<div class='title6 ta_c'>累計</div><div class='title6 ta_c'>平均</div></div>";
                                            $past_temp1_title3 = "<div class='wid100 ul2'><div class='title7 ta_c'>" . $past_between_start_view. "～<br>" .$past_between_end_view . "</div>" .$past_temp1_title3 ."<div class='title7 ta_c'>平均</div></div>";
                                            $past_temp1_title4 = "<div class='wid100 ul2 bg_green'><div class='title7 ta_c'>" . $past_between_start_view. "～<br>" .$past_between_end_view . "</div>" .$past_temp1_title4 ."<div class='title7 ta_c'>平均</div></div>";
                                            $past_temp1_title5 = "<div class='wid100 ul2 bg_yellow'><div class='title7 ta_c'>" . $past_between_start_view. "～<br>" .$past_between_end_view . "</div>" .$past_temp1_title5 ."<div class='title7 ta_c'>平均</div></div>";
                                        
                                     
                                        
                                        // 全期間の全部門売上合計用変数リセット
                                            $past_all_sum_uriage_all = 0;
                                            $past_all_sum_number_all = 0;
                                            for($past_all_i = 0; $past_all_i < $past_i; $past_all_i++){
                                                // 各月の全部門売上合計用変数リセット
                                                    $past_all_month_uriage = 0;
                                                    $past_all_month_number= 0;
                                                // 各月の全部門売上合計をHTMLへ
                                                    if($out1_b == "ON"){ 
                                                        if(isset($past_jack_uriage[$past_all_i])){$past_all_month_uriage = $past_all_month_uriage + (int)$past_jack_uriage[$past_all_i];}
                                                        if(isset($past_jack_number[$past_all_i])){$past_all_month_number = $past_all_month_number + (int)$past_jack_number[$past_all_i]; }
                                                    }
                                                    if($out1_a == "ON"){ 
                                                        if(isset($past_betty_uriage[$past_all_i])){$past_all_month_uriage = $past_all_month_uriage + (int)$past_betty_uriage[$past_all_i]; }
                                                        if(isset($past_betty_number[$past_all_i])){$past_all_month_number = $past_all_month_number + (int)$past_betty_number[$past_all_i];} 
                                                    }

                                                // 全期間の全部門売上合計
                                                    $past_all_sum_uriage_all = (int)$past_all_sum_uriage_all + (int)$past_all_month_uriage;
                                                    $past_all_sum_number_all = (int)$past_all_sum_number_all + (int)$past_all_month_number;
                                                
                                            }



                            /************************************************************************************************************************************************************************************************************* */
                                // 最終ソース出力
                            /************************************************************************************************************************************************************************************************************* */
                                        


                                        // ジャック（過去）用HTMLの作成
                                                $past_js_jack_uriage  = "";
                                                $past_js_jack_number  = "";
                                                $past_temp1_jack_manthly_html = "";
                                                $past_temp1_jack_manthly_html2 = "";
                                                $past_temp1_jack_manthly_html3 = "";
                                                if($out1_b == "ON"){     
                                                    // 過去全期間名の文字列で、年月名がそのまま記載されているものは「0」に変換（売上データが存在するは年月名を売上の数字に置き換え済なので、年月名がそのまま残っているものはデータ無なので）
                                                        foreach($manth_past_array as $val){
                                                                $val = mb_substr($val,0,-3);
                                                                if(strpos($past_temp1_jack_manthly_data, $val ) !== false){
                                                                    $past_temp1_jack_manthly_data = str_replace($val, 0, $past_temp1_jack_manthly_data);
                                                                }
                                                                if(strpos($past_temp1_jack_manthly_data2, $val ) !== false){
                                                                    $past_temp1_jack_manthly_data2 = str_replace($val, 0, $past_temp1_jack_manthly_data2);
                                                                }
                                                        }
                                                    // 各月売上が記載された文字列を配列へ変換
                                                        $past_temp1_jack_manthly_array = explode(',',$past_temp1_jack_manthly_data);
                                                        $past_temp1_jack_manthly_array2 = explode(',',$past_temp1_jack_manthly_data2);
                                                    // 各月のHTMLを作成
                                                        $past_jack_last_uriage = "";

                                                        foreach($past_temp1_jack_manthly_array as $val){
                                                            // 【進捗率の取得】最終月の「過去・ジャック・売上」を取得
                                                                //$past_jack_last_uriage = $val;
                                                            
                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $past_js_jack_uriage  .= "0, ";
                                                                // 表示用
                                                                    $past_temp1_jack_manthly_html .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $past_js_jack_uriage  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $past_temp1_jack_manthly_html .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }

                                                        }
                                                        foreach($past_temp1_jack_manthly_array2 as $val){
                                                            // 【進捗率の取得】最終月の「過去・ジャック・点数」を取得
                                                                //$past_jack_last_number = $val;
                                                            
                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $past_js_jack_number  .= "0, ";
                                                                // 表示用
                                                                    $past_temp1_jack_manthly_html2 .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $past_js_jack_number  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $past_temp1_jack_manthly_html2 .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }

                                                        }

                                                    // 全体HTMLの作成
                                                        if(isset($past_temp1_jack_manthly_html) && isset($past_temp1_jack_sum)){
                                                            $past_temp1_jack_manthly_html = "<div class='wid100 ul1'><div class='title1 ta_c'>ジャック</div>" . $past_temp1_jack_manthly_html . $past_temp1_jack_sum;
                                                        }
                                                        if(isset($past_temp1_jack_manthly_html2) && isset($past_temp1_jack_sum2)){
                                                            $past_temp1_jack_manthly_html2 = "<div class='wid100 ul1'><div class='title1 ta_c'>ジャック</div>" . $past_temp1_jack_manthly_html2 . $past_temp1_jack_sum2;
                                                        }
                                                        if(isset($past_temp1_jack_manthly_html3) && isset($past_temp1_jack_sum3)){
                                                            $past_temp1_jack_manthly_html3 = "<div class='wid100 ul1'><div class='title1 ta_c'>ジャック</div>" . $past_temp1_jack_manthly_html3 . $past_temp1_jack_sum3;
                                                        }
                                                }
                                
                            
                                        // ベティー（過去）用HTMLの作成
                                                $past_js_betty_uriage  = "";
                                                $past_js_betty_number  = "";
                                                $past_temp1_betty_manthly_html = "";
                                                $past_temp1_betty_manthly_html2 = "";
                                                $past_temp1_betty_manthly_html3 = "";
                                                if($out1_a == "ON"){     
                                                    // 過去全期間名の文字列で、年月名がそのまま記載されているものは「0」に変換（売上データが存在するは年月名を売上の数字に置き換え済なので、年月名がそのまま残っているものはデータ無なので）
                                                        foreach($manth_past_array as $val){
                                                                $val = mb_substr($val,0,-3);
                                                                if(strpos($past_temp1_betty_manthly_data, $val ) !== false){
                                                                    $past_temp1_betty_manthly_data = str_replace($val, 0, $past_temp1_betty_manthly_data);
                                                                }
                                                                if(strpos($past_temp1_betty_manthly_data2, $val ) !== false){
                                                                    $past_temp1_betty_manthly_data2 = str_replace($val, 0, $past_temp1_betty_manthly_data2);
                                                                }
                                                        }
                                                    // 各月売上が記載された文字列を配列へ変換
                                                        $past_temp1_betty_manthly_array = explode(',',$past_temp1_betty_manthly_data);
                                                        $past_temp1_betty_manthly_array2 = explode(',',$past_temp1_betty_manthly_data2);
                                                    // 各月のHTMLを作成
                                                        foreach($past_temp1_betty_manthly_array as $val){
                                                            // 【進捗率の取得】最終月の「過去・ベティー・売上」を取得
                                                                //$past_betty_last_uriage = $val;

                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $past_js_betty_uriage  .= "0, ";
                                                                // 表示用
                                                                    $past_temp1_betty_manthly_html .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $past_js_betty_uriage  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $past_temp1_betty_manthly_html .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }

                                                        }
                                                        foreach($past_temp1_betty_manthly_array2 as $val){
                                                            // 【進捗率の取得】最終月の「過去・ベティー・点数」を取得
                                                                //$past_betty_last_number = $val;
                                                            
                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $past_js_betty_number  .= "0, ";
                                                                // 表示用
                                                                    $past_temp1_betty_manthly_html2 .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $past_js_betty_number  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $past_temp1_betty_manthly_html2 .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }

                                                        }

                                                    // 全体HTMLの作成
                                                        if(isset($past_temp1_betty_manthly_html) && isset($past_temp1_betty_sum)){
                                                            $past_temp1_betty_manthly_html = "<div class='wid100 ul1'><div class='title1 ta_c'>ベティー</div>" . $past_temp1_betty_manthly_html . $past_temp1_betty_sum;
                                                        }
                                                        if(isset($past_temp1_betty_manthly_html2) && isset($past_temp1_betty_sum2)){
                                                            $past_temp1_betty_manthly_html2 = "<div class='wid100 ul1'><div class='title1 ta_c'>ベティー</div>" . $past_temp1_betty_manthly_html2 . $past_temp1_betty_sum2;
                                                        }
                                                        if(isset($past_temp1_betty_manthly_html3) && isset($past_temp1_betty_sum3)){
                                                            $past_temp1_betty_manthly_html3 = "<div class='wid100 ul1'><div class='title1 ta_c'>ベティー</div>" . $past_temp1_betty_manthly_html3 . $past_temp1_betty_sum3;
                                                        }
                                                }


                                        // ジュエリー（過去）用HTMLの作成
                                                $past_js_jewelry_uriage  = "";
                                                $past_js_jewelry_number  = "";
                                                $past_temp1_jewelry_manthly_html = "";
                                                $past_temp1_jewelry_manthly_html2 = "";
                                                $past_temp1_jewelry_manthly_html3 = "";
                                                if($out1_c == "ON"){     
                                                    // 過去全期間名の文字列で、年月名がそのまま記載されているものは「0」に変換（売上データが存在するは年月名を売上の数字に置き換え済なので、年月名がそのまま残っているものはデータ無なので）
                                                        foreach($manth_past_array as $val){
                                                                $val = mb_substr($val,0,-3);
                                                                if(strpos($past_temp1_jewelry_manthly_data, $val ) !== false){
                                                                    $past_temp1_jewelry_manthly_data = str_replace($val, 0, $past_temp1_jewelry_manthly_data);
                                                                }
                                                                if(strpos($past_temp1_jewelry_manthly_data2, $val ) !== false){
                                                                    $past_temp1_jewelry_manthly_data2 = str_replace($val, 0, $past_temp1_jewelry_manthly_data2);
                                                                }
                                                        }
                                                    // 各月売上が記載された文字列を配列へ変換
                                                        $past_temp1_jewelry_manthly_array = explode(',',$past_temp1_jewelry_manthly_data);
                                                        $past_temp1_jewelry_manthly_array2 = explode(',',$past_temp1_jewelry_manthly_data2);
                                                    // 各月のHTMLを作成
                                                        foreach($past_temp1_jewelry_manthly_array as $val){
                                                            // 【進捗率の取得】最終月の「過去・ジュエリー・売上」を取得
                                                                //$past_jewelry_last_uriage = $val;
                                                            
                                                            if($val == ""){
                                                                // 表示用
                                                                    $past_temp1_jewelry_manthly_html .= "<div class='title3 ta_r'>0</div>";
                                                                // JSグラフ用
                                                                    $past_js_jewelry_uriage  .= "0, ";
                                                            } else {
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $past_temp1_jewelry_manthly_html .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                                // JSグラフ用
                                                                    $past_js_jewelry_uriage  .= $val . ", ";
                                                            }

                                                        }
                                                        foreach($past_temp1_jewelry_manthly_array2 as $val){
                                                            // 【進捗率の取得】最終月の「過去・ジュエリー・点数」を取得
                                                                //$past_jewelry_last_number = $val;

                                                            if($val == ""){
                                                                // 表示用
                                                                    $past_temp1_jewelry_manthly_html2 .= "<div class='title3 ta_r'>0</div>";
                                                                // JSグラフ用
                                                                    $past_js_jewelry_number  .= "0, ";
                                                            } else {
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $past_temp1_jewelry_manthly_html2 .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                                // JSグラフ用
                                                                    $past_js_jewelry_number  .= $val . ", ";
                                                            }

                                                        }

                                                    // 全体HTMLの作成
                                                        if(isset($past_temp1_jewelry_manthly_html) && isset($past_temp1_jewelry_sum)){
                                                            $past_temp1_jewelry_manthly_html = "<div class='wid100 ul1'><div class='title1 ta_c'>ジュエリー</div>" . $past_temp1_jewelry_manthly_html . $past_temp1_jewelry_sum;
                                                        }
                                                        if(isset($past_temp1_jewelry_manthly_html2) && isset($past_temp1_jewelry_sum2)){
                                                            $past_temp1_jewelry_manthly_html2 = "<div class='wid100 ul1'><div class='title1 ta_c'>ジュエリー</div>" . $past_temp1_jewelry_manthly_html2 . $past_temp1_jewelry_sum2;
                                                        }
                                                        if(isset($past_temp1_jewelry_manthly_html3) && isset($past_temp1_jewelry_sum3)){
                                                            $past_temp1_jewelry_manthly_html3 = "<div class='wid100 ul1'><div class='title1 ta_c'>ジュエリー</div>" . $past_temp1_jewelry_manthly_html3 . $past_temp1_jewelry_sum3;
                                                        }
                                                }

                                        // 各月の全部門売上合計のJS表示用
                                                $js_past_all_month_uriage = "";
                                                $js_past_all_month_number = "";
                                                $i = 0;
                                                foreach($manth_past_array as $val){
                                                    $all_js = 0;
                                                    $all_js2 = 0;
                                                    $all_js3 = 0;
                                                    if($out1_a == "ON"){ $all_js = (int)$all_js + (int)$past_temp1_betty_manthly_array[$i]; $all_js2 = (int)$all_js2 + (int)$past_temp1_betty_manthly_array2[$i]; $all_js3 = (int)$all_js3;}
                                                    if($out1_b == "ON"){ $all_js = (int)$all_js + (int)$past_temp1_jack_manthly_array[$i]; $all_js2 = (int)$all_js2 + (int)$past_temp1_jack_manthly_array2[$i]; $all_js3 = (int)$all_js3;}
                                                    if($out1_c == "ON"){ $all_js = (int)$all_js + (int)$past_temp1_jewelry_manthly_array[$i]; $all_js2 = (int)$all_js2 + (int)$past_temp1_jewelry_manthly_array2[$i]; $all_js3 = (int)$all_js3;}

                                                    $js_past_all_month_uriage .= $all_js . ", ";
                                                    $js_past_all_month_number .= $all_js2 . ", ";
                                                    
                                                    $i++;
                                                }
        




                                        // 各月の全部門売上合計の先頭（1列目）部分のタイトルHTML
                                            $past_all_sum_uriage = "<div class='wid100 ul3'><div class='title5 ta_c'>合計</div>";
                                            $past_all_sum_number = "<div class='wid100 ul3'><div class='title5 ta_c'>合計</div>";

                                        // 各月の全部門売上合計を配列に代入
                                            $past_temp1_all_m_sum_uriage_array = array();
                                            $past_temp1_all_m_sum_number_array = array();
                                            $i = 0;
                                            foreach($manth_past_array as $val){
                                                $all = "";
                                                $all2 = "";
                                                $all3 = "";
                                                if($out1_a == "ON"){ $all = (int)$all + (int)$past_temp1_betty_manthly_array[$i]; $all2 = (int)$all2 + (int)$past_temp1_betty_manthly_array2[$i]; $all3 = (int)$all3;}
                                                if($out1_b == "ON"){ $all = (int)$all + (int)$past_temp1_jack_manthly_array[$i]; $all2 = (int)$all2 + (int)$past_temp1_jack_manthly_array2[$i]; $all3 = (int)$all3;}
                                                if($out1_c == "ON"){ $all = (int)$all + (int)$past_temp1_jewelry_manthly_array[$i]; $all2 = (int)$all2 + (int)$past_temp1_jewelry_manthly_array2[$i]; $all3 = (int)$all3;}
                                                array_push($past_temp1_all_m_sum_uriage_array,$all);
                                                array_push($past_temp1_all_m_sum_number_array,$all2);

                                                $i++;
                                            }
                                        // 各月の全部門売上合計部分のHTML作成
                                            foreach($past_temp1_all_m_sum_uriage_array as $var){
                                                if($var <> 0 && $var <> ""){
                                                    $past_all_sum_uriage .= "<div class='title6 ta_r'>" . number_format((int)$var) . "</div>";
                                                } else {
                                                    $past_all_sum_uriage .= "<div class='title6 ta_r'>" . (int)$var . "</div>";
                                                }
                                            }
                                        // 各月の全部門売上点数合計部分のHTML作成
                                            foreach($past_temp1_all_m_sum_number_array as $var){
                                                if($var <> 0 && $var <> ""){
                                                    $past_all_sum_number .= "<div class='title6 ta_r'>" . number_format((int)$var) . "</div>";
                                                } else {
                                                    $past_all_sum_number .= "<div class='title6 ta_r'>" . (int)$var . "</div>";
                                                }
                                            }
                                                  
                                        // 全期間全部門売上合計とその平均値のHTML作成
                                            if($past_all_sum_uriage_all <> 0){ 
                                                // 金額・全部門・全期間の平均を横軸合計から縦軸合計に変更
                                                    //$past_all_average = floor((int)$past_all_sum_uriage_all / $past_i);
                                                    if($out1_c == "ON"){
                                                        $past_all_average = (int)$past_jack_sum_uriage_ave2 + (int)$past_betty_sum_uriage_ave2 + (int)$past_jewelry_sum_uriage_ave2;
                                                    } else {
                                                        $past_all_average = (int)$past_jack_sum_uriage_ave2 + (int)$past_betty_sum_uriage_ave2;
                                                    }
                                            } else {
                                                $past_all_average = 0;
                                            }
                                            $past_all_sum_uriage .= "<div class='title6 ta_r'>" . number_format((int)$past_all_sum_uriage_all) . "</div><div class='title6 ta_r'>" . number_format((int)$past_all_average) . "</div></div>";
                                        // 全HTMLを合体（検索対象外は除く）
                                            $view = "";
                                            if($out1_a == "ON"){ $view .= $past_temp1_betty_manthly_html;}
                                            if($out1_b == "ON"){ $view .= $past_temp1_jack_manthly_html;}
                                            if($out1_c == "ON"){ $view .= $past_temp1_jewelry_manthly_html;}
                                            $past_temp1_all_sorce = "<p class='title_a'>金額（過去）</p><div class='box1'>" . $past_temp1_title . $view . $past_all_sum_uriage . "</div>";

                                        // 全期間全部門売上点数合計とその平均値のHTML作成
                                            if($past_all_sum_number_all <> 0){ 
                                                // 金額・全部門・全期間の平均を横軸合計から縦軸合計に変更
                                                    //$past_all_average2 = floor((int)$past_all_sum_number_all / $past_i);
                                                    if($out1_c == "ON"){
                                                        $past_all_average2 = (int)$past_jack_sum_number_ave2 + (int)$past_betty_sum_number_ave2 + (int)$past_jewelry_sum_number_ave2;
                                                    } else {
                                                        $past_all_average2 = (int)$past_jack_sum_number_ave2 + (int)$past_betty_sum_number_ave2;
                                                    }
                                            } else {
                                                $past_all_average2 = 0;
                                            }
                                            $past_all_sum_number .= "<div class='title6 ta_r'>" . number_format((int)$past_all_sum_number_all) . "</div><div class='title6 ta_r'>" . number_format((int)$past_all_average2) . "</div></div>";
                                        // 全HTMLを合体（検索対象外は除く）
                                            $view2 = "";
                                            if($out1_a == "ON"){ $view2 .= $past_temp1_betty_manthly_html2;}
                                            if($out1_b == "ON"){ $view2 .= $past_temp1_jack_manthly_html2;}
                                            if($out1_c == "ON"){ $view2 .= $past_temp1_jewelry_manthly_html2;}
                                            $past_temp1_all_sorce2 = "<p class='title_a'>点数（過去）</p><div class='box1'>" . $past_temp1_title . $view2 . $past_all_sum_number . "</div>";

                  
                    
                    /************************************************************************************************************************************************************************************************************* */
                        // DB情報の受け取り（過去の期間）end
                    /************************************************************************************************************************************************************************************************************* */





                    /************************************************************************************************************************************************************************************************************* */
                        // DB情報の受け取り（検索期間）start
                    /************************************************************************************************************************************************************************************************************* */
                            $temp1_title2 = "";
                            $i = 0;
                            /************************************************************************************************************************************************************************************************************* */
                                // ジャック用
                            /************************************************************************************************************************************************************************************************************* */
                                    if($out1_a == "ON"){
                                            // DB検索（ジャック値）スタート
                                                $jack_buys = DB::table($table_name) 
                                                // 月毎にグループ化して値を分けるための処理
                                                    ->select([
                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jack_month'),
                                                        \DB::raw("SUM(zaikokingaku) AS jack_uriage"),
                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS jack_number"),
                                                    ])
                                                    ->groupBy('jack_month')
                                                // 条件（売上部門がジャック）
                                                    ->where('bumon','Jackroad')
                                                // 条件（期間の指定）
                                                    ->whereBetween($table_name . '.date', [$between_start, $between_end])
                                                // 条件（分類名）
                                                    ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
															// 条件（商品区分分類名が新品）
																if($out2_a == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%新品%");
																}
															// 条件（商品区分分類名が中古）
																if($out2_b == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%中古%");
																}
															// 条件（商品区分分類名がアンティーク）
																if($out2_c == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
																}
                                                    
                                                    })

                                                // 条件
                                                    ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                        // 条件（修理預かりか否か）
                                                            if($out3_a == "ON"){
                                                                $query->orwhere("souko_name","not like","%修理預%");
                                                            }
                                                        // 条件（ブランド名無しか否か）
                                                            if($out3_b == "ON"){
                                                                $query->orwhere("brand_name","<>","");
                                                            }
                                                        // 条件（商品ID無しか否か）
                                                            if($out3_c == "ON"){
                                                                $query->orwhere("tag","<>","");
                                                            }
                                                
                                                    })
                                                
                                                    
                                                // 条件（期間の指定）
                                                    ->whereBetween($table_name . '.date', [$between_start, $between_end])
                                                // ソート順指定
                                                    ->orderBy('date', 'asc')
                                                    ->get();

                                            // クエリビルダスタート
                                                $i = 0;
                                                // 変数リセット
                                                    $jack_sum_uriage = "";
                                                    $jack_sum_number = "";
                                                foreach ($jack_buys as $jack_buy) {
                                                    // 各月名
                                                        $jack_month[$i]= $jack_buy->jack_month;
                                                    // 各月ジャック売上
                                                        $jack_uriage[$i]= $jack_buy->jack_uriage;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($temp1_jack_manthly_data, $jack_month[$i] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $temp1_jack_manthly_data = str_replace($jack_month[$i], $jack_uriage[$i], $temp1_jack_manthly_data);
                                                                }
                                                    // 全期間ジャック売上合計
                                                        // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                            if($last_nodata_flag == "ON"){
                                                                $jack_sum_uriage_average = (int)$jack_sum_uriage;
                                                            } else {
                                                                $jack_sum_uriage_average = (int)$jack_sum_uriage + (int)$jack_uriage[$i];
                                                            }

                                                        $jack_sum_uriage = (int)$jack_sum_uriage + (int)$jack_uriage[$i];
                                                    // 各月ジャック点数
                                                        $jack_number[$i]= $jack_buy->jack_number;
                                                        // 全過去期間に現在の期間が含まれている場合
                                                            if(strpos($temp1_jack_manthly_data2, $jack_month[$i] ) !== false){
                                                                // 文字列の同期間名を現在月の売上に書き換え
                                                                    $temp1_jack_manthly_data2 = str_replace($jack_month[$i], $jack_number[$i], $temp1_jack_manthly_data2);
                                                            }

                                                    // 全期間ジャック点数合計
                                                        // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                            if($last_nodata_flag == "ON"){
                                                                $jack_sum_number_average = (int)$jack_sum_number;
                                                            } else {
                                                                $jack_sum_number_average = (int)$jack_sum_number + (int)$jack_number[$i];
                                                            }
                                                        $jack_sum_number = (int)$jack_sum_number + (int)$jack_number[$i];


                                                    $i++;
                                                }

                                                // 全期間ジャック売上合計とその平均値のHTML作成
                                                    $temp1_jack_sum = "";
                                                    if($jack_sum_uriage <> 0 && $jack_sum_uriage <> ""){
                                                        $jack_sum_uriage_c = number_format((int)$jack_sum_uriage);
                                                        // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象                                                        
                                                        if($last_nodata_flag == "ON"){
                                                            if($jack_sum_uriage_average <> "" && $jack_sum_uriage_average <> 0){$jack_sum_uriage_ave = number_format(floor((int)$jack_sum_uriage_average / ((int)$i -1)));} else {$jack_sum_uriage_ave = "---";}
                                                            if($jack_sum_uriage_average <> "" && $jack_sum_uriage_average <> 0){$jack_sum_uriage_ave2 = floor((int)$jack_sum_uriage_average / ((int)$i -1));} else {$jack_sum_uriage_ave2 = "---";}
                                                        } else {
                                                            $jack_sum_uriage_ave = number_format(floor((int)$jack_sum_uriage / $i));
                                                            $jack_sum_uriage_ave2 = floor((int)$jack_sum_uriage / $i);
                                                        }
                                                    } else {
                                                        $jack_sum_uriage_c = $jack_sum_uriage;
                                                        $jack_sum_uriage_ave = 0;
                                                        $jack_sum_uriage_ave2 = 0;
                                                    }
                                                    $temp1_jack_sum = "<div class='title4 ta_r'>" . $jack_sum_uriage_c . "</div><div class='title4 ta_r'>" . $jack_sum_uriage_ave . "</div></div>";
                                                // 全期間ジャック売上点数合計とその平均値のHTML作成
                                                    $temp1_jack_sum2 = "";
                                                    if($jack_sum_number <> 0 && $jack_sum_number <> ""){
                                                        $jack_sum_number_c = number_format((int)$jack_sum_number);
                                                        // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                        if($last_nodata_flag == "ON"){
                                                            if($jack_sum_number_average <> "" && $jack_sum_number_average <> 0){$jack_sum_number_ave = number_format(floor((int)$jack_sum_number_average / ((int)$i -1)));} else {$jack_sum_number_ave = "---";}
                                                            if($jack_sum_number_average <> "" && $jack_sum_number_average <> 0){$jack_sum_number_ave2 = floor((int)$jack_sum_number_average / ((int)$i -1));} else {$jack_sum_number_ave2 = "---";}
                                                        } else {
                                                            $jack_sum_number_ave = number_format(floor((int)$jack_sum_number / $i));
                                                            $jack_sum_number_ave2 = floor((int)$jack_sum_number / $i);
                                                        }
                                                    } else {
                                                        $jack_sum_number_c = $jack_sum_number;
                                                        $jack_sum_number_ave = 0;
                                                        $jack_sum_number_ave2 = 0;
                                                    }
                                                    $temp1_jack_sum2 = "<div class='title4 ta_r'>" . $jack_sum_number_c . "</div><div class='title4 ta_r'>" . $jack_sum_number_ave . "</div></div>";

                                        }



                            /************************************************************************************************************************************************************************************************************* */
                                // ベティー用
                            /************************************************************************************************************************************************************************************************************* */
                                    if($out1_b == "ON"){
                                            // DB検索（ベティー値）スタート
                                                $betty_buys = DB::table($table_name) 
                                                // 月毎にグループ化して値を分けるための処理
                                                    ->select([
                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS betty_month'),
                                                        \DB::raw("SUM(zaikokingaku) AS betty_uriage"),
                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS betty_number"),
                                                    ])
                                                    ->groupBy('betty_month')
                                                // 条件（売上部門がベティー）
                                                    ->where('bumon','Bettyroad')
                                                // 条件（期間の指定）
                                                    ->whereBetween($table_name . '.date', [$between_start, $between_end])
                                                // 条件（分類名）
                                                    ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
															// 条件（商品区分分類名が新品）
																if($out2_a == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%新品%");
																}
															// 条件（商品区分分類名が中古）
																if($out2_b == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%中古%");
																}
															// 条件（商品区分分類名がアンティーク）
																if($out2_c == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
																}
                                                    
                                                    })

                                                // 条件
                                                    ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                        // 条件（修理預かりか否か）
                                                            if($out3_a == "ON"){
                                                                $query->orwhere("souko_name","not like","%修理預%");
                                                            }
                                                        // 条件（ブランド名無しか否か）
                                                            if($out3_b == "ON"){
                                                                $query->orwhere("brand_name","<>","");
                                                            }
                                                        // 条件（商品ID無しか否か）
                                                            if($out3_c == "ON"){
                                                                $query->orwhere("tag","<>","");
                                                            }
                                                
                                                    })
                                                
                                                    
                                                // ソート順指定
                                                    ->orderBy('date', 'asc')
                                                    ->get();

                                            // クエリビルダスタート
                                                $i = 0;
                                                // 変数リセット
                                                    $betty_sum_uriage = "";
                                                    $betty_sum_number = "";
                                                    foreach ($betty_buys as $betty_buy) {
                                                        // 各月名
                                                            $betty_month[$i]= $betty_buy->betty_month;
                                                        // 各月ベティー売上
                                                            $betty_uriage[$i]= $betty_buy->betty_uriage;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                            if(strpos($temp1_betty_manthly_data, $betty_month[$i] ) !== false){
                                                                // 文字列の同期間名を現在月の売上に書き換え
                                                                    $temp1_betty_manthly_data = str_replace($betty_month[$i], $betty_uriage[$i], $temp1_betty_manthly_data);
                                                            }
                                                        // 全期間ベティー売上合計
                                                            // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                                if($last_nodata_flag == "ON"){
                                                                    $betty_sum_uriage_average = (int)$betty_sum_uriage;
                                                                } else {
                                                                    $betty_sum_uriage_average = (int)$betty_sum_uriage + (int)$betty_uriage[$i];
                                                                }
                                                            $betty_sum_uriage = (int)$betty_sum_uriage + (int)$betty_uriage[$i];
                                                        // 各月ベティー点数
                                                            $betty_number[$i]= $betty_buy->betty_number;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($temp1_betty_manthly_data2, $betty_month[$i] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $temp1_betty_manthly_data2 = str_replace($betty_month[$i], $betty_number[$i], $temp1_betty_manthly_data2);
                                                                }
                                                        // 全期間ベティー点数合計
                                                            // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                                if($last_nodata_flag == "ON"){
                                                                    $betty_sum_number_average = (int)$betty_sum_number;
                                                                } else {
                                                                    $betty_sum_number_average = (int)$betty_sum_number + (int)$betty_number[$i];
                                                                }
                                                            $betty_sum_number = (int)$betty_sum_number + (int)$betty_number[$i];
                                                            
                                                            
                                                        $i++;
                                                    }


                                                // 全期間ベティー売上合計とその平均値のHTML作成
                                                    $temp1_betty_sum = "";
                                                    if($betty_sum_uriage <> 0 && $betty_sum_uriage <> ""){
                                                        $betty_sum_uriage_c = number_format((int)$betty_sum_uriage);
                                                        // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                        if($last_nodata_flag == "ON"){
                                                            if($betty_sum_uriage_average <> "" && $betty_sum_uriage_average <> 0){$betty_sum_uriage_ave = number_format(floor((int)$betty_sum_uriage_average / ((int)$i -1)));} else {$betty_sum_uriage_ave = "---";}
                                                            if($betty_sum_uriage_average <> "" && $betty_sum_uriage_average <> 0){$betty_sum_uriage_ave2 = floor((int)$betty_sum_uriage_average / ((int)$i -1));} else {$betty_sum_uriage_ave2 = "---";}
                                                        } else {
                                                            $betty_sum_uriage_ave = number_format(floor((int)$betty_sum_uriage / $i));
                                                            $betty_sum_uriage_ave2 = floor((int)$betty_sum_uriage / $i);
                                                        }
                                                    } else {
                                                        $betty_sum_uriage_c = $betty_sum_uriage;
                                                        $betty_sum_uriage_ave = 0;
                                                        $betty_sum_uriage_ave2 = 0;
                                                    }
                                                    $temp1_betty_sum = "<div class='title4 ta_r'>" . $betty_sum_uriage_c . "</div><div class='title4 ta_r'>" . $betty_sum_uriage_ave . "</div></div>";
                                                // 全期間ベティー売上点数合計とその平均値のHTML作成
                                                    $temp1_betty_sum2 = "";
                                                    if($betty_sum_number <> 0 && $betty_sum_number <> ""){
                                                        $betty_sum_number_c = number_format((int)$betty_sum_number);
                                                        // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                        if($last_nodata_flag == "ON"){
                                                            if($betty_sum_number_average <> "" && $betty_sum_number_average <> 0){$betty_sum_number_ave = number_format(floor((int)$betty_sum_number_average / ((int)$i -1)));} else {$betty_sum_number_ave = "---";}
                                                            if($betty_sum_number_average <> "" && $betty_sum_number_average <> 0){$betty_sum_number_ave2 = floor((int)$betty_sum_number_average / ((int)$i -1));} else {$betty_sum_number_ave2 = "---";}
                                                        } else {
                                                            $betty_sum_number_ave = number_format(floor((int)$betty_sum_number / $i));
                                                            $betty_sum_number_ave2 = floor((int)$betty_sum_number / $i);
                                                        }
                                                    } else {
                                                        $betty_sum_number_c = $betty_sum_number;
                                                        $betty_sum_number_ave = 0;
                                                        $betty_sum_number_ave2 = 0;
                                                    }
                                                    $temp1_betty_sum2 = "<div class='title4 ta_r'>" . $betty_sum_number_c . "</div><div class='title4 ta_r'>" . $betty_sum_number_ave . "</div></div>";
                                    }
                            /************************************************************************************************************************************************************************************************************* */
                                // ジュエリー用
                            /************************************************************************************************************************************************************************************************************* */
                                    if($out1_c == "ON"){
                                            // DB検索（ジュエリー）スタート
                                                $jewelry_buys = DB::table($table_name) 
                                                // 月毎にグループ化して値を分けるための処理
                                                    ->select([
                                                        \DB::raw('DATE_FORMAT(date, "%Y-%m") AS jewelry_month'),
                                                        \DB::raw("SUM(zaikokingaku) AS jewelry_uriage"),
                                                        \DB::raw("SUM(tougetsumizaikosuuryou) AS jewelry_number"),
                                                    ])
                                                    ->groupBy('jewelry_month')
                                                // 条件（売上部門がジュエリー）
                                                    ->where('bumon','Jewelry')
                                                // 条件（期間の指定）
                                                    ->whereBetween($table_name . '.date', [$between_start, $between_end])
                                                // 条件（分類名）
                                                    ->where(function ($query) use ($out2_a,$out2_b,$out2_c) {
															// 条件（商品区分分類名が新品）
																if($out2_a == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%新品%");
																}
															// 条件（商品区分分類名が中古）
																if($out2_b == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%中古%");
																}
															// 条件（商品区分分類名がアンティーク）
																if($out2_c == "ON"){
																	$query->orwhere("shouhinkubunbunrui_name","like","%アンティーク%");
																}
                                                    })

                                                // 条件
                                                    ->where(function ($query) use ($out3_a,$out3_b,$out3_c) {
                                                        // 条件（修理預かりか否か）
                                                            if($out3_a == "ON"){
                                                                $query->orwhere("souko_name","not like","%修理預%");
                                                            }
                                                        // 条件（ブランド名無しか否か）
                                                            if($out3_b == "ON"){
                                                                $query->orwhere("brand_name","<>","");
                                                            }
                                                        // 条件（商品ID無しか否か）
                                                            if($out3_c == "ON"){
                                                                $query->orwhere("tag","<>","");
                                                            }
                                                
                                                    })
                                               
                                                    
                                                // ソート順指定
                                                    ->orderBy('date', 'asc')
                                                    ->get();

                                            // クエリビルダスタート
                                                // 以下の変数は月数フラグとして後のロジックで使用するが、フォームにて「免税のみ」を選択した場合「ジュエリー」は全月一つも無いので、上でロジックが止まってしまい月数カウントの変数も0のままとなる。「ジュエリー」のみ独立した変数名として、カウント用はベティー用で対応
                                                $i2 = 0;
                                                // 変数リセット
                                                    $jewelry_sum_uriage = "";
                                                    $jewelry_sum_number = "";
                                                    foreach ($jewelry_buys as $jewelry_buy) {
                                                        // 各月名
                                                            $jewelry_month[$i2]= $jewelry_buy->jewelry_month;
                                                        // 各月ジュエリー売上
                                                            $jewelry_uriage[$i2]= $jewelry_buy->jewelry_uriage;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($temp1_jewelry_manthly_data, $jewelry_month[$i2] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $temp1_jewelry_manthly_data = str_replace($jewelry_month[$i2], $jewelry_uriage[$i2], $temp1_jewelry_manthly_data);
                                                                }
                                                        // 全期間ジュエリー売上合計
                                                            // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                                if($last_nodata_flag == "ON"){
                                                                    $jewelry_sum_uriage_average = (int)$jewelry_sum_uriage;
                                                                } else {
                                                                    $jewelry_sum_uriage_average = (int)$jewelry_sum_uriage + (int)$jewelry_uriage[$i2];
                                                                }
                                                            $jewelry_sum_uriage = (int)$jewelry_sum_uriage + (int)$jewelry_uriage[$i2];
                                                        // 各月ジュエリー点数
                                                            $jewelry_number[$i2]= $jewelry_buy->jewelry_number;
                                                            // 全過去期間に現在の期間が含まれている場合
                                                                if(strpos($temp1_jewelry_manthly_data2, $jewelry_month[$i2] ) !== false){
                                                                    // 文字列の同期間名を現在月の売上に書き換え
                                                                        $temp1_jewelry_manthly_data2 = str_replace($jewelry_month[$i2], $jewelry_number[$i2], $temp1_jewelry_manthly_data2);
                                                                }
                                                        // 全期間ジュエリー点数合計
                                                            // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                                if($last_nodata_flag == "ON"){
                                                                    $jewelry_sum_number_average = (int)$jewelry_sum_number;
                                                                } else {
                                                                    $jewelry_sum_number_average = (int)$jewelry_sum_number + (int)$jewelry_number[$i2];
                                                                }
                                                            $jewelry_sum_number = (int)$jewelry_sum_number + (int)$jewelry_number[$i2];


                                                        $i2++;
                                                    }


                                                // 全期間ジュエリー売上合計とその平均値のHTML作成
                                                    $temp1_jewelry_sum = "";
                                                    if($jewelry_sum_uriage == 0 || $jewelry_sum_uriage == ""){
                                                        $temp1_jewelry_sum = "<div class='title4 ta_r'>0</div><div class='title4 ta_r'>0</div></div>";
                                                        $jewelry_sum_uriage_ave = 0;
                                                        $jewelry_sum_uriage_ave2 = 0;
                                                    } else {
                                                        // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                        if($last_nodata_flag == "ON"){
                                                            if($jewelry_sum_uriage_average <> "" && $jewelry_sum_uriage_average <> 0){$jewelry_sum_uriage_ave = number_format(floor((int)$jewelry_sum_uriage_average / ((int)$i -1)));} else {$jewelry_sum_uriage_ave = "---";}
                                                            if($jewelry_sum_uriage_average <> "" && $jewelry_sum_uriage_average <> 0){$jewelry_sum_uriage_ave2 = floor((int)$jewelry_sum_uriage_average / ((int)$i -1));} else {$jewelry_sum_uriage_ave2 = "---";}
                                                        } else {
                                                            $jewelry_sum_uriage_ave = number_format(floor((int)$jewelry_sum_uriage / $i));
                                                            $jewelry_sum_uriage_ave2 = floor((int)$jewelry_sum_uriage / $i);
                                                        }
                                                        $temp1_jewelry_sum = "<div class='title4 ta_r'>" . number_format((int)$jewelry_sum_uriage) . "</div><div class='title4 ta_r'>" . $jewelry_sum_uriage_ave . "</div></div>";
                                                    }
                                                // 全期間ジュエリー売上点数合計とその平均値のHTML作成
                                                    $temp1_jewelry_sum2 = "";
                                                    //$temp1_jewelry_sum2 = "<div class='title4 ta_r'>" . number_format((int)$jewelry_sum_number) . "</div><div class='title4 ta_c'>" . $yoy_number3 . "</div><div class='title4 ta_r'>" . number_format(floor((int)$jewelry_sum_number / $i)) . "</div></div>";
                                                    if($jewelry_sum_number == 0 || $jewelry_sum_number == ""){
                                                        $temp1_jewelry_sum2 = "<div class='title4 ta_r'>0</div><div class='title4 ta_r'>0</div></div>";
                                                        $jewelry_sum_number_ave = 0;
                                                        $jewelry_sum_number_ave2 = 0;
                                                    } else {
                                                        // 【データ格納最終日がその月の最終日でなければ平均計算に含めない】現在の「金額」「点数」のみが対象
                                                        if($last_nodata_flag == "ON"){
                                                            if($jewelry_sum_number_average <> "" && $jewelry_sum_number_average <> 0){$jewelry_sum_number_ave = number_format(floor((int)$jewelry_sum_number_average / ((int)$i -1)));} else {$jewelry_sum_number_ave = "---";}
                                                            if($jewelry_sum_number_average <> "" && $jewelry_sum_number_average <> 0){$jewelry_sum_number_ave2 = floor((int)$jewelry_sum_number_average / ((int)$i -1));} else {$jewelry_sum_number_ave2 = "---";}
                                                        } else {
                                                            $jewelry_sum_number_ave = number_format(floor((int)$jewelry_sum_number / $i));
                                                            $jewelry_sum_number_ave2 = floor((int)$jewelry_sum_number / $i);
                                                        }
                                                        $temp1_jewelry_sum2 = "<div class='title4 ta_r'>" . number_format((int)$jewelry_sum_number) . "</div><div class='title4 ta_r'>" . $jewelry_sum_number_ave . "</div></div>";
                                                    }

                                                    
                                    }
                            /************************************************************************************************************************************************************************************************************* */
                                // 全件用
                            /************************************************************************************************************************************************************************************************************* */


                                    // 各月のタイトル表示用HTMLを作成
                                        $temp1_title2 = "";
                                        $temp1_title3 = "";
                                        $temp1_title4 = "";
                                        $temp1_title5 = "";
                                        foreach($manth_now_array as $val){
                                                // 表示用
                                                $temp1_title2 .= "<div class='title2 ta_c'>" . $val . "</div>";
                                                // 20230803
                                                $temp1_title3 .= "<div class='title7 ta_c'>" . $val . "</div>";
                                                $temp1_title4 .= "<div class='title7 ta_c'>" . $val . "</div>";
                                                $temp1_title5 .= "<div class='title7 ta_c'>" . $val . "</div>";
                                            }
                                
                                            $temp1_title = "<div class='wid100 ul2'><div class='title5 ta_c'>" . $between_start_view. "～<br>" .$between_end_view . "</div>" .$temp1_title2 ."<div class='title6 ta_c'>累計</div><!--<div class='title6 ta_c'>過去比</div>--><div class='title6 ta_c'>平均</div></div>";
                                            $temp1_title3 = "<div class='wid100 ul2'><div class='title7 ta_c'>" . $between_start_view. "～<br>" .$between_end_view . "</div>" .$temp1_title3 ."<div class='title7 ta_c'>平均</div></div>";
                                            $temp1_title4 = "<div class='wid100 ul2 bg_green'><div class='title7 ta_c'>" . $between_start_view. "～<br>" .$between_end_view . "</div>" .$temp1_title4 ."<div class='title7 ta_c'>平均</div></div>";
                                            $temp1_title5 = "<div class='wid100 ul2 bg_yellow'><div class='title7 ta_c'>" . $between_start_view. "～<br>" .$between_end_view . "</div>" .$temp1_title5 ."<div class='title7 ta_c'>平均</div></div>";
                                        
                                        
                                        // 全期間の全部門売上合計用変数リセット
                                            $all_sum_uriage_all = 0;
                                            $all_sum_number_all = 0;
                                            for($all_i = 0; $all_i < $i; $all_i++){
                                                // 各月の全部門売上合計用変数リセット
                                                    $all_month_uriage = 0;
                                                    $all_month_number= 0;
                                                // 各月の全部門売上合計をHTMLへ
                                                    if($out1_b == "ON"){ 
                                                        if(isset($jack_uriage[$all_i])){$all_month_uriage = $all_month_uriage + (int)$jack_uriage[$all_i]; }
                                                        if(isset($jack_number[$all_i])){$all_month_number = $all_month_number + (int)$jack_number[$all_i]; }
                                                    }
                                                    if($out1_a == "ON"){ 
                                                        if(isset($betty_uriage[$all_i])){$all_month_uriage = $all_month_uriage + (int)$betty_uriage[$all_i]; }
                                                        if(isset($betty_number[$all_i])){$all_month_number = $all_month_number + (int)$betty_number[$all_i]; }
                                                    }

                                                // 全期間の全部門売上合計
                                                    $all_sum_uriage_all = (int)$all_sum_uriage_all + (int)$all_month_uriage;
                                                    $all_sum_number_all = (int)$all_sum_number_all + (int)$all_month_number;
                                                
                                            }







// 【進捗率の取得】
                                        

// 検索スタート日からデータが格納されている最終日までの日数
    $search_start = strtotime($start_now);
    $data_end = strtotime($last_day);
    $data_in_days = ($data_end - $search_start) / (60 * 60 * 24);

// 検索期間
    $search_start = strtotime($start_now);
    $search_end = strtotime($end_now);
    $search_days = ($search_end - $search_start) / (60 * 60 * 24);

// 検索期間・着地予測（期間合計 / データ格納期間 * 検索期間）
    ($betty_sum_uriage <> 0 && $betty_sum_uriage <> "") ? $betty_term_progress = $betty_sum_uriage / $data_in_days * $search_days : $betty_term_progress = "---";
    ($jack_sum_uriage <> 0 && $jack_sum_uriage <> "") ? $jack_term_progress = $jack_sum_uriage / $data_in_days * $search_days : $jack_term_progress = "---";
    ($betty_sum_number <> 0 && $betty_sum_number <> "") ? $betty_term_progress_n = $betty_sum_number / $data_in_days * $search_days : $betty_term_progress_n = "---";
    ($jack_sum_number <> 0 && $jack_sum_number <> "") ? $jack_term_progress_n = $jack_sum_number / $data_in_days * $search_days : $jack_term_progress_n = "---";
    
    $jewelry_term_progress = 0;
    $jewelry_term_progress_n = 0;
    if($out1_c == "ON"){($jewelry_sum_uriage <> 0 && $jewelry_sum_uriage <> "") ? $jewelry_term_progress = $jewelry_sum_uriage / $data_in_days * $search_days : $jewelry_term_progress = "---";}
    if($out1_c == "ON"){($jewelry_sum_number <> 0 && $jewelry_sum_number <> "") ? $jewelry_term_progress_n = $jewelry_sum_number / $data_in_days * $search_days : $jewelry_term_progress_n = "---";}
    
    // 合計
        $all_term_progress = (int)$betty_term_progress + (int)$jack_term_progress + (int)$jewelry_term_progress;
        $all_term_progress_n = (int)$betty_term_progress_n + (int)$jack_term_progress_n + (int)$jewelry_term_progress_n;
// 検索期間・過去との着地予測比（検索期間・着地予測 / 過去合計）
    ($betty_term_progress <> 0 && $betty_term_progress <> "" && $past_betty_sum_uriage <> 0 && $past_betty_sum_uriage <> "") ? $betty_term_progress2 = number_format((floor(((int)$betty_term_progress / (int)$past_betty_sum_uriage) * 100 * 10)) / 10,1) : $betty_term_progress2 = 0;
    ($jack_term_progress <> 0 && $jack_term_progress <> "" && $past_jack_sum_uriage <> 0 && $past_jack_sum_uriage <> "") ? $jack_term_progress2 = number_format((floor(((int)$jack_term_progress / (int)$past_jack_sum_uriage) * 100 * 10)) / 10,1) : $jack_term_progress2 = 0;
    ($betty_term_progress_n <> 0 && $betty_term_progress_n <> "" && $past_betty_sum_number <> 0 && $past_betty_sum_number <> "") ? $betty_term_progress2_n = number_format((floor(((int)$betty_term_progress_n / (int)$past_betty_sum_number) * 100 * 10)) / 10,1) : $betty_term_progress2_n = 0;
    ($jack_term_progress_n <> 0 && $jack_term_progress_n <> "" && $past_jack_sum_number <> 0 && $past_jack_sum_number <> "") ? $jack_term_progress2_n = number_format((floor(((int)$jack_term_progress_n / (int)$past_jack_sum_number) * 100 * 10)) / 10,1) : $jack_term_progress2_n = 0;
    
    if($out1_c == "ON"){
        if($jewelry_term_progress <> "" && $jewelry_term_progress <> 0 && $past_jewelry_sum_uriage <> "" && $past_jewelry_sum_uriage <> 0){
            $jewelry_term_progress2 = number_format((floor(((int)$jewelry_term_progress / (int)$past_jewelry_sum_uriage) * 100 * 10)) / 10,1);
        } else {
            $jewelry_term_progress2 = "---";
        }
        if($jewelry_term_progress_n <> "" && $jewelry_term_progress_n <> 0 && $past_jewelry_sum_number <> "" && $past_jewelry_sum_number <> 0){
            $jewelry_term_progress2_n = number_format((floor(((int)$jewelry_term_progress_n / (int)$past_jewelry_sum_number) * 100 * 10)) / 10,1);
        } else {
            $jewelry_term_progress2_n = "---"; 
        }
    }
    
    // 合計
    ($all_term_progress <> 0 && $all_term_progress <> "" && $past_all_sum_uriage_all <> 0 && $past_all_sum_uriage_all <> "") ? $all_term_progress2 = number_format((floor(((int)$all_term_progress / (int)$past_all_sum_uriage_all) * 100 * 10)) / 10,1) : $all_term_progress2 = "---";
    ($all_term_progress_n <> 0 && $all_term_progress_n <> "" && $past_all_sum_number_all <> 0 && $past_all_sum_number_all <> "") ? $all_term_progress2_n = number_format((floor(((int)$all_term_progress_n / (int)$past_all_sum_number_all) * 100 * 10)) / 10,1) : $all_term_progress2_n = "---";

// HTML追記
    ($betty_term_progress <> 0 && $betty_term_progress <> "") ? $betty_term_progress_view = "<div class='sinchoku'>" . number_format((int)$betty_term_progress) . "</div>" : $betty_term_progress_view = "<div class='sinchoku'>---</div>";
    ($betty_sum_uriage <> 0 && $betty_sum_uriage <> "") ? $betty_sum_uriage_view = "<div class='sinchoku'>" . number_format($betty_sum_uriage) . "</div>" : $betty_sum_uriage_view = "<div class='sinchoku'>---</div>";
    ($betty_term_progress2 < 100) ? $betty_term_progress2_view = "<div class='sinchoku fc_blue'>" . $betty_term_progress2 . "%</div>" : $betty_term_progress2_view = "<div class='sinchoku fc_red'>" . $betty_term_progress2 . "%</div>";
    ($jack_term_progress <> 0 && $jack_term_progress <> "") ? $jack_term_progress_view = "<div class='sinchoku'>" . number_format((int)$jack_term_progress) . "</div>" : $jack_term_progress_view = "<div class='sinchoku'>---</div>";
    ($jack_sum_uriage <> 0 && $jack_sum_uriage <> "") ? $jack_sum_uriage_view = "<div class='sinchoku'>" . number_format((int)$jack_sum_uriage) . "</div>" : $jack_sum_uriage_view = "<div class='sinchoku'>---</div>";
    ($jack_term_progress2 < 100) ? $jack_term_progress2_view = "<div class='sinchoku fc_blue'>" . $jack_term_progress2 . "%</div>" : $jack_term_progress2_view = "<div class='sinchoku fc_red'>" . $jack_term_progress2 . "%</div>";
    
    ($betty_term_progress_n <> 0 && $betty_term_progress_n <> "") ? $betty_term_progress_n_view = "<div class='sinchoku'>" . number_format((int)$betty_term_progress_n) . "</div>" : $betty_term_progress_n_view = "<div class='sinchoku'>---</div>";
    ($betty_sum_number <> 0 && $betty_sum_number <> "") ? $betty_sum_number_view = "<div class='sinchoku'>" . number_format($betty_sum_number) . "</div>" : $betty_sum_number_view = "<div class='sinchoku'>---</div>";
    ($betty_term_progress2_n < 100) ? $betty_term_progress2_n_view = "<div class='sinchoku fc_blue'>" . $betty_term_progress2_n . "%</div>" : $betty_term_progress2_n_view = "<div class='sinchoku fc_red'>" . $betty_term_progress2_n . "%</div>";
    ($jack_term_progress_n <> 0 && $jack_term_progress_n <> "") ? $jack_term_progress_n_view = "<div class='sinchoku'>" . number_format((int)$jack_term_progress_n) . "</div>" : $jack_term_progress_n_view = "<div class='sinchoku'>---</div>";
    ($jack_sum_number <> 0 && $jack_sum_number <> "") ? $jack_sum_number_view = "<div class='sinchoku'>" . number_format((int)$jack_sum_number) . "</div>" : $jack_sum_number_view = "<div class='sinchoku'>---</div>";
    ($jack_term_progress2_n < 100) ? $jack_term_progress2_n_view = "<div class='sinchoku fc_blue'>" . $jack_term_progress2_n . "%</div>" : $jack_term_progress2_n_view = "<div class='sinchoku fc_red'>" . $jack_term_progress2_n . "%</div>";
  
   
    if($out1_c == "ON"){ 
        ($jewelry_term_progress <> 0 && $jewelry_term_progress <> "") ? $jewelry_term_progress_view = "<div class='sinchoku'>" . number_format((int)$jewelry_term_progress) . "</div>" : $jewelry_term_progress_view = "<div class='sinchoku'>---</div>";
        ($jewelry_sum_uriage <> 0 && $jewelry_sum_uriage <> "") ? $jewelry_sum_uriage_view = "<div class='sinchoku'>" . number_format((int)$jewelry_sum_uriage) . "</div>" : $jewelry_sum_uriage_view = "<div class='sinchoku'>---</div>";
        ($jewelry_term_progress2 < 100) ? $jewelry_term_progress2_view = "<div class='sinchoku fc_blue'>" . $jewelry_term_progress2 . "%</div>" : $jewelry_term_progress2_view = "<div class='sinchoku fc_red'>" . $jewelry_term_progress2 . "%</div>";
        ($jewelry_term_progress_n <> 0 && $jewelry_term_progress_n <> "") ? $jewelry_term_progress_n_view = "<div class='sinchoku'>" . number_format((int)$jewelry_term_progress_n) . "</div>" : $jewelry_term_progress_n_view = "<div class='sinchoku'>---</div>";
        ($jewelry_sum_number <> 0 && $jewelry_sum_number <> "") ? $jewelry_sum_number_view = "<div class='sinchoku'>" . number_format((int)$jewelry_sum_number) . "</div>" : $jewelry_sum_number_view = "<div class='sinchoku'>---</div>";
        ($jewelry_term_progress2_n < 100) ? $jewelry_term_progress2_n_view = "<div class='sinchoku fc_blue'>" . $jewelry_term_progress2_n . "%</div>" : $jewelry_term_progress2_n_view = "<div class='sinchoku fc_red'>" . $jewelry_term_progress2_n . "%</div>";
    }
    ($all_term_progress <> 0 && $all_term_progress <> "") ? $all_term_progress_view = "<div class='sinchoku bg_grey'>" . number_format((int)$all_term_progress) . "</div>" : $all_term_progress_view = "<div class='sinchoku bg_grey'>---</div>";
    ($all_sum_uriage_all <> 0 && $all_sum_uriage_all <> "") ? $all_sum_uriage_all_view = "<div class='sinchoku bg_grey'>" . number_format((int)$all_sum_uriage_all) . "</div>" : $all_sum_uriage_all_view = "<div class='sinchoku bg_grey'>---</div>";
    ($all_term_progress2 < 100) ? $all_term_progress2_view = "<div class='sinchoku fc_blue bg_grey'>" . $all_term_progress2 . "%</div>" : $all_term_progress2_view = "<div class='sinchoku fc_red bg_grey'>" . $all_term_progress2 . "%</div>";
    ($all_term_progress_n <> 0 && $all_term_progress_n <> "") ? $all_term_progress_n_view = "<div class='sinchoku bg_grey'>" . number_format((int)$all_term_progress_n) . "</div>" : $all_term_progress_n_view = "<div class='sinchoku bg_grey'>---</div>";
    ($all_sum_number_all <> 0 && $all_sum_number_all <> "") ? $all_sum_number_all_view = "<div class='sinchoku bg_grey'>" . number_format((int)$all_sum_number_all) . "</div>" : $all_sum_number_all_view = "<div class='sinchoku bg_grey'>---</div>";
    ($all_term_progress2_n < 100) ? $all_term_progress2_n_view = "<div class='sinchoku fc_blue bg_grey'>" . $all_term_progress2_n . "%</div>" : $all_term_progress2_n_view = "<div class='sinchoku fc_red bg_grey'>" . $all_term_progress2_n . "%</div>";
    
    
    // 売上額進捗
                                                                    $uriage_progress_html = 
                                                                    "<div class='btn_bulldown_  pt2'><span class='view'>＋</span> 予測数値について</div>
                                                                    <div class='down'>
                                                                        <p class='text'>▼月間着地予測：データを有する最終月の数値 / 月初からデータを有する最終日までの日数 x 該当月の最終日の数字</p>
                                                                        <p class='text'>▼月間着地予測比（対過去・同月）：データを有する最終月を検索期間遡った過去月との対比（1～12月までの検索で、8月までのデータが存在するのなら、昨年の8月との対比）</p>
                                                                        <p class='text'>▼全期間着地予測：検索期間の累計 / 検索スタート日からデータを有する最終日までの日数 x 検索期間の総日数</p>
                                                                    </div>
                                                                    <div class='ul_p mt1'>
                                                                        <div class='sinchoku_t'>" . $last_year_last . "年" . $last_month_last. "月</div>
                                                                        <div class='sinchoku_t'>月間売上進捗</div>
                                                                        <div class='sinchoku_t'>月間着地予測</div>
                                                                        <div class='sinchoku_t'>月間着地予測比（対前月）</div>
                                                                        <div class='sinchoku_t'>月間着地予測比（対過去・同月）</div>
                                                                        <div class='sinchoku_t'>全期間売上進捗</div>
                                                                        <div class='sinchoku_t'>全期間着地予測</div>
                                                                        <div class='sinchoku_t'>全期間着地予測比（対過去・全期間）</div>
                                                                    </div>
                                                                    <div class='ul_p'>
                                                                        <div class='sinchoku ta_c'>ベティー</div>
                                                                        <div class='sinchoku'>" . $betty_uriage_view1. "</div>
                                                                        <div class='sinchoku'>" . $betty_uriage_view2. "</div>
                                                                        " . $betty_uriage_view3 . "
                                                                        " . $betty_uriage_view4 . "
                                                                        " . $betty_sum_uriage_view . "
                                                                        " . $betty_term_progress_view. "
                                                                        " . $betty_term_progress2_view. "
                                                                    </div>
                                                                    <div class='ul_p'>
                                                                        <div class='sinchoku ta_c'>ジャック</div>
                                                                        <div class='sinchoku'>" . $jack_uriage_view1 . "</div>
                                                                        <div class='sinchoku'>" . $jack_uriage_view2. "</div>
                                                                        " . $jack_uriage_view3 . "
                                                                        " . $jack_uriage_view4 . "
                                                                        " . $jack_sum_uriage_view . "
                                                                        " . $jack_term_progress_view. "
                                                                        " . $jack_term_progress2_view. "
                                                                    </div>";
                                                                    if($out1_c == "ON"){ 
                                                                    $uriage_progress_html .= 
                                                                    "<div class='ul_p'>
                                                                        <div class='sinchoku ta_c'>ジュエリー</div>
                                                                        <div class='sinchoku'>" . $jewelry_uriage_view1 . "</div>
                                                                        <div class='sinchoku'>" . $jewelry_uriage_view2. "</div>
                                                                        " . $jewelry_uriage_view3 . "
                                                                        " . $jewelry_uriage_view4 . "
                                                                        " . $jewelry_sum_uriage_view . "
                                                                        " . $jewelry_term_progress_view. "
                                                                        " . $jewelry_term_progress2_view. "
                                                                    </div>";
                                                                    }
                                                                    $uriage_progress_html .= 
                                                                    "<div class='ul_p'>
                                                                        <div class='sinchoku bg_grey ta_c'>合計</div>
                                                                        <div class='sinchoku bg_grey'>" . $all_uriage_view1 . "</div>
                                                                        <div class='sinchoku bg_grey'>" . $all_uriage_view2 . "</div>
                                                                        " . $all_uriage_view3 . "
                                                                        " . $all_uriage_view4 . "
                                                                        " . $all_sum_uriage_all_view . "
                                                                        " . $all_term_progress_view. "
                                                                        " . $all_term_progress2_view. "
                                                                    </div>";
                                                            // 売上点数進捗
                                                                    $number_progress_html = 
                                                                    "<div class='btn_bulldown_  pt2'><span class='view2'>＋</span> 予測数値について</div>
                                                                    <div class='down'>
                                                                    <p class='text'>▼月間着地予測：データを有する最終月の数値 / 月初からデータを有する最終日までの日数 x 該当月の最終日の数字</p>
                                                                    <p class='text'>▼月間着地予測比（対過去・同月）：データを有する最終月を検索期間遡った過去月との対比（1～12月までの検索で、8月までのデータが存在するのなら、昨年の8月との対比）</p>
                                                                    <p class='text'>▼全期間着地予測：検索期間の累計 / 検索スタート日からデータを有する最終日までの日数 x 検索期間の総日数</p>
                                                                    </div>
                                                                    <div class='ul_p mt1'>
                                                                        <div class='sinchoku_t'>" . $last_year_last . "年" . $last_month_last. "月</div>
                                                                        <div class='sinchoku_t'>月間売上進捗</div>
                                                                        <div class='sinchoku_t'>月間着地予測</div>
                                                                        <div class='sinchoku_t'>月間着地予測比（対前月）</div>
                                                                        <div class='sinchoku_t'>月間着地予測比（対過去・同月）</div>
                                                                        <div class='sinchoku_t'>全期間売上進捗</div>
                                                                        <div class='sinchoku_t'>全期間着地予測</div>
                                                                        <div class='sinchoku_t'>全期間着地予測比（対過去・全期間）</div>
                                                                    </div>
                                                                    <div class='ul_p'>
                                                                        <div class='sinchoku ta_c'>ベティー</div>
                                                                        <div class='sinchoku'>" . $betty_number_view1. "</div>
                                                                        <div class='sinchoku'>" . $betty_number_view2. "</div>
                                                                        " . $betty_number_view3 . "
                                                                        " . $betty_number_view4 . "
                                                                        " . $betty_sum_number_view . "
                                                                        " . $betty_term_progress_n_view. "
                                                                        " . $betty_term_progress2_n_view. "
                                                                    </div>
                                                                    <div class='ul_p'>
                                                                        <div class='sinchoku ta_c'>ジャック</div>
                                                                        <div class='sinchoku'>" . $jack_number_view1 . "</div>
                                                                        <div class='sinchoku'>" . $jack_number_view2. "</div>
                                                                        " . $jack_number_view3 . "
                                                                        " . $jack_number_view4 . "
                                                                        " . $jack_sum_number_view . "
                                                                        " . $jack_term_progress_n_view. "
                                                                        " . $jack_term_progress2_n_view. "
                                                                    </div>";
                                                                    if($out1_c == "ON"){ 
                                                                    $number_progress_html .= 
                                                                    "<div class='ul_p'>
                                                                        <div class='sinchoku ta_c'>ジュエリー</div>
                                                                        <div class='sinchoku'>" . $jewelry_number_view1 . "</div>
                                                                        <div class='sinchoku'>" . $jewelry_number_view2. "</div>
                                                                        " . $jewelry_number_view3 . "
                                                                        " . $jewelry_number_view4 . "
                                                                        " . $jewelry_sum_number_view . "
                                                                        " . $jewelry_term_progress_n_view. "
                                                                        " . $jewelry_term_progress2_n_view. "
                                                                    </div>";
                                                                    }
                                                                    $number_progress_html .= 
                                                                    "<div class='ul_p'>
                                                                        <div class='sinchoku bg_grey ta_c'>合計</div>
                                                                        <div class='sinchoku bg_grey'>" . $all_number_view1 . "</div>
                                                                        <div class='sinchoku bg_grey'>" . $all_number_view2 . "</div>
                                                                        " . $all_number_view3 . "
                                                                        " . $all_number_view4 . "
                                                                        " . $all_sum_number_all_view . "
                                                                        " . $all_term_progress_n_view. "
                                                                        " . $all_term_progress2_n_view. "
                                                                    </div>";


                            /************************************************************************************************************************************************************************************************************* */
                                // 最終ソース出力
                            /************************************************************************************************************************************************************************************************************* */
                                        
                                            // 【進捗率の取得】検索最終月の日数を取得
                                                //$get_days = $end_year . "-" . $end_month;
                                                //$get_days2 = date('t', strtotime($get_days));
                            
                            
                                        // ベティー用HTMLの作成
                                                $js_betty_uriage  = "";
                                                $js_betty_number  = "";
                                                $temp1_betty_manthly_html = "";
                                                $temp1_betty_manthly_html2 = "";
                                                $temp1_betty_manthly_html3 = "";
                                                $progress_uriage_html = "";
                                                $progress_number_html = "";
                                                if($out1_a == "ON"){     
                                                    // 過去全期間名の文字列で、年月名がそのまま記載されているものは「0」に変換（売上データが存在するは年月名を売上の数字に置き換え済なので、年月名がそのまま残っているものはデータ無なので）
                                                        foreach($manth_now_array as $val){
                                                                //$val = mb_substr($val,0,-3);
                                                                if(strpos($temp1_betty_manthly_data, $val ) !== false){
                                                                    $temp1_betty_manthly_data = str_replace($val, 0, $temp1_betty_manthly_data);
                                                                }
                                                                if(strpos($temp1_betty_manthly_data2, $val ) !== false){
                                                                    $temp1_betty_manthly_data2 = str_replace($val, 0, $temp1_betty_manthly_data2);
                                                                }
                                                        }
                                                    // 各月売上が記載された文字列を配列へ変換
                                                        $temp1_betty_manthly_array = explode(',',$temp1_betty_manthly_data);
                                                        $temp1_betty_manthly_array2 = explode(',',$temp1_betty_manthly_data2);
                                                    // 各月のHTMLを作成
                                                        $betty_last_uriage = "";
                                                        $i = 0;
                                                        foreach($temp1_betty_manthly_array as $val){
                                                            // 【進捗率の取得】最終月の「現在・ベティー・売上」を取得
                                                                //$betty_last_uriage = $val;

                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $js_betty_uriage  .= "0, ";
                                                                // 表示用
                                                                    $temp1_betty_manthly_html .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $js_betty_uriage  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $temp1_betty_manthly_html .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }
                                                            $i++;
                                                        }

                                                        $i = 0;
                                                        foreach($temp1_betty_manthly_array2 as $val){
                                                            // 【進捗率の取得】最終月の「現在・ベティー・点数」を取得
                                                                //$betty_last_number = $val;
                                                            
                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $js_betty_number  .= "0, ";
                                                                // 表示用
                                                                    $temp1_betty_manthly_html2 .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $js_betty_number  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $temp1_betty_manthly_html2 .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }
                                                            $i++;
                                                        }
                                                            
                                                        // 全体HTMLの作成
                                                            if(isset($temp1_betty_manthly_html) && isset($temp1_betty_sum)){
                                                                $temp1_betty_manthly_html = "<div class='wid100 ul1'><div class='title1 ta_c'>ベティー</div>" . $temp1_betty_manthly_html . $temp1_betty_sum;
                                                            }
                                                            if(isset($temp1_betty_manthly_html2) && isset($temp1_betty_sum2)){
                                                                $temp1_betty_manthly_html2 = "<div class='wid100 ul1'><div class='title1 ta_c'>ベティー</div>" . $temp1_betty_manthly_html2 . $temp1_betty_sum2;
                                                            }
                                                            if(isset($temp1_betty_manthly_html3) && isset($temp1_betty_sum3)){
                                                                $temp1_betty_manthly_html3 = "<div class='wid100 ul1'><div class='title1 ta_c'>ベティー</div>" . $temp1_betty_manthly_html3 . $temp1_betty_sum3;
                                                            }
                                                    }

                                            // ジャック用HTMLの作成
                                                $js_jack_uriage  = "";
                                                $js_jack_number  = "";
                                                $temp1_jack_manthly_html = "";
                                                $temp1_jack_manthly_html2 = "";
                                                $temp1_jack_manthly_html3 = "";
                                                if($out1_b == "ON"){     
                                                    // 過去全期間名の文字列で、年月名がそのまま記載されているものは「0」に変換（売上データが存在するは年月名を売上の数字に置き換え済なので、年月名がそのまま残っているものはデータ無なので）
                                                        foreach($manth_now_array as $val){
                                                                //$val = mb_substr($val,0,-3);
                                                                if(strpos($temp1_jack_manthly_data, $val ) !== false){
                                                                    $temp1_jack_manthly_data = str_replace($val, 0, $temp1_jack_manthly_data);
                                                                }
                                                                if(strpos($temp1_jack_manthly_data2, $val ) !== false){
                                                                    $temp1_jack_manthly_data2 = str_replace($val, 0, $temp1_jack_manthly_data2);
                                                                }
                                                        }
                                                    // 各月売上が記載された文字列を配列へ変換
                                                        $temp1_jack_manthly_array = explode(',',$temp1_jack_manthly_data);
                                                        $temp1_jack_manthly_array2 = explode(',',$temp1_jack_manthly_data2);
                                                    // 各月のHTMLを作成
                                                        //$jack_last_uriage = "";

                                                        $i = 0;
                                                        foreach($temp1_jack_manthly_array as $val){
                                                            // 【進捗率の取得】最終月の「現在・ジャック・売上」を取得
                                                                //$jack_last_uriage = $val;

                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $js_jack_uriage  .= "0, ";
                                                                // 表示用
                                                                    $temp1_jack_manthly_html .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $js_jack_uriage  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $temp1_jack_manthly_html .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }
                                                            $i++;
                                                        }
                                                        $i = 0;
                                                        foreach($temp1_jack_manthly_array2 as $val){
                                                            // 【進捗率の取得】最終月の「現在・ジャック・点数」を取得
                                                                //$jack_last_number = $val;

                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $js_jack_number  .= "0, ";
                                                                // 表示用
                                                                    $temp1_jack_manthly_html2 .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $js_jack_number  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $temp1_jack_manthly_html2 .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }
                                                            $i++;
                                                        }

                                                    // 全体HTMLの作成
                                                            if(isset($temp1_jack_manthly_html) && isset($temp1_jack_sum)){
                                                                $temp1_jack_manthly_html = "<div class='wid100 ul1'><div class='title1 ta_c'>ジャック</div>" . $temp1_jack_manthly_html . $temp1_jack_sum;
                                                            }
                                                            if(isset($temp1_jack_manthly_html2) && isset($temp1_jack_sum2)){
                                                                $temp1_jack_manthly_html2 = "<div class='wid100 ul1'><div class='title1 ta_c'>ジャック</div>" . $temp1_jack_manthly_html2 . $temp1_jack_sum2;
                                                            }
                                                            if(isset($temp1_jack_manthly_html3) && isset($temp1_jack_sum3)){
                                                                $temp1_jack_manthly_html3 = "<div class='wid100 ul1'><div class='title1 ta_c'>ジャック</div>" . $temp1_jack_manthly_html3 . $temp1_jack_sum3;
                                                            }
                                                }



                                        // ジュエリー用HTMLの作成
                                                $js_jewelry_uriage  = "";
                                                $js_jewelry_number  = "";
                                                $temp1_jewelry_manthly_html = "";
                                                $temp1_jewelry_manthly_html2 = "";
                                                $temp1_jewelry_manthly_html3 = "";
                                                if($out1_c == "ON"){     
                                                    // 過去全期間名の文字列で、年月名がそのまま記載されているものは「0」に変換（売上データが存在するは年月名を売上の数字に置き換え済なので、年月名がそのまま残っているものはデータ無なので）
                                                        foreach($manth_now_array as $val){
                                                                //$val = mb_substr($val,0,-3);
                                                                if(strpos($temp1_jewelry_manthly_data, $val ) !== false){
                                                                    $temp1_jewelry_manthly_data = str_replace($val, 0, $temp1_jewelry_manthly_data);
                                                                }
                                                                if(strpos($temp1_jewelry_manthly_data2, $val ) !== false){
                                                                    $temp1_jewelry_manthly_data2 = str_replace($val, 0, $temp1_jewelry_manthly_data2);
                                                                }
                                                        }
                                                    // 各月売上が記載された文字列を配列へ変換
                                                        $temp1_jewelry_manthly_array = explode(',',$temp1_jewelry_manthly_data);
                                                        $temp1_jewelry_manthly_array2 = explode(',',$temp1_jewelry_manthly_data2);
                                                    // 各月のHTMLを作成
                                                        //$jewelry_last_uriage = "";
                                                        $i = 0;
                                                        foreach($temp1_jewelry_manthly_array as $val){
                                                            // 【進捗率の取得】最終月の「現在・ジュエリー・売上」を取得
                                                                //$jewelry_last_uriage = $val;

                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $js_jewelry_uriage  .= "0, ";
                                                                // 表示用
                                                                    $temp1_jewelry_manthly_html .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $js_jewelry_uriage  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $temp1_jewelry_manthly_html .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }
                                                            $i++;
                                                        }
                                                        $i = 0;
                                                        foreach($temp1_jewelry_manthly_array2 as $val){
                                                            // 【進捗率の取得】最終月の「現在・ジュエリー・点数」を取得
                                                                //$jewelry_last_number = $val;
                                                            if($val == ""){
                                                                // JSグラフ用
                                                                    $js_jewelry_number  .= "0, ";
                                                                // 表示用
                                                                    $temp1_jewelry_manthly_html2 .= "<div class='title3 ta_r'>0</div>";
                                                            } else {
                                                                // JSグラフ用
                                                                    $js_jewelry_number  .= $val . ", ";
                                                                // 表示用
                                                                    if($val <> 0 && $val <> ""){$val = number_format((int)$val);}
                                                                    $temp1_jewelry_manthly_html2 .= "<div class='title3 ta_r'>" . $val . "</div>";
                                                            }
                                                            $i++;
                                                        }

                                                    // 全体HTMLの作成
                                                        if(isset($temp1_jewelry_manthly_html) && isset($temp1_jewelry_sum)){
                                                            $temp1_jewelry_manthly_html = "<div class='wid100 ul1'><div class='title1 ta_c'>ジュエリー</div>" . $temp1_jewelry_manthly_html . $temp1_jewelry_sum;
                                                        }
                                                        if(isset($temp1_jewelry_manthly_html2) && isset($temp1_jewelry_sum2)){
                                                            $temp1_jewelry_manthly_html2 = "<div class='wid100 ul1'><div class='title1 ta_c'>ジュエリー</div>" . $temp1_jewelry_manthly_html2 . $temp1_jewelry_sum2;
                                                        }
                                                        if(isset($temp1_jewelry_manthly_html3) && isset($temp1_jewelry_sum3)){
                                                            $temp1_jewelry_manthly_html3 = "<div class='wid100 ul1'><div class='title1 ta_c'>ジュエリー</div>" . $temp1_jewelry_manthly_html3 . $temp1_jewelry_sum3;
                                                        }
                                                }

                                        // 各月の全部門売上合計のJS表示用
                                                $js_all_month_uriage = "";
                                                $js_all_month_number = "";
                                                $i = 0;
                                                foreach($manth_now_array as $val){
                                                    $all_js = 0;
                                                    $all_js2 = 0;
                                                    $all_js3 = 0;
                                                    if($out1_a == "ON"){ $all_js = (int)$all_js + (int)$temp1_betty_manthly_array[$i]; $all_js2 = (int)$all_js2 + (int)$temp1_betty_manthly_array2[$i]; $all_js3 = (int)$all_js3;}
                                                    if($out1_b == "ON"){ $all_js = (int)$all_js + (int)$temp1_jack_manthly_array[$i]; $all_js2 = (int)$all_js2 + (int)$temp1_jack_manthly_array2[$i]; $all_js3 = (int)$all_js3;}
                                                    if($out1_c == "ON"){ $all_js = (int)$all_js + (int)$temp1_jewelry_manthly_array[$i]; $all_js2 = (int)$all_js2 + (int)$temp1_jewelry_manthly_array2[$i]; $all_js3 = (int)$all_js3;}

                                                    $js_all_month_uriage .= $all_js . ", ";
                                                    $js_all_month_number .= $all_js2 . ", ";
                                                    
                                                    $i++;
                                                }





// 現在・金額構成比

    $i = 0;
    $total = "";
    $total2 = 0;
    $jack_per = "";
    $betty_per = "";
    $jewelry_per = "";
    $jack_total = "";
    $betty_total = "";
    $jewelry_total = "";
    $jack_per_html = "";
    $betty_per_html = "";
    $jewelry_per_html = "";
    $jack_total_js2 = "";
    $betty_total_js2 = "";
    $jewelry_total_js2 = "";
    foreach($temp1_jack_manthly_array as $var){
        if($out1_c == "ON"){
            $total = (int)$var + (int)$temp1_betty_manthly_array[$i] + (int)$temp1_jewelry_manthly_array[$i];
        } else {
            $total = (int)$var + (int)$temp1_betty_manthly_array[$i];
        }
        $total2 = (int)$total2 + (int)$total;
        $jack_total = (int)$jack_total + (int)$var;
        $betty_total = (int)$betty_total + (int)$temp1_betty_manthly_array[$i];
        if($out1_c == "ON"){ $jewelry_total = (int)$jewelry_total + (int)$temp1_jewelry_manthly_array[$i]; }
        if($var == 0){
            $jack_per = "---";
            if($temp1_betty_manthly_array[$i] == 0){
                $betty_per = "---";
            } else {
                if($out1_c == "ON"){ 
                    if($temp1_betty_manthly_array[$i] <> 0 && $total <> 0 && $temp1_betty_manthly_array[$i] <> "" && $total <> ""){
                        $betty_per = number_format((floor(($temp1_betty_manthly_array[$i] / $total) * 100 * 10)) / 10 ,1); 
                    } else {
                        $betty_per = "---"; 
                    }
                } else {
                    //$betty_per = 100 - $jack_per;
                    $betty_per = number_format(bcsub('100', ((float)$jack_per), 1) ,1);
                }
            }
            if($out1_c == "ON"){
                if($temp1_jewelry_manthly_array[$i] == 0){
                    $jewelry_per = "---";
                } else {
                    //$jewelry_per = 100 - $jack_per - $betty_per;
                    $jewelry_per = number_format(bcsub('100', ($jack_per + $betty_per), 1) ,1);
                }
            }
        } else {
            $jack_per = number_format((floor(($var / $total) * 100 * 10)) / 10 ,1);
            if($temp1_betty_manthly_array[$i] == 0){
                $betty_per = "---";
            } else {
                if($out1_c == "ON"){ $betty_per = number_format((floor(($temp1_betty_manthly_array[$i] / $total) * 100 * 10)) / 10 ,1); } else {$betty_per = 100 - $jack_per;}
            }
            if($out1_c == "ON"){
                if($temp1_jewelry_manthly_array[$i] == 0){
                    $jewelry_per = "---";
                } else {
                    //$jewelry_per = 100 - $jack_per - $betty_per;
                    $jewelry_per = number_format(bcsub('100', ($jack_per + $betty_per), 1) ,1);
                }
            }
        }
        $jack_per_html .= "<div class='title7 ta_r'>" . $jack_per . "%</div>";
        $betty_per_html .= "<div class='title7 ta_r'>" . $betty_per . "%</div>";
        $jack_total_js2  .= (float)$jack_per . ", ";
        $betty_total_js2  .= (float)$betty_per . ", ";
        if($out1_c == "ON"){
            $jewelry_per_html .= "<div class='title7 ta_r'>" . $jewelry_per . "%</div>";
            $jewelry_total_js2  .= (float)$jewelry_per . ", ";
        }

        $i++;
    }
    // 期間中の売上合計に対するパーセンテージを取得
       // $jack_total_per = $jack_total / $i;
        if($jack_total <> 0 && $total2 <> 0 && $jack_total <> "" && $total2 <> ""){
            $jack_total_per = number_format((floor(((float)$jack_total / (float)$total2) * 100 * 10)) / 10 ,1);
        } else {
            $jack_total_per = "---";
        }
        if($betty_total <> 0 && $total2 <> 0 && $betty_total <> "" && $total2 <> ""){
            $betty_total_per = number_format((floor(((float)$betty_total / (float)$total2) * 100 * 10)) / 10 ,1);
        } else {
            $betty_total_per = "---";
        }
        //if($out1_c == "ON"){ $jewelry_total_per = 100 - ((float)$jack_total_per + (float)$betty_total_per); }
        if($out1_c == "ON"){ $jewelry_total_per = number_format(bcsub('100', ((float)$jack_total_per + (float)$betty_total_per), 1), 1);}

        $jack_per_html .= "<div class='title7 ta_r'>" . $jack_total_per . "%</div>";
        $betty_per_html .= "<div class='title7 ta_r'>" . $betty_total_per . "%</div>";
        if($out1_c == "ON"){ $jewelry_per_html .= "<div class='title7 ta_r'>" . $jewelry_total_per. "%</div>";}


    $temp1_all_sorce4 = "<p class='title_a'>金額・構成比</p><div class='box1'>" . $temp1_title4 . "<div class='wid100 ul4'><div class='title7 ta_c'>ベティー    </div>" . $betty_per_html . "</div>";
    $temp1_all_sorce4 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジャック</div>" . $jack_per_html . "</div>";
    if($out1_c == "ON"){$temp1_all_sorce4 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジュエリー</div>" . $jewelry_per_html . "</div>";}
    $temp1_all_sorce4 .= "</div>";




    // 現在・点数構成比

    $i = 0;
    $total = "";
    $total2 = 0;
    $jack_per = "";
    $betty_per = "";
    $jewelry_per = "";
    $jack_total = "";
    $betty_total = "";
    $jewelry_total = "";
    $jack_per_html = "";
    $betty_per_html = "";
    $jewelry_per_html = "";
    $jack_total_js3 = "";
    $betty_total_js3 = "";
    $jewelry_total_js3 = "";
    foreach($temp1_jack_manthly_array2 as $var){
        //echo $temp1_betty_manthly_array2[$i] . "<br>";
        if($out1_c == "ON"){
            $total = (int)$var + (int)$temp1_betty_manthly_array2[$i] + (int)$temp1_jewelry_manthly_array2[$i];
        } else {
            $total = (int)$var + (int)$temp1_betty_manthly_array2[$i];
        }
        $total2 = (int)$total2 + (int)$total;
        $jack_total = (int)$jack_total + (int)$var;
        $betty_total = (int)$betty_total + (int)$temp1_betty_manthly_array2[$i];
        if($out1_c == "ON"){ $jewelry_total = (int)$jewelry_total + (int)$temp1_jewelry_manthly_array2[$i]; }
        if($var == 0){
            $jack_per = "---";
            if($temp1_betty_manthly_array2[$i] == 0){
                $betty_per = "---";
            } else {
                if($out1_c == "ON"){ 
                    if($temp1_betty_manthly_array2[$i] <> 0 && $total <> 0 && $temp1_betty_manthly_array2[$i] <> "" && $total <> ""){
                        $betty_per = number_format((floor(($temp1_betty_manthly_array2[$i] / $total) * 100 * 10)) / 10 ,1); 
                    } else {
                        $betty_per = "---"; 
                    }
                } else {
                    //$betty_per = 100 - $jack_per;
                    $betty_per = number_format(bcsub('100', ((float)$jack_per), 1) ,1);
            }
            }
            if($out1_c == "ON"){
                if($temp1_jewelry_manthly_array2[$i] == 0){
                    $jewelry_per = "---";
                } else {
                    //$jewelry_per = 100 - $jack_per - $betty_per;
                    $jewelry_per = number_format(bcsub('100', ($jack_per + $betty_per), 1) ,1);
                }
            }
        } else {
            $jack_per = number_format((floor(($var / $total) * 100 * 10)) / 10 ,1);
            if($temp1_betty_manthly_array2[$i] == 0){
                $betty_per = "---";
            } else {
                if($out1_c == "ON"){ $betty_per = number_format((floor(($temp1_betty_manthly_array2[$i] / $total) * 100 * 10)) / 10 ,1); } else {$betty_per = number_format(100 - $jack_per ,1);}
            }
            if($out1_c == "ON"){
                if($temp1_jewelry_manthly_array2[$i] == 0){
                    $jewelry_per = "---";
                } else {
                    //$jewelry_per = 100 - $jack_per - $betty_per;
                    $jewelry_per = number_format(bcsub('100', ($jack_per + $betty_per), 1) ,1);
                }
            }
        }
        $jack_per_html .= "<div class='title7 ta_r'>" . $jack_per . "%</div>";
        $betty_per_html .= "<div class='title7 ta_r'>" . $betty_per . "%</div>";
        $jack_total_js3  .= (float)$jack_per . ", ";
        $betty_total_js3  .= (float)$betty_per . ", ";
        if($out1_c == "ON"){
            $jewelry_per_html .= "<div class='title7 ta_r'>" . $jewelry_per . "%</div>";
            $jewelry_total_js3  .= (float)$jewelry_per . ", ";
        }

        $i++;
    }
    // 期間中の売上合計点数に対するパーセンテージを取得
       // $jack_total_per = $jack_total / $i;
        if($jack_total <> 0 && $total2 <> 0 && $jack_total <> "" && $total2 <> ""){
            $jack_total_per = number_format((floor(((float)$jack_total / (float)$total2) * 100 * 10)) / 10 ,1);
        } else {
            $jack_total_per = "---";
        }
        if($betty_total <> 0 && $total2 <> 0 && $betty_total <> "" && $total2 <> ""){
            $betty_total_per = number_format((floor(((float)$betty_total / (float)$total2) * 100 * 10)) / 10 ,1);
        } else {
            $betty_total_per = "---";
        }
        //if($out1_c == "ON"){ $jewelry_total_per = 100 - $jack_total_per - $betty_total_per; }
        if($out1_c == "ON"){ $jewelry_total_per = number_format(bcsub('100', ((float)$jack_total_per + (float)$betty_total_per), 1) ,1);}


        $jack_per_html .= "<div class='title7 ta_r'>" . $jack_total_per . "%</div>";
        $betty_per_html .= "<div class='title7 ta_r'>" . $betty_total_per . "%</div>";
        if($out1_c == "ON"){ $jewelry_per_html .= "<div class='title7 ta_r'>" . $jewelry_total_per . "%</div>";}


    $temp1_all_sorce5 = "<p class='title_a'>点数・構成比</p><div class='box1'>" . $temp1_title4 . "<div class='wid100 ul4'><div class='title7 ta_c'>ベティー</div>" . $betty_per_html . "</div>";
    $temp1_all_sorce5 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジャック</div>" . $jack_per_html . "</div>";
    if($out1_c == "ON"){$temp1_all_sorce5 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジュエリー</div>" . $jewelry_per_html . "</div>";}
    $temp1_all_sorce5 .= "</div>";



// 現在・平均単価

    $i = 0;
    $jack_average = "";
    $jack_ave_html = "";
    $jack_total = "";
    $jack_total2 = "";
    $jack_total_ave = "";
    foreach($temp1_jack_manthly_array as $var){

        if($var == 0){
            $jack_average = 0;
            $jack_total = (int)$jack_total + (int)$var;
            if($temp1_jack_manthly_array2[$i] == 0){
                $jack_total2 = $jack_total2;
            } else {
                $jack_total2 = (int)$jack_total2 + (int)$temp1_jack_manthly_array2[$i];
            }
        } else {
            $jack_average = (floor(((int)$var / (int)$temp1_jack_manthly_array2[$i])) * 10) / 10;
            $jack_total = (int)$jack_total + (int)$var;
            if($temp1_jack_manthly_array2[$i] == 0){
                $jack_total2 = $jack_total2;
            } else {
                $jack_total2 = (int)$jack_total2 + (int)$temp1_jack_manthly_array2[$i];
            }
        }
        if($jack_average <> 0 && $jack_average <> ""){$jack_average = number_format((int)$jack_average);}
        $jack_ave_html .= "<div class='title7 ta_r'>" . $jack_average . "</div>";

        $i++;
    }
    // 期間中の売上合計に対する平均単価を取得
        if($jack_total <> 0 && $jack_total2 <> 0 && $jack_total <> "" && $jack_total2 <> ""){
            $jack_total_ave = (floor(((int)$jack_total / (int)$jack_total2) * 10)) / 10;
        } else {
            $jack_total_ave = "---";
        }
        if($jack_total_ave <> 0 && $jack_total_ave <> ""){$jack_total_ave = number_format((int)$jack_total_ave);}
        $jack_ave_html .= "<div class='title7 ta_r'>" . $jack_total_ave . "</div>";

    $i = 0;
    $betty_average = "";
    $betty_ave_html = "";
    $betty_total = "";
    $betty_total2 = "";
    $betty_total_ave = "";
    foreach($temp1_betty_manthly_array as $var){

        if($var == 0){
            $betty_average = 0;
            $betty_total = (int)$betty_total + (int)$var;
            if($temp1_betty_manthly_array2[$i] == 0){
                $betty_total2 = $betty_total2;
            } else {
                $betty_total2 = (int)$betty_total2 + (int)$temp1_betty_manthly_array2[$i];
            }
        } else {
            $betty_average = (floor(((int)$var / (int)$temp1_betty_manthly_array2[$i])) * 10) / 10;
            $betty_total = (int)$betty_total + (int)$var;
            if($temp1_betty_manthly_array2[$i] == 0){
                $betty_total2 = $betty_total2;
            } else {
                $betty_total2 = (int)$betty_total2 + (int)$temp1_betty_manthly_array2[$i];
            }
        }
        if($betty_average <> 0 && $betty_average <> ""){$betty_average = number_format((int)$betty_average);}
        $betty_ave_html .= "<div class='title7 ta_r'>" . $betty_average . "</div>";

        $i++;
    }
    // 期間中の売上合計に対する平均単価を取得
        if($betty_total <> 0 && $betty_total2 <> 0 && $betty_total <> "" && $betty_total2 <> ""){
            $betty_total_ave = (floor(((int)$betty_total / (int)$betty_total2) * 10)) / 10;
        } else {
            "---";
        }
        if($betty_total_ave <> 0 && $betty_total_ave <> ""){$betty_total_ave = number_format((int)$betty_total_ave);}
        $betty_ave_html .= "<div class='title7 ta_r'>" . $betty_total_ave . "</div>";


        if($out1_c == "ON"){    
            $i = 0;
            $jewelry_average = "";
            $jewelry_ave_html = "";
            $jewelry_total = "";
            $jewelry_total2 = "";
            $jewelry_total_ave = "";
            foreach($temp1_jewelry_manthly_array as $var){

                if($var == 0){
                    $jewelry_average = 0;
                    $jewelry_total = (int)$jewelry_total + (int)$var;
                    if($temp1_jewelry_manthly_array2[$i] == 0){
                        $jewelry_total2 = $jewelry_total2;
                    } else {
                        $jewelry_total2 = (int)$jewelry_total2 + (int)$temp1_jewelry_manthly_array2[$i];
                    }
                } else {
                    $jewelry_average = (floor(((int)$var / (int)$temp1_jewelry_manthly_array2[$i])) * 10) / 10;
                    $jewelry_total = (int)$jewelry_total + (int)$var;
                    if($temp1_jewelry_manthly_array2[$i] == 0){
                        $jewelry_total2 = $jewelry_total2;
                    } else {
                        $jewelry_total2 = (int)$jewelry_total2 + (int)$temp1_jewelry_manthly_array2[$i];
                    }
                }
                if($jewelry_average <> 0 && $jewelry_average <> ""){$jewelry_average = number_format((int)$jewelry_average);}
                $jewelry_ave_html .= "<div class='title7 ta_r'>" . $jewelry_average . "</div>";

                $i++;
            }
            // 期間中の売上合計に対する平均単価を取得
                if($jewelry_total == 0 || $jewelry_total2 == 0 || $jewelry_total == "" || $jewelry_total2 == ""){
                    $jewelry_total_ave = "---";
                } else {
                    $jewelry_total_ave = (floor(((int)$jewelry_total / (int)$jewelry_total2) * 10)) / 10;
                }
                if($jewelry_total_ave <> 0 && $jewelry_total_ave <> ""){$jewelry_total_ave = number_format((int)$jewelry_total_ave);}
                $jewelry_ave_html .= "<div class='title7 ta_r'>" . $jewelry_total_ave . "</div>";
        }


    $temp1_all_sorce6 = "<p class='title_a'>平均単価</p><div class='box1'>" . $temp1_title4 . "<div class='wid100 ul4'><div class='title7 ta_c'>ベティー</div>" . $betty_ave_html . "</div>";
    $temp1_all_sorce6 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジャック</div>" . $jack_ave_html . "</div>";
    if($out1_c == "ON"){$temp1_all_sorce6 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジュエリー</div>" . $jewelry_ave_html . "</div>";}
    $temp1_all_sorce6 .= "</div>";


// ジャック・金額・過去比

    $i = 0;
    $jack_ratio = "";
    $jack_ratio_html = "";
    $jack_total = "";
    $jack_total_past = "";
    $jack_total_ratio = "";
    foreach($temp1_jack_manthly_array as $var){
        if($var == 0){
            $jack_ratio = "---";
            $jack_total = $jack_total;
            if($past_temp1_jack_manthly_array[$i] == 0){
                $jack_total_past = $jack_total_past;
            } else {
                $jack_total_past = (int)$jack_total_past + (int)$past_temp1_jack_manthly_array[$i];
            }
        } else {
            if($var == 0 || $past_temp1_jack_manthly_array[$i] == 0 || $var == "" || $past_temp1_jack_manthly_array[$i] == ""){
                $jack_ratio = "---";
            } else { 
                $jack_ratio = number_format((floor(($var / $past_temp1_jack_manthly_array[$i]) * 100 * 10)) / 10 ,1);
            }
            $jack_total = (int)$jack_total + (int)$var;
            if($past_temp1_jack_manthly_array[$i] == 0){
                $jack_total_past = $jack_total_past;
            } else {
                $jack_total_past = (int)$jack_total_past + (int)$past_temp1_jack_manthly_array[$i];
            }
        }
        if($jack_ratio < 100){
            $jack_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $jack_ratio . "%</div>";
        } else {
            $jack_ratio_html .= "<div class='title7 ta_r fc_red'>" . $jack_ratio . "%</div>";
        }

        $i++;
    }
    // 過去の同期間売上金額に対する比率を取得
        if($jack_total <> 0 && $jack_total_past <> 0 && $jack_total <> "" && $jack_total_past <> ""){
            $jack_total_ratio = number_format((floor(((float)$jack_total / (float)$jack_total_past) * 100 * 10)) / 10 ,1);
        } else {
            $jack_total_ratio = "---";
        }

        if($jack_total_ratio < 100){
            $jack_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $jack_total_ratio . "%</div>";
        } else {
            $jack_ratio_html .= "<div class='title7 ta_r fc_red'>" . $jack_total_ratio . "%</div>";
        }


// ベティー・金額・過去比

    $i = 0;
    $betty_ratio = "";
    $betty_ratio_html = "";
    $betty_total = "";
    $betty_total_past = "";
    $betty_total_ratio = "";
    foreach($temp1_betty_manthly_array as $var){
        if($var == 0){
            $betty_ratio = "---";
            $betty_total = $betty_total;
            if($past_temp1_betty_manthly_array[$i] == 0){
                $betty_total_past = $betty_total_past;
            } else {
                $betty_total_past = (int)$betty_total_past + (int)$past_temp1_betty_manthly_array[$i];
            }
        } else {
            if($var == 0 || $past_temp1_betty_manthly_array[$i] == 0 || $var == "" || $past_temp1_betty_manthly_array[$i] == ""){
                $betty_ratio = "---";
            } else {
                $betty_ratio = number_format((floor(($var / $past_temp1_betty_manthly_array[$i]) * 100 * 10)) / 10 ,1);
            }
            $betty_total = (int)$betty_total + (int)$var;
            if($past_temp1_betty_manthly_array[$i] == 0){
                $betty_total_past = $betty_total_past;
            } else {
                $betty_total_past = (int)$betty_total_past + (int)$past_temp1_betty_manthly_array[$i];
            }
        }
        if($betty_ratio < 100){
            $betty_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $betty_ratio . "%</div>";
        } else {
            $betty_ratio_html .= "<div class='title7 ta_r fc_red'>" . $betty_ratio . "%</div>";
        }
        

        $i++;
    }
    // 過去の同期間売上金額に対する比率を取得
        if($jack_total <> 0 && $jack_total_past <> 0 && $jack_total <> "" && $jack_total_past <> ""){
            $betty_total_ratio = number_format((floor(((float)$betty_total / (float)$betty_total_past) * 100 * 10)) / 10 ,1);
        } else {
            $betty_total_ratio = "---";
        }

        if($betty_total_ratio < 100){
            $betty_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $betty_total_ratio . "%</div>";
        } else {
            $betty_ratio_html .= "<div class='title7 ta_r fc_red'>" . $betty_total_ratio . "%</div>";
        }
        
    if($out1_c == "ON"){
        // ジュエリー・金額・過去比
            $i = 0;
            $jewelry_ratio = "";
            $jewelry_ratio_html = "";
            $jewelry_total = "";
            $jewelry_total_past = "";
            $jewelry_total_ratio = "";
            foreach($temp1_jewelry_manthly_array as $var){
                if($var == 0){
                    $jewelry_ratio = "---";
                    $jewelry_total = $jewelry_total;
                    if($past_temp1_jewelry_manthly_array[$i] == 0){
                        $jewelry_total_past = $jewelry_total_past;
                    } else {
                        $jewelry_total_past = (int)$jewelry_total_past + (int)$past_temp1_jewelry_manthly_array[$i];
                    }
                } else {
                    if($var == 0 || $past_temp1_jewelry_manthly_array[$i] == 0 || $var == "" || $past_temp1_jewelry_manthly_array[$i] == ""){
                        $jewelry_ratio = "---";
                    } else {
                        $jewelry_ratio = number_format((floor(($var / $past_temp1_jewelry_manthly_array[$i]) * 100 * 10)) / 10 ,1);
                    }
                    $jewelry_total = (int)$jewelry_total + (int)$var;
                    if($past_temp1_jewelry_manthly_array[$i] == 0){
                        $jewelry_total_past = $jewelry_total_past;
                    } else {
                        $jewelry_total_past = (int)$jewelry_total_past + (int)$past_temp1_jewelry_manthly_array[$i];
                    }
                }

                if($jewelry_ratio < 100){
                    $jewelry_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $jewelry_ratio . "%</div>";
                } else {
                    $jewelry_ratio_html .= "<div class='title7 ta_r fc_red'>" . $jewelry_ratio . "%</div>";
                }
        
                $i++;
            }
            // 過去の同期間売上金額に対する比率を取得
                if($jewelry_total == 0 || $jewelry_total_past == 0 || $jewelry_total == "" || $jewelry_total_past == ""){
                    $jewelry_total_ratio = "---";
                } else {
                    $jewelry_total_ratio = number_format((floor(((int)$jewelry_total / (int)$jewelry_total_past) * 100 * 10)) / 10 ,1);
                }

                if($jewelry_total_ratio < 100){
                    $jewelry_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $jewelry_total_ratio . "%</div>";
                } else {
                    $jewelry_ratio_html .= "<div class='title7 ta_r fc_red'>" . $jewelry_total_ratio . "%</div>";
                }
                
    }


// ジャック・ベティー・ジュエリー合計・金額・過去比

    $i = 0;
    $ratio = "";
    $ratio_html = "";
    $total = "";
    $total_past = "";
    $total_ratio = "";
    foreach($temp1_jack_manthly_array as $var){
        if($var == 0 && $temp1_betty_manthly_array[$i] == 0/* && $temp1_jewelry_manthly_array[$i] == 0*/){
            $ratio = 0;
            $total = $total;
            if($past_temp1_jack_manthly_array[$i] == 0 && $past_temp1_betty_manthly_array[$i] == 0/* && $past_temp1_jewelry_manthly_array[$i] == 0*/){
                $total_past = $total_past;
            } else {
                if($out1_c == "ON"){
                    $total_past = (int)$total_past + (int)$past_temp1_jack_manthly_array[$i] + (int)$past_temp1_betty_manthly_array[$i] + (int)$past_temp1_jewelry_manthly_array[$i];
                } else {
                    $total_past = (int)$total_past + (int)$past_temp1_jack_manthly_array[$i] + (int)$past_temp1_betty_manthly_array[$i];
                }
            }
        } else {
            if($out1_c == "ON"){
                if((int)$var + (int)$temp1_betty_manthly_array[$i] + (int)$temp1_jewelry_manthly_array[$i] == 0 || (int)$past_temp1_jack_manthly_array[$i] + (int)$past_temp1_betty_manthly_array[$i] + (int)$past_temp1_jewelry_manthly_array[$i] == 0){
                    $ratio = "---";
                } else {
                    $ratio = number_format((floor((((int)$var + (int)$temp1_betty_manthly_array[$i] + (int)$temp1_jewelry_manthly_array[$i]) / ((int)$past_temp1_jack_manthly_array[$i] + (int)$past_temp1_betty_manthly_array[$i] + (int)$past_temp1_jewelry_manthly_array[$i])) * 100 * 10)) / 10 ,1);
                }
                $total = (int)$total + (int)$var + (int)$temp1_betty_manthly_array[$i] + (int)$temp1_jewelry_manthly_array[$i];
            } else {
                if((int)$var + (int)$temp1_betty_manthly_array[$i] == 0 || (int)$past_temp1_jack_manthly_array[$i] + (int)$past_temp1_betty_manthly_array[$i] == 0){
                    $ratio = "---";
                } else {
                    $ratio = number_format((floor((((int)$var + (int)$temp1_betty_manthly_array[$i]) / ((int)$past_temp1_jack_manthly_array[$i] + (int)$past_temp1_betty_manthly_array[$i])) * 100 * 10)) / 10 ,1);
                }
                $total = (int)$total + (int)$var + (int)$temp1_betty_manthly_array[$i];
            }
            if($out1_c == "ON"){
                if($past_temp1_jack_manthly_array[$i] == 0 && $past_temp1_betty_manthly_array[$i] == 0 && $past_temp1_jewelry_manthly_array[$i] == 0){
                    $total_past = $total_past;
                } else {
                    $total_past = (int)$total_past + (int)$past_temp1_jack_manthly_array[$i] + (int)$past_temp1_betty_manthly_array[$i] + (int)$past_temp1_jewelry_manthly_array[$i];
                }
            } else {
                if($past_temp1_jack_manthly_array[$i] == 0 && $past_temp1_betty_manthly_array[$i] == 0){
                    $total_past = $total_past;
                } else {
                    $total_past = (int)$total_past + (int)$past_temp1_jack_manthly_array[$i] + (int)$past_temp1_betty_manthly_array[$i];
                }
            }
        }
        //$ratio_html .= "<div class='title7 ta_r'>" . $ratio . "%</div>";

        if($ratio < 100){
            $ratio_html .= "<div class='title7 ta_r fc_blue'>" . $ratio . "%</div>";
        } else {
            $ratio_html .= "<div class='title7 ta_r fc_red'>" . $ratio . "%</div>";
        }

        $i++;
    }
    // 過去の同期間売上金額に対する比率を取得
        if($total <> 0 && $total_past <> 0 && $total <> "" && $total_past <> ""){
            $total_ratio = number_format((floor(((float)$total / (float)$total_past) * 100 * 10)) / 10 ,1);
        } else {
            $total_ratio = "---";
        }

        //$ratio_html .= "<div class='title7 ta_r bg_grey'>" . $total_ratio . "%</div>";

        if($total_ratio < 100){
            $ratio_html .= "<div class='title7 ta_r fc_blue'>" . $total_ratio . "%</div>";
        } else {
            $ratio_html .= "<div class='title7 ta_r fc_red'>" . $total_ratio . "%</div>";
        }


    $temp1_all_sorce7 = "<p class='title_a'>金額・過去比</p><div class='box1'>" . $temp1_title5 . "<div class='wid100 ul4'><div class='title7 ta_c'>ベティー</div>" . $betty_ratio_html . "</div>";
    $temp1_all_sorce7 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジャック</div>" . $jack_ratio_html . "</div>";
    if($out1_c == "ON"){$temp1_all_sorce7 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジュエリー</div>" . $jewelry_ratio_html . "</div>";}
    $temp1_all_sorce7 .= "<div class='wid100 ul4 bg_grey'><div class='title7 ta_c'>合計</div>" . $ratio_html . "</div></div>";


// ジャック・点数・過去比

    $i = 0;
    $jack_ratio = "";
    $jack_ratio_html = "";
    $jack_total = "";
    $jack_total_past = "";
    $jack_total_ratio = "";
    foreach($temp1_jack_manthly_array2 as $var){
        if($var == 0){
            $jack_ratio = "---";
            $jack_total = $jack_total;
            if($past_temp1_jack_manthly_array2[$i] == 0){
                $jack_total_past = $jack_total_past;
            } else {
                $jack_total_past = (int)$jack_total_past + (int)$past_temp1_jack_manthly_array2[$i];
            }
        } else {
            if($var == 0 || $past_temp1_jack_manthly_array2[$i] == 0 || $var == "" || $past_temp1_jack_manthly_array2[$i] == ""){
                $jack_ratio = "---";
            } else {
                $jack_ratio = number_format((floor(($var / $past_temp1_jack_manthly_array2[$i]) * 100 * 10)) / 10 ,1);
            }
            $jack_total = (int)$jack_total + (int)$var;
            if($past_temp1_jack_manthly_array2[$i] == 0){
                $jack_total_past = $jack_total_past;
            } else {
                $jack_total_past = (int)$jack_total_past + (int)$past_temp1_jack_manthly_array2[$i];
            }
        }
        //$jack_ratio_html .= "<div class='title7 ta_r'>" . $jack_ratio . "%</div>";

        if($jack_ratio < 100){
            $jack_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $jack_ratio . "%</div>";
        } else {
            $jack_ratio_html .= "<div class='title7 ta_r fc_red'>" . $jack_ratio . "%</div>";
        }

        $i++;
    }
    // 過去の同期間売上点数に対する比率を取得
        if($jack_total <> 0 && $jack_total_past <> 0 && $jack_total <> "" && $jack_total_past <> ""){
            $jack_total_ratio = number_format((floor(((float)$jack_total / (float)$jack_total_past) * 100 * 10)) / 10 ,1);
        } else {
            $jack_total_ratio = "---";
        }

        //$jack_ratio_html .= "<div class='title7 ta_r'>" . $jack_total_ratio . "%</div>";

        if($jack_total_ratio < 100){
            $jack_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $jack_total_ratio . "%</div>";
        } else {
            $jack_ratio_html .= "<div class='title7 ta_r fc_red'>" . $jack_total_ratio . "%</div>";
        }


// ベティー・点数・過去比

    $i = 0;
    $betty_ratio = "";
    $betty_ratio_html = "";
    $betty_total = "";
    $betty_total_past = "";
    $betty_total_ratio = "";
    foreach($temp1_betty_manthly_array2 as $var){
        if($var == 0){
            $betty_ratio = "---";
            $betty_total = $betty_total;
            if($past_temp1_betty_manthly_array2[$i] == 0){
                $betty_total_past = $betty_total_past;
            } else {
                $betty_total_past = (int)$betty_total_past + (int)$past_temp1_betty_manthly_array2[$i];
            }
        } else {
            if($var == 0 || $past_temp1_betty_manthly_array2[$i] == 0 || $var == "" || $past_temp1_betty_manthly_array2[$i] == ""){
                $betty_ratio = "---";
            } else {
                $betty_ratio = number_format((floor(($var / $past_temp1_betty_manthly_array2[$i]) * 100 * 10)) / 10 ,1);
            }
            $betty_total = (int)$betty_total + (int)$var;
            if($past_temp1_betty_manthly_array2[$i] == 0){
                $betty_total_past = $betty_total_past;
            } else {
                $betty_total_past = (int)$betty_total_past + (int)$past_temp1_betty_manthly_array2[$i];
            }
        }
        //$betty_ratio_html .= "<div class='title7 ta_r'>" . $betty_ratio . "%</div>";
        if($betty_ratio < 100){
            $betty_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $betty_ratio . "%</div>";
        } else {
            $betty_ratio_html .= "<div class='title7 ta_r fc_red'>" . $betty_ratio . "%</div>";
        }

        $i++;
    }
    // 過去の同期間売上点数に対する比率を取得
        if($betty_total <> 0 && $betty_total_past <> 0 && $betty_total <> "" && $betty_total_past <> ""){
            $betty_total_ratio = number_format((floor(((float)$betty_total / (float)$betty_total_past) * 100 * 10)) / 10 ,1);
        } else {
            $betty_total_ratio = "---";
        }

        //$betty_ratio_html .= "<div class='title7 ta_r'>" . $betty_total_ratio . "%</div>";
        if($betty_total_ratio < 100){
            $betty_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $betty_total_ratio . "%</div>";
        } else {
            $betty_ratio_html .= "<div class='title7 ta_r fc_red'>" . $betty_total_ratio . "%</div>";
        }


    if($out1_c == "ON"){
        // ジュエリー・金額・過去比
            $i = 0;
            $jewelry_ratio = "";
            $jewelry_ratio_html = "";
            $jewelry_total = "";
            $jewelry_total_past = "";
            $jewelry_total_ratio = "";
            foreach($temp1_jewelry_manthly_array2 as $var){
                if($var == 0){
                    $jewelry_ratio = "---";
                    $jewelry_total = $jewelry_total;
                    if($past_temp1_jewelry_manthly_array2[$i] == 0){
                        $jewelry_total_past = $jewelry_total_past;
                    } else {
                        $jewelry_total_past = (int)$jewelry_total_past + (int)$past_temp1_jewelry_manthly_array2[$i];
                    }
                } else {
                    if($var == 0 || $past_temp1_jewelry_manthly_array2[$i] == 0 || $var == "" || $past_temp1_jewelry_manthly_array2[$i] == ""){
                        $jewelry_ratio = "---";
                    } else {
                        $jewelry_ratio = number_format((floor(($var / $past_temp1_jewelry_manthly_array2[$i]) * 100 * 10)) / 10 ,1);
                    }
                    $jewelry_total = (int)$jewelry_total + (int)$var;
                    if($past_temp1_jewelry_manthly_array2[$i] == 0){
                        $jewelry_total_past = $jewelry_total_past;
                    } else {
                        $jewelry_total_past = (int)$jewelry_total_past + (int)$past_temp1_jewelry_manthly_array2[$i];
                    }
                }
                //$jewelry_ratio_html .= "<div class='title7 ta_r'>" . $jewelry_ratio . "%</div>";
                if($jewelry_ratio < 100){
                    $jewelry_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $jewelry_ratio . "%</div>";
                } else {
                    $jewelry_ratio_html .= "<div class='title7 ta_r fc_red'>" . $jewelry_ratio . "%</div>";
                }
        
                $i++;
            }
            // 過去の同期間売上金額に対する比率を取得
                if($jewelry_total == 0 || $jewelry_total_past == 0 || $jewelry_total == "" || $jewelry_total_past == ""){
                    $jewelry_total_ratio = "---";
                } else {
                    $jewelry_total_ratio = number_format((floor(((int)$jewelry_total / (int)$jewelry_total_past) * 100 * 10)) / 10 ,1);
                }

                //$jewelry_ratio_html .= "<div class='title7 ta_r'>" . $jewelry_total_ratio . "%</div>";
                if($jewelry_total_ratio < 100){
                    $jewelry_ratio_html .= "<div class='title7 ta_r fc_blue'>" . $jewelry_total_ratio . "%</div>";
                } else {
                    $jewelry_ratio_html .= "<div class='title7 ta_r fc_red'>" . $jewelry_total_ratio . "%</div>";
                }
    }


// ジャック・ベティー・ジュエリー合計・点数・過去比

    $i = 0;
    $ratio = "";
    $ratio_html = "";
    $total = "";
    $total_past = "";
    $total_ratio = "";
    foreach($temp1_jack_manthly_array2 as $var){
        if($var == 0 && $temp1_betty_manthly_array2[$i] == 0/* && $temp1_jewelry_manthly_array2[$i] == 0*/){
            $ratio = 0;
            $total = $total;
            if($past_temp1_jack_manthly_array2[$i] == 0 && $past_temp1_betty_manthly_array2[$i] == 0/* && $past_temp1_jewelry_manthly_array2[$i] == 0*/){
                $total_past = $total_past;
            } else {
                if($out1_c == "ON"){
                    $total_past = (int)$total_past + (int)$past_temp1_jack_manthly_array2[$i] + (int)$past_temp1_betty_manthly_array2[$i] + (int)$past_temp1_jewelry_manthly_array2[$i];
                } else {
                    $total_past = (int)$total_past + (int)$past_temp1_jack_manthly_array2[$i] + (int)$past_temp1_betty_manthly_array2[$i];
                }
            }
        } else {
            if($out1_c == "ON"){
                if((int)$var + (int)$temp1_betty_manthly_array2[$i] + (int)$temp1_jewelry_manthly_array2[$i] == 0 || (int)$past_temp1_jack_manthly_array2[$i] + (int)$past_temp1_betty_manthly_array2[$i] + (int)$past_temp1_jewelry_manthly_array2[$i] == 0){
                    $ratio = "---";
                } else {
                    $ratio = number_format((floor((((int)$var + (int)$temp1_betty_manthly_array2[$i] + (int)$temp1_jewelry_manthly_array2[$i]) / ((int)$past_temp1_jack_manthly_array2[$i] + (int)$past_temp1_betty_manthly_array2[$i] + (int)$past_temp1_jewelry_manthly_array2[$i])) * 100 * 10)) / 10 ,1);
                }
                $total = (int)$total + (int)$var + (int)$temp1_betty_manthly_array2[$i] + (int)$temp1_jewelry_manthly_array2[$i];
            } else {
                if((int)$var + (int)$temp1_betty_manthly_array2[$i] == 0 || (int)$past_temp1_jack_manthly_array2[$i] + (int)$past_temp1_betty_manthly_array2[$i] == 0){
                    $ratio = "---";
                } else {
                    $ratio = number_format((floor((((int)$var + (int)$temp1_betty_manthly_array2[$i]) / ((int)$past_temp1_jack_manthly_array2[$i] + (int)$past_temp1_betty_manthly_array2[$i])) * 100 * 10)) / 10 ,1);
                }
                $total = (int)$total + (int)$var + (int)$temp1_betty_manthly_array2[$i];
            }
            if($out1_c == "ON"){
                if($past_temp1_jack_manthly_array2[$i] == 0 && $past_temp1_betty_manthly_array2[$i] == 0 && $past_temp1_jewelry_manthly_array2[$i] == 0){
                    $total_past = $total_past;
                } else {
                    $total_past = (int)$total_past + (int)$past_temp1_jack_manthly_array2[$i] + (int)$past_temp1_betty_manthly_array2[$i] + (int)$past_temp1_jewelry_manthly_array2[$i];
                }
            } else {
                if($past_temp1_jack_manthly_array2[$i] == 0 && $past_temp1_betty_manthly_array2[$i] == 0){
                    $total_past = $total_past;
                } else {
                    $total_past = (int)$total_past + (int)$past_temp1_jack_manthly_array2[$i] + (int)$past_temp1_betty_manthly_array2[$i];
                }
            }
        }
        //$ratio_html .= "<div class='title7 ta_r'>" . $ratio . "%</div>";
        if($ratio < 100){
            $ratio_html .= "<div class='title7 ta_r fc_blue'>" . $ratio . "%</div>";
        } else {
            $ratio_html .= "<div class='title7 ta_r fc_red'>" . $ratio . "%</div>";
        }

        $i++;
    }
    // 過去の同期間売上金額に対する比率を取得
        if($total <> 0 && $total_past <> 0 && $total <> "" && $total_past <> ""){
            $total_ratio = number_format((floor(((float)$total / (float)$total_past) * 100 * 10)) / 10 ,1);
        } else {
            $total_ratio = "---";
        }

        //$ratio_html .= "<div class='title7 ta_r bg_grey'>" . $total_ratio . "%</div>";
        if($total_ratio < 100){
            $ratio_html .= "<div class='title7 ta_r fc_blue'>" . $total_ratio . "%</div>";
        } else {
            $ratio_html .= "<div class='title7 ta_r fc_red'>" . $total_ratio . "%</div>";
        }

    $temp1_all_sorce8 = "<p class='title_a'>点数・過去比</p><div class='box1'>" . $temp1_title5 . "<div class='wid100 ul4'><div class='title7 ta_c'>ベティー</div>" . $betty_ratio_html . "</div>";
    $temp1_all_sorce8 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジャック</div>" . $jack_ratio_html . "</div>";
    if($out1_c == "ON"){$temp1_all_sorce8 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジュエリー</div>" . $jewelry_ratio_html . "</div>";}
    $temp1_all_sorce8 .= "<div class='wid100 ul4 bg_grey'><div class='title7 ta_c'>合計</div>" . $ratio_html . "</div></div>";
    
        
// 過去・金額構成比

    $i = 0;
    $total = "";
    $total2 = 0;
    $jack_per = "";
    $betty_per = "";
    $jewelry_per = "";
    $jack_total = "";
    $betty_total = "";
    $jewelry_total = "";
    $jack_per_html = "";
    $betty_per_html = "";
    $jewelry_per_html = "";
    $past_jack_total_js2 = "";
    $past_betty_total_js2 = "";
    $past_jewelry_total_js2 = "";
    foreach($past_temp1_jack_manthly_array as $var){
        //echo $past_temp1_betty_manthly_array[$i] . "<br>";
        if($out1_c == "ON"){
            $total = (int)$var + (int)$past_temp1_betty_manthly_array[$i] + (int)$past_temp1_jewelry_manthly_array[$i];
        } else {
            $total = (int)$var + (int)$past_temp1_betty_manthly_array[$i];
        }
        $total2 = (int)$total2 + (int)$total;
        $jack_total = (int)$jack_total + (int)$var;
        $betty_total = (int)$betty_total + (int)$past_temp1_betty_manthly_array[$i];
        if($out1_c == "ON"){ $jewelry_total = (int)$jewelry_total + (int)$past_temp1_jewelry_manthly_array[$i]; }
        if($var == 0){
            $jack_per = "---";
            if($past_temp1_betty_manthly_array[$i] == 0){
                $betty_per = "---";
            } else {
                if($out1_c == "ON"){ 
                    if($past_temp1_betty_manthly_array[$i] <> 0 && $total <> 0 && $past_temp1_betty_manthly_array[$i] <> "" && $total <> ""){
                        $betty_per = number_format((floor(($past_temp1_betty_manthly_array[$i] / $total) * 100 * 10)) / 10 ,1); 
                    } else {
                        $betty_per = "---"; 
                    }
                } else {
                    //$betty_per = 100 - $jack_per;
                    $betty_per = number_format(bcsub('100', ((float)$jack_per), 1) ,1);

                }
            }
            if($out1_c == "ON"){
                if($past_temp1_jewelry_manthly_array[$i] == 0){
                    $jewelry_per = "---";
                } else {
                    //$jewelry_per = 100 - $jack_per - $betty_per;
                    $jewelry_per = number_format(bcsub('100', ($jack_per + $betty_per), 1) ,1);
                }
            }
        } else {
            if($var <> 0 && $total <> 0 && $var <> "" && $total <> ""){
                $jack_per = number_format((floor(($var / $total) * 100 * 10)) / 10 ,1);
            } else {
                $jack_per = "---";
            }
            if($past_temp1_betty_manthly_array[$i] == 0){
                $betty_per = "---";
            } else {
                if($out1_c == "ON"){ 
                    if($past_temp1_betty_manthly_array[$i] <> 0 && $total <> 0 && $past_temp1_betty_manthly_array[$i] <> "" && $total <> ""){
                        $betty_per = number_format((floor(($past_temp1_betty_manthly_array[$i] / $total) * 100 * 10)) / 10 ,1); 
                    } else {
                        $betty_per = "---";
                    }
                } else {
                    //$betty_per = 100 - $jack_per;
                    $betty_per = number_format(bcsub('100', ((float)$jack_per), 1) ,1);

                }
            }
            if($out1_c == "ON"){
                if($past_temp1_jewelry_manthly_array[$i] == 0){
                    $jewelry_per = "---";
                } else {
                    //$jewelry_per = 100 - $jack_per - $betty_per;
                    $jewelry_per = number_format(bcsub('100', ((float)$jack_per + (float)$betty_per), 1) ,1);
                }
            }
        }
        $jack_per_html .= "<div class='title7 ta_r'>" . $jack_per . "%</div>";
        $betty_per_html .= "<div class='title7 ta_r'>" . $betty_per . "%</div>";
        $past_jack_total_js2  .= (float)$jack_per . ", ";
        $past_betty_total_js2  .= (float)$betty_per . ", ";

        if($out1_c == "ON"){
            $jewelry_per_html .= "<div class='title7 ta_r'>" . $jewelry_per . "%</div>";
            $past_jewelry_total_js2  .= (float)$jewelry_per . ", ";
        }

        $i++;
    }
    // 期間中の売上合計に対するパーセンテージを取得
       // $jack_total_per = $jack_total / $i;
        if($jack_total <> 0 && $total2 <> 0 && $jack_total <> "" && $total2 <> ""){
            $jack_total_per = number_format((floor(($jack_total / $total2) * 100 * 10)) / 10 ,1);
        } else {
            $jack_total_per = "---";
        }
        if($betty_total <> 0 && $total2 <> 0 && $betty_total <> "" && $total2 <> ""){
            $betty_total_per = number_format((floor(($betty_total / $total2) * 100 * 10)) / 10 ,1);
        } else {
            $betty_total_per = "---";
        }
        //if($out1_c == "ON"){ $jewelry_total_per = 100 - $jack_total_per - $betty_total_per; }
        if($out1_c == "ON"){ $jewelry_total_per = number_format(bcsub('100', ((float)$jack_total_per + (float)$betty_total_per), 1) ,1);}
        $jack_per_html .= "<div class='title7 ta_r'>" . $jack_total_per . "%</div>";
        $betty_per_html .= "<div class='title7 ta_r'>" . $betty_total_per . "%</div>";
        if($out1_c == "ON"){ $jewelry_per_html .= "<div class='title7 ta_r'>" . $jewelry_total_per . "%</div>";}

    $past_temp1_all_sorce4 = "<p class='title_a'>金額・構成比（過去）</p><div class='box1'>" . $past_temp1_title4 . "<div class='wid100 ul4'><div class='title7 ta_c'>ベティー</div>" . $betty_per_html . "</div>";
    $past_temp1_all_sorce4 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジャック</div>" . $jack_per_html . "</div>";
    if($out1_c == "ON"){$past_temp1_all_sorce4 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジュエリー</div>" . $jewelry_per_html . "</div>";}
    $past_temp1_all_sorce4 .= "</div>";

// 過去・点数構成比

    $i = 0;
    $total = "";
    $total2 = 0;
    $jack_per = "";
    $betty_per = "";
    $jewelry_per = "";
    $jack_total = "";
    $betty_total = "";
    $jewelry_total = "";
    $jack_per_html = "";
    $betty_per_html = "";
    $jewelry_per_html = "";
    $past_jack_total_js3 = "";
    $past_betty_total_js3 = "";
    $past_jewelry_total_js3 = "";
    foreach($past_temp1_jack_manthly_array2 as $var){
        //echo $past_temp1_betty_manthly_array2[$i] . "<br>";
        if($out1_c == "ON"){
            $total = (int)$var + (int)$past_temp1_betty_manthly_array2[$i] + (int)$past_temp1_jewelry_manthly_array2[$i];
        } else {
            $total = (int)$var + (int)$past_temp1_betty_manthly_array2[$i];
        }
        $total2 = (int)$total2 + (int)$total;
        $jack_total = (int)$jack_total + (int)$var;
        $betty_total = (int)$betty_total + (int)$past_temp1_betty_manthly_array2[$i];
        if($out1_c == "ON"){ $jewelry_total = (int)$jewelry_total + (int)$past_temp1_jewelry_manthly_array2[$i]; }
        if($var == 0){
            $jack_per = "---";
            if($past_temp1_betty_manthly_array2[$i] == 0){
                $betty_per = "---";
            } else {
                if($out1_c == "ON"){ 
                    if($past_temp1_betty_manthly_array2[$i] <> 0 && $total <> 0 && $past_temp1_betty_manthly_array2[$i] <> "" && $total <> ""){
                        $betty_per = number_format((floor(($past_temp1_betty_manthly_array2[$i] / $total) * 100 * 10)) / 10 ,1); 
                    } else {
                        $betty_per = "---"; 
                    }
                } else {
                    //$betty_per = 100 - $jack_per;
                    $betty_per = number_format(bcsub('100', ((float)$betty_per), 1) ,1);

                }
            }
            if($out1_c == "ON"){
                if($past_temp1_jewelry_manthly_array2[$i] == 0){
                    $jewelry_per = "---";
                } else {
                    //$jewelry_per = 100 - $jack_per - $betty_per;
                    $jewelry_per = number_format(bcsub('100', ($jack_per + $betty_per), 1) ,1);
                }
            }
        } else {
            if($var <> 0 && $total <> 0 && $var <> "" && $total <> ""){
                $jack_per = number_format((floor(($var / $total) * 100 * 10)) / 10 ,1);
            } else {
                $jack_per = "---";
            }
            if($past_temp1_betty_manthly_array2[$i] == 0){
                $betty_per = "---";
            } else {
                if($out1_c == "ON"){ 
                    if($past_temp1_betty_manthly_array2[$i] <> 0 && $total <> 0 && $past_temp1_betty_manthly_array2[$i] <> "" && $total <> ""){
                        $betty_per = number_format((floor(($past_temp1_betty_manthly_array2[$i] / $total) * 100 * 10)) / 10 ,1); 
                    } else {
                        $betty_per = "---"; 
                    }
                } else {
                    //$betty_per = 100 - $jack_per;
                    $betty_per = number_format(bcsub('100', ((float)$jack_per), 1) ,1);

                }
            }
            if($out1_c == "ON"){
                if($past_temp1_jewelry_manthly_array2[$i] == 0){
                    $jewelry_per = "---";
                } else {
                    //$jewelry_per = 100 - $jack_per - $betty_per;
                    $jewelry_per = number_format(bcsub('100', ($jack_per + $betty_per), 1) ,1);
                }
            }
        }
        $jack_per_html .= "<div class='title7 ta_r'>" . $jack_per . "%</div>";
        $betty_per_html .= "<div class='title7 ta_r'>" . $betty_per . "%</div>";
        $past_jack_total_js3  .= (float)$jack_per . ", ";
        $past_betty_total_js3  .= (float)$betty_per . ", ";
        if($out1_c == "ON"){
            $jewelry_per_html .= "<div class='title7 ta_r'>" . $jewelry_per . "%</div>";
            $past_jewelry_total_js3  .= (float)$jewelry_per . ", ";
        }

        $i++;
    }
    // 期間中の売上合計点数に対するパーセンテージを取得
       // $jack_total_per = $jack_total / $i;
        if($jack_total <> 0 && $total2 <> 0 && $jack_total <> "" && $total2 <> ""){
           $jack_total_per = number_format((floor(($jack_total / $total2) * 100 * 10)) / 10 ,1);
        } else {
            $jack_total_per = "---";
        }
        if($betty_total <> 0 && $total2 <> 0 && $betty_total <> "" && $total2 <> ""){
            $betty_total_per = number_format((floor(($betty_total / $total2) * 100 * 10)) / 10 ,1);
        } else {
            $betty_total_per = "---";
        }
       //if($out1_c == "ON"){ $jewelry_total_per = 100 - $jack_total_per - $betty_total_per; }
       if($out1_c == "ON"){ $jewelry_total_per = number_format(bcsub('100', ((float)$jack_total_per + (float)$betty_total_per), 1) ,1);}
       $jack_per_html .= "<div class='title7 ta_r'>" . $jack_total_per . "%</div>";
       $betty_per_html .= "<div class='title7 ta_r'>" . $betty_total_per . "%</div>";
       if($out1_c == "ON"){ $jewelry_per_html .= "<div class='title7 ta_r'>" . $jewelry_total_per . "%</div>";}


    $past_temp1_all_sorce5 = "<p class='title_a'>点数・構成比（過去）</p><div class='box1'>" . $past_temp1_title4 . "<div class='wid100 ul4'><div class='title7 ta_c'>ベティー</div>" . $betty_per_html . "</div>";
    $past_temp1_all_sorce5 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジャック</div>" . $jack_per_html . "</div>";
    if($out1_c == "ON"){$past_temp1_all_sorce5 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジュエリー</div>" . $jewelry_per_html . "</div>";}
    $past_temp1_all_sorce5 .= "</div>";

// 過去・平均単価

    $i = 0;
    $jack_average = "";
    $jack_ave_html = "";
    $jack_total = "";
    $jack_total2 = "";
    $jack_total_ave = "";
    foreach($past_temp1_jack_manthly_array as $var){

        if($var == 0){
            $jack_average = 0;
            $jack_total = (int)$jack_total + (int)$var;
            if($past_temp1_jack_manthly_array2[$i] == 0){
                $jack_total2 = $jack_total2;
            } else {
                $jack_total2 = (int)$jack_total2 + (int)$past_temp1_jack_manthly_array2[$i];
            }
        } else {
            if($var <> 0 && $past_temp1_jack_manthly_array2[$i] <> 0 && $var <> "" && $past_temp1_jack_manthly_array2[$i] <> ""){
                $jack_average = (floor(((int)$var / (int)$past_temp1_jack_manthly_array2[$i])) * 10) / 10;
            } else {
                $jack_average = "---";
            }
            $jack_total = (int)$jack_total + (int)$var;
            if($past_temp1_jack_manthly_array2[$i] == 0){
                $jack_total2 = $jack_total2;
            } else {
                $jack_total2 = (int)$jack_total2 + (int)$past_temp1_jack_manthly_array2[$i];
            }
        }
        if($jack_average <> 0 && $jack_average <> ""){$jack_average = number_format((int)$jack_average);}
        $jack_ave_html .= "<div class='title7 ta_r'>" . $jack_average . "</div>";

        $i++;
    }
    // 期間中の売上合計に対する平均単価を取得
        if($jack_total <> 0 && $jack_total2 <> 0 && $jack_total <> "" && $jack_total2 <> ""){
            $jack_total_ave = (floor(($jack_total / $jack_total2) * 10)) / 10;
        } else {
            $jack_total_ave = "---";
        }
        if($jack_total_ave <> 0 && $jack_total_ave <> ""){$jack_total_ave = number_format((int)$jack_total_ave);}
        $jack_ave_html .= "<div class='title7 ta_r'>" . $jack_total_ave . "</div>";

    $i = 0;
    $betty_average = "";
    $betty_ave_html = "";
    $betty_total = "";
    $betty_total2 = "";
    $betty_total_ave = "";
    foreach($past_temp1_betty_manthly_array as $var){

        if($var == 0){
            $betty_average = 0;
            $betty_total = (int)$betty_total + (int)$var;
            if($past_temp1_betty_manthly_array2[$i] == 0){
                $betty_total2 = $betty_total2;
            } else {
                $betty_total2 = (int)$betty_total2 + (int)$past_temp1_betty_manthly_array2[$i];
            }
        } else {
            if($var <> 0 && $past_temp1_betty_manthly_array2[$i] <> 0 && $var <> "" && $past_temp1_betty_manthly_array2[$i] <> ""){
                $betty_average = (floor(((int)$var / (int)$past_temp1_betty_manthly_array2[$i])));
            } else {
                $betty_average = "---";
            }
            $betty_total = (int)$betty_total + (int)$var;
            if($past_temp1_betty_manthly_array2[$i] == 0){
                $betty_total2 = $betty_total2;
            } else {
                $betty_total2 = (int)$betty_total2 + (int)$past_temp1_betty_manthly_array2[$i];
            }
        }
        if($betty_average <> 0 && $betty_average <> ""){$betty_average = number_format((int)$betty_average);}
        $betty_ave_html .= "<div class='title7 ta_r'>" . $betty_average . "</div>";

        $i++;
    }
    // 期間中の売上合計に対する平均単価を取得
        if($betty_total <> 0 && $betty_total2 <> 0 && $betty_total <> "" && $betty_total2 <> ""){
            $betty_total_ave = (floor(((float)$betty_total / (float)$betty_total2)));
        } else {
            $betty_total_ave = "---";
        }
        if($betty_total_ave <> 0 && $betty_total_ave <> ""){$betty_total_ave = number_format((int)$betty_total_ave);}
        $betty_ave_html .= "<div class='title7 ta_r'>" . $betty_total_ave . "</div>";

        if($out1_c == "ON"){    
            $i = 0;
            $jewelry_average = "";
            $jewelry_ave_html = "";
            $jewelry_total = "";
            $jewelry_total2 = "";
            $jewelry_total_ave = "";
            foreach($past_temp1_jewelry_manthly_array as $var){

                if($var == 0){
                    $jewelry_average = 0;
                    $jewelry_total = (int)$jewelry_total + (int)$var;
                    if($past_temp1_jewelry_manthly_array2[$i] == 0){
                        $jewelry_total2 = $jewelry_total2;
                    } else {
                        $jewelry_total2 = (int)$jewelry_total2 + (int)$past_temp1_jewelry_manthly_array2[$i];
                    }
                } else {
                    if($var <> 0 && $past_temp1_jewelry_manthly_array2[$i] <> 0 && $var <> "" && $past_temp1_jewelry_manthly_array2[$i] <> ""){
                        $jewelry_average = (floor(((int)$var / (int)$past_temp1_jewelry_manthly_array2[$i])) * 10) / 10;
                    } else {
                        $jewelry_average = "---";
                    }
                    $jewelry_total = (int)$jewelry_total + (int)$var;
                    if($past_temp1_jewelry_manthly_array2[$i] == 0){
                        $jewelry_total2 = $jewelry_total2;
                    } else {
                        $jewelry_total2 = (int)$jewelry_total2 + (int)$past_temp1_jewelry_manthly_array2[$i];
                    }
                }
                if($jewelry_average <> 0 && $jewelry_average <> ""){$jewelry_average = number_format((int)$jewelry_average);}
                $jewelry_ave_html .= "<div class='title7 ta_r'>" . $jewelry_average . "</div>";

                $i++;
            }
            // 期間中の売上合計に対する平均単価を取得
                if($jewelry_total == 0 || $jewelry_total2 == 0 || $jewelry_total == "" || $jewelry_total2 == ""){
                    $jewelry_total_ave = "---";
                } else {
                    $jewelry_total_ave = (floor(((int)$jewelry_total / (int)$jewelry_total2) * 10)) / 10;
                }

                if($jewelry_total_ave <> 0 && $jewelry_total_ave <> ""){$jewelry_total_ave = number_format((int)$jewelry_total_ave);}
                $jewelry_ave_html .= "<div class='title7 ta_r'>" . $jewelry_total_ave . "</div>";
        }




        $past_temp1_all_sorce6 = "<p class='title_a'>平均単価（過去）</p><div class='box1'>" . $past_temp1_title4 . "<div class='wid100 ul4'><div class='title7 ta_c'>ベティー</div>" . $betty_ave_html . "</div>";
        $past_temp1_all_sorce6 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジャック</div>" . $jack_ave_html . "</div>";
        if($out1_c == "ON"){$past_temp1_all_sorce6 .= "<div class='wid100 ul4'><div class='title7 ta_c'>ジュエリー</div>" . $jewelry_ave_html . "</div>";}
        $past_temp1_all_sorce6 .= "</div>";
    



                                        // 各月の全部門売上合計の先頭（1列目）部分のタイトルHTML
                                            $all_sum_uriage = "<div class='wid100 ul3'><div class='title5 ta_c'>合計</div>";
                                            $all_sum_number = "<div class='wid100 ul3'><div class='title5 ta_c'>合計</div>";

                                        // 各月の全部門売上合計を配列に代入
                                            $temp1_all_m_sum_uriage_array = array();
                                            $temp1_all_m_sum_number_array = array();
                                            $i = 0;
                                            foreach($manth_now_array as $val){
                                                $all = "";
                                                $all2 = "";
                                                $all3 = "";
                                                if($out1_a == "ON"){ $all = (int)$all + (int)$temp1_betty_manthly_array[$i]; $all2 = (int)$all2 + (int)$temp1_betty_manthly_array2[$i]; $all3 = (int)$all3;}
                                                if($out1_b == "ON"){ $all = (int)$all + (int)$temp1_jack_manthly_array[$i]; $all2 = (int)$all2 + (int)$temp1_jack_manthly_array2[$i]; $all3 = (int)$all3;}
                                                if($out1_c == "ON"){ $all = (int)$all + (int)$temp1_jewelry_manthly_array[$i]; $all2 = (int)$all2 + (int)$temp1_jewelry_manthly_array2[$i]; $all3 = (int)$all3;}

                                                array_push($temp1_all_m_sum_uriage_array,$all);
                                                array_push($temp1_all_m_sum_number_array,$all2);

                                                $i++;
                                            }
                                        // 各月の全部門売上合計部分のHTML作成
                                            foreach($temp1_all_m_sum_uriage_array as $var){
                                                if($var <> 0 && $var <> ""){
                                                    $all_sum_uriage .= "<div class='title6 ta_r'>" . number_format((int)$var) . "</div>";
                                                } else {
                                                    $all_sum_uriage .= "<div class='title6 ta_r'>" . (int)$var . "</div>";
                                                }
                                            }
                                            
                                        // 各月の全部門売上点数合計部分のHTML作成
                                            foreach($temp1_all_m_sum_number_array as $var){
                                                if($var <> 0 && $var <> ""){
                                                    $all_sum_number .= "<div class='title6 ta_r'>" . number_format((int)$var) . "</div>";
                                                } else {
                                                    $all_sum_number .= "<div class='title6 ta_r'>" . (int)$var . "</div>";
                                                }
                                            }
                                            
                          
                                        // 全期間全部門売上合計とその平均値のHTML作成
                                            if($all_sum_uriage_all <> 0){ 
                                                // 金額・全部門・全期間の平均を横軸合計から縦軸合計に変更
                                                    //$all_average = floor((int)$all_sum_uriage_all / $i);
                                                        if($out1_c == "ON"){
                                                            $all_average = (int)$jack_sum_uriage_ave2 + (int)$betty_sum_uriage_ave2 + (int)$jewelry_sum_uriage_ave2;
                                                        } else {
                                                            $all_average = (int)$jack_sum_uriage_ave2 + (int)$betty_sum_uriage_ave2;
                                                        }
                                            } else {
                                                $all_average = 0;            
                                            }
                                            //$all_sum_uriage .= "<div class='title6 ta_r'>" . number_format((int)$all_sum_uriage_all) . "</div><div class='title6 ta_r'>" . $yoy_uriage_sum . "</div><div class='title6 ta_r'>" . number_format((int)$all_average) . "</div></div>";
                                            $all_sum_uriage .= "<div class='title6 ta_r'>" . number_format((int)$all_sum_uriage_all) . "</div><div class='title6 ta_r'>" . number_format((int)$all_average) . "</div></div>";
                                        // 全HTMLを合体（検索対象外は除く）
                                            $view = "";
                                            if($out1_a == "ON"){ $view .= $temp1_betty_manthly_html;}
                                            if($out1_b == "ON"){ $view .= $temp1_jack_manthly_html;}
                                            if($out1_c == "ON"){ $view .= $temp1_jewelry_manthly_html;}
                                            $temp1_all_sorce = "<p class='title_a'>金額</p><div class='box1'>" . $temp1_title . $view . $all_sum_uriage . "</div>"/* . $uriage_progress*/;

                                        // 全期間全部門売上点数合計とその平均値のHTML作成
                                            if($all_sum_number_all <> 0){ 
                                                // 金額・全部門・全期間の平均を横軸合計から縦軸合計に変更
                                                    //$all_average2 = floor((int)$all_sum_number_all / $i);
                                                        if($out1_c == "ON"){
                                                            $all_average2 = (int)$jack_sum_number_ave2 + (int)$betty_sum_number_ave2 + (int)$jewelry_sum_number_ave2;
                                                        } else {
                                                            $all_average2 = (int)$jack_sum_number_ave2 + (int)$betty_sum_number_ave2;
                                                        }
                                            } else {
                                                $all_average2 = 0;
                                            }
                                            //$all_sum_number .= "<div class='title6 ta_r'>" . number_format((int)$all_sum_number_all) . "</div><div class='title6 ta_r'>" . $yoy_number_sum . "</div><div class='title6 ta_r'>" . number_format((int)$all_average2) . "</div></div>";
                                            $all_sum_number .= "<div class='title6 ta_r'>" . number_format((int)$all_sum_number_all) . "</div><div class='title6 ta_r'>" . number_format((int)$all_average2) . "</div></div>";
                                        // 全HTMLを合体（検索対象外は除く）
                                        
                                            $view2 = "";
                                            if($out1_a == "ON"){ $view2 .= $temp1_betty_manthly_html2;}
                                            if($out1_b == "ON"){ $view2 .= $temp1_jack_manthly_html2;}
                                            if($out1_c == "ON"){ $view2 .= $temp1_jewelry_manthly_html2;}
                                            $temp1_all_sorce2 = "<p class='title_a'>点数</p><div class='box1'>" . $temp1_title . $view2 . $all_sum_number . "</div>"/* . $number_progress*/;

                    /************************************************************************************************************************************************************************************************************* */
                        // DB情報の受け取り（検索期間） end
                    /************************************************************************************************************************************************************************************************************* */

                        // JSで表示させるための、期間売上などのデータを作成                    
                            if($out1_a == "ON"){$js_betty_uriage = substr($js_betty_uriage, 0, -2);} else {$js_betty_uriage = "";}
                            if($out1_b == "ON"){$js_jack_uriage = substr($js_jack_uriage, 0, -2);} else {$js_jack_uriage = "";}
                            if($out1_c == "ON"){$js_jewelry_uriage = substr($js_jewelry_uriage, 0, -2);} else {$js_jewelry_uriage = "";}
                            //if($js_month <> ""){$js_month = substr($js_month, 0, -1);} else {$js_month = "";}
                        // 列の横幅を列数によって可変させる
                            $line_width = 100 / ($diff_month + 4);
                            // 20230803
                            $line_width2 = 100 / ($diff_month + 1);

                            
                            if (PostRequest::has('brand_bumon_select')){ $brand_bumon_select = PostRequest::input('brand_bumon_select');} else {$brand_bumon_select = "";}
                            if (PostRequest::has('view_select')){ $view_select = PostRequest::input('view_select');} else {$view_select = "";}
                            return view($bladename,['view_select' => $view_select,'brand_bumon_select' => $brand_bumon_select,'first_day' => $first_day,'last_day' => $last_day,'next_year' => $next_year,'this_year' => $this_year,'last_year' => $last_year,'two_years_ago' => $two_years_ago,'three_years_ago' => $three_years_ago,'start_year' => $start_year,'start_month' => $start_month,'start_day' => $start_day,'end_year' => $end_year,'end_month' => $end_month,'end_day' => $end_day,'output' => $output,'form_view' => $form_view,'out1' => $out1,'out1_a' => $out1_a,'out1_b' => $out1_b,'out1_c' => $out1_c,'out1_c' => $out1_c,'out2_a' => $out2_a,'out2_b' => $out2_b,'out2_c' => $out2_c,'out3_a' => $out3_a,'out3_b' => $out3_b,'out3_c' => $out3_c,'temp1_all_sorce' => $temp1_all_sorce,'temp1_all_sorce2' => $temp1_all_sorce2,'js_jack_uriage' => $js_jack_uriage,'js_betty_uriage' => $js_betty_uriage,'js_jewelry_uriage' => $js_jewelry_uriage,'js_month' => $js_month,'past_between_start' => $past_between_start,'past_between_end' => $past_between_end,'past_temp1_all_sorce' => $past_temp1_all_sorce,'past_temp1_all_sorce2' => $past_temp1_all_sorce2,'past_js_jack_uriage' => $past_js_jack_uriage,'past_js_betty_uriage' => $past_js_betty_uriage,'past_js_jewelry_uriage' => $past_js_jewelry_uriage,'past_js_jack_number' => $past_js_jack_number,'past_js_betty_number' => $past_js_betty_number,'past_js_jewelry_number' => $past_js_jewelry_number,'js_jack_number' => $js_jack_number,'js_betty_number' => $js_betty_number,'js_jewelry_number' => $js_jewelry_number,'js_all_month_uriage' => $js_all_month_uriage,'js_past_all_month_uriage' => $js_past_all_month_uriage,'js_all_month_number' => $js_all_month_number,'js_past_all_month_number' => $js_past_all_month_number,'search' => $search,'line_width' => $line_width,'line_width2' => $line_width2,'temp1_all_sorce4' => $temp1_all_sorce4,'temp1_all_sorce5' => $temp1_all_sorce5,'temp1_all_sorce6' => $temp1_all_sorce6,'temp1_all_sorce7' => $temp1_all_sorce7,'temp1_all_sorce8' => $temp1_all_sorce8,'past_temp1_all_sorce4' => $past_temp1_all_sorce4,'past_temp1_all_sorce5' => $past_temp1_all_sorce5,'past_temp1_all_sorce6' => $past_temp1_all_sorce6,'jack_total_js2' => $jack_total_js2,'betty_total_js2' => $betty_total_js2,'jewelry_total_js2' => $jewelry_total_js2,'past_jack_total_js2' => $past_jack_total_js2,'past_betty_total_js2' => $past_betty_total_js2,'past_jewelry_total_js2' => $past_jewelry_total_js2,'jack_total_js3' => $jack_total_js3,'betty_total_js3' => $betty_total_js3,'jewelry_total_js3' => $jewelry_total_js3,'past_jack_total_js3' => $past_jack_total_js3,'past_betty_total_js3' => $past_betty_total_js3,'past_jewelry_total_js3' => $past_jewelry_total_js3,'uriage_progress_html' => $uriage_progress_html,'number_progress_html' => $number_progress_html]);
        
                }







}



