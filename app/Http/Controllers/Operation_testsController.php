<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as PostRequest;
use App\Op_request_test; // 今回のDB用に作成した「Op_request_test.php」モデル(DB内容)を参照
//use App\Op_request; // 今回のDB用に作成した「Op_request.php」モデル(DB内容)を参照
use App\Models\Stuff_select; // 今回のDB用に作成した「Edit_stuffname.php」モデル(DB内容)を参照
use Illuminate\Support\Facades\DB;

class Operation_testsController extends Controller
//class OperationsController extends Controller
{


    public function bladename(){
        $bladename = "_test";
        //$bladename = "";
        return $bladename;
    }



/************************************************************************************************************************************************************************************************************* */
    // オペレーションページの表示
/************************************************************************************************************************************************************************************************************* */
    public function operationview(Request $request){
        // 20240913 二重送信を防ぐため token を再生成する
            $request->session()->regenerateToken();

        $bladename = $this->bladename();
        $bladename = 'parts.operation'.$bladename;
        
        $db_ok = "";
        //$stuff_select = $this->stuff_info_get($request,$db_ok);
        //return view('parts.operation',['stuff_select' => $stuff_select]);
        //return view('parts.operation');
        return view($bladename);
    }

/************************************************************************************************************************************************************************************************************* */
    // 押下されたボタン毎に処理（メソッド）を切り分け
/************************************************************************************************************************************************************************************************************* */
    public function btn_select(Request $request){
        // 20240913 二重送信を防ぐため token を再生成する
            $request->session()->regenerateToken();
            
            $bladename = $this->bladename();
            $bladename = 'parts.operation'.$bladename;

        // 使用するメソッドの切り分け
            if (PostRequest::get('idcheck') || PostRequest::get('return')) {
                // 商品チェック用メソッドの実行
                    return $this->id_check($request);
            } else if (PostRequest::get('info_check')) {
                // 旧データと依頼データ登録用メソッドの実行
                return $this->info_check($request);
            } else if (PostRequest::get('db_insert')) {
                // 旧データと依頼データ登録用メソッドの実行
                return $this->db_insert();
            }
            
        // 元の画面を表示
            //return view('parts.operation');
            return view($bladename);
    }

/************************************************************************************************************************************************************************************************************* */
    // ID送信ボタン(入力IDチェック)押下時の処理用
/************************************************************************************************************************************************************************************************************* */
    public function id_check(Request $request){
        // 20240913 二重送信を防ぐため token を再生成する
            $request->session()->regenerateToken();
            
            $db_ok = "";

        // 使用するメソッドの切り分け
            if (PostRequest::has('pid')) {

                // 入力されたIDを取得し、余計な情報を削除した上で変数に代入
                    $pid = PostRequest::input('pid');
                    $pid2 = str_replace("\r\n",",",$pid);
                    // 空白抜く
                        $pid2 = str_replace(array(" ", "　"), "", $pid2);
                    // 空の改行を抜く
                        $pid2 = str_replace(",,", ",", $pid2);
                    // 最後のカンマを取り除く
                        $pid2=RTrim($pid2,",");

                    // IDが何も入力されていない場合の対応
                        if($pid2 == ""){
                            $pid2 = "noid";
                        }

                // 担当者取得
                    $stuff = PostRequest::input('stuff');

                    $id_num = substr_count($pid2,",");
                    $id_num = $id_num + 1;
                    $num_limit = 120;
                    if($num_limit < $id_num){
                        //$check_comment = "<div class='comment'>一度の処理の上限は" . $num_limit . "件までです<p><a href='/operation'>元のページに戻る</a></p></div>";
                        $check_comment = "<div class='comment'>一度の処理の上限は" . $num_limit . "件までです<p><a href=''>元のページに戻る</a></p></div>";
                        return view('parts.operation_insert',['check_comment' => $check_comment]);
                    }

                // 重複チェック用
                    $pid2_array_check = array();
                    $pid2_array = explode(",",$pid2);

                // 各ID毎の情報をXMLから取得
                    $xml = "https://bo-wwwjackroadcojp.ecbeing.biz/services/api/goodslistapi.aspx?type=xml&charset=UTF-8&goods=" . $pid2;
                    //$xml = "http://stg.jackroad.co.jp/services/api/goodslistapi.aspx?goods=" . $pid2;


                    $xmlData = simplexml_load_file($xml);

                    // 変数作成
                        $i = 0;
                        $rec = "";
                        $rec2 = "";
                        $id_exist = array();
                        $no_exist = "";
                        $old_data = array();
                        $check_ok = "";

                    foreach($xmlData -> item as $data[$i]){

                            // XMLから取得した情報を変数に代入
                                $goods[$i] = $data[$i] -> goods = mb_convert_encoding($data[$i] -> goods, "UTF-8", "auto");
                                $brand[$i] = $data[$i] -> brand = mb_convert_encoding($data[$i] -> brand, "UTF-8", "auto");
                                $price[$i] = $data[$i] -> price = mb_convert_encoding($data[$i] -> price, "UTF-8", "auto");
                                $price_sale[$i] = $data[$i] -> price_sale = mb_convert_encoding($data[$i] -> price_sale, "UTF-8", "auto");
                                $status_flg[$i] = $data[$i] -> status_flg = mb_convert_encoding($data[$i] -> status_flg, "UTF-8", "auto");                  // 例：「イメージ撮影終了,価格.com」
                                $stock_condition[$i] = $data[$i] -> stock_condition = mb_convert_encoding($data[$i] -> stock_condition, "UTF-8", "auto");   // 例：「在庫あり」「SOLDOUT」
                                $status[$i] = $data[$i] -> status = mb_convert_encoding($data[$i] -> status, "UTF-8", "auto");                              // 例：0:通常　2:下書き　9:終息(削除)
                                $maker_price[$i] = $data[$i] -> maker_price = mb_convert_encoding($data[$i] -> maker_price, "UTF-8", "auto");               // 定価
                                $model[$i] = $data[$i] -> name = mb_convert_encoding($data[$i] -> name, "UTF-8", "auto");                                   // モデル名
                                $class[$i] = $data[$i] -> classification = mb_convert_encoding($data[$i] -> classification, "UTF-8", "auto");               // 新中アン
                                // 20220830
                                $src_s[$i] = $data[$i] -> src_s = mb_convert_encoding($data[$i] -> src_s, "UTF-8", "auto");                                 // S画像URL




                                // 20220523 終息の場合に「SOLDOUT」が選択される事への対応と「下書き」表示フラグ追加
                                    if($status[$i] == '9'){
                                        $stock_condition[$i] = '終息';
                                    }
                                    $shitagaki[$i] = "";
                                    if($status[$i] == '2'){
                                        $shitagaki[$i] = "(下書き)";
                                    }
                                    if(strpos($status_flg[$i],'OUTLET') !== false){
                                        $shitagaki[$i] .= "(OUTLET)";
                                    }


                             // 重複チェック用
                                $double = "OFF";
                                $double_check = 0;
                                foreach($pid2_array as $pid2_var){
                                    if($pid2_var == $goods[$i]){$double_check++;}
                                }
                                if($double_check > 1){
                                    $double = "ON";
                                }

                            // 商品存在確認用変数にIDを追加
                                array_push($id_exist,$goods[$i]);

                            // 今回取得した登録されている情報を配列に代入し、別メソッド(DBへのinsert)で使用する
                                $title[$i] = now() . "_" . $stuff;
                                //20220830 $old_data2[$i] = array('pid'=>$goods[$i],'title'=>$title[$i],'stuff'=>$stuff,'brand'=>$brand[$i],'model'=>$model[$i],'price'=>$price[$i],'price_sale'=>$price_sale[$i],'status_flg'=>$status_flg[$i],'stock_condition'=>$stock_condition[$i],'status'=>$status[$i],'maker_price'=>$maker_price[$i],'class'=>$class[$i],'shitagaki'=>$shitagaki[$i]);
                                $old_data2[$i] = array('pid'=>$goods[$i],'title'=>$title[$i],'stuff'=>$stuff,'brand'=>$brand[$i],'model'=>$model[$i],'price'=>$price[$i],'price_sale'=>$price_sale[$i],'status_flg'=>$status_flg[$i],'stock_condition'=>$stock_condition[$i],'status'=>$status[$i],'maker_price'=>$maker_price[$i],'class'=>$class[$i],'shitagaki'=>$shitagaki[$i],'src_s'=>$src_s[$i]);
                                array_push($old_data,$old_data2[$i]);


                            // 新データを取得(商品数が旧データと同じなので、旧データ取得の繰り返し文の中で実施)
                                ${"change_status_" . $i . "_" . $goods[$i]} = "change_status_" . $i . "_" . $goods[$i];
                                ${"change_status_" . $i . "_" . $goods[$i]} = PostRequest::input(${"change_status_" . $i . "_" . $goods[$i]});
        
                                ${"change_price_" . $i . "_" . $goods[$i]} = "change_price_" . $i . "_" . $goods[$i];
                                ${"change_price_" . $i . "_" . $goods[$i]} = PostRequest::input(${"change_price_" . $i . "_" . $goods[$i]});
        
                                ${"change_price_sale_" . $i . "_" . $goods[$i]} = "change_price_sale_" . $i . "_" . $goods[$i];
                                ${"change_price_sale_" . $i . "_" . $goods[$i]} = PostRequest::input(${"change_price_sale_" . $i . "_" . $goods[$i]});
        
                                ${"change_maker_price_" . $i . "_" . $goods[$i]} = "change_maker_price_" . $i . "_" . $goods[$i];
                                ${"change_maker_price_" . $i . "_" . $goods[$i]} = PostRequest::input(${"change_maker_price_" . $i . "_" . $goods[$i]});
        
                                ${"cancel_" . $i . "_" . $goods[$i]} = "cancel_" . $i . "_" . $goods[$i];
                                ${"cancel_" . $i . "_" . $goods[$i]} = PostRequest::input(${"cancel_" . $i . "_" . $goods[$i]});
                                ${"sale_d_" . $i . "_" . $goods[$i]} = "sale_d_" . $i . "_" . $goods[$i];
                                ${"sale_d_" . $i . "_" . $goods[$i]} = PostRequest::input(${"sale_d_" . $i . "_" . $goods[$i]});
                                ${"pricedown_" . $i . "_" . $goods[$i]} = "pricedown_" . $i . "_" . $goods[$i];
                                ${"pricedown_" . $i . "_" . $goods[$i]} = PostRequest::input(${"pricedown_" . $i . "_" . $goods[$i]});
        

                            // UI表示用のHTMLを作成(現データ)
                                if($stock_condition[$i] == "在庫あり"){ $status_selected1[$i] = "selected"; } else { $status_selected1[$i] = ""; }
                                if($stock_condition[$i] == "商談中"){ $status_selected2[$i] = "selected"; } else { $status_selected2[$i] = ""; }
                                if($stock_condition[$i] == "申し込み"){ $status_selected3[$i] = "selected"; } else { $status_selected3[$i] = ""; }
                                if($stock_condition[$i] == "SOLDOUT"){ $status_selected4[$i] = "selected"; } else { $status_selected4[$i] = ""; }
                                if($stock_condition[$i] == "終息"){ $status_selected5[$i] = "selected"; } else { $status_selected5[$i] = ""; }
                                $select_status[$i] = "<option value='在庫あり' " . $status_selected1[$i] . ">在庫あり</option>";
                                $select_status[$i] .= "<option value='商談中' " . $status_selected2[$i] . ">商談中</option>";
                                $select_status[$i] .= "<option value='申し込み' " . $status_selected3[$i] . ">申し込み</option>";
                                $select_status[$i] .= "<option value='SOLDOUT' " . $status_selected4[$i] . ">SOLDOUT</option>";
                                $select_status[$i] .= "<option value='終息' " . $status_selected5[$i] . ">終息</option>";
                            
                            // UI表示用のHTMLを作成(新データ)
                                if(${"change_status_" . $i . "_" . $goods[$i]} == "在庫あり"){ ${"status_selected1_" . $i . "_" . $goods[$i]} = "selected"; } else { ${"status_selected1_" . $i . "_" . $goods[$i]} = ""; }
                                if(${"change_status_" . $i . "_" . $goods[$i]} == "商談中"){ ${"status_selected2_" . $i . "_" . $goods[$i]} = "selected"; } else { ${"status_selected2_" . $i . "_" . $goods[$i]} = ""; }
                                if(${"change_status_" . $i . "_" . $goods[$i]} == "申し込み"){ ${"status_selected3_" . $i . "_" . $goods[$i]} = "selected"; } else { ${"status_selected3_" . $i . "_" . $goods[$i]} = ""; }
                                if(${"change_status_" . $i . "_" . $goods[$i]} == "SOLDOUT"){ ${"status_selected4_" . $i . "_" . $goods[$i]} = "selected"; } else { ${"status_selected4_" . $i . "_" . $goods[$i]} = ""; }
                                if(${"change_status_" . $i . "_" . $goods[$i]} == "終息"){ ${"status_selected5_" . $i . "_" . $goods[$i]} = "selected"; } else { ${"status_selected5_" . $i . "_" . $goods[$i]} = ""; }
                                ${"select_status_" . $i . "_" . $goods[$i]} = "<option value='在庫あり' " . ${"status_selected1_" . $i . "_" . $goods[$i]} . ">在庫あり</option>";
                                ${"select_status_" . $i . "_" . $goods[$i]} .= "<option value='商談中' " . ${"status_selected2_" . $i . "_" . $goods[$i]} . ">商談中</option>";
                                ${"select_status_" . $i . "_" . $goods[$i]} .= "<option value='申し込み' " . ${"status_selected3_" . $i . "_" . $goods[$i]} . ">申し込み</option>";
                                ${"select_status_" . $i . "_" . $goods[$i]} .= "<option value='SOLDOUT' " . ${"status_selected4_" . $i . "_" . $goods[$i]} . ">SOLDOUT</option>";
                                ${"select_status_" . $i . "_" . $goods[$i]} .= "<option value='終息' " . ${"status_selected5_" . $i . "_" . $goods[$i]} . ">終息</option>";

                            // デフォルトの状態は旧状態と一緒にする
                                if(empty(${"change_status_" . $i . "_" . $goods[$i]})){${"select_status_" . $i . "_" . $goods[$i]} = $select_status[$i]; }
        
                            // 現在データに「セール価格」と「定価」が無い場合とある場合の表示用
                                if($price_sale[$i] == ""){
                                    $price_sale2[$i] = "なし";
                                } else {
                                    $price_sale2[$i] = number_format((float)$price_sale[$i]);
                                }
                                if($maker_price[$i] == ""){
                                    $maker_price2[$i] = "なし";
                                } else {
                                    $maker_price2[$i] = number_format((float)$maker_price[$i]);
                                }

                            // キャンセル用チェックボックスにフラグがある場合にチェックを表示
                                if(${"cancel_" . $i . "_" . $goods[$i]} == "ON"){
                                    ${"cancel2_" . $i . "_" . $goods[$i]} = " checked";
                                } else {
                                    ${"cancel2_" . $i . "_" . $goods[$i]} = "";
                                }
                            // セール外し用チェックボックスにフラグがある場合にチェックを表示
                                if(${"sale_d_" . $i . "_" . $goods[$i]} == "ON"){
                                    ${"sale_d2_" . $i . "_" . $goods[$i]} = " checked";
                                } else {
                                    ${"sale_d2_" . $i . "_" . $goods[$i]} = "";
                                }
                            // プライスダウン外し用チェックボックスにフラグがある場合にチェックを表示
                                if(${"pricedown_" . $i . "_" . $goods[$i]} == "ON"){
                                    ${"pricedown2_" . $i . "_" . $goods[$i]} = " checked";
                                } else {
                                    ${"pricedown2_" . $i . "_" . $goods[$i]} = "";
                                }


                            // 表示用ソースの作成
                                $model2[$i] = mb_strimwidth( $model[$i], 0, 25, '…', 'UTF-8' );
                                $brand2[$i] = mb_strimwidth( $brand[$i], 0, 25, '…', 'UTF-8' );

                            // クラス名表示用
                                if($class[$i] == "新品"){
                                    $class2[$i] = "<span class='class1'>N・</span>";
                                } else if($class[$i] == "中古"){
                                    $class2[$i] = "<span class='class2'>U・</span>";
                                } else if($class[$i] == "アンティーク"){
                                    $class2[$i] = "<span class='class3'>A・</span>";
                                }
                            
                            // 重複用クラス
                                if($double == "ON"){ $double_class = " double";} else { $double_class = "";}

                            // 依頼ID送信ボタン押下時
                                // 通常の個別入力ID用フォームの表示
                                    // 現在情報表示フォーム
                                        $rec .= "<ul class='default'><li class='parts'>現在データ</li><li class='parts'>" . $class2[$i] . $goods[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'>" . $stock_condition[$i] . $shitagaki[$i] . "</li><li class='parts'>" . number_format((float)$price[$i]) . "</li><li class='parts'>" . $price_sale2[$i] . "</li><li class='parts'>" . $maker_price2[$i] . "</li><li>---</li><li>---</li><li>---</li></ul>";
                                    // 変更依頼登録用フォーム
                                        $rec .= "<ul class='change " . $double_class . "' id='" . ($i + 1) . "'><li class='parts'>変更依頼 [ " . ($i + 1) . " ]</li><li class='parts'>" . $class2[$i] . $goods[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'><select class='select1' name='change_status_" . $i . "_" . $goods[$i] . "'>" . ${"select_status_" . $i . "_" . $goods[$i]} . "</select></li><li class='parts'><input type='text' name='change_price_" . $i . "_" . $goods[$i] . "' class='price input_number_only' value='" . ${"change_price_" . $i . "_" . $goods[$i]} . "'></li><li class='parts'><input type='text' name='change_price_sale_" . $i . "_" . $goods[$i] . "' class='price input_number_only' value='" . ${"change_price_sale_" . $i . "_" . $goods[$i]} . "'></li><li class='parts'><input type='text' name='change_maker_price_" . $i . "_" . $goods[$i] . "' class='price input_number_only' value='" . ${"change_maker_price_" . $i . "_" . $goods[$i]} . "'></li><li><input type='checkbox' value='ON' name='sale_d_" . $i . "_" . $goods[$i] . "' ". ${"sale_d2_" . $i . "_" . $goods[$i]} . "></li><li><input type='checkbox' value='ON' name='pricedown_" . $i . "_" . $goods[$i] . "' ". ${"pricedown2_" . $i . "_" . $goods[$i]} . "></li><li><input type='checkbox' value='ON' name='cancel_" . $i . "_" . $goods[$i] . "' ". ${"cancel2_" . $i . "_" . $goods[$i]} . "></li></ul><input type='hidden' value='" . $double . "' name='double_" . $i . "_" . $goods[$i] . "'>";
                                // DB登録ボタン表示後のフォーム表示用（セレクトボタンを変更されないようにする）
                                    /* 「入力内容チェックボタン押下時」に作成するソース。ID送信時には必要ないはずなので撤去
                                    // 現在情報表示フォーム
                                        $rec2 .= "<ul class='default'><li class='parts'>現在データ</li><li class='parts'>" . $class2[$i] . $goods[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'>" . $stock_condition[$i] . $shitagaki[$i] . "</li><li class='parts'>" . number_format((float)$price[$i]) . "</li><li class='parts'>" . $price_sale2[$i] . "</li><li class='parts'>" . $maker_price2[$i] . "</li><li>---</li><li>---</li><li>---</li></ul>";
                                    // 変更依頼登録用フォーム（変更不可）
                                        $rec2 .= "<ul class='change " . $double_class . "' id='" . ($i + 1) . "'><li class='parts'>変更依頼 [ " . ($i + 1) . " ]</li><li class='parts'>" . $class2[$i] . $goods[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'><select class='select1' name='change_status_" . $i . "_" . $goods[$i] . "'><option value='" . ${"change_status_" . $i . "_" . $goods[$i]} . "'>" . ${"change_status_" . $i . "_" . $goods[$i]} . "</option></select></li><li class='parts'><input type='text' name='change_price_" . $i . "_" . $goods[$i] . "' class='price input_number_only' value='" . ${"change_price_" . $i . "_" . $goods[$i]} . "'></li><li class='parts'><input type='text' name='change_price_sale_" . $i . "_" . $goods[$i] . "' class='price input_number_only' value='" . ${"change_price_sale_" . $i . "_" . $goods[$i]} . "'></li><li class='parts'><input type='text' name='change_maker_price_" . $i . "_" . $goods[$i] . "' class='price input_number_only' value='" . ${"change_maker_price_" . $i . "_" . $goods[$i]} . "'></li><li><input type='checkbox' value='ON' name='sale_d_" . $i . "_" . $goods[$i] . "' ". ${"sale_d2_" . $i . "_" . $goods[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='pricedown_" . $i . "_" . $goods[$i] . "' ". ${"pricedown2_" . $i . "_" . $goods[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='cancel_" . $i . "_" . $goods[$i] . "' ". ${"cancel2_" . $i . "_" . $goods[$i]} . " onclick='return false;'></li></ul><input type='hidden' value='" . $double . "' name='double_" . $i . "_" . $goods[$i] . "'>";
                                    */
                            $i++;
                    }

            }


            // 存在しないIDを配列に追加し、ソースにも追記（チェック時のエラーでメッセージを表示し、キャンセルで回避するような仕様にしたい）        
                // IDの存在チェック用
                    $id_check = explode(',',$pid2);

                    foreach($id_check as $val){
                        if(in_array($val,$id_exist,true)){
                        } else {
                            // 商品存在確認用変数にIDを追加
                                $no_data = array('pid'=>$val,'title'=>'noid','stuff'=>'','brand'=>'','model'=>'','price'=>'','price_sale'=>'','status_flg'=>'','stock_condition'=>'','status'=>'','maker_price'=>'','shitagaki'=>'','shitagaki'=>'');
                            array_push($old_data,$no_data);
                            // 存在しないIDのフォーム表示用
                                $rec .= "<ul class='default'><li class='parts'>IDが存在しない</li><li class='parts'>" . $val . "</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li>---</li></ul>";
                                $rec .= "<ul class='change'><li class='parts'>IDが存在しない</li><li class='parts'>" . $val . "</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li><input type='checkbox' value='ON' name='cancel" . $val. "' ></li></ul>";
                                $rec2 .= "<ul class='default'><li class='parts'>IDが存在しない</li><li class='parts'>" . $val . "</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li>---</li></ul>";
                                $rec2 .= "<ul class='change'><li class='parts'>IDが存在しない</li><li class='parts'>" . $val . "</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li><input type='checkbox' value='ON' name='cancel" . $val. "' onclick='return false;'></li></ul>";
                        }
                    }

            // 別メソッドで使用する為、取得した情報配列の変数をセッションで保存
                session()->put('old_data', $old_data);

            // 選択されたスタッフ名を取得
                $stuff_name = $this->stuff_name_get($stuff);

            // チェック結果をビューに渡す
                $bladename = $this->bladename();
                $bladename = 'parts.operation'.$bladename;
            
                if($no_exist == ""){ $check_ok = "ON";}
                //return view('parts.operation',['rec' => $rec,'rec2' => $rec2,'pid' => $pid,'stuff' => $stuff,'check_ok' => $check_ok,'stuff_name' => $stuff_name]);
                return view($bladename,['rec' => $rec,'rec2' => $rec2,'pid' => $pid,'stuff' => $stuff,'check_ok' => $check_ok,'stuff_name' => $stuff_name]);
    }



/************************************************************************************************************************************************************************************************************* */
    // 入力内容チェックボタン押下時の処理用
/************************************************************************************************************************************************************************************************************* */

    public function info_check(Request $request){

        // 旧データの取得
            $old_data = $request->session()->get('old_data');

        // 変数初期化
            $i = 0;
            $error_nochange_text = "";
            $pid2 = "";
            $rec = "";
            $rec2 = "";
            $finush = array();
            $check_comment = "";
            $check = "";
            $db_ok = "";
            $check_ok = "ON";
            $check_ng = "";
            $confirm = "";
            $stuff_input = "OFF";


            // 20220626
                $noid_com = "";
                $noid_flag = "";
                
        // 旧データを取得
            foreach($old_data as $value){
                //print_r($value) . "<br>";

                // 変数初期化
                    ${"input_check" .$i} = "OFF";
                    ${"error_flug" .$i} = "OFF";
                    $title[$i] = "";
                    
                foreach($value as $key[$i] => $value[$i]){

                        // 旧データ変数代入
                            if($key[$i] == "pid"){ $pid[$i] = $value[$i]; }
                            if($key[$i] == "title"){ $title[$i] = $value[$i]; }
                            if($key[$i] == "brand"){ $brand[$i] = $value[$i]; }
                            if($key[$i] == "model"){ $model[$i] = $value[$i]; }
                            if($key[$i] == "price"){ $price[$i] = $value[$i]; }
                            if($key[$i] == "price_sale"){ if($value[$i] !=""){ $price_sale[$i] = $value[$i]; } else { $price_sale[$i] = null;}}
                            if($key[$i] == "status_flg"){ if($value[$i] !=""){ $status_flg[$i] = $value[$i]; } else { $status_flg[$i] = null;}}
                            if($key[$i] == "stock_condition"){ if($value[$i] !=""){ $stock_condition[$i] = $value[$i]; } else { $stock_condition[$i] = null;}}
                            if($key[$i] == "status"){ if($value[$i] !=""){ $status[$i] = $value[$i]; } else { $status[$i] = null;}}
                            if($key[$i] == "maker_price"){ if($value[$i] !=""){ $maker_price[$i] = $value[$i]; } else { $maker_price[$i] = null;}}
                            if($key[$i] == "class"){ if($value[$i] !=""){ $class[$i] = $value[$i]; } else { $class[$i] = null;}}
                            if($key[$i] == "shitagaki"){ if($value[$i] !=""){ $shitagaki[$i] = $value[$i]; } else { $shitagaki[$i] = null;}}
                            // 20220830
                            if($key[$i] == "src_s"){ if($value[$i] !=""){ $src_s[$i] = $value[$i]; } else { $src_s[$i] = null;}}
                  
                }

                // 新データを取得(商品数が旧データと同じなので、旧データ取得の繰り返し文の中で実施)
                    $stuff = PostRequest::input("stuff");
                
        // 20220626 チェックボタン押下時に存在しないIDが混ざっているとエラーとなるため
            if($title[$i] !="noid"){
                        // 20220626 一つでもIDが存在すればフラグを立てる（入力したIDが全て存在しない場合でも送信ボタンを表示させるのを回避するため）
                            $noid_flag = "ON";

                    
                        ${"change_status_" . $i . "_" . $pid[$i]} = "change_status_" . $i . "_" . $pid[$i];
                        ${"change_status_" . $i . "_" . $pid[$i]} = PostRequest::input(${"change_status_" . $i . "_" . $pid[$i]});

                        ${"change_price_" . $i . "_" . $pid[$i]} = "change_price_" . $i . "_" . $pid[$i];
                        ${"change_price_" . $i . "_" . $pid[$i]} = PostRequest::input(${"change_price_" . $i . "_" . $pid[$i]});

                        ${"change_price_sale_" . $i . "_" . $pid[$i]} = "change_price_sale_" . $i . "_" . $pid[$i];
                        ${"change_price_sale_" . $i . "_" . $pid[$i]} = PostRequest::input(${"change_price_sale_" . $i . "_" . $pid[$i]});

                        ${"change_maker_price_" . $i . "_" . $pid[$i]} = "change_maker_price_" . $i . "_" . $pid[$i];
                        ${"change_maker_price_" . $i . "_" . $pid[$i]} = PostRequest::input(${"change_maker_price_" . $i . "_" . $pid[$i]});

                        ${"cancel_" . $i . "_" . $pid[$i]} = "cancel_" . $i . "_" . $pid[$i];
                        ${"cancel_" . $i . "_" . $pid[$i]} = PostRequest::input(${"cancel_" . $i . "_" . $pid[$i]});

                        ${"sale_d_" . $i . "_" . $pid[$i]} = "sale_d_" . $i . "_" . $pid[$i];
                        ${"sale_d_" . $i . "_" . $pid[$i]} = PostRequest::input(${"sale_d_" . $i . "_" . $pid[$i]});

                        ${"pricedown_" . $i . "_" . $pid[$i]} = "pricedown_" . $i . "_" . $pid[$i];
                        ${"pricedown_" . $i . "_" . $pid[$i]} = PostRequest::input(${"pricedown_" . $i . "_" . $pid[$i]});

                    // 重複用フラグの追加
                        ${"double_" . $i . "_" . $pid[$i]} = "double_" . $i . "_" . $pid[$i];
                        ${"double_" . $i . "_" . $pid[$i]} = PostRequest::input(${"double_" . $i . "_" . $pid[$i]});
                        
                
                    // エラーチェック

                        // キャンセルフラグにチェックが入っている場合はエラーをスルー
                            if(${"cancel_" . $i . "_" . $pid[$i]} != "ON"){

                                // エラーチェック用メソッドの呼び出し（当メソッドで取得したデータを渡して処理してもらう）
                                    // 20220830
                                    //$change_check = $this->change_check($i,$pid[$i],${"change_status_" . $i . "_" . $pid[$i]},${"change_price_" . $i . "_" . $pid[$i]},${"change_price_sale_" . $i . "_" . $pid[$i]},${"change_maker_price_" . $i . "_" . $pid[$i]},$stock_condition[$i],$price[$i],$price_sale[$i],$maker_price[$i],$error_nochange_text,${"input_check" .$i},$title[$i],${"sale_d_" . $i . "_" . $pid[$i]},$status[$i],$status_flg[$i],$class[$i],${"double_" . $i . "_" . $pid[$i]},${"pricedown_" . $i . "_" . $pid[$i]});
                                    $change_check = $this->change_check($i,$pid[$i],${"change_status_" . $i . "_" . $pid[$i]},${"change_price_" . $i . "_" . $pid[$i]},${"change_price_sale_" . $i . "_" . $pid[$i]},${"change_maker_price_" . $i . "_" . $pid[$i]},$stock_condition[$i],$price[$i],$price_sale[$i],$maker_price[$i],$error_nochange_text,${"input_check" .$i},$title[$i],${"sale_d_" . $i . "_" . $pid[$i]},$status[$i],$status_flg[$i],$class[$i],${"double_" . $i . "_" . $pid[$i]},${"pricedown_" . $i . "_" . $pid[$i]},$src_s[$i]);

                                    $error_nochange_text = $change_check['error_nochange_text'];
                                    ${"input_check" .$i} = $change_check['input_check'];

                            }

                        // 間違い防止用確認メソッドの呼び出し（当メソッドで取得したデータを渡して処理してもらう）
                            $confirm_check = $this->confirm_check($i,$pid[$i],$price[$i],$price_sale[$i],$maker_price[$i],${"change_price_" . $i . "_" . $pid[$i]},${"change_price_sale_" . $i . "_" . $pid[$i]},${"change_maker_price_" . $i . "_" . $pid[$i]},$status_flg[$i],${"double_" . $i . "_" . $pid[$i]},$class[$i],${"change_status_" . $i . "_" . $pid[$i]});
                            $confirm .= $confirm_check['confirm'];

                    
                    // エラーの際の作業やり直しの為の入力した値を含めたUIを再構築
                        $pid2 .= $pid[$i] . "\n";

                        if(${"change_status_" . $i . "_" . $pid[$i]} == "在庫あり"){ ${"status_selected1".$pid[$i]} = "selected"; } else { ${"status_selected1".$pid[$i]} = ""; }
                        if(${"change_status_" . $i . "_" . $pid[$i]} == "商談中"){ ${"status_selected2".$pid[$i]} = "selected"; } else { ${"status_selected2".$pid[$i]} = ""; }
                        if(${"change_status_" . $i . "_" . $pid[$i]} == "申し込み"){ ${"status_selected3".$pid[$i]} = "selected"; } else { ${"status_selected3".$pid[$i]} = ""; }
                        if(${"change_status_" . $i . "_" . $pid[$i]} == "SOLDOUT"){ ${"status_selected4".$pid[$i]} = "selected"; } else { ${"status_selected4".$pid[$i]} = ""; }
                        if(${"change_status_" . $i . "_" . $pid[$i]} == "終息"){ ${"status_selected5".$pid[$i]} = "selected"; } else { ${"status_selected5".$pid[$i]} = ""; }
                        ${"select_status".$pid[$i]} = "<option value='在庫あり' " . ${"status_selected1".$pid[$i]} . ">在庫あり</option>";
                        ${"select_status".$pid[$i]} .= "<option value='商談中' " . ${"status_selected2".$pid[$i]} . ">商談中</option>";
                        ${"select_status".$pid[$i]} .= "<option value='申し込み' " . ${"status_selected3".$pid[$i]} . ">申し込み</option>";
                        ${"select_status".$pid[$i]} .= "<option value='SOLDOUT' " . ${"status_selected4".$pid[$i]} . ">SOLDOUT</option>";
                        ${"select_status".$pid[$i]} .= "<option value='終息' " . ${"status_selected5".$pid[$i]} . ">終息</option>";

                    // 現在データに「セール価格」と「定価」が無い場合とある場合の表示用
                        if($price_sale[$i] == ""){
                            $price_sale2[$i] = "なし";
                        } else {
                            $price_sale2[$i] = number_format((float)$price_sale[$i]);
                        }
                        if($maker_price[$i] == ""){
                            $maker_price2[$i] = "なし";
                        } else {
                            $maker_price2[$i] = number_format((float)$maker_price[$i]);
                        }

                    // キャンセル用チェックボックスにフラグがある場合にチェックを表示
                        if(${"cancel_" . $i . "_" . $pid[$i]} == "ON"){
                            ${"cancel2_" . $i . "_" . $pid[$i]} = " checked";
                        } else {
                            ${"cancel2_" . $i . "_" . $pid[$i]} = "";
                        }
 
                    // セール外し用チェックボックスにフラグがある場合にチェックを表示
                        if(${"sale_d_" . $i . "_" . $pid[$i]} == "ON"){
                            ${"sale_d2_" . $i . "_" . $pid[$i]} = " checked";
                        } else {
                            ${"sale_d2_" . $i . "_" . $pid[$i]} = "";
                        }

                    // プライスダウン外し用チェックボックスにフラグがある場合にチェックを表示
                        if(${"pricedown_" . $i . "_" . $pid[$i]} == "ON"){
                            ${"pricedown2_" . $i . "_" . $pid[$i]} = " checked";
                        } else {
                            ${"pricedown2_" . $i . "_" . $pid[$i]} = "";
                        }
                        
                    // 表示用ソースの作成
                        $model2[$i] = mb_strimwidth( $model[$i], 0, 25, '…', 'UTF-8' );
                        $brand2[$i] = mb_strimwidth( $brand[$i], 0, 25, '…', 'UTF-8' );
                    // クラス名表示用
                        if($class[$i] == "新品"){
                            $class2[$i] = "<span class='class1'>N・</span>";
                        } else if($class[$i] == "中古"){
                            $class2[$i] = "<span class='class2'>U・</span>";
                        } else if($class[$i] == "アンティーク"){
                            $class2[$i] = "<span class='class3'>A・</span>";
                        }
                    // 重複用クラス
                        if(${"double_" . $i . "_" . $pid[$i]} == "ON"){ $double_class = " double";} else { $double_class = "";}
                        
                        if($title[$i] != "noid"){

                            // 入力内容チェックボタン押下時
                                // 通常の個別入力ID用フォームの表示
                                    // 現在情報表示フォーム
                                        $rec .= "<ul class='default'><li class='parts'>現在データ</li><li class='parts'>" . $class2[$i] . $pid[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'>" . $stock_condition[$i] . $shitagaki[$i] . "</li><li class='parts'>" . number_format((float)$price[$i]) . "</li><li class='parts'>" . $price_sale2[$i] . "</li><li class='parts'>" . $maker_price2[$i] . "</li><li class='parts'>---</li><li>---</li><li>---</li></ul>";
                                    // 変更依頼登録用フォーム
                                        $rec .= "<ul class='change " . $double_class . "' id='" . ($i + 1) . "'><li class='parts'>変更依頼 [ " . ($i + 1) . " ]</li><li class='parts'>" . $class2[$i] . $pid[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'><select class='select1' name='change_status_" . $i . "_" . $pid[$i] . "'>" . ${"select_status".$pid[$i]} . "</select></li><li class='parts'><input type='text' name='change_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_price_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_price_sale_" . $i . "_" . $pid[$i] . "' class='price input_number_only'  value='" . ${"change_price_sale_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_maker_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_maker_price_" . $i . "_" . $pid[$i]} . "'></li><li><input type='checkbox' value='ON' name='sale_d_" . $i . "_" . $pid[$i] . "' ". ${"sale_d2_" . $i . "_" . $pid[$i]} . "></li><li><input type='checkbox' value='ON' name='pricedown_" . $i . "_" . $pid[$i] . "' ". ${"pricedown2_" . $i . "_" . $pid[$i]} . "></li><li><input type='checkbox' value='ON' name='cancel_" . $i . "_" . $pid[$i] . "' ". ${"cancel2_" . $i . "_" . $pid[$i]} . "></li></ul><input type='hidden' value='" . ${"double_" . $i . "_" . $pid[$i]} . "' name='double_" . $i . "_" . $pid[$i] . "'>";
                                // DB登録ボタン表示後のフォーム表示用（セレクトボタンを変更されないようにする）
                                    // 現在情報表示フォーム
                                        $rec2 .= "<ul class='default'><li class='parts'>現在データ</li><li class='parts'>" . $class2[$i] . $pid[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'>" . $stock_condition[$i] . $shitagaki[$i] . "</li><li class='parts'>" . number_format((float)$price[$i]) . "</li><li class='parts'>" . $price_sale2[$i] . "</li><li class='parts'>" . $maker_price2[$i] . "</li><li class='parts'>---</li><li>---</li><li>---</li></ul>";
                                    // 変更依頼登録用フォーム（変更不可）
                                            // $rec2 .= "<ul class='change " . $double_class . "' id='" . ($i + 1) . "'><li class='parts'>変更依頼 [ " . ($i + 1) . " ]</li><li class='parts'>" . $pid[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'><select class='select1' name='change_status_" . $i . "_" . $pid[$i] . "'><option value='" . ${"change_status_" . $i . "_" . $pid[$i]} . "'>" . ${"change_status_" . $i . "_" . $pid[$i]} . "</option></select></li><li class='parts'><input type='text' name='change_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_price_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_maker_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_maker_price_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_price_sale_" . $i . "_" . $pid[$i] . "' class='price input_number_only'  value='" . ${"change_price_sale_" . $i . "_" . $pid[$i]} . "'></li><li><input type='checkbox' value='ON' name='sale_d_" . $i . "_" . $pid[$i] . "' ". ${"sale_d2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='pricedown_" . $i . "_" . $pid[$i] . "' ". ${"pricedown2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='cancel_" . $i . "_" . $pid[$i] . "' ". ${"cancel2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li></ul><input type='hidden' value='" . ${"double_" . $i . "_" . $pid[$i]} . "' name='double_" . $i . "_" . $pid[$i] . "'>";
                                        // チェックボタン押下後もキャンセルのみ出来るよう変更
                                            // $rec2 .= "<ul class='change " . $double_class . "' id='" . ($i + 1) . "'><li class='parts'>変更依頼 [ " . ($i + 1) . " ]</li><li class='parts'>" . $class2[$i] . $pid[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'><select class='select1' name='change_status_" . $i . "_" . $pid[$i] . "'><option value='" . ${"change_status_" . $i . "_" . $pid[$i]} . "'>" . ${"change_status_" . $i . "_" . $pid[$i]} . "</option></select></li><li class='parts'><input type='text' name='change_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_price_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_price_sale_" . $i . "_" . $pid[$i] . "' class='price input_number_only'  value='" . ${"change_price_sale_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_maker_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_maker_price_" . $i . "_" . $pid[$i]} . "'></li><li><input type='checkbox' value='ON' name='sale_d_" . $i . "_" . $pid[$i] . "' ". ${"sale_d2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='pricedown_" . $i . "_" . $pid[$i] . "' ". ${"pricedown2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='cancel_" . $i . "_" . $pid[$i] . "' ". ${"cancel2_" . $i . "_" . $pid[$i]} . "></li></ul><input type='hidden' value='" . ${"double_" . $i . "_" . $pid[$i]} . "' name='double_" . $i . "_" . $pid[$i] . "'>";
                                        // チェックボタン押下後もキャンセルにチェックは入れれるが、既に入っているチェックを外せないような仕様に変更
                                            if(${"cancel_" . $i . "_" . $pid[$i]} == "ON"){
                                                $rec2 .= "<ul class='change " . $double_class . "' id='" . ($i + 1) . "'><li class='parts'>変更依頼 [ " . ($i + 1) . " ]</li><li class='parts'>" . $pid[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'><select class='select1' name='change_status_" . $i . "_" . $pid[$i] . "'><option value='" . ${"change_status_" . $i . "_" . $pid[$i]} . "'>" . ${"change_status_" . $i . "_" . $pid[$i]} . "</option></select></li><li class='parts'><input type='text' name='change_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_price_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_maker_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_maker_price_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_price_sale_" . $i . "_" . $pid[$i] . "' class='price input_number_only'  value='" . ${"change_price_sale_" . $i . "_" . $pid[$i]} . "'></li><li><input type='checkbox' value='ON' name='sale_d_" . $i . "_" . $pid[$i] . "' ". ${"sale_d2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='pricedown_" . $i . "_" . $pid[$i] . "' ". ${"pricedown2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='cancel_" . $i . "_" . $pid[$i] . "' ". ${"cancel2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li></ul><input type='hidden' value='" . ${"double_" . $i . "_" . $pid[$i]} . "' name='double_" . $i . "_" . $pid[$i] . "'>";
                                            } else {
                                                $rec2 .= "<ul class='change " . $double_class . "' id='" . ($i + 1) . "'><li class='parts'>変更依頼 [ " . ($i + 1) . " ]</li><li class='parts'>" . $class2[$i] . $pid[$i] . "</li><li class='parts'>" . $brand2[$i] . "</li><li class='parts'>" . $model2[$i] . "</li><li class='parts'><select class='select1' name='change_status_" . $i . "_" . $pid[$i] . "'><option value='" . ${"change_status_" . $i . "_" . $pid[$i]} . "'>" . ${"change_status_" . $i . "_" . $pid[$i]} . "</option></select></li><li class='parts'><input type='text' name='change_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_price_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_price_sale_" . $i . "_" . $pid[$i] . "' class='price input_number_only'  value='" . ${"change_price_sale_" . $i . "_" . $pid[$i]} . "'></li><li class='parts'><input type='text' name='change_maker_price_" . $i . "_" . $pid[$i] . "' class='price input_number_only' value='" . ${"change_maker_price_" . $i . "_" . $pid[$i]} . "'></li><li><input type='checkbox' value='ON' name='sale_d_" . $i . "_" . $pid[$i] . "' ". ${"sale_d2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='pricedown_" . $i . "_" . $pid[$i] . "' ". ${"pricedown2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li><li><input type='checkbox' value='ON' name='cancel_" . $i . "_" . $pid[$i] . "' ". ${"cancel2_" . $i . "_" . $pid[$i]} . "></li></ul><input type='hidden' value='" . ${"double_" . $i . "_" . $pid[$i]} . "' name='double_" . $i . "_" . $pid[$i] . "'>";
                                            }
                        
                        } else {
                            // 20220627 noidはここのロジックを通らないようになったので、以下はもう使用しない
                            // 存在しないIDのフォーム表示用
                                $rec .= "<ul class='default'><li class='parts'>現在データ</li><li class='parts'>" . $pid[$i] . "</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li></ul>";
                                $rec .= "<ul class='change'><li class='parts'>IDが存在しない</li><li class='parts'>" . $pid[$i] . "</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li><input type='checkbox' value='ON' name='cancel_" . $i . "_" . $pid[$i] . "' ". ${"cancel2_" . $i . "_" . $pid[$i]} . "></li></ul>";
                                $rec2 .= "<ul class='default'><li class='parts'>現在データ</li><li class='parts'>" . $pid[$i] . "</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li></ul>";
                                $rec2 .= "<ul class='change'><li class='parts'>IDが存在しない</li><li class='parts'>" . $pid[$i] . "</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li class='parts'>---</li><li><input type='checkbox' value='ON' name='cancel_" . $i . "_" . $pid[$i] . "' ". ${"cancel2_" . $i . "_" . $pid[$i]} . " onclick='return false;'></li></ul>";
                        }
                    
                    // 問題のある商品IDデータは次の処理へ進ませない為にフラグを付ける
                        if(${"input_check" .$i} == "ON"){
                            ${"error_flug" .$i} = "ON";
                        }
                        // 20220627移動array_push($finush,${"error_flug" .$i});
                } else {
                    $noid_com .= "<p class='red'>商品ID:" . $pid[$i] ."は存在しない為、削除しました</p>";
                }
                array_push($finush,${"error_flug" .$i});
                $i++;
            }

            // 担当者入力確認用メソッドの呼び出し
                $stuff_check = $this->stuff_check($stuff,$stuff_input,$error_nochange_text);

                $error_nochange_text = $stuff_check['error_nochange_text'];
                $stuff_input = $stuff_check['stuff_input'];
        
                array_push($finush,$stuff_input);

            // 一つでも問題のある商品IDがある場合はやり直しさせる為の処理
                $check = in_array("ON", $finush);
                if($check){
                    $check_comment = $error_nochange_text;
                    $check_ng = "ON";
                } else {
                    $check_comment = "<p>チェック問題なし。
                    </p>";  
                    $db_ok = "ON";         

                    // DB登録ボタン表示後にテキストエリアを編集出来ないようにする為の処理
                        if(strpos($rec2,"type='text'") !== false){

                            $rec2 = str_replace("type='text'", "type='text' readonly", $rec2);
                        }

                }

                // 選択されたスタッフ名を取得
                    $stuff_name = $this->stuff_name_get($stuff);


                $bladename = $this->bladename();
                $bladename = 'parts.operation'.$bladename;
                // 20220626return view('parts.operation',['pid2' => $pid2,'rec' => $rec,'rec2' => $rec2,'check_comment' => $check_comment,'db_ok' => $db_ok,'check_ok' => $check_ok,'check_ng' => $check_ng,'confirm' => $confirm,'stuff_name' => $stuff_name,'stuff' => $stuff]);
                //return view('parts.operation',['pid2' => $pid2,'rec' => $rec,'rec2' => $rec2,'check_comment' => $check_comment,'db_ok' => $db_ok,'check_ok' => $check_ok,'check_ng' => $check_ng,'confirm' => $confirm,'stuff_name' => $stuff_name,'stuff' => $stuff,'noid_com' => $noid_com,'noid_flag' => $noid_flag]);
                return view($bladename,['pid2' => $pid2,'rec' => $rec,'rec2' => $rec2,'check_comment' => $check_comment,'db_ok' => $db_ok,'check_ok' => $check_ok,'check_ng' => $check_ng,'confirm' => $confirm,'stuff_name' => $stuff_name,'stuff' => $stuff,'noid_com' => $noid_com,'noid_flag' => $noid_flag]);
    }


/************************************************************************************************************************************************************************************************************* */
    // 依頼内容のチェック用
/************************************************************************************************************************************************************************************************************* */

    // 20220830 public function change_check($a,$b,$c,$d,$e,$f,$g,$h,$i2,$j,$k,$l,$m,$n,$o,$p,$q,$r,$s){
    public function change_check($a,$b,$c,$d,$e,$f,$g,$h,$i2,$j,$k,$l,$m,$n,$o,$p,$q,$r,$s,$t){

        $i = $a;
        $pid[$i] = $b;
        ${"change_status".$i} = $c;
        ${"change_price".$i} = $d;
        ${"change_price_sale".$i} = $e;
        ${"change_maker_price".$i} = $f;
        $stock_condition[$i] = $g;
        $price[$i] = $h;
        $price_sale[$i] = $i2;
        $maker_price[$i] = $j;
        $error_nochange_text = $k;
        ${"input_check" .$i} = $l;
        ${"noid".$i} = $m;
        ${"sale_d" .$i} = $n;
        $status[$i] = $o;
        $status_flg[$i] = $p;
        $class[$i] = $q;
        $double[$i] = $r;
        ${"pricedown_".$i} = $s; 
        // 20220830
        $src_s[$i] = $t;

        if($i == 0){$link="#head";} else { $link = "#" . $i; }

       // IDが存在しない場合のエラー
            if(${"noid".$i} == "noid" ){

                $error_nochange_text .="ID:" . $pid[$i] . " ECBに該当IDが存在しません。<br>";
                ${"input_check" .$i} = "ON";

       // それ以外のエラー
            } else {

                // 新旧全ての項目が一致している場合のエラー（一つも変更していないという事）
                    if($stock_condition[$i] == ${"change_status".$i} && ${"change_price".$i} == "" && ${"change_price_sale".$i} == ""  && ${"change_maker_price".$i} == "" && ${"sale_d".$i} == "" ){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] データ変更が未入力です。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                // 通常価格の0円指定エラー
                    if(str_replace(',','',${"change_price".$i} == "0")){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 通常価格に0円が入力されています。通常価格を0円に変更することは出来ません。<br>";
                        ${"input_check" .$i} = "ON";
                // 通常価格が変更前と変更後で同一の場合のエラー
                    } else if(str_replace(',','',$price[$i]) == str_replace(',','',${"change_price".$i})){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 入力した通常価格が現在の通常価格と同じです。正しい金額を入力して下さい。<br>";
                        ${"input_check" .$i} = "ON";
                    }

                // 元々セール価格が無い商品をそのままにしたい場合に同一値のエラーを出さない
                    if(str_replace(',','',$price_sale[$i])  =="" && str_replace(',','',${"change_price_sale".$i}) == ""){
                // 0円を指定した場合のエラー
                    } else if(str_replace(',','',${"change_price_sale".$i}) == "0"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] セール価格に0円が入力されています。セール価格を0円に変更することは出来ません。<br>";
                        ${"input_check" .$i} = "ON";
                // セール価格が変更前と変更後で同一の場合のエラー
                    } else if(str_replace(',','',$price_sale[$i]) == str_replace(',','',${"change_price_sale".$i})){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 入力したセール価格が現在のセール価格と同じです。正しい金額を入力して下さい。<br>";
                        ${"input_check" .$i} = "ON";
                    }

                // セール価格が存在しないのにセール外しにチェックが入っている場合のエラー
                    if(str_replace(',','',$price_sale[$i]) == "" && ${"sale_d" .$i} == "ON"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] セール品ではない商品に対して「セール外し」にチェックが入っています。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                // セール価格の変更時にセール外しにもチェックが入っている場合のエラー
                    if(str_replace(',','',${"change_price_sale".$i}) != "" && ${"sale_d" .$i} == "ON"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] セール価格が入力されていますが、「セール外し」にチェックが入っています<br>";
                        ${"input_check" .$i} = "ON";
                    }

                // セール価格と通常価格を同時に変更した際に新セール価格が新通常価格以上だった場合のエラー
                    if(str_replace(',','',${"change_price".$i}) != ""){
                        if(str_replace(',','',${"change_price".$i}) <= str_replace(',','',${"change_price_sale".$i})){
                            $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 入力した通常価格より高いセール価格が入力されています。<br>";
                            ${"input_check" .$i} = "ON";
                        }
                // セール価格のみの変更時に元々の通常価格以上だった場合のエラー
                    } else {
                        if(str_replace(',','',$price[$i]) <= str_replace(',','',${"change_price_sale".$i})){
                            $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 通常価格より高いセール価格が入力されています<br>";
                            ${"input_check" .$i} = "ON";
                        }
                    }

                // セール品の通常価格変更の場合に元々のセール価格より安い場合（セール外しにチェックが無い場合）
                    //20220422セール外しにチェックが無い場合を追記。if(str_replace(',','',$price_sale[$i])  !="" && str_replace(',','',${"change_price".$i}) != "" && str_replace(',','',$price_sale[$i]) >= str_replace(',','',${"change_price".$i})){
                    if(${"sale_d" .$i} != "ON" && str_replace(',','',$price_sale[$i])  !="" && str_replace(',','',${"change_price".$i}) != "" && str_replace(',','',$price_sale[$i]) >= str_replace(',','',${"change_price".$i})){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在のセール価格よりと同額、もしくは安い通常価格が入力されています。<br>";
                        ${"input_check" .$i} = "ON";
                    }


                // 元々「定価」が無い商品をそのままにしたい場合に同一値のエラーを出さない
                    if(str_replace(',','',$maker_price[$i]) =="" && str_replace(',','',${"change_maker_price".$i}) == ""){
                // 「0円」を指定した場合のエラー
                    } else if(str_replace(',','',${"change_maker_price".$i}) == "0"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 定価に0円が入力されています。定価を0円に変更することは出来ません。※定価を削除する場合はスプレッドシートに記入してください。<br>";
                        ${"input_check" .$i} = "ON";
                // 「定価」が変更前と変更後で同一の場合のエラー
                    } else if( str_replace(',','',$maker_price[$i]) == str_replace(',','',${"change_maker_price".$i})){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 入力した定価が現在の定価と同じです。正しい金額を入力して下さい。<br>";
                        ${"input_check" .$i} = "ON";
                    }

                // 「下書き」依頼不可
                /* 下書きの状態変更は必要なのでエラー撤去
                    if($status[$i] == "2"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] は現在下書きです。WEB掲載前なので、ECBから直接変更してください<br>";
                        ${"input_check" .$i} = "ON";
                    }*/
                // 「OUTLET」への「SOLDOUT」依頼不可
                    //if(strpos($status_flg[$i],'OUTLET') !== false && ${"change_status".$i} == "SOLDOUT"){
                    if(strpos($status_flg[$i],'OUTLET') !== false && ${"change_status".$i} == "SOLDOUT" && $stock_condition[$i] != "SOLDOUT"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] アウトレット品の為、「SOLDOUT」への変更ができません。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                // 「OUTLET」への「申し込み」依頼不可
                    //if(strpos($status_flg[$i],'OUTLET') !== false && ${"change_status".$i} == "申し込み"){
                    if(strpos($status_flg[$i],'OUTLET') !== false && ${"change_status".$i} == "申し込み" && $stock_condition[$i] != "申し込み"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] アウトレット品の為、「申し込み」への変更ができません。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                // アウトレットの商品で、現状が申込、SOLDOUTの商品に対して上代の変更、セール価格変更/追加を依頼不可
                    //if(strpos($status_flg[$i],'OUTLET') !== false && ${"change_status".$i} == "申し込み"){
                        if(strpos($status_flg[$i],'OUTLET') !== false /*&& ($stock_condition[$i] != "SOLDOUT" || $stock_condition[$i] != "申し込み")*/ && (${"change_price".$i} != "" || ${"change_price_sale".$i} != "") && (${"change_status".$i} == "SOLDOUT" || ${"change_status".$i} == "申し込み")){
                                $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 申込、SOLDOUTのアウトレット商品の価格は変更できません。<br>";
                                ${"input_check" .$i} = "ON";
                        }
    
                // 「アンティーク」「中古」に対し「申し込み」依頼不可(元から間違った状態にはエラーを出さない)
                    //if((strpos($class[$i],'アンティーク') !== false || strpos($class[$i],'中古') !== false) && ${"change_status".$i} == "申し込み"){
                    if((strpos($class[$i],'アンティーク') !== false || strpos($class[$i],'中古') !== false) && (${"change_status".$i} == "申し込み" && $stock_condition[$i] == "申し込み")){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 「アンティーク」「中古」の商品は「申し込み」への依頼はできません。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                    
                /*　「ID:112995」は「SOLDOUT」なので、今は可能としているのかもしれないのでコメントアウト
                // 「アンティーク」「中古」に対し「SOLDOUT」依頼不可
                    if((strpos($class[$i],'アンティーク') !== false || strpos($class[$i],'中古') !== false) && ${"change_status".$i} == "SOLDOUT"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 「アンティーク」「中古」への「SOLDOUT」依頼はできません<br>";
                        ${"input_check" .$i} = "ON";
                    }
                */
                /* 20220524 許容する。アウトレット以外には注意文のみ表示させる
                // 「新品」に対し「終息(削除)」依頼不可
                    if(strpos($class[$i],'新品') !== false && ${"change_status".$i} == "終息"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 「新品」商品の「終息」への依頼ですが、問題ないでしょうか。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                */
                // 「新品」の「セール品」に対し「申し込み」or「SOLDOUT」依頼不可（セール外しにチェックが無い場合）
                    /*撤去if(${"sale_d" .$i} != "ON" && str_replace(',','',$price_sale[$i])  !="" && strpos($class[$i],'新品') !== false && (${"change_status".$i} == "申し込み" || ${"change_status".$i} == "SOLDOUT")){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 「セール品」で「新品」への「申し込み」や「SOLDOUT」の依頼はできません<br>";
                        ${"input_check" .$i} = "ON";
                    }*/

                //  「新品」の「申込」or「SOLDOUT」で「セール価格」が存在する場合（ややこしくなるのでこの条件で元からセール価格が入っている場合は間違った状態だがエラーは出さない）
                    $flag1[$i] = "";
                    //　新品 && セール外しにチェックが入っていない
                        // 20220701 セール外しにチェックが入っていてもエラーを出す。アウトレットは除外を追加
                        //if($class[$i] == "新品" && ${"sale_d" .$i} != "ON"){
                        if($class[$i] == "新品" && strpos($status_flg[$i],'OUTLET') === false){
                        // ステータス変更依頼が「申し込み」or「SOLDOUT」の場合 or
                            // ステータス変更依頼が「申し込み」or「SOLDOUT」ではなくて、元々のステータスが「申し込み」or「SOLDOUT」の場合
                                if((${"change_status".$i} == "申し込み" || ${"change_status".$i} == "SOLDOUT") || (${"change_status".$i} != "申し込み" && ${"change_status".$i} != "SOLDOUT" && ($stock_condition[$i] == "申し込み" || $stock_condition[$i] == "SOLDOUT"))){
                                    // 元々の「セール価格」が空ではない
                                        if($price_sale[$i] != ""){
                                            $flag1[$i] = "ON";
                                    // 元々の「セール価格」が空。セール価格変更依頼が空ではない
                                        } else if($price_sale[$i] == "" && ${"change_price_sale".$i} != ""){
                                            $flag1[$i] = "ON";
                                        }
                                    // 例外処理（元々の「セール価格」とセール価格変更依頼が同じ価格）の場合はエラーを出さない(別の同価格依頼エラーが出てどのみち登録できないので撤去)
                                        /*if($price_sale[$i] == str_replace(',','',${"change_price_sale".$i})){
                                            $flag1[$i] = "";
                                        }*/
                                }

                        // 例外処理（元から「申込」or「SOLDOUT」に対しセール価格が設定されている場合は改めてセール価格依頼をしない限りはエラーを出さない(元々のおかしな状態は今回の依頼者とは無関係なためあえてスルーさせる)
                                // 下記だと元々が「申込」or「SOLDOUT」以外でセール品だった場合にセールを触らず「申込」or「SOLDOUT」依頼をした場合に例外がら外れるためエラーが出てしまう。単純にセール価格の変更がなければエラーなしで良いはず
                                //if($price_sale[$i] != "" && ($stock_condition[$i] == "申し込み" || $stock_condition[$i] == "SOLDOUT") && ${"change_price_sale".$i} == ""){
                                if(${"change_price_sale".$i} == ""){
                                    $flag1[$i] = "";
                                }

                        // 例外処理（状態を「在庫あり」にする依頼が同時にあれば問題なし)
                                if(${"change_status".$i} == "在庫あり" || ${"change_status".$i} == "商談中"){
                                    $flag1[$i] = "";
                                }
                                    

                        }
                    if($flag1[$i] == "ON"){
                        //$error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 申し込み、SOLDOUTの商品のセール価格を変更することは出来ません。<br>";
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 申し込み、SOLDOUTの商品にセール価格を設定することは出来ません。<br>";
                        ${"input_check" .$i} = "ON";
                    }

                // 通常価格、セール価格に入力無し、プライスダウンフラグにチェックの場合
                    if(${"change_price".$i} == "" && ${"change_price_sale".$i} == "" && ${"pricedown_".$i} == "ON"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 価格変更が無い場合は「プライスDに入れない」のチェックを外してください。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                // 「下書き」への「在庫あり」依頼不可
                    /* 20220604依頼ミス。撤去
                    if($status[$i] == "2" && ${"change_status".$i} == "在庫あり"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 下書きの商品を在庫ありに変更することは出来ません。<br>";
                        ${"input_check" .$i} = "ON";
                    }*/
                // 「下書き」への「通常価格変更、セール価格追加、セール価格変更」依頼不可
                    if($status[$i] == "2" && (${"change_price".$i} != "" || ${"change_price_sale".$i} != "")){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 下書きの商品の価格変更はこのフォームで依頼することは出来ません。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                 // 「アウトレット」への「セール外し」及び「プライスダウンに入れない」依頼不可
                    if(strpos($status_flg[$i],'OUTLET') !== false && (${"pricedown_".$i} == "ON" || ${"sale_d" .$i} == "ON")){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] アウトレット商品のため、「セール外し」及び「プライスダウンに入れない」にチェックを入れることは出来ません。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                 // 商談中の商品に対して上代、セール価格を変更/追加の依頼不可
                    //if($stock_condition[$i] == "商談中" && (${"change_price".$i} != "" || ${"change_price_sale".$i} != "")){
                    if(${"change_status".$i} == "商談中" && (${"change_price".$i} != "" || ${"change_price_sale".$i} != "")){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 商談中の商品は価格の変更ができません。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                //  「新品」への「終息」「商談中」依頼（アウトレットは例外）
                    $flag2[$i] = "";
                    if(strpos($class[$i],'新品') !== false && (${"change_status".$i} == "終息" || ${"change_status".$i} == "商談中") && strpos($status_flg[$i],'OUTLET') === false){
                    //if(strpos($class[$i],'新品') !== false && (${"change_status".$i} == "終息" || ${"change_status".$i} == "商談中") && strpos($status_flg[$i],'OUTLET') === false && $stock_condition[$i] != "終息" && $stock_condition[$i] != "商談中"){
                        $flag2[$i] = "ON";
                        
                        if(($stock_condition[$i] == "終息" && ${"change_status".$i} == "終息") || ($stock_condition[$i] == "商談中" && ${"change_status".$i} == "商談中")){
                            $flag2[$i] = "";
                        }
                        if($flag2[$i] == "ON"){
                            $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 新品の商品は商談中、終息に変更できません。<br>";
                            ${"input_check" .$i} = "ON";
                        }
                    }
                //  「中古」or「アンティーク」への「SOLDOUT」(元から「SOLDOUT」は除外)
                    if((strpos($class[$i],'中古') !== false || strpos($class[$i],'アンティーク') !== false) && ${"change_status".$i} == "SOLDOUT" && $stock_condition[$i] != "SOLDOUT"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 中古・アンティークの商品は「SOLDOUT」へ変更できません。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                //  20220624「中古」or「アンティーク」への「申し込み」(元から「申し込み」は除外)
                    if((strpos($class[$i],'中古') !== false || strpos($class[$i],'アンティーク') !== false) && ${"change_status".$i} == "申し込み" && $stock_condition[$i] != "申し込み"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 中古・アンティークの商品は「申し込み」へ変更できません。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                // 20220606中古・アンティークで現状：SOLDOUTの商品に対して上代変更、セール価格変更/追加の依頼不可
                    if((strpos($class[$i],'アンティーク') !== false || strpos($class[$i],'中古') !== false) && $stock_condition[$i] == "SOLDOUT" && (${"change_price".$i} != "" || ${"change_price_sale".$i} != "")){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 「アンティーク」「中古」で「SOLDOUT」の商品は価格の変更ができません。<br>";
                        ${"input_check" .$i} = "ON";
                    }

                // 「新品」で「終息」への「通常価格変更、セール価格追加、セール価格変更」依頼不可（アウトレットは例外）
                    //20220624if(strpos($class[$i],'新品') !== false && $stock_condition[$i] == "終息" && (${"change_price".$i} != "" || ${"change_price_sale".$i} != "")){
                    if(strpos($class[$i],'新品') !== false && $stock_condition[$i] == "終息" && (${"change_price".$i} != "" || ${"change_price_sale".$i} != "") && strpos($status_flg[$i],'OUTLET') === false){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 新品で終息の商品の価格変更はこのフォームで依頼することは出来ません。<br>";
                        ${"input_check" .$i} = "ON";
                    }

                // 20220701　現在のセール価格よりも高い金額の修正を依頼して、プライスDに入れないにチェックを入れた場合
                    if(str_replace(',','',${"change_price_sale".$i}) > str_replace(',','',$price_sale[$i]) && ${"pricedown_".$i} == "ON"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在のセール価格よりも高いセール価格を入力した場合、「プライスダウンに入れない」にチェックを入れることは出来ません。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                    
                // 20220701　現在の通常価格よりも高い金額の修正を依頼して、プライスDに入れないにチェックを入れた場合
                    if(str_replace(',','',${"change_price".$i}) > str_replace(',','',$price[$i]) && ${"pricedown_".$i} == "ON"){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在の通常価格よりも高い通常価格を入力した場合、「プライスダウンに入れない」にチェックを入れることは出来ません。<br>";
                        ${"input_check" .$i} = "ON";
                    }

                // 20220830 下書き以外でs画像無し商品への依頼の場合(画像無URL：https://stg.jackroad.co.jp/img/sys/sorryS.jpg)
                    if($status[$i] <> "2" && strpos($src_s[$i],'sorryS.jpg') !== false){
                        $error_nochange_text .="[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 画像が無い商品への依頼です。下書きの状態にして変更したい場合はイレギュラーシートにてご依頼ください。<br>";
                        ${"input_check" .$i} = "ON";
                    }
                    

            }

            $bladename = $this->bladename();
            $bladename = 'parts.operation'.$bladename;
        
            //return view('parts.operation',['input_check'=>${"input_check" .$i},'error_nochange_text'=>$error_nochange_text]);
            return view($bladename,['input_check'=>${"input_check" .$i},'error_nochange_text'=>$error_nochange_text]);
    }



/************************************************************************************************************************************************************************************************************* */
    // 担当者入力とID存在確認チェック用
/************************************************************************************************************************************************************************************************************* */

    public function stuff_check($a,$b,$c){

        $stuff = $a;
        $stuff_input = $b;
        $error_nochange_text = $c;

        // 担当者が存在しない場合のエラー
            if($stuff == ""){

                $error_nochange_text .="担当者が入力されていません<br>";
                $stuff_input = "ON";

            }


        $bladename = $this->bladename();
        $bladename = 'parts.operation'.$bladename;

        //return view('parts.operation',['error_nochange_text'=>$error_nochange_text,'stuff_input'=>$stuff_input]);
        return view($bladename,['error_nochange_text'=>$error_nochange_text,'stuff_input'=>$stuff_input]);
    }




/************************************************************************************************************************************************************************************************************* */
    // 依頼内容に間違いが無いかの確認用
/************************************************************************************************************************************************************************************************************* */

    //重複フラグ追加public function confirm_check($a,$b,$c,$d,$e,$f,$g,$h,$j){
    public function confirm_check($a,$b,$c,$d,$e,$f,$g,$h,$j,$k,$l,$m){

        $i = $a;
        $pid[$i] = $b;
        $price[$i] = $c;
        $price_sale[$i] = $d;
        $maker_price[$i] = $e;
        ${"change_price".$i} = $f;
        ${"change_price_sale".$i} = $g;
        ${"change_maker_price".$i} = $h;
        ${"change_status".$i} = $m;
        $status_flg[$i] = $j;
        // 重複フラグ追加
            $double[$i] = $k;

        // 新中アン
            $class[$i] = $l;

        $confirm[$i] = "";
        // 価格閾値を変数へ(35%)
            $low_price = 0.65;
            $high_price = 1.35;
            $threshold_view = "35%";

        if($i == 0){$link="#head";} else { $link = "#" . $i; }
        //  「重複フラグ」の表示
            if($double[$i] == "ON"){
                    $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 重複（背景が赤）があります。依頼を1つにまとめてください。※片方はキャンセルにチェック</p>";
            }
       
        //  「上代変更」依頼の場合に、「指示された上代」が「元々の上代」よりも35％以上安い
            if(${"change_price".$i} != ""){
                if(str_replace(',','',${"change_price".$i}) < (str_replace(',','',$price[$i]) * $low_price)){
                    $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在の通常価格よりも" . $threshold_view . "以上安い通常価格が入力されていますが、問題ないでしょうか。</p>";
                }
            }
        //  「上代変更」依頼の場合に、「指示された上代」が「元々の上代」よりも35％以上高い
            if(${"change_price".$i} != ""){
                if(str_replace(',','',${"change_price".$i}) > (str_replace(',','',$price[$i]) * $high_price)){
                    $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在の通常価格よりも" . $threshold_view . "以上高い通常価格が入力されていますが、問題ないでしょうか。</p>";
                }
            }
        //  「セール価格変更」依頼の場合に、「指示されたセール価格」が「元々のセール価格」よりも35％以上安い
            if(${"change_price_sale".$i} != "" && $price_sale[$i] != ""){
                if(str_replace(',','',${"change_price_sale".$i}) < (str_replace(',','',$price_sale[$i]) * $low_price)){
                    $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在のセール価格よりも" . $threshold_view . "以上安いセール価格が入力されていますが、問題ないでしょうか。</p>";
                }
            }
        //  「セール価格変更」依頼の場合に、「指示されたセール価格」が「元々のセール価格」よりも35％以上高い
            if(${"change_price_sale".$i} != "" && $price_sale[$i] != ""){
                if(str_replace(',','',${"change_price_sale".$i}) > (str_replace(',','',$price_sale[$i]) * $high_price)){
                    $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在のセール価格よりも" . $threshold_view . "以上高いセール価格が入力されていますが、問題ないでしょうか。</p>";
                }
            }
        //  「指示されたセール価格」が「元々の上代」よりも35％以上安い
            // 20220604 セール価格同士の比較のみで良いので撤去
            // 20220701 上記指示間違いとの事
            if(${"change_price_sale".$i} != ""){
                if(str_replace(',','',${"change_price_sale".$i}) < (str_replace(',','',$price[$i]) * $low_price)){
                    $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在の通常価格よりも" . $threshold_view . "以上安いセール価格が入力されていますが、問題ないでしょうか。</p>";
                }
            }
        //  「指示されたセール価格」が「元々の上代」よりも35％以上高い
            if(${"change_price_sale".$i} != ""){
                if(str_replace(',','',${"change_price_sale".$i}) > (str_replace(',','',$price[$i]) * $high_price)){
                    $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現上代価格よりも" . $threshold_view . "以上高いセール価格指定ですが問題ないでしょうか</p>";
                }
            }
        // 20220519 定価価格確認追記
        //  「定価変更」依頼の場合に、「指示された定価」が「元々の定価」よりも35％以上安い
            // 20220909 元々定価が存在しない場合にプログラムエラーとなるので追記
            //if(${"change_maker_price".$i} != ""){
            if(${"change_maker_price".$i} != "" && $maker_price[$i] <> ""){
                if(str_replace(',','',${"change_maker_price".$i}) < (str_replace(',','',$maker_price[$i]) * $low_price)){
                        $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在の定価よりも" . $threshold_view . "以上安い定価が入力されていますが、問題ないでしょうか。</p>";
                }
            }
        //  「定価変更」依頼の場合に、「指示された定価」が「元々の定価」よりも35％以上高い
            // 20220909 元々定価が存在しない場合にプログラムエラーとなるので追記
            //if(${"change_maker_price".$i} != ""){
            if(${"change_maker_price".$i} != "" && $maker_price[$i] <> ""){
                if(str_replace(',','',${"change_maker_price".$i}) > (str_replace(',','',$maker_price[$i]) * $high_price)){
                    $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] 現在の定価よりも" . $threshold_view . "以上高い定価が入力されていますが、問題ないでしょうか。</p>";
                }
            }



        //  アウトレット用注意
            /*if(strpos($status_flg[$i],'OUTLET') !== false && (${"change_price".$i} != "" || ${"change_price_sale".$i} != "" || ${"change_maker_price".$i} != "")){
                $confirm[$i]  .= "<p>[ ID：<a href='" . $link . "'>" . $pid[$i] . "</a> ] アウトレット品の価格変更ですが問題ないでしょうか</p>";
            }*/

            $bladename = $this->bladename();
            $bladename = 'parts.operation'.$bladename;
                
            //return view('parts.operation',['confirm'=>$confirm[$i]]);
            return view($bladename,['confirm'=>$confirm[$i]]);

        }

/************************************************************************************************************************************************************************************************************* */
    // DB登録用（旧商品データと依頼データ）
/************************************************************************************************************************************************************************************************************* */


    public function db_insert(){

        // 旧データの取得
            $old_data = session()->get('old_data');

        // 変数初期化
            $i = 0;
            $error_nochange_text = "";
            $pid2 = "";
            $rec = "";
            $rec2 = "";
            $finush = array();
            $check_comment = "";
            $check = "";
            $insert_num = 0;

            $cancel_com = "";


        // 旧データを取得
            foreach($old_data as $value){
                //print_r($value) . "<br>";

                // 変数初期化
                    ${"input_check" .$i} = "OFF";
                    ${"error_flug" .$i} = "OFF";

                foreach($value as $key[$i] => $value[$i]){

                    // 旧データ変数代入
                        if($key[$i] == "pid"){ $pid[$i] = $value[$i]; }
                        if($key[$i] == "title"){ $title[$i] = $value[$i]; }
                        //if($key[$i] == "stuff"){ $stuff[$i] = $value[$i]; }
                        if($key[$i] == "brand"){ $brand[$i] = $value[$i]; }
                        if($key[$i] == "model"){ $model[$i] = $value[$i]; }
                        if($key[$i] == "price"){ $price[$i] = $value[$i]; }
                        if($key[$i] == "price_sale"){ if($value[$i] !=""){ $price_sale[$i] = $value[$i]; } else { $price_sale[$i] = null;}}
                        if($key[$i] == "status_flg"){ if($value[$i] !=""){ $status_flg[$i] = $value[$i]; } else { $status_flg[$i] = null;}}
                        if($key[$i] == "stock_condition"){ if($value[$i] !=""){ $stock_condition[$i] = $value[$i]; } else { $stock_condition[$i] = null;}}
                        if($key[$i] == "status"){ if($value[$i] !=""){ $status[$i] = $value[$i]; } else { $status[$i] = null;}}
                        if($key[$i] == "maker_price"){ if($value[$i] !=""){ $maker_price[$i] = $value[$i]; } else { $maker_price[$i] = null;}}
                        if($key[$i] == "class"){ if($value[$i] !=""){ $class[$i] = $value[$i]; } else { $class[$i] = null;}}
                    
                }

                // 新データを取得(商品数が旧データと同じなので、旧データ取得の繰り返し文の中で実施)
                    ${"change_status_" . $i . "_" . $pid[$i]} = "change_status_" . $i . "_" . $pid[$i];
                    ${"change_status_" . $i . "_" . $pid[$i]} = PostRequest::input(${"change_status_" . $i . "_" . $pid[$i]});
                    if(${"change_status_" . $i . "_" . $pid[$i]} == ""){ ${"change_status_" . $i . "_" . $pid[$i]} = null; }
                    // 変更状態が旧状態と一緒なら空で登録
                        if($stock_condition[$i] == ${"change_status_" . $i . "_" . $pid[$i]}){ ${"change_status_" . $i . "_" . $pid[$i]} = null; }

                    ${"change_price_" . $i . "_" . $pid[$i]} = "change_price_" . $i . "_" . $pid[$i];
                    ${"change_price_" . $i . "_" . $pid[$i]} = PostRequest::input(${"change_price_" . $i . "_" . $pid[$i]});
                    ${"change_price_" . $i . "_" . $pid[$i]} = str_replace(',','',${"change_price_" . $i . "_" . $pid[$i]});
                    if(${"change_price_" . $i . "_" . $pid[$i]} == ""){ ${"change_price_" . $i . "_" . $pid[$i]} = null; }

                    ${"change_price_sale_" . $i . "_" . $pid[$i]} = "change_price_sale_" . $i . "_" . $pid[$i];
                    ${"change_price_sale_" . $i . "_" . $pid[$i]} = PostRequest::input(${"change_price_sale_" . $i . "_" . $pid[$i]});
                    ${"change_price_sale_" . $i . "_" . $pid[$i]} = str_replace(',','',${"change_price_sale_" . $i . "_" . $pid[$i]});
                    if(${"change_price_sale_" . $i . "_" . $pid[$i]} == ""){ ${"change_price_sale_" . $i . "_" . $pid[$i]} = null; }

                    ${"change_maker_price_" . $i . "_" . $pid[$i]} = "change_maker_price_" . $i . "_" . $pid[$i];
                    ${"change_maker_price_" . $i . "_" . $pid[$i]} = PostRequest::input(${"change_maker_price_" . $i . "_" . $pid[$i]});
                    ${"change_maker_price_" . $i . "_" . $pid[$i]} = str_replace(',','',${"change_maker_price_" . $i . "_" . $pid[$i]});
                    if(${"change_maker_price_" . $i . "_" . $pid[$i]} == ""){ ${"change_maker_price_" . $i . "_" . $pid[$i]} = null; }

                    ${"cancel_" . $i . "_" . $pid[$i]} = "cancel_" . $i . "_" . $pid[$i];
                    ${"cancel_" . $i . "_" . $pid[$i]} = PostRequest::input(${"cancel_" . $i . "_" . $pid[$i]});

                    ${"sale_d_" . $i . "_" . $pid[$i]} = "sale_d_" . $i . "_" . $pid[$i];
                    ${"sale_d_" . $i . "_" . $pid[$i]} = PostRequest::input(${"sale_d_" . $i . "_" . $pid[$i]});

                    ${"pricedown_" . $i . "_" . $pid[$i]} = "pricedown_" . $i . "_" . $pid[$i];
                    ${"pricedown_" . $i . "_" . $pid[$i]} = PostRequest::input(${"pricedown_" . $i . "_" . $pid[$i]});


                    $stuff = PostRequest::input("stuff");
                    
                // 20220626 チェックボタン押下時に存在しないIDが混ざっているとエラーとなるため
                    if($title[$i] !="noid"){


                            // スタッフ名が最初と変更されている場合は、タイトルも変更
                                if(strpos($title[$i],$stuff) === false){
                                    $title[$i] = now() . "_" . $stuff;
                                }

                            // 新中アン用
                                if($class[$i] == "新品"){
                                    $class_num[$i] = 1;
                                } else if($class[$i] == "中古"){
                                    $class_num[$i] = 2;
                                } else if($class[$i] == "アンティーク"){
                                    $class_num[$i] = 3;
                                }
                                

                        // キャンセルフラグにチェックが入っている場合はDB登録をスルー
                            if(${"cancel_" . $i . "_" . $pid[$i]} != "ON"){

                                // DB登録ロジックを実施
                                            
                                    // 新旧データをDBへインサートする
                                        $op_request = Op_request_test::insert([
                                        //$op_request = Op_request::insert([
                                            'pid' => $pid[$i],
                                            'brand' => $brand[$i],
                                            'title' => $title[$i],
                                            'stuff' => $stuff,
                                            'model' => $model[$i],
                                            'class' => $class_num[$i],
                                            'price' => $price[$i],
                                            'price_sale' => $price_sale[$i],
                                            'status_flg' => $status_flg[$i],
                                            'stock_condition' => $stock_condition[$i],
                                            'status' => $status[$i],
                                            'maker_price' => $maker_price[$i],
                                            'new_stock_condition' => ${"change_status_" . $i . "_" . $pid[$i]},
                                            'new_price' => ${"change_price_" . $i . "_" . $pid[$i]},
                                            'new_price_sale' => ${"change_price_sale_" . $i . "_" . $pid[$i]},
                                            'new_maker_price' => ${"change_maker_price_" . $i . "_" . $pid[$i]},
                                            'sale_d' => ${"sale_d_" . $i . "_" . $pid[$i]},
                                            'NO_PD' => ${"pricedown_" . $i . "_" . $pid[$i]},
                                            'NO_CSVDL' => '',
                                            'CSVDL' => '',
                                            'MEMO' => '',
                                            'FINUSH' => '',
                                            'created_at' => now(),
                                            'updated_at' => now()
                                        ]);

                                        $insert_num++;

                                        ${"error_flug" .$i} = "ON";
                                        array_push($finush,${"error_flug" .$i});

                            } else {

                                $cancel_com .= "<span class='cancel'>[ " . $pid[$i] . "の登録はキャンセルしました ]</span>";
                            }
                    }

                $i++;
            }

            // 一つでも問題のある商品IDがある場合はやり直しさせる為の処理
                $check = in_array("OFF", $finush);
                if($check){
                    $check_comment = "<p>!! ERROR !!</p><p>登録出来ませんでした</p>";
                } else {
                    if($insert_num == 0){
                        $check_comment = "<p>!! 作業内容の再確認 !!</p><p>登録項目が一つもありませんでした</p>";
                    } else {          
                        $check_comment = "<p class='font1'>!! 依頼内容をデータベースへ登録しました !!</p><p>[ 登録件数：" . $insert_num . "件 ]</p>" . $check_comment;         
                    }  
                }
                if($cancel_com != ""){
                    $cancel_com = "<div class='cancel_com'>" . $cancel_com . "</div>";
                }

                $check_comment = "<div class='comment'>" . $check_comment . "<p>" . $cancel_com . "<a href=''>元のページに戻る</a></p></div>";

            
            // ブラウザの戻るで同じ処理をしても無効化させるためセッションの削除
                session()->flush();

                return view('parts.operation_insert',['check_comment' => $check_comment]);
    }



public function stuff_name_get($stuff){

                $stuff_name = "";

                // 担当者取得
                //$stuff = PostRequest::input('stuff');

                    // ソフトデリート以外を取得
                    $stuff_selects = \App\Models\Stuff_name::get();

                    $view = "";
                    foreach ($stuff_selects as $stuff_select) {
                        $id = $stuff_select->sid;
                        $first_name = $stuff_select->first_name;
                        $last_name = $stuff_select->last_name;
                        $dell = $stuff_select->dell;
                        if($stuff == $id){
                            $stuff_name = $first_name . " " . $last_name;
                        }
                    }

                    return $stuff_name;
        }






}
