<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as PostRequest;

class AnalysisController extends Controller
{
        /************************************************************************************************************************************************************************************************************* */
            // 定数管理用メソッド
        /************************************************************************************************************************************************************************************************************* */
                public function define(){

                    $define = array();

                    // 本番 or テスト用フォルダの切り替え変数
                        //$change = "_test";
                        //$change2 = "test_";
                        $change = "";
                        $change2 = "";
                    
                        $bladename = "parts.analysis" . $change;
                        //$folda_name = "";
                        $file_pass = "../storage/app/public/csv/op/analysis" . $change . "/";
                        $file_pass2 = "public/csv/op/analysis" . $change . "/";
                        //$file_name = "uriage_data" . $change . ".csv";
                        $file_name = "data" . $change . ".csv";
                        //20240417$file_name2 = "data";
                        $file_name2 = "data" . $change;
                        $table_name = $change2 . "analysises";
                        $table_name2 = $change2 . "analysises2";

                        //$table_name2 = $change2 . "connection_ids";
                        //$table_name3 = $change2 . "connection_infos";
                        //$table_name4 = $change2 . "connection_info2s";
                        //$file_name2 = "get_id" . $change . ".csv";
                        //$file_name3 = "upload" . $change . ".csv";
                        
                        array_push($define,$bladename);
                        array_push($define,$file_pass);
                        array_push($define,$file_pass2);
                        array_push($define,$file_name);
                        array_push($define,$table_name);
                        array_push($define,$table_name2);
                        array_push($define,$file_name2);

                        return $define;

                }



        /************************************************************************************************************************************************************************************************************* */
            // 売り上げデータ登録ページの表示
        /************************************************************************************************************************************************************************************************************* */
                public function Analysis_view(Request $request){
                    
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
                                    if($def_i == 5){ $table_name2 = $def; }
                                    if($def_i == 6){ $file_name2 = $def; }
                                    $def_i++;
                                }
                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）end
                    /************************************************************************************************************************************************************************************************************* */
                    
                    // ページ表示時にフォルダ内のCSVを全削除（過去のファイルを参照する事故を防ぐ為かく、確実に現在アップしているものを扱うようにする）
                        $success = \File::cleanDirectory($file_pass);

                    // ページ表示時にテーブルの情報を削除
                        //\DB::table($table_name)->truncate();

                    return view($bladename);
                    
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
                                    if($def_i == 5){ $table_name2 = $def; }
                                    if($def_i == 6){ $file_name2 = $def; }

                                    $def_i++;
                                }
                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）end
                    /************************************************************************************************************************************************************************************************************* */
                    

                    if (PostRequest::get('csvup')) {
                        // アップロード用メソッドの実行
                            return $this->file_up($request);
                    } else if (PostRequest::get('db_insert')) {
                        // CSVデータをデータベースへ登録用メソッドの実行
                            return $this->db_insert($request);
                    } 
                }


        /************************************************************************************************************************************************************************************************************* */
            // CSVのアップロード START
        /************************************************************************************************************************************************************************************************************* */
                public function file_up(Request $request){

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
                                if($def_i == 5){ $table_name2 = $def; }
                                if($def_i == 6){ $file_name2 = $def; }

                                $def_i++;
                            }
                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）end
                    /************************************************************************************************************************************************************************************************************* */

                                $comment = "";
                                $error_comment = "";
                                $db_insert = "";
                                $up_file_name = "";
                                $up_file_name2 = "";
                                $up_file_name3 = "";
                                $up_file_name4 = "";
                            // ファイルのアップロード
                                if ($request->file('loadFileName')) {
                                    $up_file_name = $request->file("loadFileName")->getClientOriginalName();
                                    
                                    //20240217$request->file('loadFileName')->storeAs($file_pass2,$file_name);
                                    $request->file('loadFileName')->storeAs($file_pass2,$file_name2 . ".csv");
                                    $comment .= "<p>！！　ファイル1のアップロード終了　！！</p>";

                                    $db_insert = "ON";
                                }
                                if ($request->file('loadFileName2')) {
                                    $up_file_name2 = $request->file("loadFileName2")->getClientOriginalName();
                                    $request->file('loadFileName2')->storeAs($file_pass2,$file_name2 . "2.csv");
                                    $comment .= "<p>！！　ファイル2のアップロード終了　！！</p>";

                                    $db_insert = "ON";
                                }
                                if ($request->file('loadFileName3')) {
                                    $up_file_name3 = $request->file("loadFileName3")->getClientOriginalName();
                                    $request->file('loadFileName3')->storeAs($file_pass2,$file_name2 . "3.csv");
                                    $comment .= "<p>！！　ファイル3のアップロード終了　！！</p>";

                                    $db_insert = "ON";
                                }



                            // 元の画面を表示
                            return view($bladename,['db_insert'=>$db_insert,'comment'=>$comment,'error_comment'=>$error_comment,'up_file_name'=>$up_file_name,'up_file_name2'=>$up_file_name2,'up_file_name3'=>$up_file_name3]);

                }

        /************************************************************************************************************************************************************************************************************* */
            // CSVのアップロード END
        /************************************************************************************************************************************************************************************************************* */

        /************************************************************************************************************************************************************************************************************* */
            // CSVデータをデータベースへ登録用 START
        /************************************************************************************************************************************************************************************************************* */
                public function db_insert(Request $request){

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
                                    if($def_i == 5){ $table_name2 = $def; }
                                    if($def_i == 6){ $file_name2 = $def; }
        
                                    $def_i++;
                                }
                    /************************************************************************************************************************************************************************************************************* */
                        // 定数管理用（メソッドの呼び出し）end
                    /************************************************************************************************************************************************************************************************************* */
                    /************************************************************************************************************************************************************************************************************* */
                        // アップロードしたCSVを開いて中身をDBへ登録　start
                    /************************************************************************************************************************************************************************************************************* */

                            $error_comment = "";

                            for($iii = 0; $iii < 4; $iii++){
                                    if($iii == 0){ $iii = ""; }

                                    if (\File::exists($file_pass . $file_name2 . $iii . ".csv")) {

                                        $final_up_file_name = "up_file_name" . $iii;
                                        if (PostRequest::has($final_up_file_name)) {
                                            $final_up_file_name = PostRequest::input($final_up_file_name);
                                        }

                                        $final_up_file_name = str_replace("在庫_",'',$final_up_file_name);
                                        $final_up_file_name = str_replace(".csv",'',$final_up_file_name);
                                        $final_up_file_name = str_replace(".",'-',$final_up_file_name);
                                        $final_up_file_name = date('Ymd', strtotime('first day of ' . $final_up_file_name));


                                                // ファイルの読み込み
                                                    $file = new \SplFileObject(storage_path($file_pass . $file_name2 . $iii . ".csv"));
                                                    
                                                    $file->setFlags(
                                                    \SplFileObject::READ_CSV |           // CSV 列として行を読み込む
                                                    \SplFileObject::READ_AHEAD |       //z 先読み/巻き戻しで読み出す。
                                                    \SplFileObject::SKIP_EMPTY |         // 空行は読み飛ばす
                                                    \SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす
                                                    );
                                                
                                                // エスケープ処理
                                                    $file->setCsvControl(",", '"', "\"");

                                                // 読み込んだCSVデータをループ
                                                    $i = 0;
                                                    $stack = array();
                                                    $exsit_id_array = array();
                                                    $params = array();
                                                    $file_flag = "";
                                                    foreach ($file as $line) {

                                                        $ii = 0;
                                                        foreach ($line as $line2[$ii]) {

                                                            
                                                            // インサートする期間の開始日と終了日を変数に代入(この期間中のデータを一旦削除するため)
                                                                // 在庫登録用ファイルの場合
                                                                    if($i == 0 && $ii == 0){
                                                                        if(strpos($line2[$ii],'対象年月') !== false){
                                                                                $file_flag = "zaiko";
   
                                                                                \DB::table($table_name2)->where($table_name2 . '.date', $final_up_file_name)->delete();
                                                                            }
                                                                        
                
                                                                    }
                                                                // 売上登録用ファイルの場合
                                                                    if($i == 1 && $ii == 0){
                                                                        if(strpos($line2[$ii],'日付') !== false){
                                                                            $file_flag = "uriage";


                                                                                $line2[$ii] = str_replace('日付','',$line2[$ii]);
                                                                                $line2[$ii] = str_replace(':','',$line2[$ii]);
                                                                                $line2[$ii] = trim($line2[$ii]);

                                                                                $del_term = explode(" ～ ", $line2[$ii]);

                                                                                $del_term[0] = str_replace('年','/',$del_term[0]);
                                                                                $del_term[0] = str_replace('月','/',$del_term[0]);
                                                                                $del_term[0] = str_replace('日','',$del_term[0]);
                                                                                $del_term[1] = str_replace('年','/',$del_term[1]);
                                                                                $del_term[1] = str_replace('月','/',$del_term[1]);
                                                                                $del_term[1] = str_replace('日','',$del_term[1]);

                                                                                //echo $del_term[0] . "-" . $del_term[1] . "<br>";

                                                                            // データの削除（UPするデータの期間に、既に存在するデータを先に削除）
                                                                                \DB::table($table_name)->whereBetween($table_name . '.uriage', [$del_term[0], $del_term[1]])->delete();
                                                                                //\DB::table($table_name)->whereBetween($table_name . '.uriage', [$del_term[0], $del_term[1]])->truncate();

                                                                        }
                                                                        
                
                                                                    }


                                                                    if($file_flag == "zaiko"){

                                                                        if($ii == 17 && $i <> 0 && $i <> 1 && $i <> 2 && $i <> 3/* && $i <> 4*/ && $line2[4] <> ""){
                                                                            //echo $del_term;
                                                                                // データをインサート
                                                                                    // bulk insert（行毎にDBへアクセスするとタイムアウトしてしまうので、一旦配列へ代入し、ある程度たまったタイミングでまとめてDBへ登録する）
                                                                                    $params[] = [ 
                                                                                        'date' => $final_up_file_name,
                                                                                        'souko' => $line2[0],
                                                                                        'souko_name' => $line2[1],
                                                                                        'brand_id' => (int)$line2[2],
                                                                                        'brand_name' => $line2[3],
                                                                                        'shouhin' => (int)$line2[4],
                                                                                        'shouhin_name' => $line2[5],
                                                                                        'bumon' => $line2[6],
                                                                                        'shouhinkubunbunrui_name' => $line2[7],
                                                                                        'zengetsumizaikosuuryou' => (int)$line2[8],
                                                                                        'siiresuuryou' => (int)$line2[9],
                                                                                        'nyuukosuuryou' => (int)$line2[10],
                                                                                        'uriagesuuryou' => (int)$line2[11],
                                                                                        'shukkosuuryou' => (int)$line2[12],
                                                                                        'chouseisuuryou' => (int)$line2[13],
                                                                                        'tougetsumizaikosuuryou' => (int)$line2[14],
                                                                                        'zaikokingaku' => (int)str_replace(",","",$line2[15]),
                                                                                        'ref' => $line2[16],
                                                                                        'tag' => $line2[17],
                                                                                        'created_at' => now(),
                                                                                        'updated_at' => now()
                                                                                    ];

                                                                        }
                                                                    

                                                                    } else if($file_flag == "uriage"){
                                                                            if($ii == 95 && $i <> 0 && $i <> 1 && $i <> 2 && $i <> 3 && $line2[1] <> ""){

                                                                                //echo $line2[0] . "<br>";
                                                                                // データをインサート
                                                                                    // bulk insert（行毎にDBへアクセスするとタイムアウトしてしまうので、一旦配列へ代入し、ある程度たまったタイミングでまとめてDBへ登録する）
                                                                                    $params[] = [ 
                                                                                        'uriage' => $line2[0],
                                                                                        'shukka' => $line2[1],
                                                                                        'gamenkubun' => $line2[6],
                                                                                        'shouhin' => $line2[8],
                                                                                        'pname' => $line2[9],
                                                                                        'zeiritsukubun' => $line2[11],
                                                                                        'zeiritsu' => $line2[12],
                                                                                        'uriagesuu' => (int)str_replace(",","",$line2[13]),
                                                                                        'uriagetanka' => (int)str_replace(",","",$line2[15]),
                                                                                        'uriagekingaku' => (int)str_replace(",","",$line2[16]),
                                                                                        'genkatanka' => (int)str_replace(",","",$line2[18]),
                                                                                        'genkakingaku' => (int)str_replace(",","",$line2[19]),
                                                                                        'ararikingaku' => (int)str_replace(",","",$line2[20]),
                                                                                        'stuffname' => $line2[22],
                                                                                        'genkinkubun' => $line2[34],
                                                                                        'bumon' => (int)$line2[41],
                                                                                        'bumonmei' => $line2[44],
                                                                                        'baikyakukubun' => (int)$line2[45],
                                                                                        'tsuuhankubun' => (int)$line2[47],
                                                                                        'shouhinkubunbunruimei' => $line2[56],
                                                                                        'atsukaibumon' => (int)$line2[57],
                                                                                        'brand' => (int)$line2[59],
                                                                                        'brandname' => $line2[60],
                                                                                        'joudaitanka' => (int)str_replace(",","",$line2[78]),
                                                                                        'jancode' => (int)$line2[90],
                                                                                        'sirialno' => $line2[91],
                                                                                        'refno' => $line2[92],
                                                                                        'nebiki' => (int)str_replace(",","",$line2[93]),
                                                                                        'zeinukinebiki' => (int)str_replace(",","",$line2[94]),
                                                                                        'menzei' => $line2[95],
                                                                                        'created_at' => now(),
                                                                                        'updated_at' => now()
                                                                                    ];
                                                                                    //]);
                                                                                }

                                                                                
                                                                    }
                                                                // bulk insert（配列が300件たまる毎にまとめてDBへ登録）
                                                                    if($file_flag == "zaiko"){
                                                                        if (count($params) >= 1800) {
                                                                            if (isset($params)) {
                                                                                \DB::table($table_name2)->insert($params);
                                                                                $params = [];
                                                                            }
                                                                        }
                                                                    } else if($file_flag == "uriage"){
                                                                        if (count($params) >= 1800) {
                                                                            if (isset($params)) {
                                                                                \DB::table($table_name)->insert($params);
                                                                                $params = [];
                                                                            }
                                                                        }
                                                                    }

                                                                    $ii++;
                                                                    
                                                            }

                                                        //mb_convert_variables('sjis-win', 'UTF-8', $line);
                                                                            
                                                    $i++;
                                                    }
                                                    $count = count($params);

                                                    // 残り1000件を切った行を最後にデータベースへ登録
                                                        if($file_flag == "zaiko"){
                                                            if (isset($params)) {
                                                                \DB::table($table_name2)->insert($params);
                                                                $params = [];
                                                            }
                                                        } else if($file_flag == "uriage"){
                                                            if (isset($params)) {
                                                                \DB::table($table_name)->insert($params);
                                                                $params = [];
                                                            }
                                                        }


                                    } else { 
                                        //$error_comment .= "<p>" . $need_file_name1 . "ファイルがアップされていません！"; 
                                        $need_file_error1 = "ON";
                                    }



                            // ファイルがアップされていない状態でフォーム表示ボタン押下時のエラー
                                $Empty = (count(glob("../storage/app/public/csv/op/analysis/*")) === 0) ? 'Empty' : 'Not empty';

                                if ($Empty=="Empty"){
                                    echo "<p style='width:100%; height:100%;display: flex;align-items: center;justify-content: center;'><span style='height:2em; text-align:center;'>ファイルが一つもアップされていません！<br><a href=''>戻る</a></span></p>";
                                    exit;
                                } else {
                                    if($error_comment <> ""){
                                        echo "<p style='width:100%; height:100%;display: flex;align-items: center;justify-content: center;'><span style='height:2em; text-align:center;'>" . $error_comment . "<br><a href=''>戻る</a></span></p>";
                                        exit;
                                    }

                                }


                            }
                    /************************************************************************************************************************************************************************************************************* */
                        // アップロードしたCSVを開いて中身をDBへ登録　end
                    /************************************************************************************************************************************************************************************************************* */
                    
                    // フラグの作成
                        $search = "ON";
                        $comment = "<p>！！　DB登録終了　！！</p><p><a href=''>最初のページに戻る</a></p>";
                        $error_comment = "";

                    // 元の画面を表示
                        return view($bladename,['error_comment'=>$error_comment,'search'=>$search,'comment'=>$comment]);
                }

        /************************************************************************************************************************************************************************************************************* */
            // CSVデータをデータベースへ登録用 END
        /************************************************************************************************************************************************************************************************************* */




}
