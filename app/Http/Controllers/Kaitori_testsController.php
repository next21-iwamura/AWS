<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as PostRequest;

//class KaitorisController extends Controller
class Kaitori_testsController extends Controller

{

/************************************************************************************************************************************************************************************************************* */
	// ■構成メソッド
		// 定数管理用
		// 買取ページの表示
		// 押下されたボタン毎に処理（メソッド）を切り分け
		// CSVのアップロード
		// CSVを読み込み値を配列へ代入
		// PC用HTMLの作成
		// SP用HTMLの作成
		// ブランド別にヘッダー・フッターのHTMLを作成
		// 買取ページ用全体HTNMLの作成（関連メソッドの結果を呼び出して最終形を作成）

/************************************************************************************************************************************************************************************************************* */



/************************************************************************************************************************************************************************************************************* */
    // 定数管理用メソッド
/************************************************************************************************************************************************************************************************************* */
        public function define(){

            $define = array();

            // 本番 or テスト用フォルダの切り替え変数
                $folda_name = "test/";
                $folda_name2 = "_test";
                //$folda_name = "";
                //$folda_name2 = "";


            $file_pass1 = "../storage/app/public/csv/op/kaitori/" . $folda_name;
            $file_pass2 = "public/csv/op/kaitori/" . $folda_name;
            $file_pass3 = "../storage/app/public/csv/op/kaitori/" . $folda_name . "*";
            $file_pass4 = "parts.kaitori" . $folda_name2;
            array_push($define,$file_pass1);
            array_push($define,$file_pass2);
            array_push($define,$file_pass3);
            array_push($define,$file_pass4);

            return $define;

        }



/************************************************************************************************************************************************************************************************************* */
    // 買取用デバッグ
/************************************************************************************************************************************************************************************************************* */
        public function debug(Request $request)
        {

            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）start
            /************************************************************************************************************************************************************************************************************* */

                $define = $this->define();
                $def_i = 0;
                // 各変数にパスやファイル名を代入
                    foreach($define as $def){
                        if($def_i == 3){ $file_pass4 = $def; }
                        
                        $def_i++;
                    }

            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）end
            /************************************************************************************************************************************************************************************************************* */
                    

            dd(
                // リクエストURIの取得
                $request->path(),
                // リクエストのURIが指定されたパターンに合致するか確認
                $request->is('*/kaitori'),
                // 完全なURLを取得(クエリ文字列なし)
                $request->url(),
                // 完全なURLを取得(クエリ文字列付き)
                $request->fullUrl(),
                // リクエストメソッドの取得
                $request->method(),
                // リクエストメソッドの取得
                $request->isMethod('post')
            );
            //return view('parts.kaitori');
            return view($file_pass4);
        }
    
/************************************************************************************************************************************************************************************************************* */
    // 買取ページの表示
/************************************************************************************************************************************************************************************************************* */
        public function kaitoriview(){

            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）start
            /************************************************************************************************************************************************************************************************************* */

                $define = $this->define();
                $def_i = 0;
                // 各変数にパスやファイル名を代入
                    foreach($define as $def){
                        if($def_i == 3){ $file_pass4 = $def; }
                        
                        $def_i++;
                    }

            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）end
            /************************************************************************************************************************************************************************************************************* */


            //return view('parts.kaitori');
            return view($file_pass4);
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
                        if($def_i == 3){ $file_pass4 = $def; }
                        
                        $def_i++;
                    }

            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）end
            /************************************************************************************************************************************************************************************************************* */


                // 使用するメソッドの切り分け
                    if (PostRequest::get('csvup')) {
                        // アップロード用メソッドの実行
                            return $this->kaitori_up($request);
                    } elseif (PostRequest::get('create')){
                        // HTML作成用メソッドの実行
                            return $this->output_source($request);
                    }
                // 元の画面を表示
                    //return view('parts.kaitori');
                    return view($file_pass4);
        }

/************************************************************************************************************************************************************************************************************* */
    // CSVのアップロード
/************************************************************************************************************************************************************************************************************* */
        public function kaitori_up(Request $request){

            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）start
            /************************************************************************************************************************************************************************************************************* */

                $define = $this->define();
                $def_i = 0;
                // 各変数にパスやファイル名を代入
                    foreach($define as $def){
                        if($def_i == 0){ $file_pass1 = $def; }
                        if($def_i == 1){ $file_pass2 = $def; }
                        if($def_i == 3){ $file_pass4 = $def; }
                        
                        $def_i++;
                    }
            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）end
            /************************************************************************************************************************************************************************************************************* */

                    // アップロードの前にフォルダ内のCSVを全削除（過去のファイルを参照する事故を防ぐ為かく、確実に現在アップしているものを扱うようにする）
                        //$directory = "../storage/app/public/csv/op/kaitori/";
                        $directory = $file_pass1;
                        $success = \File::cleanDirectory($directory);
                    
                    // ローカルと同名にてファイル名を取得
                        $file_name = $request->file('loadFileName')->getClientOriginalName();
                    // リネーム
                        if(strpos($file_name,'ロレックス') !== false){
                            $rename = date('Y_m_d_') . "ROLEX" . ".csv";
                        } else if(strpos($file_name,'オメガ') !== false){
                            $rename = date('Y_m_d_') . "OMEGA" . ".csv";
                        } else if(strpos($file_name,'ホイヤー') !== false){
                            $rename = date('Y_m_d_') . "HEUER" . ".csv";
                        } else if(strpos($file_name,'ブライトリング') !== false){
                            $rename = date('Y_m_d_') . "BREIT" . ".csv";
                        } else if(strpos($file_name,'セイコ') !== false){
                            $rename = date('Y_m_d_') . "SEIKO" . ".csv";
                        } else if(strpos($file_name,'パネライ') !== false){
                            $rename = date('Y_m_d_') . "PANERAI" . ".csv";
                        } else if(strpos($file_name,'IWC') !== false){
                            $rename = date('Y_m_d_') . "IWC" . ".csv";
                        } else if(strpos($file_name,'カルティエ') !== false){
                            $rename = date('Y_m_d_') . "CARTIER" . ".csv";
                        // 20211123
                        } else if(strpos($file_name,'パテック') !== false){
                            $rename = date('Y_m_d_') . "patek" . ".csv";
                        // 20211123
                        } else if(strpos($file_name,'ヴァシュロン') !== false){
                            $rename = date('Y_m_d_') . "VACHERON" . ".csv";
                        // 20211123
                        } else if(strpos($file_name,'AP') !== false){
                            $rename = date('Y_m_d_') . "AUDEMA" . ".csv";
                    } else {
                            $rename = date('Y_m_d_') . "kaitori" . ".csv";
                        }
                    // ファイルの存在有無を確認
                        //$file_name2 = '../storage/app/public/csv/op/kaitori/' . $rename;
                        $file_name2 = $file_pass1 . $rename;
                        if (\File::exists($file_name2)) {
                                $up_comment = "ファイルを上書きしました！";
                            } else {
                                $up_comment="ファイルをアップロードしました！";
                            }
                    // ファイルのアップロード
                        //$request->file('loadFileName')->storeAs('public/csv/op/kaitori',$rename);
                        $request->file('loadFileName')->storeAs($file_pass2,$rename);
                    // 元の画面を表示
                        //return view('parts.kaitori',['up_comment'=>$up_comment]);
                        return view($file_pass4,['up_comment'=>$up_comment]);

        }

/************************************************************************************************************************************************************************************************************* */
    // CSVを読み込み値を配列へ代入
/************************************************************************************************************************************************************************************************************* */
        public function read_csv(){

            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）start
            /************************************************************************************************************************************************************************************************************* */

                $define = $this->define();
                $def_i = 0;
                // 各変数にパスやファイル名を代入
                    foreach($define as $def){
                        if($def_i == 2){ $file_pass3 = $def; }
                        
                        $def_i++;
                    }

            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）end
            /************************************************************************************************************************************************************************************************************* */

            
            // ディレクトリ内のファイル名を全て取得
                //$files = glob('../storage/app/public/csv/op/kaitori/*');
                $files = glob($file_pass3);
            // 配列から取り出す
                foreach($files as $var){
                    $file_name = $var;
                }

            // ファイルの読み込み
                $file = new \SplFileObject(storage_path($file_name));
                
                $file->setFlags(
                  \SplFileObject::READ_CSV |           // CSV 列として行を読み込む
                  \SplFileObject::READ_AHEAD |       // 先読み/巻き戻しで読み出す。
                  \SplFileObject::SKIP_EMPTY |         // 空行は読み飛ばす
                  \SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす
                );

            // 読み込んだCSVデータをループ
                $i = 0;
                $stack = array();
                foreach ($file as $line) {

                    // 20211020 ローカルWindowsサーバーエラーに対する機能（環境がWindows日本語版でCSVがUTF-8のときに配列のカンマ区切りを分割出来ない現象が起きる為の対応(見た目はヘッダーの列数が減ってしまって最終行でソース代入も出来ないのでヘッダーが無いなど)Linuxでは必要ないが同じ挙動にしておきたいので）
                        $i3 = 0;
                        $windows_array = array();
                        // 行毎の配列を個別データに分解
                            foreach($line as $line2){
                                //if($i3 == 0){
                                // 個別データに「,」が含まれている場合（配列として分解されていないという事）
                                    if(strpos($line2, ',' ) !== false){  
                                        // 「,」で区切った配列へ分解する                          
                                            $line3 = explode(',',$line2);
                                        // 上記配列を分解して、データ毎に「$line」に代わる新しく作成した配列へ代入
                                            foreach($line3 as $line4){
                                                //echo "<span style='color:blue;'>" . $line4 . "</span><br><br>";
                                                // 余計な情報を削除
                                                    if(strpos($line4, '"' ) !== false){ 
                                                        $line4 = str_replace('"','',$line4);
                                                    }
                                                array_push($windows_array,$line4);
                                            }

                                    } else {
                                        // データ毎に「$line」に代わる新しく作成した配列へ代入
                                            array_push($windows_array,$line2);
                                    }
                               // }
                            }

                    // 20211020 撤去 mb_convert_variables('sjis-win', 'UTF-8', $line);
                        // 20211020 array_push($stack,$line);
                        // 20211020 「$line」に代わる新しく作成した配列を代入
                        array_push($stack,$windows_array);
          
                  $i++;
                }

            return $stack;

        }

/************************************************************************************************************************************************************************************************************* */
    // PC用HTMLの作成
/************************************************************************************************************************************************************************************************************* */

        public function create_html($a,$b,$c,$d,$e,$f,$g,$h,$j,$k,$l,$m,$n,$o,$p,$q,$r,$s,$t){

                // 引数で取得したデータを本メソッドで使用できるよう変数に代入
                $i = $a;                    // 行毎のナンバー
                $file_name = $b;
                $info1 = $c;
                $info2 = $d;
                $info3 = $e;
                $info4 = $f;
                $info5 = $g;
                $info6 = $h;
                $info7 = $j;
                $info8 = $k;
                $title1 = $l;
                $title2 = $m;
                $title3 = $n;
                $title4 = $o;
                $title5 = $p;
                $title6 = $q;
                $title7 = $r;
                $class_name1 = $s;
                $class_name2 = $t;
                $brand = "";
                $size = "";
                $model = "";

                //echo $class_name1 . "(" . $class_name2 . ")";

                // ブランド名の付与
                    if(strpos($file_name,'ROLEX') !== false){
                        $brand = "ロレックス";
                    } else if(strpos($file_name,'OMEGA') !== false){
                        $brand = "オメガ";
                    } else if(strpos($file_name,'HEUER') !== false){
                        $brand = "タグ・ホイヤー";
                    } else if(strpos($file_name,'BREIT') !== false){
                        $brand = "ブライトリング";
                    } else if(strpos($file_name,'SEIKO') !== false){
                        $brand = "セイコー";
                    } else if(strpos($file_name,'PANERAI') !== false){
                        $brand = "パネライ";
                    } else if(strpos($file_name,'IWC') !== false){
                        $brand = "IWC";
                    } else if(strpos($file_name,'CARTIER') !== false){
                        $brand = "カルティエ";
                    } else if(strpos($file_name,'patek') !== false){
                        $brand = "パテック フィリップ";
                    } else if(strpos($file_name,'VACHERON') !== false){
                        $brand = "ヴァシュロン・コンスタンタン";
                    } else if(strpos($file_name,'AUDEMA') !== false){
                        $brand = "オーデマ ピゲ";
                    }
                


            // 価格表示用の処理
                $info4 = (float)$info4;
                $info5 = (float)$info5;

                if($info4 != ""){
                    $pc_price = "<span class='" . $class_name1 . "1" . $class_name2 . "'>" . number_format($info4) . "円</span>";
                    $sp_price = "<span class='" . $class_name1 . "1" . $class_name2 . "'>" . number_format($info4) . "円</span>";
                } else {
                    $pc_price = "ASK";
                    $sp_price = "ASK";
                }
                if($info5 != ""){
                    $pc_price2 = number_format($info5) . "円";
                    $sp_price2 = number_format($info5) . "円";
                } else {
                    $pc_price2 = "ASK";
                    $sp_price2 = "ASK";
                }
            // 画像表示用の処理
                $sp_satei_link = "https://www.jackroad.co.jp/shop/assessment/assessment.aspx?subject_id=S0000001&goods=" . $info6;
                // 20220729if($info6 != ""){
                if($info6 != "" && strpos($info6,'noimg') === false){
                    //$pc_img = "<img src='https://www.jackroad.co.jp/img/goods/1/". $info6 . ".jpg' width='600' height='600' alt='" . $brand . " " . $info1 . "'>";
                    $pc_img = "<img src='https://www.jackroad.co.jp/img/goods/1/". $info6 . ".jpg' width='120' height='120' loading='lazy'>";
                    //20220117$pc_img = "<picture>";
                    //20220117$pc_img .= "<source type='image/webp' srcset='https://bo-wwwjackroadcojp.ecbeing.biz/img/brand/webp/". $info6 . ".webp' width='120' height='120' loading='lazy'>";
                    //20220117$pc_img .= "<img src='https://www.jackroad.co.jp/img/goods/1/". $info6 . ".jpg' width='120' height='120' loading='lazy'>";
                    //20220117$pc_img .= "</picture>";
                    $pc_img2 = "<a href='https://www.jackroad.co.jp/shop/assessment/assessment.aspx?subject_id=S0000001&goods=". $info6 . "'><img src='https://www.jackroad.co.jp/img/kaitori/btn_assessment.png' width='118' height='44' alt='査定申し込み' loading='lazy'></a>";
                    //20220117$pc_img2 = "<a href='https://www.jackroad.co.jp/shop/assessment/assessment.aspx?subject_id=S0000001&goods=". $info6 . "'>";
                    //20220117$pc_img2 .= "<picture>";
                    //20220117$pc_img2 .= "<source type='image/webp' srcset='https://bo-wwwjackroadcojp.ecbeing.biz/img/lp/purchase_record/goods/btn_assessment.webp' width='118' height='44' alt='査定申し込み' loading='lazy'>";
                    //20220117$pc_img2 .= "<img src='https://www.jackroad.co.jp/img/kaitori/btn_assessment.png' alt='' width='118' height='44' alt='査定申し込み' loading='lazy'>";
                    //20220117$pc_img2 .= "</picture>";
                    //20220117$pc_img2 .= "</a>";
                    //$sp_img = "<img src='https://www.jackroad.co.jp/img/goods/1/" . $info6 . ".jpg' width='600' height='600' alt='" . $brand . " " . $info1 . "'>";
                    $sp_img = "<img src='https://www.jackroad.co.jp/img/goods/1/" . $info6 . ".jpg' width='120' height='120' loading='lazy'>";
                    //20220117$sp_img = "<picture>";
                    //20220117$sp_img .= "<source type='image/webp' srcset='https://bo-wwwjackroadcojp.ecbeing.biz/img/brand/webp/". $info6 . ".webp' width='120' height='120' loading='lazy'>";
                    //20220117$sp_img .= "<img src='https://www.jackroad.co.jp/img/goods/1/". $info6 . ".jpg' width='120' height='120' loading='lazy'>";
                    //20220117$sp_img .= "</picture>";
                    $sp_img2 = "<a href='" . $sp_satei_link . "'><img src='https://www.jackroad.co.jp/img/kaitori/btn_assessment.png' width='400' height='150' alt='査定申し込み' loading='lazy'></a>";
                    //20220117$sp_img2 = "<a href='" . $sp_satei_link . "'>";
                    //20220117$sp_img2 .= "<picture>";
                    //20220117$sp_img2 .= "<source type='image/webp' srcset='https://bo-wwwjackroadcojp.ecbeing.biz/img/lp/purchase_record/goods/btn_assessment.webp' width='400' height='150' alt='査定申し込み' loading='lazy'>";
                    //20220117$sp_img2 .= "<img src='https://www.jackroad.co.jp/img/kaitori/btn_assessment.png' width='400' height='150' alt='査定申し込み' loading='lazy'>";
                    //20220117$sp_img2 .= "</picture>";
                    //20220117$sp_img2 .= "</a>";
                // 20220729 } else {
                } else if($info6 == "" || strpos($info6,'noimg') !== false) {
                    $pc_img = "<img src='https://www.jackroad.co.jp/img/kaitori/noimage.jpg' width='600' height='600' alt='NOIMAGE'>";
                    $pc_img2 = "<a href='#satei_area'><img src='https://www.jackroad.co.jp/img/kaitori/btn_ask.png' width='400' height='150' alt='お問い合わせください' loading='lazy'></a>";
                    $sp_img = "<img src='https://www.jackroad.co.jp/img/kaitori/noimage.jpg' width='600' height='600' alt='NOIMAGE'>";
                    $sp_img2 = "<a href='tel:0333869399'><img src='https://www.jackroad.co.jp/img/kaitori/btn_ask.png' width='400' height='150' alt='お問い合わせください' loading='lazy'></a>";
                }

            // PC用商品ソースのテンプレート
                /*20240809処理が重いので簡単にできる範囲でランダムロジックを外したい
                $p_rand = mt_rand(1,5);*/
                $dammy = "";                
                $dammy_sp = "";   
                /*20240809処理が重いので簡単にできる範囲でランダムロジックを外したい
                20240809for($p_i = 0; $p_i < $p_rand; $p_i++){*/
                    $dammy .= '<p class="' . $class_name1 . "23" . $class_name2 . '">' . $pc_price . "</p>";
                    $dammy_sp .='<div class="' . $class_name1 . "23" . $class_name2 . '"><p class="' . $class_name1 . "14" . $class_name2 . '">' . $sp_price . '</p></div>';
                //}
                $pc_sorce = "<div class='" . $class_name1 . "2" . $class_name2 . " " . $class_name1 . "4" . $class_name2 . "'>";
                $pc_sorce .= "<p>" .$info1 . "</p>";
                $pc_sorce .= "<p>". $info2 . "</p>";
                $pc_sorce .= "<p>". $info3 . "</p>";
                $pc_sorce .= $dammy;
                $pc_sorce .= "<p>". $pc_price . "</p>";
                $pc_sorce .= "<p class='" . $class_name1 . "3" . $class_name2 . "'>". $pc_price2 . "</p>";
                $pc_sorce .= $dammy;
                $pc_sorce .= "<p>" . $pc_img . "</p>";
                $pc_sorce .= "<p>" . $pc_img2 ."</p>";
                $pc_sorce .= "</div>";
                
            // SP用商品ソースのテンプレート
                $sp_sorce = '<div class="' . $class_name1 . "106" . $class_name2 . ' ' .$class_name1 . "8" . $class_name2 . ' '. $class_name1 . "5" . $class_name2 . ' ">';
                $sp_sorce .= '<div>';
                $sp_sorce .= '<div class="' .$class_name1 . "9" . $class_name2 . '">';
                $sp_sorce .= '<div class="' .$class_name1 . "10" . $class_name2 . '">' . $sp_img . '</div><div class="' . $class_name1 . "20" . $class_name2 . ' ' .$class_name1 . "22" . $class_name2 . ' ' .$class_name1 . "11" . $class_name2 . '"><span>' . $info1 . ' / ' . $info2 . '  / ' . $info3 . '</span></div>';
                //20220114 個別商品用の矢印をモデル用と分離する為、新たに作成
                //$sp_sorce .= '<div class="' . $class_name1 . "18" . $class_name2 . ' ' . $class_name1 . '16' . $class_name2 . '"></div>';
                $sp_sorce .= '<div class="' . $class_name1 . "118" . $class_name2 . ' ' . $class_name1 . '116' . $class_name2 . '"></div>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '<div class="' .$class_name1 . "119" . $class_name2 . ' ' .$class_name1 . "8" . $class_name2 . ' '. $class_name1 . "5" . $class_name2 . '">';
                $sp_sorce .= '<div class="' .$class_name1 . "8" . $class_name2 . '">';
                $sp_sorce .= '<div class="' .$class_name1 . "13" . $class_name2 . ' '. $class_name1 . "15" . $class_name2 .'">';
                $sp_sorce .= '<p class="' .$class_name1 . "12" . $class_name2 . '">' . $title4 . '</p>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '<div class="' .$class_name1 . "13" . $class_name2 . ' '. $class_name1 . "15" . $class_name2 .' ">';
                $sp_sorce .= '<p class="' .$class_name1 . "12" . $class_name2 . '">' . $title5 . '</p>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '</div>';
                $sp_sorce .= $dammy_sp;
                $sp_sorce .= '<div class="' .$class_name1 . "8" . $class_name2 . '">';
                $sp_sorce .= '<div class="' .$class_name1 . "13" . $class_name2 . '">';
                $sp_sorce .= '<p class="' . $class_name1 . "20" . $class_name2 . '">' . $sp_price . '</p>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '<div class="' .$class_name1 . "13" . $class_name2 . '">';
                $sp_sorce .= '<p class="' . $class_name1 . "14" . $class_name2 . '">' . $sp_price2 . '</p>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '</div>';
                $sp_sorce .= $dammy_sp;
                $sp_sorce .= '<div class="' .$class_name1 . "8" . $class_name2 . '">';
                $sp_sorce .= '<div class="' .$class_name1 . "13" . $class_name2 . ' '. $class_name1 . "15" . $class_name2 .'">';
                $sp_sorce .= '<p class="' .$class_name1 . "12" . $class_name2 . '">' . $title6 . '</p>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '<div class="' .$class_name1 . "13" . $class_name2 . ' '. $class_name1 . "15" . $class_name2 .'">';
                $sp_sorce .= '<p class="' .$class_name1 . "12" . $class_name2 . '">' . $title7 . '</p>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '<div class="' .$class_name1 . "8" . $class_name2 . '">';
                $sp_sorce .= '<div class="' .$class_name1 . "13" . $class_name2 . '">';
                $sp_sorce .= '<p>' . $sp_img . '</p>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '<div class="' .$class_name1 . "13" . $class_name2 . ' ' . $class_name1 . "21" . $class_name2 . '">';
                $sp_sorce .= '<p>' . $sp_img2 . '</p>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '</div>';
                $sp_sorce .= '</div>';

                $all_sorce = array();
                

                // サイズの付与
                    // メンズ
                        if($info8 == ""){
                            $size = "メンズ";
                    // レディース
                        } else {
                            $size = "レディース";
                        }
                // 処理しないフラグ（サイズの変数を利用）
                    if(strpos($info1,'ここまで') !== false){
                        $size = "";
                    }
                        

                // モデル名の付与
                    if($brand == "ロレックス"){
                        if(strpos($info1,'デイトナ') !== false){
                            $model = "デイトナ";
                        } else if(strpos($info1,'エクスプローラー') !== false){
                            $model = "エクスプローラー";
                        } else if(strpos($info1,'GMT') !== false){
                            $model = "GMT";
                        } else if(strpos($info1,'サブマリーナ') !== false){
                            $model = "サブマリーナ";
                        /*20220121 ディープシーはシードゥエラーのシリーズ} else if(strpos($info1,'ディープシ') !== false){
                            $model = "ディープシー";*/
                        //20220114} else if(strpos($info1,'シードゥウェラ') !== false){
                        //20220121} else if(strpos($info1,'シードゥウェラ') !== false || strpos($info1,'シードゥエラ') !== false){
                        } else if(strpos($info1,'シードゥウェラ') !== false || strpos($info1,'シードゥエラ') !== false || strpos($info1,'ディープシ') !== false){
                            //20200114$model = "シードゥウェラー";
                            $model = "シードゥエラー";
                        } else if(strpos($info1,'ヨットマスタ') !== false){
                            $model = "ヨットマスター";
                        } else if(strpos($info1,'ミルガウス') !== false){
                            $model = "ミルガウス";
                        } else if(strpos($info1,'デイトジャスト') !== false){
                            $model = "デイトジャスト";
                        } else if(strpos($info1,'スカイドゥエラー') !== false){
                            $model = "スカイドゥエラー";
                        } else if(strpos($info1,'エアキング') !== false){
                            $model = "エアキング";
                        }
                    } else if($brand == "オメガ"){
                        if(strpos($info1,'スピードマスター') !== false){
                            $model = "スピードマスター";
                        } else if(strpos($info1,'シーマスタ') !== false){
                            $model = "シーマスター";
                        } else if(strpos($info1,'デ・ヴィル') !== false){
                            $model = "デ・ヴィル";
                        } else if(strpos($info1,'コンステレーション') !== false){
                            $model = "コンステレーション";
                        } else if(strpos($info1,'レイルマスター') !== false){
                            $model = "レイルマスター";
                        }
                    } else if($brand == "タグ・ホイヤー"){
                        if(strpos($info1,'カレラ') !== false){
                            $model = "カレラ";
                        } else if(strpos($info1,'アクアレーサー') !== false){
                            $model = "アクアレーサー";
                        } else if(strpos($info1,'フォーミュラ') !== false){
                            $model = "フォーミュラ";
                        } else if(strpos($info1,'モナコ') !== false){
                            $model = "モナコ";
                        } else if(strpos($info1,'リンク') !== false){
                            $model = "リンク";
                        }
                    } else if($brand == "ブライトリング"){
                        if(strpos($info1,'クロノマット') !== false){
                            $model = "クロノマット";
                        } else if(strpos($info1,'ナビタイマー') !== false){
                            $model = "ナビタイマー";
                        } else if(strpos($info1,'アビエーター8') !== false){
                            $model = "アビエーター8";
                        } else if(strpos($info1,'スーパーオーシャン') !== false && strpos($info1,'ヘリテージ') !== false){
                            $model = "スーパーオーシャンヘリテージ";
                        } else if(strpos($info1,'スーパーオーシャン') !== false){
                            $model = "スーパーオーシャン";
                        } else if(strpos($info1,'トランスオーシャン') !== false){
                            $model = "トランスオーシャン";
                        } else if(strpos($info1,'アベンジャー') !== false){
                            $model = "アベンジャー";
                        } else if(strpos($info1,'プレミエ') !== false){
                            $model = "プレミエ";
                        } else if(strpos($info1,'モンブリラン') !== false){
                            $model = "モンブリラン";
                        } else if(strpos($info1,'コルト') !== false){
                            $model = "コルト";
                        } else if(strpos($info1,'プロフェッショナル') !== false){
                            $model = "プロフェッショナル";
                        } else if(strpos($info1,'コックピット') !== false){
                            $model = "コックピット";
                        } else if(strpos($info1,'ベントレー') !== false){
                            $model = "ベントレー";
                        } else if(strpos($info1,'ギャラクティック') !== false){
                            $model = "ギャラクティック";
                        }
                    } else if($brand == "セイコー"){
                        if(strpos($info1,'GS スプリングドライブ') !== false){
                            $model = "GS スプリングドライブ";
                        } else if(strpos($info1,'GS メカニカル') !== false){
                            $model = "GS メカニカル";
                        } else if(strpos($info1,'GS クオーツ') !== false){
                            $model = "GS クオーツ";
                        } else if(strpos($info1,'アストロン') !== false){
                            $model = "アストロン";
                        }
                    } else if($brand == "パネライ"){
                        if(strpos($info1,'ラジオミール') !== false){
                            $model = "ラジオミール";
                        } else if(strpos($info1,'ルミノール') !== false){
                            $model = "ルミノール";
                        } else if(strpos($info1,'サブマーシブル') !== false){
                            $model = "サブマーシブル";
                        }
                    } else if($brand == "IWC"){
                        if(strpos($info1,'ポルトギーゼ') !== false){
                            $model = "ポルトギーゼ";
                        } else if(strpos($info1,'パイロット') !== false){
                            $model = "パイロット";
                        } else if(strpos($info1,'ポートフィノ') !== false){
                            $model = "ポートフィノ";
                        } else if(strpos($info1,'インヂュニア') !== false){
                            $model = "インヂュニア";
                        } else if(strpos($info1,'アクアタイマー') !== false){
                            $model = "アクアタイマー";
                        } else if(strpos($info1,'ヴィンチ') !== false){
                            $model = "ダ・ヴィンチ";
                        } 
                    } else if($brand == "カルティエ"){
                        if(strpos($info1,'タンクフランセーズ') !== false){
                            $model = "タンクフランセーズ";
                        } else if(strpos($info1,'カリブル') !== false){
                            $model = "カリブル";
                        } else if(strpos($info1,'タンクMC') !== false){
                            $model = "タンクMC";
                        } else if(strpos($info1,'タンクソロ') !== false){
                            $model = "タンクソロ";
                        } else if(strpos($info1,'タンクアメリカン') !== false){
                            $model = "タンクアメリカン";
                        } else if(strpos($info1,'サントス') !== false){
                            $model = "サントス";
                        } else if(strpos($info1,'パンテール') !== false){
                            $model = "パンテール";
                        } else if(strpos($info1,'バロンブルー') !== false){
                            $model = "バロンブルー";
                        } else if(strpos($info1,'パシャ') !== false){
                            $model = "パシャ";
                        } else if(strpos($info1,'ロンドソロ') !== false){
                            $model = "ロンドソロ";
                        } 
                    } else if($brand == "パテック フィリップ"){
                        if(strpos($info1,'アクアノート') !== false){
                            $model = "アクアノート";
                        } else if(strpos($info1,'ノーチラス') !== false){
                            $model = "ノーチラス";
                        }
                    } else if($brand == "ヴァシュロン・コンスタンタン"){
                    } else if($brand == "オーデマ ピゲ"){
                        if(strpos($info1,'ロイヤルオーク') !== false){
                            $model = "ロイヤルオーク";
                        } else if(strpos($info1,'CODE 11.59') !== false){
                            $model = "CODE 11.59";
                        }
                    }
                // 取得した情報を配列へ代入し、別のメソッドへ渡す
                    if($i != 0){
                        array_push($all_sorce,$brand);
                        array_push($all_sorce,$size);
                        array_push($all_sorce,$model);
                        array_push($all_sorce,$pc_sorce);
                        array_push($all_sorce,$sp_sorce);
                    }
                   // print_r($all_sorce);
    
            return $all_sorce;

        }


/************************************************************************************************************************************************************************************************************* */
    // ブランド別にヘッダー・フッターのHTMLを作成
/************************************************************************************************************************************************************************************************************* */
        public function create_temp_html($file_name,$class_name1,$class_name2){

            $file_name = $file_name;

            if(strpos($file_name,'ROLEX') !== false){

                $complate = "ロレックス 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "afeeee";
                $brand_title = "ロレックス買取ページ・";
                /*$brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>ロレックス買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>ロレックス買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    

                                    <div>
                                        <h1 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_rolex.png" alt="ロレックス買取価格・相場【ジャックロード】" width="1240" height="40"></h1>
                                        <h2 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/main_rolex_satei.jpg" alt="ロレックス限定・買取額10％UPキャンペーン実施中" width="1240" height="488"></h2>
                                        <p class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point.png" alt="高額査定のポイント" width="295" height="75"></p>
                                        <h1 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_rolex_sp.png" alt="ロレックス買取価格・相場【ジャックロード】" width="1000" height="108"></h1>
                                        <h2 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/main_rolex_satei_sp.jpg" alt="ロレックス限定・買取額10％UPキャンペーン実施中" width="1000" height="802"></h2>
                                        <p class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point_sp.png" alt="高額査定のポイント" width="590" height="150"></p>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証期間内のもの。<br>（保証書に記入の改ざん等が無いもの）</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div class="btn_area2 bgc-blue">
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                        </div>													
                                        <p class="other_brand_title">ROLEX<br>買取価格表</p>
                                        <ul class="atention">
                                            <li>※ 保証書に記載されている日付が3カ月以上前の場合、その日付に応じて買取価格は変動いたします</li>
                                            <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                            <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                            <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='				<div class="btn_area">
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            </div>
                                            <div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">ロレックス以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <!--<ul class="other_brand_box">-->
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';*/
                
                $brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>ロレックス買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>ロレックス買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h1>ロレックス買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_rolex_satei.jpg" alt="ロレックス限定・買取額10％UPキャンペーン実施中" width="1240" height="488" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_rolex_satei_sp.jpg" alt="ロレックス限定・買取額10％UPキャンペーン実施中" width="1000" height="802" class="sp">
                                        <h2>高額査定のポイント</h2>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証期間内のもの。<br>（保証書に記入の改ざん等が無いもの）</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">ROLEX</span><br>買取価格表</h2>
                                        <ul class="atention">
                                            <li>※ 保証書に記載されている日付が3カ月以上前の場合、その日付に応じて買取価格は変動いたします</li>
                                            <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                            <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                            <li>※ 一部対象外の商品もあります。</li>
                                            <li>※ 買取価格表に掲載のないモデルの買取査定依頼は直接お問い合わせください。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='<div id="satei_area">
                                    <p>いますぐ無料査定!!</p>
                                    <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                    </div>
                                    <p>お電話でもお気軽にご相談ください。</p>
                                    <p><a href="tel:0333869399">03-3386-9399</a></p>
                               </div>
                               <span id="other" class="innerlink"></span>
                               <p class="title2">ロレックス以外の買取価格表はこちら</p>
                               <div class="other_brand_cont">
                                   <!--<ul class="other_brand_box">-->
                                   <ul class="other_brand_link">
                                       <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                       <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                       <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                       <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                       <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                       <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                       <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                       <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                       <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>
                                       <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                   </ul>
                               </div>
                            </div>
                        </div>
                    </div>';
            // 20220331 追加コンテンツも自動出力するよう追記
                $brand_footer2 ='
                </div>
                <hr align="center" style="width:90%;">
                <div class="appeal_area">
                    <div id="aq_area">
                    <h2>ロレックス買取価格Q&amp;A</h2>
                    <dl class="reverse">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q1\');">ロレックスを高く買い取ってもらうための条件はありますか？</a></span></dt>
                    <dd>
                        <span>基本的には、年式が新しいロレックス(ROLEX)ほど買取価格は高くなります。特に2010年以降のモデルは、それ以前のようにシリアルナンバーで製造年を推定できなくなるため、保証書記載の日付が買取価格に影響します。そのため、保証書の有無で価格が大きく変わる場合があります。保証書以外にもブレスレットの余りコマやボックスも一緒にご持参いただけますと査定額がプラスとなります（もちろん付属品がなくても買取可能です）。</span>
                    </dd>
                    </dl>
                    <dl class="reverse">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q2\');">付属品は揃っている方が買取価格は高くなりますか？</a></span></dt>
                    <dd>
                        <span>はい、ロレックスの買取では箱や取扱説明書などの付属品、特に保証書が揃っている場合は高価な買取価格となる傾向にあります。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q3\');">ロレックスの買取価格にはどんなことが影響しますか？</a></span></dt>
                    <dd class="op1">
                        <span>ロレックスの買取ではお品物の状態(傷、汚れの有無など)に加え、年式や保証書の有無、箱や付属品が揃っているかどうかも買取価格に影響します。基本的には年式が新しいほど買取価格は高くなります。また、新作モデルはお探しのお客さまも多く、特に高値で取り引きされる傾向があります。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q4\');">故障していたり、傷がありますが買取できますか？</a></span></dt>
                    <dd class="op1">
                        <span>はい、買取可能です。状態が悪いモデルでも、弊社提携工房でメンテナンスを行う事で修理金額を大幅に抑え、高価買取を実現しています。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q5\');">保証書がなくても買取可能でしょうか？</a></span></dt>
                    <dd class="op1">
                        <span>はい、保証書がなくても買い取りいたしております。しかしながら保証書の有無によって買取価格は大きく変動いたしますので、保証書は大切に保管されることをおすすめします。保証書の有無による買取価格の変動幅はモデルによっても異なります。ご不明な点がございましたらお気軽にお問い合わせください。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q6\');">買取価格に流行やトレンドは影響しますか？</a></span></dt>
                    <dd class="op1">
                        <span>ロレックスは他ブランドと比べて国内外で人気・知名度ともに安定して高く、資産価値が下がりにくいブランドです。したがって流行やトレンドによって買取価格が大きく下落することは比較的少ないブランドといえます。むしろ定番モデルや人気のスポーツモデルは常に一定以上の需要があり、買取価格は高水準で推移しています。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q7\');">新作のモデルほど買取価格は高くなりますか？</a></span></dt>
                    <dd class="op1">
                        <span>はい、新作モデルは高価な買取価格となる傾向にあります。ロレックスの新作は他ブランドと比べても非常に注目度が高いため、発売からしばらくの間は入手困難な状態が続きます。そのためメーカー希望小売価格より高値で取引されることも珍しくありません。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q8\');">時計が古く、修理やオーバーホールを行っていませんが買取できますか？</a></span></dt>
                    <dd class="op1">
                        <span>はい、買取可能です。古いモデルや状態が悪いモデルでも、弊社提携工房でメンテナンスを行う事で修理金額を大幅に抑え、高価買取を実現しています。動かない(止まっている)時計でも買取できる場合がありますので、お気軽にご相談ください。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q9\');">売却の際はオーバーホールや修理を行った方が良いですか？</a></span></dt>
                    <dd class="op1">
                        <span>基本的にはオーバーホールをした後の良いコンディションの方が買取価格は高くなります。しかしながらロレックスのオーバーホールは費用が高いため、その費用を考慮するとそのままご売却いただいた方が最終的に手元に残る金額は大きくなる可能性があります。弊社では提携工房で費用を抑えてメンテナンスを行っておりますので、オーバーホールに出す前にまずはご相談いただければと思います。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q10\');">アンティーク(ヴィンテージ)モデルの買取は可能でしょうか？</a></span></dt>
                    <dd class="op1">
                        <span>はい、アンティーク(ヴィンテージ)モデルも買取可能です。アンティーク(ヴィンテージ)モデルの中には高価買取となる個体もございます。「もう売れないかも」とお考えの方も、まずはお問い合わせください。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q11\');">買取査定や売却キャンセルは無料でできますか？</a></span></dt>
                    <dd class="op1">
                        <span>はい、査定は無料で行っております。買取価格にご満足いただけなかった場合はキャンセルも可能です。キャンセル料などもいただいておりませんのでご安心ください。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q12\');">郵送で行った査定の結果、買取を見送りたい場合は依頼した時計はどうなりますか？</a></span></dt>
                    <dd class="op1">
                        <span>万が一買取が不成立となった場合、お品物は当店負担で返送いたしますので、どうぞご安心ください。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q13\');">ショッピングローンの支払い中ですが、買取は可能でしょうか？</a></span></dt>
                    <dd class="op1">
                        <span>ショッピングローンのお支払いの途中(まだローン残高がある状態)でのお買取りはできかねますのでご了承ください。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q14\');">買取成立したら、その場で現金支給されますか？</a></span></dt>
                    <dd class="op1">
                        <span>はい、店頭でのお買取りの場合はその場で現金にてお支払いいたします。ご希望の場合は振込でのお支払いも可能です。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q15\');">未成年(20歳未満)者の買取依頼は可能でしょうか？</a></span></dt>
                    <dd class="op1">
                        <span>大変申し訳ございませんが、未成年(20歳未満)者のお客さまからの買取査定のご依頼は受け付けておりません。未成年(20歳未満)者のお客さまは親権者様のご同伴と、親権者様ご自身の名義・ご本人確認書類でのお申込みをお願いいたします。
                            </span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q16\');">電話やメールで買取査定は可能でしょうか？</a></span></dt>
                    <dd class="op1">
                        <span>ブランド名、モデル名、型番、色、付属品(箱・保証書)の有無など、ご希望のモデルの情報をお伝えいただければ、目安の買取価格をお伝えすることが可能です。ただし、お品物の状態や市場の動向によって買取価格は上下いたしますので、実際の買取価格は変動する可能性がございます。</span>
                    </dd>
                    </dl>
                    <dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q17\');">査定額の変動はありますか？</a></span></dt>
                    <dd class="op1">
                        <span>はい、査定額は為替相場や国内定価の変更などによって変動いたします。また、メーカーによる生産終了や需要と供給のバランスによっても変動する場合がございます。</span>
                    </dd>
                    </dl>
                    <!--<dl class="op2">
                    <dt><span><a ontouchstart="ga(\'send\',\'event\',\'k_q&a\',\'Click\',\'q18\');">ロレックスを高く買い取ってもらうための条件はありますか？</a></span></dt>
                    <dd class="op1">
                        <span>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</span>
                    </dd>
                    </dl>-->
                    </div>
                    <script>
                    $("#aq_area .op1").hide();
                    $("#aq_area .op2").on("click", function (e) {
                    $("dd", this).slideToggle("fast");
                    if ($(this).hasClass("open")) {
                        $(this).removeClass("open");
                    } else {
                        $(this).addClass("open");
                    }  
                    });
                    $("#aq_area .reverse").on("click", function (e) {
                    $("dd", this).slideToggle("fast");
                    if ($(this).hasClass("open2")) {
                        $(this).removeClass("open2");
                    } else {
                        $(this).addClass("open2");
                    }  
                    });
                    </script>
                    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
                    <div id="chart_area">
                    <h2>ロレックス買取相場の推移</h2>
                    <canvas id="chart"></canvas>
                    <p>※上記は参考価格であり、新品の状態や時期により買取相場は変動します</p>-->
                    <!--<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>-->
                    <!--</div>
                    <script>
                    // SPの場合のみ高さを大きくする
                        var view_size = $("#chart_area").width();
                        if(view_size < 641){
                            var ctx2 = document.getElementById(\'chart\').getContext(\'2d\');
                            ctx2.canvas.height = 300;
                        }
                    var ctx = document.getElementById("chart");
                    var myLineChart = new Chart(ctx, {
                    // グラフの種類：折れ線グラフを指定
                        type: \'line\',
                        data: {
                    // x軸の各メモリ
                        labels: ["2021/08/31", "2021/10/31", "2021/11/11", "2021/11/15", "2021/11/25", "2021/12/01", "2021/12/19", "2022/01/04", "2022/01/10"],
                        datasets: [
                            {
                            label: \'デイトナ 116500LN・黒\',
                            data: [3431000, 3497000, 3607000, 3717000, 3750000, 3860000, 3970000, 4146000,4322000],
                            borderColor: "#c1ab05",
                            backgroundColor: "#00000000"
                            },
                            {
                            label: \'デイトナ 116500LN・白\',
                            data: [3937000, 4058000, 4124000, 4146000, 4212000, 4322000, 4465000, 4685000,4872000],
                            borderColor: "#68a9cf",
                            backgroundColor: "#00000000"
                            }
                        ],
                        },
                        options: {
                            // マウスオーバー時の表示データの編集
                            tooltips: {
                                callbacks: {
                                label: function(tooltipItems, data) {
                                    if(tooltipItems.yLabel == "0"){
                                        return "";
                                    }
                                    // 価格用データをカンマ区切りへ
                                    tooltipItems.yLabel = tooltipItems.yLabel.toString();
                                    tooltipItems.yLabel = tooltipItems.yLabel.split(/(?=(?:...)*$)/);
                                    tooltipItems.yLabel = tooltipItems.yLabel.join(\',\');
                                    // 後ろに「円」を付けて表示
                                    return data.datasets[tooltipItems.datasetIndex].label + "：" + tooltipItems.yLabel + "円";
                                }
                                }
                            },  
                        // タイトルの編集  
                            title: {
                                display: true/*,
                                text: \'買取価格の推移\'*/
                            },
                            // 縦軸表示データの編集
                            scales: {
                            yAxes: [{
                                ticks: {
                                    /*beginAtZero: true,
                                    stepSize: 100000,
                                    min: 2500000,
                                    max: 4200000,*/
                                    /*suggestedMax: 40,
                                    suggestedMin: 15
                                    stepSize: 10,  // 縦メモリのステップ数,*/
                                    callback: function(value, index, values){
                                    // 価格用データをカンマ区切りへ
                                    value = value.toString();
                                    value = value.split(/(?=(?:...)*$)/);
                                    value = value.join(\',\');
                                    // 後ろに「円」を付けて表示
                                    return value + "円";            
                                    }
                                }
                                
                                }]
                            },
                        }
                    });
                    </script>-->
                    <div id="satei_area">
                        <p>いますぐ無料査定!!</p>
                        <div class="satei_img">
                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_line.webp" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                            <div class="satei_img_box">
                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc">
                                    <picture>
                                      <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_satei.webp" width="200" height="100">
                                      <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_satei.png" alt="3ステップ査定" width="200" height="100">
                                    </picture>
                                </a>
                            </div>
                            <div class="satei_img_box">
                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc">
                                    <picture>
                                      <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_delivery.webp" width="200" height="100">
                                      <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_delivery.png" alt="宅配買取" width="200" height="100">
                                    </picture>
                                </a>
                            </div>
                        </div>
                        <p>お電話でもお気軽にご相談ください。</p>
                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                    </div>
                    <div id="record_area">
                        <h2>ロレックス買取実績</h2>
                        <p>当店ジャックロードのロレックス買取実績の一部をご紹介いたします。</p>
                        <div class="product_list">
                          <div class="product">
                            <picture>
                              <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx_01.webp" width="420" height="420">
                              <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx_01.jpg" alt="ロレックス オイスターパーペチュアル" width="420" height="420">
                            </picture>
                            <p>ロレックス オイスターパーペチュアル</p>
                            <p>Ref.76080</p>
                            <p>--</p>
                          </div>
                          <div class="product">
                            <picture>
                              <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx_02.webp" width="420" height="420">
                              <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx_02.jpg" alt="ロレックス グリーン サブマリーナー デイト" width="420" height="420">
                            </picture>
                            <p>ロレックス グリーン サブマリーナー デイト</p>
                            <p>Ref.126610LV</p>
                            <p>黒文字盤</p>
                          </div>
                          <div class="product">
                            <picture>
                              <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx_03.webp" width="420" height="420">
                              <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx_03.jpg" alt="ロレックス コスモグラフ デイトナ" width="420" height="420">
                            </picture>
                            <p>ロレックス コスモグラフ デイトナ</p>
                            <p>Ref.116519</p>
                            <p>グレー文字盤</p>
                          </div>
                          <div class="product">
                            <picture>
                              <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx04.webp" width="420" height="420">
                              <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx04.jpg" alt="ロレックス デイトナ" width="420" height="420">
                            </picture>
                            <p>ロレックス デイトナ</p>
                            <p>Ref.116506</p>
                            <p>アイスブルー文字盤</p>
                          </div>
                          <div class="product">
                            <picture>
                              <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx05.webp" width="420" height="420">
                              <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx05.jpg" alt="ロレックス GMTマスター" width="420" height="420">
                            </picture>
                            <p>ロレックス GMTマスター</p>
                            <p>Ref.126715CHNR</p>
                            <p></p>
                          </div>
                            <div class="product">
                            <picture>
                              <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx06.webp" width="420" height="420">
                              <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx06.jpg" alt="ロレックス エクスプローラーII" width="420" height="420">
                            </picture>
                            <p>エクスプローラーII</p>
                            <p>Ref.226570</p>
                            <p>白文字盤</p>
                          </div>
                      
                      <!--<div class="product">
                            <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx07.webp" width="210" height="210" alt="">
                            <p>シードゥエラー 4000</p>
                            <p>Ref.116600</p>
                            <p></p>
                          </div>
                          <div class="product">
                            <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx08.webp" width="210" height="210" alt="">
                            <p>デイトジャスト</p>
                            <p>Ref.116233</p>
                            <p>シャンパンゴールド</p>
                          </div>
                      <div class="product">
                            <img src="https://picsum.photos/200/210" width="210" height="210" alt="">
                            <p>コスモグラフ デイトナ</p>
                            <p>Ref.116500LN</p>
                            <p>白文字盤</p>
                          </div>-->
                        </div>
                    </div>
                    <div id="voice_area">
                    <h2>ロレックスをご売却のお客さまからの声</h2>
                    <div class="voice_cont">
                        <div class="voice_m_cont">
                            <div class="voice_left">
                                <div class="voice_left_img">
                                    <picture>
                                      <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx001.webp" width="300" height="300">
                                      <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx001.jpg" alt="ロレックス コスモグラフ デイトナ" width="300" height="300">
                                    </picture>
                                    <a href="/shop/g/grx001/"><p>商品を見る＞</p></a>
                                </div>
                            </div>
                            <div class="voice_center">
                                <p>コスモグラフ デイトナ Ref.116520</p>
                                <p>★★★★★</p>
                                <p>レビュー投稿者：非公開</p>
                                <p>ロレックスを二本買い取りしてもらったのですが他店よりいい金額にしてもらい、翌日には入金されてました、買取額はよく購入額も安くスタッフもよくおすすめのお店です、またお世話になりたいと思います</p>
                            </div>
                            <div class="voice_right"><span class="font1">2007.5.18</span></div>
                        </div>
                        <div class="voice_m_cont">
                            <div class="voice_left">
                                <div class="voice_left_img">
                                    <picture>
                                      <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.webp" width="300" height="300">
                                      <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.jpg" alt="無料買取キット(Sサイズ：縦20×横21.5×深さ17)" width="300" height="300">
                                    </picture>
                                    <a href="/shop/g/gkaitorikit1/"><p>商品を見る＞</p></a>
                                </div>
                            </div>
                            <div class="voice_center">
                                <p>無料買取キット(Sサイズ：縦20×横21.5×深さ17)</p>
                                <p>★★★★★</p>
                                <p>レビュー投稿者：時計仕掛けのミカン</p>
                                <p><span class="b">満足&amp;楽チン</span><br>
                                   満足な価格で買い取ってもらえました。</p>
                            </div>
                            <div class="voice_right"><span class="font1">2021.6.24</span></div>
                        </div>
                        <div class="voice_switch" style="width:100%;">
                        <div class="voice_open">
                            <div class="voice_m_cont">
                                <div class="voice_left">
                                    <div class="voice_left_img">
                                        <picture>
                                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.webp" width="300" height="300">
                                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.jpg" alt="無料買取キット(Mサイズ：縦23×横30×深さ19)" width="300" height="300">
                                        </picture>
                                        <a href="/shop/g/gkaitorikit/"><p>商品を見る＞</p></a>
                                    </div>
                                </div>
                                <div class="voice_center">
                                    <p>無料買取キット(Mサイズ：縦23×横30×深さ19)</p>
                                    <p>★★★★★</p>
                                    <p>レビュー投稿者：izumi</p>
                                    <p><span class="b">ロレックスBOX入を発送するのに最適でした</span><br>
                                        購入の際はもちろんですが、発送、査定、入金なども大変スムーズに行って頂きました。<br>
                                        ちょうどロレックス強化買取月間だったのもあり、買取額にも大変満足です。<br>
                                        また、いつか再度ロレックスを手にしたい時はぜひお願いしたいと思います。</p>
                                </div>
                                <div class="voice_right"><span class="font1">2021.7.20</span></div>
                            </div>
                            <div class="voice_m_cont">
                                <div class="voice_left">
                                    <div class="voice_left_img">
                                        <picture>
                                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/ch207.webp" width="300" height="300">
                                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/ch207.jpg" alt="シャネル J12 ピンク ブラッシュ" width="300" height="300">
                                        </picture>
                                        <a href="/shop/g/gch207/"><p>商品を見る＞</p></a>
                                    </div>
                                </div>
                                <div class="voice_center">
                                    <p>J12 ピンク ブラッシュ Ref.H6755</p>
                                    <p>★★★★★</p>
                                    <p>レビュー投稿者：たかはな</p>
                                    <p><span class="b">ホワイト×ピンクが最強</span><br>
                                        買取も高く評価され、ありえない値段で購入できた。次回もまたお願いしまーす★</p>
                                </div>
                                <div class="voice_right"><span class="font1">2021.7.8</span></div>
                            </div>
                            <div class="voice_m_cont">
                                <div class="voice_left">
                                    <div class="voice_left_img">
                                        <picture>
                                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.webp" width="300" height="300">
                                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.jpg" alt="無料買取キット(Mサイズ：縦23×横30×深さ19)" width="300" height="300">
                                        </picture>
                                        <a href="/shop/g/gkaitorikit/"><p>商品を見る＞</p></a>
                                    </div>
                                </div>
                                <div class="voice_center">
                                    <p>無料買取キット(Mサイズ：縦23×横30×深さ19)</p>
                                    <p>★★★★★</p>
                                    <p>レビュー投稿者：ヨッシー</p>
                                    <p><span class="b">無料買取キット</span><br>
                                        電話すればすぐに発送して貰えた上に、キットの中には梱包セットが入っているので、査定する時計を入れて送り返すだけと、非常に簡単で便利でした。<br>
                                        また査定も、2日後には連絡が来たので、とても早い取り引きができました。</p>
                                </div>
                                <div class="voice_right"><span class="font1">2021.7.14</span></div>
                            </div>
                            <div class="voice_m_cont">
                                <div class="voice_left">
                                    <div class="voice_left_img">
                                        <picture>
                                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.webp" width="300" height="300">
                                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.jpg" alt="無料買取キット(Mサイズ：縦23×横30×深さ19)" width="300" height="300">
                                        </picture>
                                        <a href="/shop/g/gkaitorikit/"><p>商品を見る＞</p></a>
                                    </div>
                                </div>
                                <div class="voice_center">
                                    <p>無料買取キット(Mサイズ：縦23×横30×深さ19)</p>
                                    <p>★★★★★</p>
                                    <p>レビュー投稿者：まさ</p>
                                    <p><span class="b">買い取りには至りませんでしたが</span><br>
                                        査定に出させて頂きました。<br>
                                        買い取りには至りませんでしたが、丁寧な対応をして下さり感謝しております。</p>
                                </div>
                                <div class="voice_right"><span class="font1">2021.7.12</span></div>
                            </div>
                            <div class="voice_m_cont">
                                <div class="voice_left">
                                    <div class="voice_left_img">
                                        <picture>
                                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.webp" width="300" height="300">
                                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/kaitorikit.jpg" alt="無料買取キット(Lサイズ：縦28×横33×深さ22)" width="300" height="300">
                                        </picture>
                                        <a href="/shop/g/gkaitorikit2/"><p>商品を見る＞</p></a>
                                    </div>
                                </div>
                                <div class="voice_center">
                                    <p>無料買取キット(Lサイズ：縦28×横33×深さ22)</p>
                                    <p>★★★★☆</p>
                                    <p>レビュー投稿者：no name</p>
                                    <p><span class="b">買取り箱</span><br>
                                        Jack Loadさんは、いつもながらスピーディーな対応ですね。他にも、時計(特にUSED)価格は、「買い取り」も「売り価格」も国内ではプライスリーダーだと思います。</p>
                                </div>
                                <div class="voice_right"><span class="font1">2021.7.12</span></div>
                            </div>
                            </div>
                            <div class="voice_change" style="width:100%; text-align:center; padding-top:20px;cursor: pointer;">もっと見る</div>
                        </div>
                        <script>
                        $(".voice_open").hide();
                        $(".voice_switch").on("click", function (e) {
                        $(".voice_open", this).slideToggle("fast");
                        if ($(this).hasClass("open")) {
                            $(this).removeClass("open");
                            $(\'.voice_change\').text("もっと見る");
                        } else {
                            $(this).addClass("open");
                            $(\'.voice_change\').text("閉じる");
                        }
                        });
                        </script>
                    </div>
                    </div>
                    <div id="reason_area">
                    <h2>ロレックスが人気の理由</h2>
                    <div class="reason_cont">
                        <div class="reason_left">
                            <picture>
                              <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx818_im.webp" width="1000" height="1000">
                              <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx818_im.jpg" alt="ロレックス コスモグラフ デイトナ" width="1000" height="1000">
                            </picture>
                        </div>
                        <div class="reason_right">
                        <p class="r_title">資産価値としての側面</p>
                        <p>ロレックスは、あまりの人気ゆえに需要と供給のバランスが崩れ、定価販売の正規店でも購入は非常に難しいといわれています。中でもデイトナに至っては、購入できるまで正規店をめぐるデイトナマラソンなる言葉も誕生するほど人気が過熱しています。加えて年々、ロレックスのメーカー小売価格自体も値上がりが続いており、それに比例して買取価格も上昇傾向となっています。数ある高級時計ブランドの中でも、特に売却時も値崩れが起こりにくいとして、その資産価値にも高い注目が集まるブランドです。</p>
                        <p class="r_title">徹底した実用性の追求</p>
                        <p>高級時計でありながらも、あくまでも実用性に重きを置くロレックス。防水のオイスターケース、自動巻きシステムのパーペチュアル、そして瞬時に日付が切り替わる機構のデイトジャストは最も有名な革命的発明といわれています。今では当たり前のような機能も数多く生み出してきたロレックスが作り出す時計は優れた堅牢性や耐久性を備えるため、日常生活でも気を遣わずに使用が可能です。高度な技術を駆使して結実した実用性を備えるロレックスの腕時計だからこそ、その安心感と信頼性は群を抜いています。</p>
                        </div>
                    </div>
                    <div class="reason_cont2 mt2">
                        <div class="reason_left">
                        <p class="r_title">素材へのこだわり</p>
                        <p>高級時計に汎用的に使用される素材、ステンレス。多くの腕時計は医療器具にも使用されるサージカルスチールのSUS316Lを用いているのに対し、ロレックスにおいてはさらにハイクオリティーなスーパーステンレススチールのSUS904Lが使用されています。主に航空宇宙、化学産業で用いられている特殊な素材で加工が難しく、かつコストのかかる素材です。ロレックスは常に完璧を求めつつ最高品質を実現するという目的に向かって歩み続けており、それは採用する素材にも表れています。</p>
                        <p class="r_title">圧倒的な人気</p>
                        <p>世界中の著名人やセレブにも愛されるロレックス。優れた実用性と認知度を誇るブランドゆえに名実ともに腕時計の最高峰と称されています。実際、腕時計専門店ジャックロードでも通信販売受注データ(直近2021年1月～9月)を元に算出すると、第2位のブランドと大差をつけて1位に君臨し、他ブランドを圧倒する人気を集めています。人気をコレクション別に細分化してもデイトナ、サブマリーナー、エクスプローラーなどロレックスの基幹コレクションは安定の上位を占めています。</p>
                        </div>
                        <div class="reason_right">
                            <picture>
                              <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx424_im.webp" width="1000" height="1000">
                              <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx424_im.jpg" alt="ロレックス コスモグラフ デイトナ" width="1000" height="1000">
                            </picture>
                        </div>
                    </div>
                    <div class="reason_cont">
                        <div class="reason_left">
                            <picture>
                              <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx1275_im.webp" width="1000" height="1000">
                              <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/rx1275_im.jpg" alt="ロレックス サブマリーナー" width="1000" height="1000">
                            </picture>
                        </div>
                        <div class="reason_right">
                        <p class="r_title">ステータス性</p>
                        <p>老若男女問わず羨望の眼差しを集めるロレックス。世界初の防水機能や自動巻きムーブメント、カレンダー機能などを生み出し、腕時計の新しい可能性を開拓してきた時計メーカーです。優れた性能を証明する数々のエピソードも相まって、ロレックスは時計界でも最高峰と称されるまでに至ります。そんなロレックスの基幹コレクションの多くは決して派手ではありませんが、アイコニックなデザインゆえに一目見てそれと分かるほど高い認知度を誇ります。実用性・知名度と共にそのステータス性はまさに世界トップクラスといえるでしょう。</p>
                        <p class="r_title">独立したメーカー</p>
                        <p>数ある時計ブランドの多くが巨大グループの傘下に入る中、ロレックスはどこにも属さない、数少ない独立を貫く企業です。なかでもロレックスは難易度が高いとされるムーブメントのひげぜんまいをも自社で一貫して製造する真のマニュファクチュール。腕時計に対する飽くなき探求心をもつロレックスから輩出される作品は、自社一貫製造が可能な同社だからこそ成し得るこだわり抜かれたものばかり。1905年の創業と老舗が軒を連ねる時計界では決して歴史は長くないながらも、時計業界に大きな軌跡を残し続けています。</p>
                        </div>
                    </div>
                    </div>
                    <div id="reason2_area">
                    <h2>ジャックロードが選ばれる理由</h2>
                    <p class="reason2_point">1 知識、経験が豊富な査定員による誠実な査定</p>
                    <p>1987年創業の老舗である当店は、確かな知識と経験がございます。人気モデル、もしくは希少モデルにも拘わらず低い査定額を提示された、ということがないよう豊富な知識と経験を持つスタッフが1本1本責任を持って査定させていただきます。また、過去の知見によるスピーディーな査定も弊社の魅力です。</p>
                    <p class="reason2_point">2 「即」現金買取が可能</p>
                    <p>買取が成立しましたら、その場ですぐ現金でお支払いいたします。振込などの待ち時間もなく、スピーディーな買取が可能です。もちろん、銀行振り込みでの対応も可能ですので、お気軽に申しつけください。</p>
                    <p class="reason2_point">3 故障品、古い時計、本体のみの買取依頼も大歓迎</p>
                    <p>古いモデルや状態が悪いモデルでも査定いたします。ベルトのない時計本体のみのお品物でも受け付けております。弊社の提携工房にてメンテナンスが可能ですので、オーバーホールが必要なモデルでもそのままお持ち込みください。</p>
                    <p class="reason2_point">4 自宅に居ながら簡単査定</p>
                    <p>忙しくて店頭まで行く時間がない、遠方のため店舗に行けない、という方もご安心ください。当店では便利な無料の宅配買取サービスをご用意しております。手順書や必要書類が同梱された買取キットが到着後、その手順書に従って査定希望の時計と必要書類を入れて返送するだけのお手軽な査定・買取が可能です。</p>
                    <p class="reason2_point">5 期間限定の高額査定キャンペーン</p>
                    <p>当店ではロレックスの買い取りを強化しております。今ならキャンペーンでロレックスの買取価格が10％UP！更に、全モデル対象で10,000円上乗せいたします。お得なこの機会にぜひご利用ください。</p>
                    </div>
                </div> 
              
            <div class="appeal_area">
                <div id="stuff_area">
                <h2>買取スタッフの紹介</h2>
                <div class="stuff_cont">
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_miyagawa.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_miyagawa.jpg" alt="宮川誠" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>買取担当　<span class="large">宮川 誠</span></p>
                            <p>愛用時計：ブレゲ マリーンII クロノグラフ<br>
                                査定担当歴：10年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                今までたくさんの時計を査定させて頂きましたが、なかでもIWC スピットファイア Ref.IW326802が記憶に残っています。味わいを増したブロンズの燻んだ変色が深い緑のダイヤルとよく合っていて、とても良い雰囲気でした。査定をしながら思わず見とれてしまったことを今も覚えています。</p>
                        </div>
                    </div>
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_shioda.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_shioda.jpg" alt="塩田広樹" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>買取担当　<span class="large">塩田 広樹</span></p>
                            <p>愛用時計：ブライトリング スーパーオーシャン ヘリテージ B20 オートマティック 42<br>
                                査定担当歴：8年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                以前、パテック フィリップの大変希少なモデルを買取させていただきました。これまでの経験の中で最高の買取価格となったことが印象に残っています。なかなか手に取って見られるようなものではないレアモデルを実際に見ることができ、とても貴重な体験となりました。</p>
                        </div>
                    </div>
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_furukawa.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_furukawa.jpg" alt="古川浩" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>買取担当　<span class="large">古川 浩</span></p>
                            <p>愛用時計：ノモス タンジェント デイト パワーリザーブ<br>
                                査定担当歴：1年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                20年以上愛用したロレックスを買取にお持ち込みくださったお客さま。社会人になって初めて購入した時計だったそうです。ご自身が社会人として経験を積みステップアップしたところで、節目として時計ももう少し良いものに変えたいとのことで、長年愛用したその時計を手放され新しいロレックスをご購入されました。人生の大切な瞬間に少しでもお力添えできたことが嬉しかったです。</p>
                        </div>
                    </div>
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_nara.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_nara.jpg" alt="奈良陽介" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>アンティーク買取担当　<span class="large">奈良 陽介</span></p>
                            <p>愛用時計：グランドセイコー<br>
                                査定担当歴：7年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                亡くなられたご主人が所持されていた複数の時計を、奥様が「使わずに持っているよりは大切にしてくれる方に再度使用してもらいたい」とお持ち込みくだった件です。奥様は相場も全くご存じなかったですが、想いの詰まったお品物でしたので精一杯の査定額を提示させていただいたところ、名残を惜しまれつつも全品買取成立となりました。</p>
                        </div>
                    </div>
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_takaoka.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_takaoka.jpg" alt="高岡陽" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>アンティーク買取担当　<span class="large">高岡 陽</span></p>
                            <p>愛用時計：グランドセイコー グランドセイコー GMT オートマティック<br>
                                査定担当歴：20年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                親御さんが大切に所持していた時計を譲り受け長年愛用されていたようでしたが、最近時計を着用する機会が減ったため手放す決意をなされたお客さま。「捨てるという選択はどうしてもできず、大事に使ってくださる方にバトンを繋いでいきたい」とのことで当店にお持ち込みいただきました。大切に扱われていた時計をお譲り頂いたのは大変ありがたく、こちらも精一杯の気持ちでお応えいたしました。</p>
                        </div>
                    </div>
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_mochiduki.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_mochiduki.jpg" alt="望月洋輔" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>買取担当　<span class="large">望月 洋輔</span></p>
                            <p>愛用時計：パネライ ルミノール パワーリザーブ 44mm<br>
                                査定担当歴：10年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                レディース1番人気のタンクフランセーズSM、Ref.W51008Q3。大切に使われていたそうで、傷もほとんどない状態でお持ち込みくださったお客さまがいらっしゃいました。状態も非常に良かったため高い査定額を提示させていただいたところ、予想以上の価格だったとのことで大変喜んでいただけました。</p>
                        </div>
                    </div>
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_miyashita.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_miyashita.jpg" alt="宮下浩志" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>買取担当　<span class="large">宮下 浩志</span></p>
                            <p>愛用時計：パネライ ルミノールGMT 44mm<br>
                                査定担当歴：10年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                流通量が少なく、大変稀少なロレックスのデイトジャスト Ref.279136RBRのマザーオブパール文字盤モデルを買取させていただいたことです。マザーオブパール文字盤はほとんど見かけることのない珍しいモデルでしたので査定額を出すのに時間を要しましたが、他店で問い合わせた際の査定額よりも弊社の方が数万円高かったとのことでご満足いただき、こちらも大変嬉しかったです。</p>
                        </div>
                    </div>
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_watanabe.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_watanabe.jpg" alt="渡部 美保子" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>買取担当　<span class="large">渡部 美保子</span></p>
                            <p>愛用時計：ロレックス アンティーク 18KPG<br>
                                査定担当歴：10年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                以前よりお付き合いさせて頂いているとても素敵なご家族がいらっしゃいます。それぞれにお好きな時計やジュエリーがあり、特にご主人様はアンティークがお好みで革ベルトの金時計がとてもお似合いな方でした。長い間大切にご使用いただきましたが、ある日奥様がご主人様からのメッセージを添えてお持ち込みくださいました。お客さまと時計の思い出をお話しいただきながら今までの時を振り返るという、とても印象深い時間でした。時計を買い取るだけでなく、お客さまと経過した時間も共有させて頂いているようで温かな気持ちになりました。</p>
                        </div>
                    </div>
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_ishizawa.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_ishizawa.jpg" alt="石澤 恵子" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>買取担当　<span class="large">石澤 恵子</span></p>
                            <p>愛用時計：パネライ ルミノール マリーナ<br>
                                査定担当歴：1年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                販売も担当させて頂いたお客さまです。10年前、結婚1年目の記念に奥様へ時計をプレゼントしたいとご来店されたご主人様。何度も店舗に足を運ぶほど悩まれていらしたので全力でサポートしたところ、アンティークオイスターを選ばれました。それから10年、とても愛着があるので手放したくはないけれど結婚10年目の記念に買い換えを検討され、先日その時計をお持ち込み頂きました。10年目に合わせ10ポイントダイヤのロレックスに買い換えられたお二人の笑顔が印象的でした。時計を通じてお客さまとの繋がりが続いている事がとても嬉しいです。</p>
                        </div>
                    </div>
                    <div class="stuff_date">
                        <picture>
                          <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_morita.webp" width="500" height="500">
                          <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/stuff_morita.jpg" alt="森田 留花" width="500" height="500">
                        </picture>
                        <div class="stuff_text">
                            <p>買取担当　<span class="large">森田 留花</span></p>
                            <p>愛用時計：カルティエ タンクフランセーズ<br>
                                査定担当歴：2年</p>
                            <p>＜印象に残っているエピソード＞<br>
                                まだ査定をはじめたばかりのころですが、お話を伺いながら査定金額を出したところ、満面の笑顔で手を握りながら「本当にありがとう」と大変お喜びいただいたお客さま。とても嬉しくて昨日のことのように鮮明に覚えています。今でも変わらずご指名くださり、買い取りだけでなく色々なご相談をしてくださる私の大切なお客さまのひとりです。</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            
            <div id="map_area">
                <p class="brand_t">ACCESS</p>
                <h2>店舗への行き方</h2>
                <div class="map_box">
                    <div class="map_left">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12958.819806462314!2d139.6657409!3d35.7088776!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2b38b39b82078987!2z44K444Oj44OD44Kv44Ot44O844OJ!5e0!3m2!1sja!2sjp!4v1642833289525!5m2!1sja!2sjp" width="500" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <div class="map_right">
                        <p>JACKROAD</p>
                        <p class="txt_icon">ADDRESS</p>
                        <p>〒164-0001 東京都中野区中野5-52-15 ブロードウェイ3F</p>
                        <p>JR中野駅より徒歩5分</p>
                        <p class="txt_icon">PHONE</p>
                        <p>03-3386-9399</p>
                        <p>（ 営業時間 11:00～20:30 ）</p>
                    </div>
                </div>
            </div>
            
                    <div id="satei_area">
                        <p>いますぐ無料査定!!</p>
                        <div class="satei_img">
                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_line.webp" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                            <div class="satei_img_box">
                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc">
                                    <picture>
                                      <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_satei.webp" width="200" height="100">
                                      <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_satei.png" alt="3ステップ査定" width="200" height="100">
                                    </picture>
                                </a>
                            </div>
                            <div class="satei_img_box">
                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc">
                                    <picture>
                                      <source type="image/webp" srcset="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_delivery.webp" width="200" height="100">
                                      <img src="https://www.jackroad.co.jp/img/lp/purchase_record/contents/btn_delivery.png" alt="宅配買取" width="200" height="100">
                                    </picture>
                                </a>
                            </div>
                        </div>
                        <p>お電話でもお気軽にご相談ください。</p>
                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                    </div>';
                $brand_footer .= $brand_footer2;

            } else if(strpos($file_name,'HEUER') !== false){

                $complate = "タグ・ホイヤー 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "87cefa";
                $brand_title = "タグ・ホイヤー買取ページ・";
                /*$brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>タグ・ホイヤー買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>タグ・ホイヤー買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                

                                    <div>
                                        <h1 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_tagheuer.jpg" alt="タグ・ホイヤー買取価格・相場【ジャックロード】" width="1240" height="555"></h1>
                                        <p class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point.png" alt="高額査定のポイント" width="295" height="75"></p>
                                        <h1 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_tagheuer_sp.jpg" alt="タグ・ホイヤー買取価格・相場【ジャックロード】" width="1000" height="910"></h1>
                                        <p class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point_sp.png" alt="高額査定のポイント" width="590" height="150"></p>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div class="btn_area2 bgc-blue">
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                        </div>													
                                        <p class="other_brand_title">TAG HEUER<br>買取価格表</p>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='				<div class="btn_area">
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            </div>
                                            <div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">タグ・ホイヤー以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                ';*/

                $brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>タグ・ホイヤー買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>タグ・ホイヤー買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h1>タグ・ホイヤー買取価格表</h1>
                                            <img src="/img/kaitori/main_satei_tagheuer.jpg" alt="タグ・ホイヤー買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                            <img src="/img/kaitori/main_satei_tagheuer_sp.jpg" alt="タグ・ホイヤー買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">TAG HEUER</span><br>買取価格表</h2>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                    <div>                
                    ';
                $brand_footer='<div id="satei_area">
                                <p>いますぐ無料査定!!</p>
                                <div class="satei_img">
                                <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                </div>
                                <p>お電話でもお気軽にご相談ください。</p>
                                <p><a href="tel:0333869399">03-3386-9399</a></p>
                                </div>
                                <span id="other" class="innerlink"></span>
                                <p class="title2">タグ・ホイヤー以外の買取価格表はこちら</p>
                                <div class="other_brand_cont">
                                    <ul class="other_brand_link">
                                        <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                        <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                        <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                        <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                        <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                        <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                        <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                        <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                        <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>
                                        <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                ';


            } else if(strpos($file_name,'OMEGA') !== false){

                $complate = "オメガ 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "fff8dc";
                $brand_title = "オメガ買取ページ・";
                /*$brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>オメガ買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>オメガ買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>


                                    <div>
                                        <h1 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_omega.jpg" alt="オメガ買取価格・相場【ジャックロード】" width="1240" height="555"></h1>
                                        <p class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point.png" alt="高額査定のポイント" width="295" height="75"></p>
                                        <h1 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_omega_sp.jpg" alt="オメガ買取価格・相場【ジャックロード】" width="1000" height="910"></h1>
                                        <p class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point_sp.png" alt="高額査定のポイント" width="590" height="150"></p>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div class="btn_area2 bgc-blue">
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                        </div>													
                                        <p class="other_brand_title">OMEGA<br>買取価格表</p>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='				<div class="btn_area">
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            </div>
                                            <div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">オメガ以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';*/

                $brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>オメガ買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>オメガ買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h1>オメガ買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_omega.jpg" alt="オメガ買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_omega_sp.jpg" alt="オメガ買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>

                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは定額買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは定額買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">OMEGA</span><br>定額買取価格表</h2>
                                        <ul class="atention">
                                                <li>※ 定額買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                    <div>
                ';
                $brand_footer='<div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">オメガ以外の定額買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">▼ IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';



            } else if(strpos($file_name,'IWC') !== false){

                $complate = "IWC 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "ccc";
                $brand_title = "IWC買取ページ・";
                /*$brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>IWC(アイダブリューシー)買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>IWC(アイダブリューシー)買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>


                                    <div>
                                        <h1 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_iwc.jpg" alt="IWC(アイダブリューシー)買取価格・相場【ジャックロード】" width="1240" height="555"></h1>
                                        <p class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point.png" alt="高額査定のポイント" width="295" height="75"></p>
                                        <h1 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_iwc_sp.jpg" alt="IWC(アイダブリューシー)買取価格・相場【ジャックロード】" width="1000" height="910"></h1>
                                        <p class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point_sp.png" alt="高額査定のポイント" width="590" height="150"></p>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div class="btn_area2 bgc-blue">
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                        </div>													
                                        <p class="other_brand_title">IWC<br>買取価格表</p>
                                        <ul class="atention">
                                            <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                            <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                            <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='				<div class="btn_area">
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            </div>
                                            <div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">IWC以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';*/


                $brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>IWC(アイダブリューシー)買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>IWC(アイダブリューシー)買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h1>IWC買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_iwc.jpg" alt="IWC(アイダブリューシー)買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_iwc_sp.jpg" alt="IWC(アイダブリューシー)買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">IWC</span><br>買取価格表</h2>
                                        <ul class="atention">
                                            <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                            <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                            <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                    <div>
                ';
                $brand_footer='<div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">IWC以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';

            } else if(strpos($file_name,'SEIKO') !== false){

                $complate = "セイコー 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "f0ffff";
                $brand_title = "セイコー買取ページ・";
                /*$brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>セイコー買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>セイコー買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>


                                    <div>
                                        <h1 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_seiko.jpg" alt="セイコー買取価格・相場【ジャックロード】" width="1240" height="555"></h1>
                                        <p class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point.png" alt="高額査定のポイント" width="295" height="75"></p>
                                        <h1 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_seiko_sp.jpg" alt="セイコー買取価格・相場【ジャックロード】" width="1000" height="910"></h1>
                                        <p class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point_sp.png" alt="高額査定のポイント" width="590" height="150"></p>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div class="btn_area2 bgc-blue">
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                        </div>													
                                        <p class="other_brand_title">SEIKO<br>買取価格表</p>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='				<div class="btn_area">
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            </div>
                                            <div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">セイコー以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                ';*/

                $brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>セイコー買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>セイコー買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h1>セイコー買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_seiko.jpg" alt="セイコー買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_seiko_sp.jpg" alt="セイコー買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">SEIKO</span><br>買取価格表</h2>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                    <div>
                ';
                $brand_footer='<div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">セイコー以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                ';
                

            } else if(strpos($file_name,'BREIT') !== false){

                $complate = "ブライトリング 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "f0fff0";
                $brand_title = "ブライトリング買取ページ・";
                /*$brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>ブライトリング買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>ブライトリング買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>


                                    <div>
                                        <h1 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_breitling.jpg" alt="ブライトリング買取価格・相場【ジャックロード】" width="1240" height="555"></h1>
                                        <p class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point.png" alt="高額査定のポイント" width="295" height="75"></p>
                                        <h1 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_breitling_sp.jpg" alt="ブライトリング買取価格・相場【ジャックロード】" width="1000" height="910"></h1>
                                        <p class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point_sp.png" alt="高額査定のポイント" width="590" height="150"></p>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div class="btn_area2 bgc-blue">
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                        </div>													
                                        <p class="other_brand_title">BREITLING<br>買取価格表</p>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='				<div class="btn_area">
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            </div>
                                            <div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">ブライトリング以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';*/

                $brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>ブライトリング買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>ブライトリング買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h1>ブライトリング買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_breitling.jpg" alt="ブライトリング買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_breitling_sp.jpg" alt="ブライトリング買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">BREITLING</span><br>買取価格表</h2>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                    <div>
                ';
                $brand_footer='<div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">ブライトリング以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';
                        

            } else if(strpos($file_name,'PANERAI') !== false){

                $complate = "パネライ 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "faebd7";
                $brand_title = "パネライ買取ページ・";
                /*$brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>パネライ買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>パネライ買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>


                                    <div>
                                        <h1 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_panerai.jpg" alt="パネライ買取価格・相場【ジャックロード】" width="1240" height="555"></h1>
                                        <p class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point.png" alt="高額査定のポイント" width="295" height="75"></p>
                                        <h1 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_panerai_sp.jpg" alt="パネライ買取価格・相場【ジャックロード】" width="1000" height="910"></h1>
                                        <p class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point_sp.png" alt="高額査定のポイント" width="590" height="150"></p>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div class="btn_area2 bgc-blue">
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                        </div>													
                                        <p class="other_brand_title">PANERAI<br>買取価格表</p>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='				<div class="btn_area">
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            </div>
                                            <div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">パネライ以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                ';*/

                $brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>パネライ買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>パネライ買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h1>パネライ買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_panerai.jpg" alt="パネライ買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_panerai_sp.jpg" alt="パネライ買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">PANERAI</span><br>買取価格表</h2>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                    <div>
                ';
                $brand_footer='<div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">パネライ以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                ';

            } else if(strpos($file_name,'CARTIER') !== false){

                $complate = "カルティエ 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "faebd7";
                $brand_title = "カルティエ買取ページ・";
                /*$brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>カルティエ買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>カルティエ買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h1 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_cartier.jpg" alt="カルティエ買取価格・相場【ジャックロード】" width="1240" height="555"></h1>
                                        <p class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point.png" alt="高額査定のポイント" width="295" height="75"></p>
                                        <h1 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_cartier_sp.jpg" alt="カルティエ買取価格・相場【ジャックロード】" width="1000" height="910"></h1>
                                        <p class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point_sp.png" alt="高額査定のポイント" width="590" height="150"></p>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div class="btn_area2 bgc-blue">
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                        </div>													
                                        <p class="other_brand_title">CARTIER<br>買取価格表</p>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='				<div class="btn_area">
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            </div>
                                            <div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">カルティエ以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';*/

                $brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>カルティエ買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>カルティエ買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h1>カルティエ買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_cartier.jpg" alt="カルティエ買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_cartier_sp.jpg" alt="カルティエ買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">CARTIER</span><br>買取価格表</h2>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                    <div>
                ';
                $brand_footer='<div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">カルティエ以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';

            // 20211123
            } else if(strpos($file_name,'patek') !== false){

                $complate = "パテック・フィリップ 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "f0ffff";
                $brand_title = "パテック・フィリップ買取ページ・";
                $brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>パテック・フィリップ買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>パテック・フィリップ買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h1>パテック・フィリップ買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_patek.jpg" alt="パテック・フィリップ買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_patek_sp.jpg" alt="パテック・フィリップ買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">PATEK PHILIPPE</span><br>買取価格表</h2>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='<div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">パテック・フィリップ以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';
            // 20211123
            } else if(strpos($file_name,'VACHERON') !== false){

                $complate = "ヴァシュロン・コンスタンタン 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "f0ffff";
                $brand_title = "ヴァシュロン・コンスタンタン買取ページ・";
                $brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>ヴァシュロン・コンスタンタン買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>ヴァシュロン・コンスタンタン買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>


                                    <div>
                                        <h1>ヴァシュロン・コンスタンタン買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_vacheron.jpg" alt="ヴァシュロン・コンスタンタン買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_vacheron_sp.jpg" alt="ヴァシュロン・コンスタンタン買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">VACHERON CONSTANTIN</span><br>買取価格表</h2>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='<div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">ヴァシュロン・コンスタンタン以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_ap_kaitori.aspx" title="オーデマ ピゲ">オーデマ ピゲ</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                ';

                
            // 20211123
            } else if(strpos($file_name,'AUDEMA') !== false){

                $complate = "オーデマ ピゲ 貼り付け用ソースの出力が完了しました";
                $brand_color = "dc143c";
                $brand_color2 = "f0ffff";
                $brand_title = "オーデマ ピゲ買取ページ・";

                /*$brand_header='<div class="kaitori_view">

                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>オーデマ ピゲ買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>オーデマ ピゲ買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>


                                    <div>
                                        <h1 class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_audema.jpg" alt="オーデマ ピゲ買取価格・相場【ジャックロード】" width="1240" height="555"></h1>
                                        <p class="pc"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point.png" alt="高額査定のポイント" width="295" height="75"></p>
                                        <h1 class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/main_satei_audema_sp.jpg" alt="オーデマ ピゲ買取価格・相場【ジャックロード】" width="1000" height="910"></h1>
                                        <p class="sp"><img src="https://www.jackroad.co.jp/img/kaitori/ttl_point_sp.png" alt="高額査定のポイント" width="590" height="150"></p>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div class="btn_area2 bgc-blue">
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                            <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                        </div>													
                                        <p class="other_brand_title">AUDEMARS PIGUET<br>買取価格表</p>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                        <div>
                ';
                $brand_footer='				<div class="btn_area">
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="pc"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_satei_sp.png" alt="簡単査定を申し込む" width="305" height="75"></a></p>
                                                <p class="sp"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/kaitori/btn_delivery_sp.png" alt="宅配査定を申し込む" width="305" height="75"></a></p>
                                            </div>
                                            <div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">オーデマ ピゲ以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';*/
                
                $brand_header='<div class="kaitori_view">
                                    <div class="ta-l">
                                        <div id="breadcrumb_area" class="pc">
                                            <ul id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                        <span itemprop="name">
                                                        <strong>腕時計買取ならジャックロード </strong>
                                                        </span>
                                                    </a>
                                                    <meta itemprop="position" content="2" />
                                                </li>
                                                <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                        <span itemprop="name">
                                                        <strong>オーデマ ピゲ買取価格・相場</strong>
                                                        </span>
                                                    <meta itemprop="position" content="3" />
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="sp pankuzu_" id="bread-crumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/" itemprop="item" class="topicpath_home_">
                                                    <span itemprop="name">トップ</span>
                                                </a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                <a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx" itemprop="item">
                                                    <span itemprop="name">
                                                    <strong>腕時計買取ならジャックロード </strong>
                                                    </span>
                                                </a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li class="current" itemscope itemtype="https://schema.org/ListItem" itemprop="itemListElement">
                                                    <span itemprop="name">
                                                    <strong>オーデマ ピゲ買取価格・相場</strong>
                                                    </span>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h1>オーデマ ピゲ買取価格表</h1>
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_audema.jpg" alt="オーデマ ピゲ買取価格・相場【ジャックロード】" width="1240" height="555" class="pc">
                                        	<img src="https://www.jackroad.co.jp/img/kaitori/main_satei_audema_sp.jpg" alt="オーデマ ピゲ買取価格・相場【ジャックロード】" width="1000" height="910" class="sp">
                                        <h2>高額査定のポイント</h2>
                                        <div class="point">
                                            <ul class="list">
                                                <li>箱・保証書が揃っている。</li>
                                                <li>メーカー保証書の日付欄が無記載ではなく、かつ保証日付から1年以内のもの。</li>
                                                <li>ガラス(風防)が無傷の状態のもの。</li>
                                                <li>ケースやブレスレットに打痕・目立つ使用傷が無い状態のもの。</li>
                                                <li>外装パーツ(りゅうず、バックル部など)に損傷、機能不全がない状態のもの。</li>
                                            </ul>
                                            <p class="pc">もちろん上記を満たしていなくても、今ならキャンペーン中につき査定額に<span class="fc-red fw-bold"> 5％ </span>を上乗せします！</p>
                                            <p class="pc">新品未使用品の場合さらにプラスの査定額をご提示いたします！</p>
                                            <p class="pc">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                            <p class="sp">もちろん上記を満たしていなくても、</p>
                                            <p class="sp">今ならキャンペーン中につき</p>
                                            <p class="sp">査定額に<span class="fc-red fw-bold"> 10％ </span>を上乗せします！</p>
                                            <p class="sp lh_12">新品未使用品の場合</p>
                                            <p class="sp lh_12">さらにプラスの査定額をご提示いたします！</p>
                                            <p class="sp">詳しくは買取価格表・カンタン査定からご確認下さい。</p>
                                        </div>
                                        <div id="satei_area">
                                        <p>いますぐ無料査定!!</p>
                                        <div class="satei_img">
                                        <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                        <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                        </div>
                                        <p>お電話でもお気軽にご相談ください。</p>
                                        <p><a href="tel:0333869399">03-3386-9399</a></p>
                                        </div>
                                        <h2><span class="sub_title">AUDEMARS PIGUET</span><br>買取価格表</h2>
                                        <ul class="atention">
                                                <li>※ 買取価格表以外の商品でも高額にて買取承ります。ご不明な点などはお気軽にお問い合わせください。</li>
                                                <li>※ 買取ご希望の商品が当店で分割クレジット決済でご購入いただいた商品の場合、残債務がないことをご誓約ください。</li>
                                                <li>※ 一部対象外の商品もあります。</li>
                                        </ul>
                                    <div>
                ';
                $brand_footer='<div id="satei_area">
                                            <p>いますぐ無料査定!!</p>
                                            <div class="satei_img">
                                            <!--<div class="satei_img_box"><a href="#"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_line.png" width="200" height="100" alt="LINE査定" loading="eager"></a></div>-->
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink1_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_satei.png" width="200" height="100" alt="3ステップ査定" loading="eager"></a></div>
                                            <div class="satei_img_box"><a href="https://www.jackroad.co.jp/shop/pages/j_brand_watch01.aspx#ilink2_pc"><img src="https://www.jackroad.co.jp/img/lp/purchase_record/btn_delivery.png" width="200" height="100" alt="宅配買取" loading="eager"></a></div>
                                            </div>
                                            <p>お電話でもお気軽にご相談ください。</p>
                                            <p><a href="tel:0333869399">03-3386-9399</a></p>
                                            </div>
                                            <span id="other" class="innerlink"></span>
                                            <p class="title2">オーデマ ピゲ以外の買取価格表はこちら</p>
                                            <div class="other_brand_cont">
                                                <ul class="other_brand_link">
                                                    <li><a href="./j_iwc_kaitori.aspx" title="IWC">IWC</a></li>
                                                    <li><a href="./j_rolex_kaitori.aspx" title="ロレックス">ロレックス</a></li>
                                                    <li><a href="./j_tagheure_kaitori.aspx" title="タグ・ホイヤー">タグ・ホイヤー</a></li>
                                                    <li><a href="./j_omega_kaitori.aspx" title="オメガ">オメガ</a></li>
                                                    <li><a href="./j_breitling_kaitori.aspx" title="ブライトリング">ブライトリング</a></li>
                                                    <li><a href="./j_seiko_kaitori.aspx" title="セイコー">セイコー</a></li>
                                                    <li><a href="./j_panerai_kaitori.aspx" title="パネライ">パネライ</a></li>
                                                    <li><a href="./j_cartier_kaitori.aspx" title="カルティエ">カルティエ</a></li>
                                                    <!--<li><a href="./j_patek_kaitori.aspx" title="パテック・フィリップ">パテック・フィリップ</a></li>
                                                    <li><a href="./j_vacheron_kaitori.aspx" title="ヴァシュロン・コンスタンタン">ヴァシュロン・コンスタンタン</a></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        ';

            } else {
            
                $alert = "ファイルが存在しません";
            
            }

            $js_area = 
                    "<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js'></script>  
                    <script type='text/javascript'>
                    jQuery(document).ready(function(){
                        jQuery('." .$class_name1 . "6" . $class_name2 . "').on('click',function(){
                            var t=jQuery(this).next('." . $class_name1 . "19" . $class_name2 . "');	
                            jQuery(t).stop().slideToggle();
                            var b=jQuery(this).children('div').children('div').children('." . $class_name1 . "18" . $class_name2 . "');	
                            var c=jQuery(this).children('." . $class_name1 . "18" . $class_name2 . "');	

                            if(jQuery(b).hasClass('" . $class_name1 . "16" . $class_name2 . "')){
                                jQuery(b).removeClass('" . $class_name1 . "16" . $class_name2 . "');
                                jQuery(b).addClass('" . $class_name1 . "17" . $class_name2 . "');
                            } else {
                                jQuery(b).removeClass('" . $class_name1 . "17" . $class_name2 . "');
                                jQuery(b).addClass('" . $class_name1 . "16" . $class_name2 . "');
                            }
                            if(jQuery(c).hasClass('" . $class_name1 . "17" . $class_name2 . "')){
                                jQuery(c).removeClass('" . $class_name1 . "17" . $class_name2 . "');
                                jQuery(c).addClass('" . $class_name1 . "16" . $class_name2 . "');
                            } else {
                                jQuery(c).removeClass('" . $class_name1 . "16" . $class_name2 . "');
                                jQuery(c).addClass('" . $class_name1 . "17" . $class_name2 . "');
                            }
                        })
                        $('." . $class_name1 . "19" . $class_name2 . "').css('display','none');

                        /*  20220114 個別商品用の矢印をモデル用と分離する為、新たに作成 */
                        jQuery('." .$class_name1 . "106" . $class_name2 . "').on('click',function(){
                            var t=jQuery(this).next('." . $class_name1 . "119" . $class_name2 . "');	
                            jQuery(t).stop().slideToggle();
                            var b=jQuery(this).children('div').children('div').children('." . $class_name1 . "118" . $class_name2 . "');	
                            var c=jQuery(this).children('." . $class_name1 . "118" . $class_name2 . "');	

                            if(jQuery(b).hasClass('" . $class_name1 . "116" . $class_name2 . "')){
                                jQuery(b).removeClass('" . $class_name1 . "116" . $class_name2 . "');
                                jQuery(b).addClass('" . $class_name1 . "117" . $class_name2 . "');
                            } else {
                                jQuery(b).removeClass('" . $class_name1 . "117" . $class_name2 . "');
                                jQuery(b).addClass('" . $class_name1 . "116" . $class_name2 . "');
                            }
                            if(jQuery(c).hasClass('" . $class_name1 . "117" . $class_name2 . "')){
                                jQuery(c).removeClass('" . $class_name1 . "117" . $class_name2 . "');
                                jQuery(c).addClass('" . $class_name1 . "116" . $class_name2 . "');
                            } else {
                                jQuery(c).removeClass('" . $class_name1 . "116" . $class_name2 . "');
                                jQuery(c).addClass('" . $class_name1 . "117" . $class_name2 . "');
                            }
                        })
                        $('." . $class_name1 . "119" . $class_name2 . "').css('display','none');
                    })
                
                </script>";
            $sp_header = "\n" . '<div class="sp sp_title sticky">モデル / 文字盤色 / 品番</div><div class="info_area sp"><div class="update">[ 最終更新日：' . date('Y / m / d') . ' ]</div><div class="other"><a href="#other">▼ 他ブランドの買取価格表はこちら ▼</a></div></div><span id="sp_m_top" class="mens_link"></span><div class="mens_title">メンズ</div>';


            // 20240811 ブラウザがエッジの場合、以下の部分で、$brand_headerなどの変数が存在しないエラーになるため各変数の有無によるロジックを追記 → エッジはブラウザの文字コードの問題と思われる。出力するとタイトルのみ出力されて、それも文字化けしているので、参照ファイルを正しく読み込めずに変数自体を作成できない事が原因だと思われる。対応しない。
            if(empty($brand_header)){$brand_header = "";}
            if(empty($complate)){$complate = "";}
            if(empty($brand_color)){$brand_color = "";}
            if(empty($brand_color2)){$brand_color2 = "";}
            if(empty($brand_title)){$brand_title = "";}
            if(empty($brand_header)){$brand_header = "";}
            if(empty($brand_footer)){$brand_footer = "";}
            if(empty($js_area)){$js_area = "";}
            if(empty($sp_header)){$sp_header = "";}

            $brand_header = $brand_header . '<div class="info_area pc"><div class="update">[ 最終更新日：' . date('Y / m / d') . ' ]</div><div class="other"><a href="#other">▼ 他ブランドの買取価格表はこちら </a></div></div>';
            
            $temp_html = $brand_header;

            $source = array('complate' => $complate,'brand_color' => $brand_color,'brand_color2' => $brand_color2,'brand_title' => $brand_title,'brand_header' => $brand_header,'brand_footer' => $brand_footer,'js_area' => $js_area,'sp_header' => $sp_header);

            return $source;
        }

/************************************************************************************************************************************************************************************************************* */
    // 買取ページ用全体HTNMLの作成（関連メソッドの結果を呼び出して最終形を作成）
/************************************************************************************************************************************************************************************************************* */
        public function output_source(Request $request){
            
            // クラス名をソース出力毎にランダム化する為の変数を作成
                // mt_randだけだとセットした上限の桁数になる事が多く、クラス名の文字数が固定されやすいので、mt_randにセットする数字の桁数自体をランダムにする事で回避するための記述をする事で対処
                /* 20240809 処理が重いので簡単にできる範囲でランダムロジックを外したい   
                    $rand = mt_rand(1,9);
                    $rand2 = "%0" . $rand . "d";
                    $rand3 = "9" . sprintf($rand2, "0");
    
                    $class_name1 = chr(mt_rand(97, 122)) . mt_rand(0,$rand3);
                    $class_name2 = chr(mt_rand(97, 122)) . mt_rand(0,$rand3);
                */
                    $class_name1 = "name1";
                    $class_name2 = "name2";
                //echo $class_name1 . "(" . $class_name2 . ")";



            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）start
            /************************************************************************************************************************************************************************************************************* */

                $define = $this->define();
                $def_i = 0;
                // 各変数にパスやファイル名を代入
                    foreach($define as $def){
                        if($def_i == 2){ $file_pass3 = $def; }
                        if($def_i == 3){ $file_pass4 = $def; }
                        
                        $def_i++;
                    }

            /************************************************************************************************************************************************************************************************************* */
                // 定数管理用（メソッドの呼び出し）end
            /************************************************************************************************************************************************************************************************************* */


            // ディレクトリ内のファイル名を全て取得
                //$files = glob('../storage/app/public/csv/op/kaitori/*');
                $files = glob($file_pass3);
            // 配列から取り出す
                foreach($files as $var){
                    $file_name = $var;
                }

            // CSV読み込み用メソッドの呼び出し
                $read_csv = $this->read_csv();

                    $i = 0;

                    $final_source = "";
                    $pc_html = "";
                    $sp_html = "";
                   // $sp_l_html = "";
                    // 20210908
                    $pc_l_html = "";
                    $pc_m_html = "";

                    $pc_l_html_array = array();
                    $pc_m_html_array = array();
                    $sp_l_html_array = array();
                    $sp_m_html_array = array();



                    $info1[$i] = "";
                    $info2[$i] = "";
                    $info3[$i] = "";
                    $info4[$i] = "";
                    $info5[$i] = "";
                    $info6[$i] = "";
                    $info7[$i] = "";
                    $info8[$i] = "";
                    $sp_source[$i] = "";


                                        // タイトル
                                        $title = array();
                                        // 全モデル
                                        $pc_all_array = array();
                                        $sp_all_array = array();
                                        $pc_all_array_l = array();
                                        $sp_all_array_l = array();
                    
                                        // メンズ・モデル
                                        $pc_m_rore1 = array();
                                        $sp_m_rore1 = array();
                                        $pc_m_rore2 = array();
                                        $sp_m_rore2 = array();
                                        $pc_m_rore3 = array();
                                        $sp_m_rore3 = array();
                                        $pc_m_rore4 = array();
                                        $sp_m_rore4 = array();
                                        $pc_m_rore5 = array();
                                        $sp_m_rore5 = array();
                                        $pc_m_rore6 = array();
                                        $sp_m_rore6 = array();
                                        $pc_m_rore7 = array();
                                        $sp_m_rore7 = array();
                                        $pc_m_rore8 = array();
                                        $sp_m_rore8 = array();
                                        $pc_m_rore9 = array();
                                        $sp_m_rore9 = array();
                                        $pc_m_rore10 = array();
                                        $sp_m_rore10 = array();
                                        $pc_m_rore11 = array();
                                        $sp_m_rore11 = array();

                                        $pc_m_ome1 = array();
                                        $sp_m_ome1 = array();
                                        $pc_m_ome2 = array();
                                        $sp_m_ome2 = array();
                                        $pc_m_ome3 = array();
                                        $sp_m_ome3 = array();
                                        $pc_m_ome4 = array();
                                        $sp_m_ome4 = array();
                                        $pc_m_ome5 = array();
                                        $sp_m_ome5 = array();
                                        
                                        $pc_m_tag1 = array();
                                        $sp_m_tag1 = array();
                                        $pc_m_tag2 = array();
                                        $sp_m_tag2 = array();
                                        $pc_m_tag3 = array();
                                        $sp_m_tag3 = array();
                                        $pc_m_tag4 = array();
                                        $sp_m_tag4 = array();
                                        $pc_m_tag5 = array();
                                        $sp_m_tag5 = array();

                                        $pc_m_breit1 = array();
                                        $sp_m_breit1 = array();
                                        $pc_m_breit2 = array();
                                        $sp_m_breit2 = array();
                                        $pc_m_breit3 = array();
                                        $sp_m_breit3 = array();
                                        $pc_m_breit4 = array();
                                        $sp_m_breit4 = array();
                                        $pc_m_breit5 = array();
                                        $sp_m_breit5 = array();
                                        $pc_m_breit6 = array();
                                        $sp_m_breit6 = array();
                                        $pc_m_breit7 = array();
                                        $sp_m_breit7 = array();
                                        $pc_m_breit8 = array();
                                        $sp_m_breit8 = array();
                                        $pc_m_breit9 = array();
                                        $sp_m_breit9 = array();
                                        $pc_m_breit10 = array();
                                        $sp_m_breit10 = array();
                                        $pc_m_breit11 = array();
                                        $sp_m_breit11 = array();
                                        $pc_m_breit12 = array();
                                        $sp_m_breit12 = array();
                                        $pc_m_breit13 = array();
                                        $sp_m_breit13 = array();
                                        $pc_m_breit14 = array();
                                        $sp_m_breit14 = array();

                                        $pc_m_seiko1 = array();
                                        $sp_m_seiko1 = array();
                                        $pc_m_seiko2 = array();
                                        $sp_m_seiko2 = array();
                                        $pc_m_seiko3 = array();
                                        $sp_m_seiko3 = array();
                                        $pc_m_seiko4 = array();
                                        $sp_m_seiko4 = array();

                                        $pc_m_pane1 = array();
                                        $sp_m_pane1 = array();
                                        $pc_m_pane2 = array();
                                        $sp_m_pane2 = array();
                                        $pc_m_pane3 = array();
                                        $sp_m_pane3 = array();

                                        $pc_m_iwc1 = array();
                                        $sp_m_iwc1 = array();
                                        $pc_m_iwc2 = array();
                                        $sp_m_iwc2 = array();
                                        $pc_m_iwc3 = array();
                                        $sp_m_iwc3 = array();
                                        $pc_m_iwc4 = array();
                                        $sp_m_iwc4 = array();
                                        $pc_m_iwc5 = array();
                                        $sp_m_iwc5 = array();
                                        $pc_m_iwc6 = array();
                                        $sp_m_iwc6 = array();

                                        $pc_m_car1 = array();
                                        $sp_m_car1 = array();
                                        $pc_m_car2 = array();
                                        $sp_m_car2 = array();
                                        $pc_m_car3 = array();
                                        $sp_m_car3 = array();
                                        $pc_m_car4 = array();
                                        $sp_m_car4 = array();
                                        $pc_m_car5 = array();
                                        $sp_m_car5 = array();
                                        $pc_m_car6 = array();
                                        $sp_m_car6 = array();
                                        $pc_m_car7 = array();
                                        $sp_m_car7 = array();
                                        $pc_m_car8 = array();
                                        $sp_m_car8 = array();
                                        $pc_m_car9 = array();
                                        $sp_m_car9 = array();
                                        $pc_m_car10 = array();
                                        $sp_m_car10 = array();

                                        $pc_m_pate1 = array();
                                        $sp_m_pate1 = array();
                                        $pc_m_pate2 = array();
                                        $sp_m_pate2 = array();

                                        $pc_m_aud1 = array();
                                        $sp_m_aud1 = array();
                                        $pc_m_aud2 = array();
                                        $sp_m_aud2 = array();
                                        

                                        
                                        $pc_m_other = array();
                                        $sp_m_other = array();



                                    // レディース・モデル
                                        $pc_l_rore1 = array();
                                        $sp_l_rore1 = array();
                                        $pc_l_rore2 = array();
                                        $sp_l_rore2 = array();
                                        $pc_l_rore3 = array();
                                        $sp_l_rore3 = array();
                                        $pc_l_rore4 = array();
                                        $sp_l_rore4 = array();
                                        $pc_l_rore5 = array();
                                        $sp_l_rore5 = array();
                                        $pc_l_rore6 = array();
                                        $sp_l_rore6 = array();
                                        $pc_l_rore7 = array();
                                        $sp_l_rore7 = array();
                                        $pc_l_rore8 = array();
                                        $sp_l_rore8 = array();
                                        $pc_l_rore9 = array();
                                        $sp_l_rore9 = array();
                                        $pc_l_rore10 = array();
                                        $sp_l_rore10 = array();
                                        $pc_l_rore11 = array();
                                        $sp_l_rore11 = array();

                                        $pc_l_ome1 = array();
                                        $sp_l_ome1 = array();
                                        $pc_l_ome2 = array();
                                        $sp_l_ome2 = array();
                                        $pc_l_ome3 = array();
                                        $sp_l_ome3 = array();
                                        $pc_l_ome4 = array();
                                        $sp_l_ome4 = array();
                                        $pc_l_ome5 = array();
                                        $sp_l_ome5 = array();

                                        $pc_l_tag1 = array();
                                        $sp_l_tag1 = array();
                                        $pc_l_tag2 = array();
                                        $sp_l_tag2 = array();
                                        $pc_l_tag3 = array();
                                        $sp_l_tag3 = array();
                                        $pc_l_tag4 = array();
                                        $sp_l_tag4 = array();
                                        $pc_l_tag5 = array();
                                        $sp_l_tag5 = array();
                                        
                                        $pc_l_breit1 = array();
                                        $sp_l_breit1 = array();
                                        $pc_l_breit2 = array();
                                        $sp_l_breit2 = array();
                                        $pc_l_breit3 = array();
                                        $sp_l_breit3 = array();
                                        $pc_l_breit4 = array();
                                        $sp_l_breit4 = array();
                                        $pc_l_breit5 = array();
                                        $sp_l_breit5 = array();
                                        $pc_l_breit6 = array();
                                        $sp_l_breit6 = array();
                                        $pc_l_breit7 = array();
                                        $sp_l_breit7 = array();
                                        $pc_l_breit8 = array();
                                        $sp_l_breit8 = array();
                                        $pc_l_breit9 = array();
                                        $sp_l_breit9 = array();
                                        $pc_l_breit10 = array();
                                        $sp_l_breit10 = array();
                                        $pc_l_breit11 = array();
                                        $sp_l_breit11 = array();
                                        $pc_l_breit12 = array();
                                        $sp_l_breit12 = array();
                                        $pc_l_breit13 = array();
                                        $sp_l_breit13 = array();
                                        $pc_l_breit14 = array();
                                        $sp_l_breit14 = array();

                                        $pc_l_seiko1 = array();
                                        $sp_l_seiko1 = array();
                                        $pc_l_seiko2 = array();
                                        $sp_l_seiko2 = array();
                                        $pc_l_seiko3 = array();
                                        $sp_l_seiko3 = array();
                                        $pc_l_seiko4 = array();
                                        $sp_l_seiko4 = array();

                                        $pc_l_pane1 = array();
                                        $sp_l_pane1 = array();
                                        $pc_l_pane2 = array();
                                        $sp_l_pane2 = array();
                                        $pc_l_pane3 = array();
                                        $sp_l_pane3 = array();

                                        $pc_l_iwc1 = array();
                                        $sp_l_iwc1 = array();
                                        $pc_l_iwc2 = array();
                                        $sp_l_iwc2 = array();
                                        $pc_l_iwc3 = array();
                                        $sp_l_iwc3 = array();
                                        $pc_l_iwc4 = array();
                                        $sp_l_iwc4 = array();
                                        $pc_l_iwc5 = array();
                                        $sp_l_iwc5 = array();
                                        $pc_l_iwc6 = array();
                                        $sp_l_iwc6 = array();

                                        $pc_l_car1 = array();
                                        $sp_l_car1 = array();
                                        $pc_l_car2 = array();
                                        $sp_l_car2 = array();
                                        $pc_l_car3 = array();
                                        $sp_l_car3 = array();
                                        $pc_l_car4 = array();
                                        $sp_l_car4 = array();
                                        $pc_l_car5 = array();
                                        $sp_l_car5 = array();
                                        $pc_l_car6 = array();
                                        $sp_l_car6 = array();
                                        $pc_l_car7 = array();
                                        $sp_l_car7 = array();
                                        $pc_l_car8 = array();
                                        $sp_l_car8 = array();
                                        $pc_l_car9 = array();
                                        $sp_l_car9 = array();
                                        $pc_l_car10 = array();
                                        $sp_l_car10 = array();

                                        $pc_l_pate1 = array();
                                        $sp_l_pate1 = array();
                                        $pc_l_pate2 = array();
                                        $sp_l_pate2 = array();

                                        $pc_l_aud1 = array();
                                        $sp_l_aud1 = array();
                                        $pc_l_aud2 = array();
                                        $sp_l_aud2 = array();


                                        $pc_l_other = array();
                                        $sp_l_other = array();

                                        // 20220114「ここまで」以下を処理しない為
                                        $no_process = "";




                // 行毎のデータ
                    foreach($read_csv as $var){

                        $create_html[$i] = "";


// 「ここまで」が含まれる最後の行のみ処理しない
                            // 20211030 end(～という関数は推奨されていないかもしれないので「ここまでと書かれた行を弾く」ロジックに変更
                            //if($var !== end($read_csv)){
                                /*$end_line = in_array("ここまで",$var);
                                if($end_line){ $end_line2 = "ON";} else { $end_line2 = "OFF"; }
                                if($end_line2 == "OFF"){ */
    
                                    // 変数の作成
                                        $pc_source[$i] = "";
                                        $sp_source[$i] = "";
                                        $sp_source_l[$i] = "";
                                        $sp_info1[$i] = "";
                                        $sp_info2[$i] = "";
                                        $sp_info3[$i] = "";
                                        $sp_info4[$i] = "";
                                        $sp_info5[$i] = "";
                                        $sp_info6[$i] = "";
                                        $sp_info7[$i] = "";
                                        $sp_info8[$i] = "";
                                        $sp_info9[$i] = "";
                                        $sp_info10[$i] = "";
    
    
                                    // 20210908
                                        $all_sp_source_l[$i] = "";
                                        $all_sp_source_m[$i] = "";
                                        $sp_l_html = "";
                                        $sp_m_html = "";
                                
                                        $pc_source_l[$i] = "";
                                        $pc_source_m[$i] = "";
                                        $all_pc_source_l[$i] = "";
                                        $all_pc_source_m[$i] = "";
    
                                    // 20211127
                                        $model_name[$i] = "";
                                        $pc_title = "";

                    
                                    // 各行の列毎のデータ
                                        $ii = 0;
                                        foreach($var as $var2){
    
                                                                    // 文字コードを UTF-8 へ変換
                                                                    // 20211020 mb_convert_variables('UTF-8', 'sjis-win', $var2);
                            
                                                                    // SP用タイトルを先に取得
                                                                        if($i == 0){
                                                                            switch($ii){
                                                                                case "0":
                                                                                    $title1 = $var2;
                                                                                case "1":
                                                                                    $title2 = $var2;
                                                                                case "2":
                                                                                    $title3 = $var2;
                                                                                case "3":
                                                                                    $title4 = $var2;
                                                                                case "4":
                                                                                    $title5 = $var2;
                                                                                case "5":
                                                                                    $title6 = $var2;
                                                                                case "6":
                                                                                    $title7 = $var2;
                                                                                }
                                                                        }    




                                                        //$create_html[$i] .= $this->create_html($i,$ii);
                                                        if($ii == 0){$info1 = $var2;} 
                                                        if($ii == 1){$info2 = $var2;} 
                                                        if($ii == 2){$info3 = $var2;} 
                                                        if($ii == 3){$info4 = $var2;} 
                                                        if($ii == 4){$info5 = $var2;} 
                                                        if($ii == 5){$info6 = $var2;} 
                                                        if($ii == 6){$info7 = $var2;} 
                                                        if($ii == 7){$info8 = $var2;} 

 

                                        
                                            $ii++;
                                        }

                                        // 20220114「ここまで」以下を処理しない為
                                        if(strpos($info1,'ここまで') !== false || strpos($info2,'ここまで') !== false || strpos($info3,'ここまで') !== false || strpos($info4,'ここまで') !== false || strpos($info5,'ここまで') !== false || strpos($info6,'ここまで') !== false || strpos($info7,'ここまで') !== false || strpos($info8,'ここまで') !== false){
                                            $no_process = "ON";
                                        }
                                        
                                        // 変数リセット
                                            $brand[$i] = "";
                                            $size[$i] = "";
                                            $model[$i] = "";
                                            $sorce[$i] = "";
                                            $sp_sorce[$i] = "";

                                        // 列情報などをメソッドに渡し、行毎のソースを作成し、必要な情報も取得
                                            $create_html[$i] = $this->create_html($i,$file_name,$info1,$info2,$info3,$info4,$info5,$info6,$info7,$info8,$title1,$title2,$title3,$title4,$title5,$title6,$title7,$class_name1,$class_name2);
                                        // 上記で取得した情報を行毎の変数へ代入   
                                            // 0 = ブランド,1 = サイズ,2 = モデル,3 = ソース
                                                $p = 0;
                                                foreach($create_html[$i] as $var3){
                                                    if($p == 0){
                                                        $brand[$i] = $var3;
                                                    } else if($p == 1){
                                                        $size[$i] = $var3;
                                                    } else if($p == 2){
                                                        $model[$i] = $var3;
                                                    } else if($p == 3){
                                                        $sorce[$i] = $var3;
                                                    } else if($p == 4){
                                                        $sp_sorce[$i] = $var3;
                                                    }
                                                $p++;
                                                }
                                        // 後に任意の順番で並べるため、各個別ソースをブランドのモデル毎の変数へ代入
                                                // 20220114「ここまで」以下を処理しない為
                                                // if($i == 0){
                                                if($i == 0 || $no_process == "ON"){
                                            //array_push($title,$sorce[$i]);
                                                } else {
                                                    if($size[$i] == "メンズ"){
                                                        if($brand[$i] == "ロレックス"){
                                                            if(strpos($model[$i],'デイトナ') !== false){
                                                                array_push($pc_m_rore1,$sorce[$i]);
                                                                array_push($sp_m_rore1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'エクスプローラー') !== false){
                                                                array_push($pc_m_rore2,$sorce[$i]);
                                                                array_push($sp_m_rore2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'GMT') !== false){
                                                                array_push($pc_m_rore3,$sorce[$i]);
                                                                array_push($sp_m_rore3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'サブマリーナ') !== false){
                                                                array_push($pc_m_rore4,$sorce[$i]);
                                                                array_push($sp_m_rore4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ディープシ') !== false){
                                                                array_push($pc_m_rore5,$sorce[$i]);
                                                                array_push($sp_m_rore5,$sp_sorce[$i]);
                                                            //20220114} else if(strpos($model[$i],'シードゥウェラ') !== false){
                                                            } else if(strpos($model[$i],'シードゥウェラ') !== false || strpos($model[$i],'シードゥエラー') !== false){
                                                                array_push($pc_m_rore6,$sorce[$i]);
                                                                array_push($sp_m_rore6,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ヨットマスタ') !== false){
                                                                array_push($pc_m_rore7,$sorce[$i]);
                                                                array_push($sp_m_rore7,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ミルガウス') !== false){
                                                                array_push($pc_m_rore8,$sorce[$i]);
                                                                array_push($sp_m_rore8,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'デイトジャスト') !== false){
                                                                array_push($pc_m_rore9,$sorce[$i]);
                                                                array_push($sp_m_rore9,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'スカイドゥエラー') !== false){
                                                                array_push($pc_m_rore10,$sorce[$i]);
                                                                array_push($sp_m_rore10,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'エアキング') !== false){
                                                                array_push($pc_m_rore11,$sorce[$i]);
                                                                array_push($sp_m_rore11,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "オメガ"){
                                                            if(strpos($model[$i],'スピードマスター') !== false){
                                                                array_push($pc_m_ome1,$sorce[$i]);
                                                                array_push($sp_m_ome1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'シーマスター') !== false){
                                                                array_push($pc_m_ome2,$sorce[$i]);
                                                                array_push($sp_m_ome2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'デ・ヴィル') !== false){
                                                                array_push($pc_m_ome3,$sorce[$i]);
                                                                array_push($sp_m_ome3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'コンステレーション') !== false){
                                                                array_push($pc_m_ome4,$sorce[$i]);
                                                                array_push($sp_m_ome4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'レイルマスター') !== false){
                                                                array_push($pc_m_ome5,$sorce[$i]);
                                                                array_push($sp_m_ome5,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "タグ・ホイヤー"){
                                                            if(strpos($model[$i],'カレラ') !== false){
                                                                array_push($pc_m_tag1,$sorce[$i]);
                                                                array_push($sp_m_tag1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アクアレーサー') !== false){
                                                                array_push($pc_m_tag2,$sorce[$i]);
                                                                array_push($sp_m_tag2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'フォーミュラ') !== false){
                                                                array_push($pc_m_tag3,$sorce[$i]);
                                                                array_push($sp_m_tag3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'モナコ') !== false){
                                                                array_push($pc_m_tag4,$sorce[$i]);
                                                                array_push($sp_m_tag4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'リンク') !== false){
                                                                array_push($pc_m_tag5,$sorce[$i]);
                                                                array_push($sp_m_tag5,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "ブライトリング"){
                                                            if(strpos($model[$i],'クロノマット') !== false){
                                                                array_push($pc_m_breit1,$sorce[$i]);
                                                                array_push($sp_m_breit1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ナビタイマー') !== false){
                                                                array_push($pc_m_breit2,$sorce[$i]);
                                                                array_push($sp_m_breit2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アビエーター8') !== false){
                                                                array_push($pc_m_breit3,$sorce[$i]);
                                                                array_push($sp_m_breit3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'スーパーオーシャンヘリテージ') !== false){
                                                                array_push($pc_m_breit4,$sorce[$i]);
                                                                array_push($sp_m_breit4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'スーパーオーシャン') !== false){
                                                                array_push($pc_m_breit5,$sorce[$i]);
                                                                array_push($sp_m_breit5,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'トランスオーシャン') !== false){
                                                                array_push($pc_m_breit6,$sorce[$i]);
                                                                array_push($sp_m_breit6,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アベンジャー') !== false){
                                                                array_push($pc_m_breit7,$sorce[$i]);
                                                                array_push($sp_m_breit7,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'プレミエ') !== false){
                                                                array_push($pc_m_breit8,$sorce[$i]);
                                                                array_push($sp_m_breit8,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'モンブリラン') !== false){
                                                                array_push($pc_m_breit9,$sorce[$i]);
                                                                array_push($sp_m_breit9,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'コルト') !== false){
                                                                array_push($pc_m_breit10,$sorce[$i]);
                                                                array_push($sp_m_breit10,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'プロフェッショナル') !== false){
                                                                array_push($pc_m_breit11,$sorce[$i]);
                                                                array_push($sp_m_breit11,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'コックピット') !== false){
                                                                array_push($pc_m_breit12,$sorce[$i]);
                                                                array_push($sp_m_breit12,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ベントレー') !== false){
                                                                array_push($pc_m_breit13,$sorce[$i]);
                                                                array_push($sp_m_breit13,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ギャラクティック') !== false){
                                                                array_push($pc_m_breit14,$sorce[$i]);
                                                                array_push($sp_m_breit14,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }

                                                        } else if($brand[$i] == "セイコー"){
                                                            if(strpos($model[$i],'GS スプリングドライブ') !== false){
                                                                array_push($pc_m_seiko1,$sorce[$i]);
                                                                array_push($sp_m_seiko1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'GS メカニカル') !== false){
                                                                array_push($pc_m_seiko2,$sorce[$i]);
                                                                array_push($sp_m_seiko2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'GS クオーツ') !== false){
                                                                array_push($pc_m_seiko3,$sorce[$i]);
                                                                array_push($sp_m_seiko3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アストロン') !== false){
                                                                array_push($pc_m_seiko4,$sorce[$i]);
                                                                array_push($sp_m_seiko4,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "パネライ"){
                                                            if(strpos($model[$i],'ラジオミール') !== false){
                                                                array_push($pc_m_pane1,$sorce[$i]);
                                                                array_push($sp_m_pane1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ルミノール') !== false){
                                                                array_push($pc_m_pane2,$sorce[$i]);
                                                                array_push($sp_m_pane2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'サブマーシブル') !== false){
                                                                array_push($pc_m_pane3,$sorce[$i]);
                                                                array_push($sp_m_pane3,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "IWC"){
                                                            if(strpos($model[$i],'ポルトギーゼ') !== false){
                                                                array_push($pc_m_iwc1,$sorce[$i]);
                                                                array_push($sp_m_iwc1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'パイロット') !== false){
                                                                array_push($pc_m_iwc2,$sorce[$i]);
                                                                array_push($sp_m_iwc2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ポートフィノ') !== false){
                                                                array_push($pc_m_iwc3,$sorce[$i]);
                                                                array_push($sp_m_iwc3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'インヂュニア') !== false){
                                                                array_push($pc_m_iwc4,$sorce[$i]);
                                                                array_push($sp_m_iwc4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アクアタイマー') !== false){
                                                                array_push($pc_m_iwc5,$sorce[$i]);
                                                                array_push($sp_m_iwc5,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ヴィンチ') !== false){
                                                                array_push($pc_m_iwc6,$sorce[$i]);
                                                                array_push($sp_m_iwc6,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "カルティエ"){
                                                            if(strpos($model[$i],'タンクフランセーズ') !== false){
                                                                array_push($pc_m_car1,$sorce[$i]);
                                                                array_push($sp_m_car1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'カリブル') !== false){
                                                                array_push($pc_m_car2,$sorce[$i]);
                                                                array_push($sp_m_car2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'タンクMC') !== false){
                                                                array_push($pc_m_car3,$sorce[$i]);
                                                                array_push($sp_m_car3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'タンクソロ') !== false){
                                                                array_push($pc_m_car4,$sorce[$i]);
                                                                array_push($sp_m_car4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'タンクアメリカン') !== false){
                                                                array_push($pc_m_car5,$sorce[$i]);
                                                                array_push($sp_m_car5,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'サントス') !== false){
                                                                array_push($pc_m_car6,$sorce[$i]);
                                                                array_push($sp_m_car6,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'パンテール') !== false){
                                                                array_push($pc_m_car7,$sorce[$i]);
                                                                array_push($sp_m_car7,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'バロンブルー') !== false){
                                                                array_push($pc_m_car8,$sorce[$i]);
                                                                array_push($sp_m_car8,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'パシャ') !== false){
                                                                array_push($pc_m_car9,$sorce[$i]);
                                                                array_push($sp_m_car9,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ロンドソロ') !== false){
                                                                array_push($pc_m_car10,$sorce[$i]);
                                                                array_push($sp_m_car10,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "パテック フィリップ"){
                                                            if(strpos($model[$i],'アクアノート') !== false){
                                                                array_push($pc_m_pate1,$sorce[$i]);
                                                                array_push($sp_m_pate1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ノーチラス') !== false){
                                                                array_push($pc_m_pate2,$sorce[$i]);
                                                                array_push($sp_m_pate2,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }  
                                                        } else if($brand[$i] == "ヴァシュロン・コンスタンタン"){
                                                        } else if($brand[$i] == "オーデマ ピゲ"){
                                                            if(strpos($model[$i],'ロイヤルオーク') !== false){
                                                                array_push($pc_m_aud1,$sorce[$i]);
                                                                array_push($sp_m_aud1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'CODE 11.59') !== false){
                                                                array_push($pc_m_aud2,$sorce[$i]);
                                                                array_push($sp_m_aud2,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_m_other,$sorce[$i]);
                                                                array_push($sp_m_other,$sp_sorce[$i]);
                                                            }
                                                        }
                                                    } else if($size[$i] == "レディース"){
                                                        if($brand[$i] == "ロレックス"){
                                                            if(strpos($model[$i],'デイトナ') !== false){
                                                                array_push($pc_l_rore1,$sorce[$i]);
                                                                array_push($sp_l_rore1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'エクスプローラー') !== false){
                                                                array_push($pc_l_rore2,$sorce[$i]);
                                                                array_push($sp_l_rore2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'GMT') !== false){
                                                                array_push($pc_l_rore3,$sorce[$i]);
                                                                array_push($sp_l_rore3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'サブマリーナ') !== false){
                                                                array_push($pc_l_rore4,$sorce[$i]);
                                                                array_push($sp_l_rore4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ディープシ') !== false){
                                                                array_push($pc_l_rore5,$sorce[$i]);
                                                                array_push($sp_l_rore5,$sp_sorce[$i]);
                                                            //20220114} else if(strpos($model[$i],'シードゥウェラ') !== false){
                                                            } else if(strpos($model[$i],'シードゥウェラ') !== false || strpos($model[$i],'シードゥエラ') !== false){
                                                                array_push($pc_l_rore6,$sorce[$i]);
                                                                array_push($sp_l_rore6,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ヨットマスタ') !== false){
                                                                array_push($pc_l_rore7,$sorce[$i]);
                                                                array_push($sp_l_rore7,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ミルガウス') !== false){
                                                                array_push($pc_l_rore8,$sorce[$i]);
                                                                array_push($sp_l_rore8,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'デイトジャスト') !== false){
                                                                array_push($pc_l_rore9,$sorce[$i]);
                                                                array_push($sp_l_rore9,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'スカイドゥエラー') !== false){
                                                                array_push($pc_l_rore9,$sorce[$i]);
                                                                array_push($sp_l_rore9,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'エアキング') !== false){
                                                                array_push($pc_l_rore9,$sorce[$i]);
                                                                array_push($sp_l_rore9,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "オメガ"){
                                                            if(strpos($model[$i],'スピードマスター') !== false){
                                                                array_push($pc_l_ome1,$sorce[$i]);
                                                                array_push($sp_l_ome1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'シーマスター') !== false){
                                                                array_push($pc_l_ome2,$sorce[$i]);
                                                                array_push($sp_l_ome2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'デ・ヴィル') !== false){
                                                                array_push($pc_l_ome3,$sorce[$i]);
                                                                array_push($sp_l_ome3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'コンステレーション') !== false){
                                                                array_push($pc_l_ome4,$sorce[$i]);
                                                                array_push($sp_l_ome4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'レイルマスター') !== false){
                                                                array_push($pc_l_ome5,$sorce[$i]);
                                                                array_push($sp_l_ome5,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }                                                        } else if($brand[$i] == "タグ・ホイヤー"){
                                                        } else if($brand[$i] == "タグ・ホイヤー"){
                                                            if(strpos($model[$i],'カレラ') !== false){
                                                                array_push($pc_l_tag1,$sorce[$i]);
                                                                array_push($sp_l_tag1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アクアレーサー') !== false){
                                                                array_push($pc_l_tag2,$sorce[$i]);
                                                                array_push($sp_l_tag2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'フォーミュラ') !== false){
                                                                array_push($pc_l_tag3,$sorce[$i]);
                                                                array_push($sp_l_tag3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'モナコ') !== false){
                                                                array_push($pc_l_tag4,$sorce[$i]);
                                                                array_push($sp_l_tag4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'リンク') !== false){
                                                                array_push($pc_l_tag5,$sorce[$i]);
                                                                array_push($sp_l_tag5,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "ブライトリング"){
                                                            if(strpos($model[$i],'クロノマット') !== false){
                                                                array_push($pc_l_breit1,$sorce[$i]);
                                                                array_push($sp_l_breit1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ナビタイマー') !== false){
                                                                array_push($pc_l_breit2,$sorce[$i]);
                                                                array_push($sp_l_breit2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アビエーター8') !== false){
                                                                array_push($pc_l_breit3,$sorce[$i]);
                                                                array_push($sp_l_breit3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'スーパーオーシャンヘリテージ') !== false){
                                                                array_push($pc_l_breit4,$sorce[$i]);
                                                                array_push($sp_l_breit4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'スーパーオーシャン') !== false){
                                                                array_push($pc_l_breit5,$sorce[$i]);
                                                                array_push($sp_l_breit5,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'トランスオーシャン') !== false){
                                                                array_push($pc_l_breit6,$sorce[$i]);
                                                                array_push($sp_l_breit6,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アベンジャー') !== false){
                                                                array_push($pc_l_breit7,$sorce[$i]);
                                                                array_push($sp_l_breit7,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'プレミエ') !== false){
                                                                array_push($pc_l_breit8,$sorce[$i]);
                                                                array_push($sp_l_breit8,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'モンブリラン') !== false){
                                                                array_push($pc_l_breit9,$sorce[$i]);
                                                                array_push($sp_l_breit9,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'コルト') !== false){
                                                                array_push($pc_l_breit10,$sorce[$i]);
                                                                array_push($sp_l_breit10,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'プロフェッショナル') !== false){
                                                                array_push($pc_l_breit11,$sorce[$i]);
                                                                array_push($sp_l_breit11,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'コックピット') !== false){
                                                                array_push($pc_l_breit12,$sorce[$i]);
                                                                array_push($sp_l_breit12,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ベントレー') !== false){
                                                                array_push($pc_l_breit13,$sorce[$i]);
                                                                array_push($sp_l_breit13,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ギャラクティック') !== false){
                                                                array_push($pc_l_breit14,$sorce[$i]);
                                                                array_push($sp_l_breit14,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "セイコー"){
                                                            if(strpos($model[$i],'GS スプリングドライブ') !== false){
                                                                array_push($pc_l_seiko1,$sorce[$i]);
                                                                array_push($sp_l_seiko1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'GS メカニカル') !== false){
                                                                array_push($pc_l_seiko2,$sorce[$i]);
                                                                array_push($sp_l_seiko2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'GS クオーツ') !== false){
                                                                array_push($pc_l_seiko3,$sorce[$i]);
                                                                array_push($sp_l_seiko3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アストロン') !== false){
                                                                array_push($pc_l_seiko4,$sorce[$i]);
                                                                array_push($sp_l_seiko4,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "パネライ"){
                                                            if(strpos($model[$i],'ラジオミール') !== false){
                                                                array_push($pc_l_pane1,$sorce[$i]);
                                                                array_push($sp_l_pane1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ルミノール') !== false){
                                                                array_push($pc_l_pane2,$sorce[$i]);
                                                                array_push($sp_l_pane2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'サブマーシブル') !== false){
                                                                array_push($pc_l_pane3,$sorce[$i]);
                                                                array_push($sp_l_pane3,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "IWC"){
                                                            if(strpos($model[$i],'ポルトギーゼ') !== false){
                                                                array_push($pc_l_iwc1,$sorce[$i]);
                                                                array_push($sp_l_iwc1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'パイロット') !== false){
                                                                array_push($pc_l_iwc2,$sorce[$i]);
                                                                array_push($sp_l_iwc2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ポートフィノ') !== false){
                                                                array_push($pc_l_iwc3,$sorce[$i]);
                                                                array_push($sp_l_iwc3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'インヂュニア') !== false){
                                                                array_push($pc_l_iwc4,$sorce[$i]);
                                                                array_push($sp_l_iwc4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'アクアタイマー') !== false){
                                                                array_push($pc_l_iwc5,$sorce[$i]);
                                                                array_push($sp_l_iwc5,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ヴィンチ') !== false){
                                                                array_push($pc_l_iwc6,$sorce[$i]);
                                                                array_push($sp_l_iwc6,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "カルティエ"){
                                                            if(strpos($model[$i],'タンクフランセーズ') !== false){
                                                                array_push($pc_l_car1,$sorce[$i]);
                                                                array_push($sp_l_car1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'カリブル') !== false){
                                                                array_push($pc_l_car2,$sorce[$i]);
                                                                array_push($sp_l_car2,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'タンクMC') !== false){
                                                                array_push($pc_l_car3,$sorce[$i]);
                                                                array_push($sp_l_car3,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'タンクソロ') !== false){
                                                                array_push($pc_l_car4,$sorce[$i]);
                                                                array_push($sp_l_car4,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'タンクアメリカン') !== false){
                                                                array_push($pc_l_car5,$sorce[$i]);
                                                                array_push($sp_l_car5,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'サントス') !== false){
                                                                array_push($pc_l_car6,$sorce[$i]);
                                                                array_push($sp_l_car6,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'パンテール') !== false){
                                                                array_push($pc_l_car7,$sorce[$i]);
                                                                array_push($sp_l_car7,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'バロンブルー') !== false){
                                                                array_push($pc_l_car8,$sorce[$i]);
                                                                array_push($sp_l_car8,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'パシャ') !== false){
                                                                array_push($pc_l_car9,$sorce[$i]);
                                                                array_push($sp_l_car9,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ロンドソロ') !== false){
                                                                array_push($pc_l_car10,$sorce[$i]);
                                                                array_push($sp_l_car10,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "パテック フィリップ"){
                                                            if(strpos($model[$i],'アクアノート') !== false){
                                                                array_push($pc_l_pate1,$sorce[$i]);
                                                                array_push($sp_l_pate1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'ノーチラス') !== false){
                                                                array_push($pc_l_pate2,$sorce[$i]);
                                                                array_push($sp_l_pate2,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }
                                                        } else if($brand[$i] == "ヴァシュロン・コンスタンタン"){
                                                        } else if($brand[$i] == "オーデマ ピゲ"){
                                                            if(strpos($model[$i],'ロイヤルオーク') !== false){
                                                                array_push($pc_l_aud1,$sorce[$i]);
                                                                array_push($sp_l_aud1,$sp_sorce[$i]);
                                                            } else if(strpos($model[$i],'CODE 11.59') !== false){
                                                                array_push($pc_l_aud2,$sorce[$i]);
                                                                array_push($sp_l_aud2,$sp_sorce[$i]);
                                                            } else {
                                                                array_push($pc_l_other,$sorce[$i]);
                                                                array_push($sp_l_other,$sp_sorce[$i]);
                                                            }
                                                        }
                                                    }
                                                }
                                                

                        $i++;
                    }
                    
                    //echo $title . "<br>" . $pc_m_rore1 . $pc_m_other .$pc_l_other;
                    // PC用・タイトルソース
                        // タイトル用配列の定義
                            $pc_title = array();
                        // タイトル用ソース作成
                            // 20220114 タイトルのCSSから「bgc-black」を撤去。これがあるとクロームで右側に線が現れるため
                            $pc_title_sorce =  '<div class="' . $class_name1 . "2" . $class_name2 . ' sticky fc-white">
                                                    <p class="fc-white">' . $title1 . '</p>
                                                    <p class="fc-white">' . $title2 . '</p>
                                                    <p class="fc-white">' . $title3 . '</p>
                                                    <p class="fc-white">' . $title4 . '</p>
                                                    <p class="fc-white">' . $title5 . '</p>
                                                    <p class="fc-white">' . $title6 . '</p>
                                                    <p class="fc-white">' . $title7 . '</p>
                                                </div><span id="m_top" class="mens_link_r"></span><div class="mens_title">メンズ</div>';
                        // タイトル用ソースの配列化
                            array_push($pc_title,$pc_title_sorce);
                        // タイトル用ソースの配列を全PCソースの配列へ合体させる
                            $pc_all_array = array_merge($pc_all_array, $pc_title);

                    // 行毎の情報をモデル毎にグループ分け
                        if(strpos($file_name,'ROLEX') !== false){

                            // デイトナ
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore1)){ 
                                        if($pc_m_rore1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore1_first = array();
                                                $pc_m_rore1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デイトナ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore1_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore1);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore1_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore1)){ 
                                        if($pc_l_rore1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore1_first = array();
                                                $pc_l_rore1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デイトナ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore1_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore1);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore1_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore1)){ 
                                        if($sp_m_rore1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore1_first = array();
                                                $sp_m_rore1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デイトナ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore1_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore1);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore1_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore1)){ 
                                        if($sp_l_rore1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore1_first = array();
                                                $sp_l_rore1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デイトナ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore1_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore1);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore1_last);
                                        }


                            // エクスプローラー
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore2)){ 
                                        if($pc_m_rore2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore2_first = array();
                                                $pc_m_rore2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>エクスプローラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore2_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore2)){ 
                                        if($pc_l_rore2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore2_first = array();
                                                $pc_l_rore2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>エクスプローラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore2)){ 
                                        if($sp_m_rore2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore2_first = array();
                                                $sp_m_rore2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>エクスプローラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore2_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore2)){ 
                                        if($sp_l_rore2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore2_first = array();
                                                $sp_l_rore2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>エクスプローラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore2_last);
                                        }

                            // GMTマスター
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore3)){ 
                                        if($pc_m_rore3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore3_first = array();
                                                $pc_m_rore3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GMTマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore3_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore3);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore3_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore3)){ 
                                        if($pc_l_rore3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore3_first = array();
                                                $pc_l_rore3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GMTマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore3_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore3);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore3_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore3)){ 
                                        if($sp_m_rore3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore3_first = array();
                                                $sp_m_rore3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GMTマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore3_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore3);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore3_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore3)){ 
                                        if($sp_l_rore3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore3_first = array();
                                                $sp_l_rore3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GMTマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "on_o'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore3_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore3);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore3_last);
                                        }
                            // サブマリーナー
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore4)){ 
                                        if($pc_m_rore4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore4_first = array();
                                                $pc_m_rore4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サブマリーナー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore4_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore4);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore4_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore4)){ 
                                        if($pc_l_rore4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore4_first = array();
                                                $pc_l_rore4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サブマリーナー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore4_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore4);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore4_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore4)){ 
                                        if($sp_m_rore4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore4_first = array();
                                                $sp_m_rore4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サブマリーナー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore4_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore4);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore4_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore4)){ 
                                        if($sp_l_rore4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore4_first = array();
                                                $sp_l_rore4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サブマリーナー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore4_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore4);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore4_last);
                                        }
                            // ディープシー
                                /*　20220121 ディープシーはシードゥエラーのシリーズ
                                    // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore5)){ 
                                        if($pc_m_rore5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore5_first = array();
                                                $pc_m_rore5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ディープシー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore5_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore5);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore5_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore5)){ 
                                        if($pc_l_rore5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore5_first = array();
                                                $pc_l_rore5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ディープシー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore5_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore5);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore5_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore5)){ 
                                        if($sp_m_rore5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore5_first = array();
                                                $sp_m_rore5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ディープシー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore5_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore5);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore5_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore5)){ 
                                        if($sp_l_rore5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore5_first = array();
                                                $sp_l_rore5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ディープシー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore5_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore5);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore5_last);
                                        }*/
                            // シードゥエラー
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore6)){ 
                                        if($pc_m_rore6){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore6_first = array();
                                                $pc_m_rore6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>シードゥエラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore6_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore6);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore6_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore6)){ 
                                        if($pc_l_rore6){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore6_first = array();
                                                $pc_l_rore6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>シードゥエラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore6_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore6);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore6_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore6)){ 
                                        if($sp_m_rore6){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore6_first = array();
                                                $sp_m_rore6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>シードゥエラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore6_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore6);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore6_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore6)){ 
                                        if($sp_l_rore6){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore6_first = array();
                                                $sp_l_rore6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>シードゥエラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore6_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore6);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore6_last);
                                        }
                            // ヨットマスター
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore7)){ 
                                        if($pc_m_rore7){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore7_first = array();
                                                $pc_m_rore7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ヨットマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore7_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore7);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore7_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore7)){ 
                                        if($pc_l_rore7){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore7_first = array();
                                                $pc_l_rore7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ヨットマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore7_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore7);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore7_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore7)){ 
                                        if($sp_m_rore7){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore7_first = array();
                                                $sp_m_rore7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ヨットマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore7_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore7);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore7_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore7)){ 
                                        if($sp_l_rore7){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore7_first = array();
                                                $sp_l_rore7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ヨットマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore7_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore7);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore7_last);
                                        }
                            // ミルガウス
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore8)){ 
                                        if($pc_m_rore8){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore8_first = array();
                                                $pc_m_rore8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ミルガウス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore8_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore8);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore8_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore8)){ 
                                        if($pc_l_rore8){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore8_first = array();
                                                $pc_l_rore8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ミルガウス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore8_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore8);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore8_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore8)){ 
                                        if($sp_m_rore8){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore8_first = array();
                                                $sp_m_rore8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ミルガウス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore8_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore8);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore8_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore8)){ 
                                        if($sp_l_rore8){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore8_first = array();
                                                $sp_l_rore8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ミルガウス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore8_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore8);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore8_last);
                                        }

                            // デイトジャスト
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore9)){ 
                                        if($pc_m_rore9){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore9_first = array();
                                                $pc_m_rore9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デイトジャスト</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore9_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore9);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore9_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore9)){ 
                                        if($pc_l_rore9){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore9_first = array();
                                                $pc_l_rore9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デイトジャスト</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore9_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore9);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore9_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore9)){ 
                                        if($sp_m_rore9){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore9_first = array();
                                                $sp_m_rore9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デイトジャスト</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore9_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore9);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore9_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore9)){ 
                                        if($sp_l_rore9){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore9_first = array();
                                                $sp_l_rore9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デイトジャスト</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore9_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore9);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore9_last);
                                        }

                            // スカイドゥエラー
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore10)){ 
                                        if($pc_m_rore10){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore10_first = array();
                                                $pc_m_rore10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スカイドゥエラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore10_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore10);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore10_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore10)){ 
                                        if($pc_l_rore10){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore10_first = array();
                                                $pc_l_rore10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スカイドゥエラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore10_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore10);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore10_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore10)){ 
                                        if($sp_m_rore10){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore10_first = array();
                                                $sp_m_rore10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スカイドゥエラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore10_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore10);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore10_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore10)){ 
                                        if($sp_l_rore10){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore10_first = array();
                                                $sp_l_rore10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スカイドゥエラー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore10_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore10);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore10_last);
                                        }

                            // エアキング
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_rore11)){ 
                                        if($pc_m_rore11){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_rore11_first = array();
                                                $pc_m_rore11_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_rore11_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>エアキング</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_rore11_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore11_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore11);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_rore11_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_rore11)){ 
                                        if($pc_l_rore11){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_rore11_first = array();
                                                $pc_l_rore11_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_rore11_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>エアキング</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_rore11_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore11_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore11);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_rore11_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_rore11)){ 
                                        if($sp_m_rore11){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_rore11_first = array();
                                                $sp_m_rore11_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_rore11_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>エアキング</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_rore11_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore11_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore11);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_rore11_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_rore11)){ 
                                        if($sp_l_rore11){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_rore11_first = array();
                                                $sp_l_rore11_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_rore11_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>エアキング</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_rore11_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore11_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore11);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_rore11_last);
                                        }



                            // その他モデル
                                // PC用
                                    // メンズ用
                                        //if(isset($pc_m_other)){ 
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        //if(isset($pc_l_other)){ 
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        //if(isset($sp_m_other)){ 
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        //if(isset($sp_l_other)){ 
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }


                        } else if(strpos($file_name,'OMEGA') !== false){
                            // スピードマスター用
                                // PC用
                                    // メンズ用
                                    if($pc_m_ome1){ 
                                        // 大枠ソース用配列の定義
                                            $pc_m_ome1_first = array();
                                            $pc_m_ome1_last = array();
                                        // 大枠ソースの配列化
                                            array_push($pc_m_ome1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スピードマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($pc_m_ome1_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $pc_all_array = array_merge($pc_all_array, $pc_m_ome1_first);
                                            $pc_all_array = array_merge($pc_all_array, $pc_m_ome1);
                                            $pc_all_array = array_merge($pc_all_array, $pc_m_ome1_last);
                                    }
                                // レディース用
                                    if($pc_l_ome1){ 
                                        // 大枠ソース用配列の定義
                                            $pc_l_ome1_first = array();
                                            $pc_l_ome1_last = array();
                                        // 大枠ソースの配列化
                                            array_push($pc_l_ome1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スピードマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($pc_l_ome1_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome1_first);
                                            $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome1);
                                            $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome1_last);
                                    }

                            // SP用
                                // メンズ用
                                    if($sp_m_ome1){ 
                                        // 大枠ソース用配列の定義
                                            $sp_m_ome1_first = array();
                                            $sp_m_ome1_last = array();
                                        // 大枠ソースの配列化
                                            array_push($sp_m_ome1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スピードマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($sp_m_ome1_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $sp_all_array = array_merge($sp_all_array, $sp_m_ome1_first);
                                            $sp_all_array = array_merge($sp_all_array, $sp_m_ome1);
                                            $sp_all_array = array_merge($sp_all_array, $sp_m_ome1_last);
                                    }
                                // レディース用
                                    if($sp_l_ome1){ 
                                        // 大枠ソース用配列の定義
                                            $sp_l_ome1_first = array();
                                            $sp_l_ome1_last = array();
                                        // 大枠ソースの配列化
                                            array_push($sp_l_ome1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スピードマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($sp_l_ome1_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome1_first);
                                            $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome1);
                                            $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome1_last);
                                    }

                            // シーマスター
                                // PC用
                                    // メンズ用
                                        if($pc_m_ome2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_ome2_first = array();
                                                $pc_m_ome2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_ome2_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>シーマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_ome2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome2_last);
                                        }
                                    // レディース用
                                        if($pc_l_ome2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_ome2_first = array();
                                                $pc_l_ome2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_ome2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>シーマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_ome2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_ome2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_ome2_first = array();
                                                $sp_m_ome2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_ome2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>シーマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_ome2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome2_last);
                                        }
                                    // レディース用
                                        if($sp_l_ome2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_ome2_first = array();
                                                $sp_l_ome2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_ome2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>シーマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_ome2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome2_last);
                                        }

                            // デ・ヴィル
                                // PC用
                                    // メンズ用
                                        if($pc_m_ome3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_ome3_first = array();
                                                $pc_m_ome3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_ome3_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デ・ヴィル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_ome3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome3_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome3);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome3_last);
                                        }
                                    // レディース用
                                        if($pc_l_ome3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_ome3_first = array();
                                                $pc_l_ome3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_ome3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デ・ヴィル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_ome3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome3_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome3);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome3_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_ome3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_ome3_first = array();
                                                $sp_m_ome3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_ome3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デ・ヴィル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_ome3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome3_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome3);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome3_last);
                                        }
                                    // レディース用
                                        if($sp_l_ome3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_ome3_first = array();
                                                $sp_l_ome3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_ome3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>デ・ヴィル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_ome3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome3_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome3);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome3_last);
                                        }
                            // コンステレーション
                                // PC用
                                    // メンズ用
                                        if($pc_m_ome4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_ome4_first = array();
                                                $pc_m_ome4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_ome4_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コンステレーション</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_ome4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome4_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome4);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome4_last);
                                        }
                                    // レディース用
                                        if($pc_l_ome4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_ome4_first = array();
                                                $pc_l_ome4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_ome4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コンステレーション</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_ome4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome4_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome4);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome4_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_ome4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_ome4_first = array();
                                                $sp_m_ome4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_ome4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コンステレーション</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_ome4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome4_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome4);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome4_last);
                                        }
                                    // レディース用
                                        if($sp_l_ome4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_ome4_first = array();
                                                $sp_l_ome4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_ome4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コンステレーション</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_ome4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome4_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome4);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome4_last);
                                        }

                            // レイルマスター
                                // PC用
                                    // メンズ用
                                        if($pc_m_ome5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_ome5_first = array();
                                                $pc_m_ome5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_ome5_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>レイルマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_ome5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome5_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome5);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_ome5_last);
                                        }
                                    // レディース用
                                        if($pc_l_ome5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_ome5_first = array();
                                                $pc_l_ome5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_ome5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>レイルマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_ome5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome5_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome5);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_ome5_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_ome5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_ome5_first = array();
                                                $sp_m_ome5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_ome5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>レイルマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_ome5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome5_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome5);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_ome5_last);
                                        }
                                    // レディース用
                                        if($sp_l_ome5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_ome5_first = array();
                                                $sp_l_ome5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_ome5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>レイルマスター</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_ome5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome5_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome5);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_ome5_last);
                                        }
                                    
                            // その他モデル
                                // PC用
                                    // メンズ用
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }
                                    

                        } else if(strpos($file_name,'HEUER') !== false){
                            // カレラ用
                                // PC用
                                    // メンズ用
                                    if($pc_m_tag1){ 
                                        // 大枠ソース用配列の定義
                                            $pc_m_tag1_first = array();
                                            $pc_m_tag1_last = array();
                                        // 大枠ソースの配列化
                                            array_push($pc_m_tag1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>カレラ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($pc_m_tag1_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $pc_all_array = array_merge($pc_all_array, $pc_m_tag1_first);
                                            $pc_all_array = array_merge($pc_all_array, $pc_m_tag1);
                                            $pc_all_array = array_merge($pc_all_array, $pc_m_tag1_last);
                                    }
                                // レディース用
                                    if($pc_l_tag1){ 
                                        // 大枠ソース用配列の定義
                                            $pc_l_tag1_first = array();
                                            $pc_l_tag1_last = array();
                                        // 大枠ソースの配列化
                                            array_push($pc_l_tag1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>カレラ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($pc_l_tag1_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag1_first);
                                            $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag1);
                                            $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag1_last);
                                    }

                                // SP用
                                    // メンズ用
                                        if($sp_m_tag1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_tag1_first = array();
                                                $sp_m_tag1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_tag1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>カレラ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_tag1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag1_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag1);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag1_last);
                                        }
                                    // レディース用
                                        if($sp_l_tag1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_tag1_first = array();
                                                $sp_l_tag1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_tag1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>カレラ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_tag1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag1_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag1);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag1_last);
                                        }

                            // アクアレーサー
                                // PC用
                                    // メンズ用
                                        if($pc_m_tag2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_tag2_first = array();
                                                $pc_m_tag2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_tag2_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアレーサー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_tag2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_tag2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_tag2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_tag2_last);
                                        }
                                    // レディース用
                                        if($pc_l_tag2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_tag2_first = array();
                                                $pc_l_tag2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_tag2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアレーサー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_tag2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_tag2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_tag2_first = array();
                                                $sp_m_tag2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_tag2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアレーサー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_tag2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag2_last);
                                        }
                                    // レディース用
                                        if($sp_l_tag2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_tag2_first = array();
                                                $sp_l_tag2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_tag2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアレーサー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_tag2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag2_last);
                                        }

                            // フォーミュラ
                                // PC用
                                    // メンズ用
                                        if($pc_m_tag3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_tag3_first = array();
                                                $pc_m_tag3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_tag3_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>フォーミュラ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_tag3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_tag3_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_tag3);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_tag3_last);
                                        }
                                    // レディース用
                                        if($pc_l_tag3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_tag3_first = array();
                                                $pc_l_tag3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_tag3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>フォーミュラ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_tag3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag3_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag3);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag3_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_tag3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_tag3_first = array();
                                                $sp_m_tag3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_tag3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>フォーミュラ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_tag3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag3_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag3);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag3_last);
                                        }
                                    // レディース用
                                        if($sp_l_tag3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_tag3_first = array();
                                                $sp_l_tag3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_tag3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>フォーミュラ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_tag3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag3_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag3);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag3_last);
                                        }
                            // モナコ
                                // PC用
                                    // メンズ用
                                        if($pc_m_tag4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_tag4_first = array();
                                                $pc_m_tag4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_tag4_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>モナコ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_tag4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_tag4_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_tag4);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_tag4_last);
                                        }
                                    // レディース用
                                        if($pc_l_tag4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_tag4_first = array();
                                                $pc_l_tag4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_tag4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>モナコ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_tag4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag4_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag4);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag4_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_tag4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_tag4_first = array();
                                                $sp_m_tag4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_tag4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>モナコ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_tag4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag4_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag4);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_tag4_last);
                                        }
                                    // レディース用
                                        if($sp_l_tag4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_tag4_first = array();
                                                $sp_l_tag4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_tag4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>モナコ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_tag4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag4_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag4);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag4_last);
                                        }

                            // リンク
                                // PC用
                                    // メンズ用
                                    if($pc_m_tag5){ 
                                        // 大枠ソース用配列の定義
                                            $pc_m_tag5_first = array();
                                            $pc_m_tag5_last = array();
                                        // 大枠ソースの配列化
                                            array_push($pc_m_tag5_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>リンク</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($pc_m_tag5_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $pc_all_array = array_merge($pc_all_array, $pc_m_tag5_first);
                                            $pc_all_array = array_merge($pc_all_array, $pc_m_tag5);
                                            $pc_all_array = array_merge($pc_all_array, $pc_m_tag5_last);
                                    }
                                // レディース用
                                    if($pc_l_tag5){ 
                                        // 大枠ソース用配列の定義
                                            $pc_l_tag5_first = array();
                                            $pc_l_tag5_last = array();
                                        // 大枠ソースの配列化
                                            array_push($pc_l_tag5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>リンク</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($pc_l_tag5_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag5_first);
                                            $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag5);
                                            $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_tag5_last);
                                    }

                            // SP用
                                // メンズ用
                                    if($sp_m_tag5){ 
                                        // 大枠ソース用配列の定義
                                            $sp_m_tag5_first = array();
                                            $sp_m_tag5_last = array();
                                        // 大枠ソースの配列化
                                            array_push($sp_m_tag5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>リンク</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($sp_m_tag5_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $sp_all_array = array_merge($sp_all_array, $sp_m_tag5_first);
                                            $sp_all_array = array_merge($sp_all_array, $sp_m_tag5);
                                            $sp_all_array = array_merge($sp_all_array, $sp_m_tag5_last);
                                    }
                                // レディース用
                                    if($sp_l_tag5){ 
                                        // 大枠ソース用配列の定義
                                            $sp_l_tag5_first = array();
                                            $sp_l_tag5_last = array();
                                        // 大枠ソースの配列化
                                            array_push($sp_l_tag5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>リンク</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                            array_push($sp_l_tag5_last,"</div>");
                                        // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                            $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag5_first);
                                            $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag5);
                                            $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_tag5_last);
                                    }                                    
                            // その他モデル
                                // PC用
                                    // メンズ用
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }
                        } else if(strpos($file_name,'BREIT') !== false){
                            // クロノマット用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit1_first = array();
                                                $pc_m_breit1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>クロノマット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit1_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit1);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit1_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit1_first = array();
                                                $pc_l_breit1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>クロノマット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit1_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit1);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit1_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit1_first = array();
                                                $sp_m_breit1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>クロノマット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit1_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit1);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit1_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit1_first = array();
                                                $sp_l_breit1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>クロノマット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit1_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit1);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit1_last);
                                        }
                            // ナビタイマー用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit2_first = array();
                                                $pc_m_breit2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit2_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ナビタイマー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit2_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit2_first = array();
                                                $pc_l_breit2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ナビタイマー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit2_first = array();
                                                $sp_m_breit2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ナビタイマー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit2_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit2_first = array();
                                                $sp_l_breit2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ナビタイマー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit2_last);
                                        }
                            // アビエーター8用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit3_first = array();
                                                $pc_m_breit3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit3_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アビエーター8</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit3_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit3);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit3_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit3_first = array();
                                                $pc_l_breit3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アビエーター8</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit3_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit3);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit3_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit3_first = array();
                                                $sp_m_breit3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アビエーター8</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit3_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit3);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit3_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit3_first = array();
                                                $sp_l_breit3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アビエーター8</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit3_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit3);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit3_last);
                                        }
                            // スーパーオーシャンヘリテージ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit4_first = array();
                                                $pc_m_breit4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit4_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スーパーオーシャンヘリテージ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit4_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit4);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit4_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit4_first = array();
                                                $pc_l_breit4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スーパーオーシャンヘリテージ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit4_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit4);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit4_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit4_first = array();
                                                $sp_m_breit4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スーパーオーシャンヘリテージ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit4_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit4);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit4_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit4_first = array();
                                                $sp_l_breit4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スーパーオーシャンヘリテージ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit4_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit4);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit4_last);
                                        }
                            // スーパーオーシャン用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit5_first = array();
                                                $pc_m_breit5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit5_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スーパーオーシャン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit5_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit5);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit5_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit5_first = array();
                                                $pc_l_breit5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スーパーオーシャン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit5_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit5);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit5_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit5_first = array();
                                                $sp_m_breit5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スーパーオーシャン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit5_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit5);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit5_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit5_first = array();
                                                $sp_l_breit5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>スーパーオーシャン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit5_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit5);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit5_last);
                                        }
                            // トランスオーシャン用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit6){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit6_first = array();
                                                $pc_m_breit6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit6_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>トランスオーシャン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit6_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit6);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit6_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit6){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit6_first = array();
                                                $pc_l_breit6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>トランスオーシャン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit6_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit6);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit6_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit6){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit6_first = array();
                                                $sp_m_breit6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>トランスオーシャン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit6_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit6);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit6_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit6){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit6_first = array();
                                                $sp_l_breit6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>トランスオーシャン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit6_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit6);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit6_last);
                                        }
                            // アベンジャー用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit7){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit7_first = array();
                                                $pc_m_breit7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit7_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アベンジャー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit7_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit7);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit7_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit7){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit7_first = array();
                                                $pc_l_breit7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アベンジャー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit7_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit7);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit7_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit7){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit7_first = array();
                                                $sp_m_breit7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アベンジャー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit7_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit7);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit7_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit7){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit7_first = array();
                                                $sp_l_breit7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アベンジャー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit7_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit7);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit7_last);
                                        }
                            // プレミエ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit8){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit8_first = array();
                                                $pc_m_breit8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit8_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>プレミエ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit8_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit8);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit8_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit8){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit8_first = array();
                                                $pc_l_breit8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>プレミエ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit8_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit8);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit8_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit8){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit8_first = array();
                                                $sp_m_breit8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>プレミエ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit8_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit8);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit8_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit8){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit8_first = array();
                                                $sp_l_breit8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>プレミエ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit8_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit8);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit8_last);
                                        }
                            // モンブリラン用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit9){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit9_first = array();
                                                $pc_m_breit9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit9_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>モンブリラン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit9_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit9);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit9_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit9){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit9_first = array();
                                                $pc_l_breit9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>モンブリラン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit9_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit9);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit9_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit9){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit9_first = array();
                                                $sp_m_breit9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>モンブリラン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit9_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit9);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit9_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit9){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit9_first = array();
                                                $sp_l_breit9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>モンブリラン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit9_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit9);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit9_last);
                                        }
                            // コルト用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit10){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit10_first = array();
                                                $pc_m_breit10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit10_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コルト</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit10_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit10);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit10_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit10){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit10_first = array();
                                                $pc_l_breit10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コルト</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit10_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit10);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit10_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit10){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit10_first = array();
                                                $sp_m_breit10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コルト</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit10_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit10);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit10_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit10){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit10_first = array();
                                                $sp_l_breit10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コルト</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit10_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit10);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit10_last);
                                        }
                            // プロフェッショナル用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit11){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit11_first = array();
                                                $pc_m_breit11_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit11_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>プロフェッショナル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit11_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit11_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit11);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit11_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit11){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit11_first = array();
                                                $pc_l_breit11_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit11_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>プロフェッショナル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit11_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit11_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit11);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit11_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit11){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit11_first = array();
                                                $sp_m_breit11_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit11_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>プロフェッショナル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit11_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit11_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit11);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit11_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit11){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit11_first = array();
                                                $sp_l_breit11_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit11_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>プロフェッショナル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit11_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit11_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit11);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit11_last);
                                        }
                            // コックピット用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit12){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit12_first = array();
                                                $pc_m_breit12_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit12_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コックピット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit12_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit12_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit12);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit12_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit12){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit12_first = array();
                                                $pc_l_breit12_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit12_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コックピット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit12_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit12_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit12);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit12_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit12){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit12_first = array();
                                                $sp_m_breit12_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit12_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コックピット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit12_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit12_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit12);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit12_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit12){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit12_first = array();
                                                $sp_l_breit12_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit12_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>コックピット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit12_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit12_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit12);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit12_last);
                                        }
                            // ベントレー用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit13){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit13_first = array();
                                                $pc_m_breit13_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit13_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ベントレー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit13_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit13_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit13);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit13_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit13){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit13_first = array();
                                                $pc_l_breit13_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit13_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ベントレー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit13_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit13_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit13);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit13_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit13){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit13_first = array();
                                                $sp_m_breit13_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit13_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ベントレー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit13_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit13_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit13);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit13_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit13){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit13_first = array();
                                                $sp_l_breit13_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit13_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ベントレー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit13_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit13_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit13);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit13_last);
                                        }
                            // ギャラクティック用
                                // PC用
                                    // メンズ用
                                        if($pc_m_breit14){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_breit14_first = array();
                                                $pc_m_breit14_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_breit14_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ギャラクティック</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_breit14_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit14_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit14);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_breit14_last);
                                        }
                                    // レディース用
                                        if($pc_l_breit14){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_breit14_first = array();
                                                $pc_l_breit14_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_breit14_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ギャラクティック</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_breit14_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit14_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit14);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_breit14_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_breit14){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_breit14_first = array();
                                                $sp_m_breit14_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_breit14_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ギャラクティック</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_breit14_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit14_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit14);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_breit14_last);
                                        }
                                    // レディース用
                                        if($sp_l_breit14){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_breit14_first = array();
                                                $sp_l_breit14_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_breit14_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ギャラクティック</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_breit14_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit14_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit14);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_breit14_last);
                                        }

                            // その他モデル
                                // PC用
                                    // メンズ用
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }
                                
                        } else if(strpos($file_name,'SEIKO') !== false){
                            // GS スプリングドライブ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_seiko1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_seiko1_first = array();
                                                $pc_m_seiko1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_seiko1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS スプリングドライブ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_seiko1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko1_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko1);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko1_last);
                                        }
                                    // レディース用
                                        if($pc_l_seiko1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_seiko1_first = array();
                                                $pc_l_seiko1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_seiko1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS スプリングドライブ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_seiko1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko1_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko1);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko1_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_seiko1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_seiko1_first = array();
                                                $sp_m_seiko1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_seiko1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS スプリングドライブ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_seiko1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko1_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko1);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko1_last);
                                        }
                                    // レディース用
                                        if($sp_l_seiko1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_seiko1_first = array();
                                                $sp_l_seiko1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_seiko1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS スプリングドライブ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_seiko1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko1_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko1);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko1_last);
                                        }
                            // GS メカニカル用
                                // PC用
                                    // メンズ用
                                        if($pc_m_seiko2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_seiko2_first = array();
                                                $pc_m_seiko2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_seiko2_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS メカニカル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_seiko2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko2_last);
                                        }
                                    // レディース用
                                        if($pc_l_seiko2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_seiko2_first = array();
                                                $pc_l_seiko2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_seiko2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS メカニカル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_seiko2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_seiko2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_seiko2_first = array();
                                                $sp_m_seiko2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_seiko2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS メカニカル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_seiko2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko2_last);
                                        }
                                    // レディース用
                                        if($sp_l_seiko2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_seiko2_first = array();
                                                $sp_l_seiko2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_seiko2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS メカニカル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_seiko2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko2_last);
                                        }
                            // GS クオーツ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_seiko3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_seiko3_first = array();
                                                $pc_m_seiko3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_seiko3_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS クオーツ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_seiko3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko3_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko3);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko3_last);
                                        }
                                    // レディース用
                                        if($pc_l_seiko3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_seiko3_first = array();
                                                $pc_l_seiko3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_seiko3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS クオーツ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_seiko3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko3_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko3);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko3_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_seiko3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_seiko3_first = array();
                                                $sp_m_seiko3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_seiko3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS クオーツ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_seiko3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko3_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko3);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko3_last);
                                        }
                                    // レディース用
                                        if($sp_l_seiko3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_seiko3_first = array();
                                                $sp_l_seiko3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_seiko3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>GS クオーツ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_seiko3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko3_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko3);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko3_last);
                                        }
                            // アストロン用
                                // PC用
                                    // メンズ用
                                        if($pc_m_seiko4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_seiko4_first = array();
                                                $pc_m_seiko4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_seiko4_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アストロン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_seiko4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko4_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko4);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_seiko4_last);
                                        }
                                    // レディース用
                                        if($pc_l_seiko4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_seiko4_first = array();
                                                $pc_l_seiko4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_seiko4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アストロン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_seiko4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko4_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko4);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_seiko4_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_seiko4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_seiko4_first = array();
                                                $sp_m_seiko4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_seiko4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アストロン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_seiko4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko4_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko4);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_seiko4_last);
                                        }
                                    // レディース用
                                        if($sp_l_seiko4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_seiko4_first = array();
                                                $sp_l_seiko4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_seiko4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アストロン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_seiko4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko4_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko4);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_seiko4_last);
                                        }

                            // その他モデル
                                // PC用
                                    // メンズ用
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }
                        } else if(strpos($file_name,'PANERAI') !== false){
                            // ラジオミール用
                                // PC用
                                    // メンズ用
                                        if($pc_m_pane1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_pane1_first = array();
                                                $pc_m_pane1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_pane1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ラジオミール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_pane1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pane1_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pane1);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pane1_last);
                                        }
                                    // レディース用
                                        if($pc_l_pane1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_pane1_first = array();
                                                $pc_l_pane1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_pane1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ラジオミール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_pane1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pane1_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pane1);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pane1_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_pane1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_pane1_first = array();
                                                $sp_m_pane1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_pane1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ラジオミール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_pane1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pane1_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pane1);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pane1_last);
                                        }
                                    // レディース用
                                        if($sp_l_pane1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_pane1_first = array();
                                                $sp_l_pane1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_pane1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ラジオミール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_pane1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pane1_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pane1);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pane1_last);
                                        }
                            // ルミノール用
                                // PC用
                                    // メンズ用
                                        if($pc_m_pane2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_pane2_first = array();
                                                $pc_m_pane2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_pane2_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ルミノール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_pane2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pane2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pane2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pane2_last);
                                        }
                                    // レディース用
                                        if($pc_l_pane2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_pane2_first = array();
                                                $pc_l_pane2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_pane2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ルミノール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_pane2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pane2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pane2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pane2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_pane2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_pane2_first = array();
                                                $sp_m_pane2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_pane2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ルミノール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_pane2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pane2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pane2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pane2_last);
                                        }
                                    // レディース用
                                        if($sp_l_pane2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_pane2_first = array();
                                                $sp_l_pane2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_pane2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ルミノール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_pane2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pane2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pane2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pane2_last);
                                        }
                            // サブマーシブル用
                                // PC用
                                    // メンズ用
                                        if($pc_m_pane3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_pane3_first = array();
                                                $pc_m_pane3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_pane3_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サブマーシブル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_pane3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pane3_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pane3);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pane3_last);
                                        }
                                    // レディース用
                                        if($pc_l_pane3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_pane3_first = array();
                                                $pc_l_pane3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_pane3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サブマーシブル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_pane3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pane3_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pane3);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pane3_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_pane3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_pane3_first = array();
                                                $sp_m_pane3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_pane3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サブマーシブル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_pane3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pane3_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pane3);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pane3_last);
                                        }
                                    // レディース用
                                        if($sp_l_pane3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_pane3_first = array();
                                                $sp_l_pane3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_pane3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サブマーシブル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_pane3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pane3_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pane3);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pane3_last);
                                        }

                            // その他モデル
                                // PC用
                                    // メンズ用
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }
                        } else if(strpos($file_name,'IWC') !== false){
                            // ポルトギーゼ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_iwc1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_iwc1_first = array();
                                                $pc_m_iwc1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_iwc1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ポルトギーゼ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_iwc1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc1_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc1);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc1_last);
                                        }
                                    // レディース用
                                        if($pc_l_iwc1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_iwc1_first = array();
                                                $pc_l_iwc1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_iwc1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ポルトギーゼ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_iwc1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc1_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc1);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc1_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_iwc1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_iwc1_first = array();
                                                $sp_m_iwc1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_iwc1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ポルトギーゼ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_iwc1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc1_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc1);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc1_last);
                                        }
                                    // レディース用
                                        if($sp_l_iwc1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_iwc1_first = array();
                                                $sp_l_iwc1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_iwc1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ポルトギーゼ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_iwc1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc1_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc1);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc1_last);
                                        }
                            // パイロット用
                                // PC用
                                    // メンズ用
                                        if($pc_m_iwc2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_iwc2_first = array();
                                                $pc_m_iwc2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_iwc2_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パイロット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_iwc2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc2_last);
                                        }
                                    // レディース用
                                        if($pc_l_iwc2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_iwc2_first = array();
                                                $pc_l_iwc2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_iwc2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パイロット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_iwc2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_iwc2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_iwc2_first = array();
                                                $sp_m_iwc2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_iwc2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パイロット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_iwc2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc2_last);
                                        }
                                    // レディース用
                                        if($sp_l_iwc2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_iwc2_first = array();
                                                $sp_l_iwc2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_iwc2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パイロット</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_iwc2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc2_last);
                                        }
                            // ポートフィノ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_iwc3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_iwc3_first = array();
                                                $pc_m_iwc3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_iwc3_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ポートフィノ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_iwc3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc3_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc3);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc3_last);
                                        }
                                    // レディース用
                                        if($pc_l_iwc3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_iwc3_first = array();
                                                $pc_l_iwc3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_iwc3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ポートフィノ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_iwc3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc3_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc3);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc3_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_iwc3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_iwc3_first = array();
                                                $sp_m_iwc3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_iwc3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ポートフィノ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_iwc3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc3_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc3);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc3_last);
                                        }
                                    // レディース用
                                        if($sp_l_iwc3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_iwc3_first = array();
                                                $sp_l_iwc3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_iwc3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ポートフィノ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_iwc3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc3_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc3);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc3_last);
                                        }
                            // インヂュニア用
                                // PC用
                                    // メンズ用
                                        if($pc_m_iwc4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_iwc4_first = array();
                                                $pc_m_iwc4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_iwc4_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>インヂュニア</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_iwc4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc4_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc4);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc4_last);
                                        }
                                    // レディース用
                                        if($pc_l_iwc4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_iwc4_first = array();
                                                $pc_l_iwc4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_iwc4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>インヂュニア</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_iwc4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc4_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc4);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc4_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_iwc4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_iwc4_first = array();
                                                $sp_m_iwc4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_iwc4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>インヂュニア</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_iwc4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc4_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc4);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc4_last);
                                        }
                                    // レディース用
                                        if($sp_l_iwc4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_iwc4_first = array();
                                                $sp_l_iwc4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_iwc4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>インヂュニア</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_iwc4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc4_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc4);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc4_last);
                                        }
                            // アクアタイマー用
                                // PC用
                                    // メンズ用
                                        if($pc_m_iwc5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_iwc5_first = array();
                                                $pc_m_iwc5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_iwc5_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアタイマー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_iwc5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc5_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc5);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc5_last);
                                        }
                                    // レディース用
                                        if($pc_l_iwc5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_iwc5_first = array();
                                                $pc_l_iwc5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_iwc5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアタイマー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_iwc5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc5_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc5);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc5_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_iwc5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_iwc5_first = array();
                                                $sp_m_iwc5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_iwc5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアタイマー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_iwc5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc5_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc5);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc5_last);
                                        }
                                    // レディース用
                                        if($sp_l_iwc5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_iwc5_first = array();
                                                $sp_l_iwc5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_iwc5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアタイマー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_iwc5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc5_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc5);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc5_last);
                                        }
                            // ダ・ヴィンチ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_iwc6){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_iwc6_first = array();
                                                $pc_m_iwc6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_iwc6_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ダ・ヴィンチ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_iwc6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc6_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc6);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_iwc6_last);
                                        }
                                    // レディース用
                                        if($pc_l_iwc6){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_iwc6_first = array();
                                                $pc_l_iwc6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_iwc6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ダ・ヴィンチ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_iwc6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc6_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc6);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_iwc6_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_iwc6){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_iwc6_first = array();
                                                $sp_m_iwc6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_iwc6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ダ・ヴィンチ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_iwc6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc6_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc6);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_iwc6_last);
                                        }
                                    // レディース用
                                        if($sp_l_iwc6){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_iwc6_first = array();
                                                $sp_l_iwc6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_iwc6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ダ・ヴィンチ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_iwc6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc6_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc6);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_iwc6_last);
                                        }


                            // その他モデル
                                // PC用
                                    // メンズ用
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }


                        } else if(strpos($file_name,'CARTIER') !== false){

                            // タンクフランセーズ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car1_first = array();
                                                $pc_m_car1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクフランセーズ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car1_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car1);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car1_last);
                                        }
                                    // レディース用
                                        if($pc_l_car1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car1_first = array();
                                                $pc_l_car1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクフランセーズ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car1_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car1);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car1_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car1_first = array();
                                                $sp_m_car1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクフランセーズ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car1_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car1);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car1_last);
                                        }
                                    // レディース用
                                        if($sp_l_car1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car1_first = array();
                                                $sp_l_car1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクフランセーズ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car1_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car1);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car1_last);
                                        }
                            // カリブル用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car2_first = array();
                                                $pc_m_car2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car2_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>カリブル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car2_last);
                                        }
                                    // レディース用
                                        if($pc_l_car2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car2_first = array();
                                                $pc_l_car2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>カリブル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car2_first = array();
                                                $sp_m_car2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>カリブル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car2_last);
                                        }
                                    // レディース用
                                        if($sp_l_car2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car2_first = array();
                                                $sp_l_car2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>カリブル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car2_last);
                                        }
                            // タンクMC用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car3_first = array();
                                                $pc_m_car3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car3_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクMC</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car3_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car3);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car3_last);
                                        }
                                    // レディース用
                                        if($pc_l_car3){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car3_first = array();
                                                $pc_l_car3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクMC</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car3_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car3);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car3_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car3_first = array();
                                                $sp_m_car3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクMC</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car3_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car3);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car3_last);
                                        }
                                    // レディース用
                                        if($sp_l_car3){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car3_first = array();
                                                $sp_l_car3_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car3_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクMC</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car3_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car3_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car3);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car3_last);
                                        }
                            // タンクソロ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car4_first = array();
                                                $pc_m_car4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car4_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクソロ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car4_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car4);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car4_last);
                                        }
                                    // レディース用
                                        if($pc_l_car4){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car4_first = array();
                                                $pc_l_car4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクソロ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car4_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car4);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car4_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car4_first = array();
                                                $sp_m_car4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクソロ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car4_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car4);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car4_last);
                                        }
                                    // レディース用
                                        if($sp_l_car4){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car4_first = array();
                                                $sp_l_car4_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car4_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクソロ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car4_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car4_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car4);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car4_last);
                                        }
                            // タンクアメリカン用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car5_first = array();
                                                $pc_m_car5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car5_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクアメリカン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car5_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car5);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car5_last);
                                        }
                                    // レディース用
                                        if($pc_l_car5){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car5_first = array();
                                                $pc_l_car5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクアメリカン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car5_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car5);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car5_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car5_first = array();
                                                $sp_m_car5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクアメリカン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car5_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car5);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car5_last);
                                        }
                                    // レディース用
                                        if($sp_l_car5){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car5_first = array();
                                                $sp_l_car5_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car5_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>タンクアメリカン</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car5_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car5_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car5);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car5_last);
                                        }
                            // サントス用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car6){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car6_first = array();
                                                $pc_m_car6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car6_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サントス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car6_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car6);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car6_last);
                                        }
                                    // レディース用
                                        if($pc_l_car6){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car6_first = array();
                                                $pc_l_car6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サントス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car6_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car6);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car6_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car6){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car6_first = array();
                                                $sp_m_car6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サントス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car6_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car6);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car6_last);
                                        }
                                    // レディース用
                                        if($sp_l_car6){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car6_first = array();
                                                $sp_l_car6_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car6_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>サントス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car6_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car6_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car6);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car6_last);
                                        }
                            // パンテール用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car7){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car7_first = array();
                                                $pc_m_car7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car7_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パンテール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car7_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car7);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car7_last);
                                        }
                                    // レディース用
                                        if($pc_l_car7){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car7_first = array();
                                                $pc_l_car7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パンテール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car7_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car7);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car7_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car7){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car7_first = array();
                                                $sp_m_car7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パンテール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car7_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car7);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car7_last);
                                        }
                                    // レディース用
                                        if($sp_l_car7){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car7_first = array();
                                                $sp_l_car7_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car7_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パンテール</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car7_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car7_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car7);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car7_last);
                                        }
                            // バロンブルー用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car8){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car8_first = array();
                                                $pc_m_car8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car8_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>バロンブルー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car8_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car8);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car8_last);
                                        }
                                    // レディース用
                                        if($pc_l_car8){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car8_first = array();
                                                $pc_l_car8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>バロンブルー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car8_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car8);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car8_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car8){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car8_first = array();
                                                $sp_m_car8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>バロンブルー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car8_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car8);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car8_last);
                                        }
                                    // レディース用
                                        if($sp_l_car8){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car8_first = array();
                                                $sp_l_car8_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car8_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>バロンブルー</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car8_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car8_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car8);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car8_last);
                                        }
                            // パシャ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car9){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car9_first = array();
                                                $pc_m_car9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car9_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パシャ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car9_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car9);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car9_last);
                                        }
                                    // レディース用
                                        if($pc_l_car9){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car9_first = array();
                                                $pc_l_car9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パシャ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car9_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car9);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car9_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car9){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car9_first = array();
                                                $sp_m_car9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パシャ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car9_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car9);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car9_last);
                                        }
                                    // レディース用
                                        if($sp_l_car9){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car9_first = array();
                                                $sp_l_car9_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car9_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>パシャ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car9_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car9_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car9);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car9_last);
                                        }
                            // ロンドソロ用
                                // PC用
                                    // メンズ用
                                        if($pc_m_car10){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_car10_first = array();
                                                $pc_m_car10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_car10_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ロンドソロ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_car10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car10_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car10);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_car10_last);
                                        }
                                    // レディース用
                                        if($pc_l_car10){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_car10_first = array();
                                                $pc_l_car10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_car10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ロンドソロ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_car10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car10_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car10);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_car10_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_car10){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_car10_first = array();
                                                $sp_m_car10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_car10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ロンドソロ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_car10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car10_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car10);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_car10_last);
                                        }
                                    // レディース用
                                        if($sp_l_car10){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_car10_first = array();
                                                $sp_l_car10_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_car10_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ロンドソロ</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_car10_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car10_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car10);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_car10_last);
                                        }

                            // その他モデル
                                // PC用
                                    // メンズ用
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }

                        } else if(strpos($file_name,'patek') !== false){

                            // アクアノート用
                                // PC用
                                    // メンズ用
                                        if($pc_m_pate1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_pate1_first = array();
                                                $pc_m_pate1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_pate1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアノート</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_pate1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pate1_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pate1);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pate1_last);
                                        }
                                    // レディース用
                                        if($pc_l_pate1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_pate1_first = array();
                                                $pc_l_pate1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_pate1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアノート</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_pate1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pate1_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pate1);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pate1_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_pate1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_pate1_first = array();
                                                $sp_m_pate1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_pate1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアノート</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_pate1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pate1_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pate1);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pate1_last);
                                        }
                                    // レディース用
                                        if($sp_l_pate1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_pate1_first = array();
                                                $sp_l_pate1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_pate1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>アクアノート</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_pate1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pate1_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pate1);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pate1_last);
                                        }
                            // ノーチラス用
                                // PC用
                                    // メンズ用
                                        if($pc_m_pate2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_pate2_first = array();
                                                $pc_m_pate2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_pate2_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ノーチラス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_pate2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pate2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pate2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_pate2_last);
                                        }
                                    // レディース用
                                        if($pc_l_pate2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_pate2_first = array();
                                                $pc_l_pate2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_pate2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ノーチラス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_pate2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pate2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pate2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_pate2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_pate2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_pate2_first = array();
                                                $sp_m_pate2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_pate2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ノーチラス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_pate2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pate2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pate2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_pate2_last);
                                        }
                                    // レディース用
                                        if($sp_l_pate2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_pate2_first = array();
                                                $sp_l_pate2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_pate2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ノーチラス</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_pate2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pate2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pate2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_pate2_last);
                                        }


                            // その他モデル
                                // PC用
                                    // メンズ用
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }

                        } else if(strpos($file_name,'VACHERON') !== false){
                        } else if(strpos($file_name,'AUDEMA') !== false){

                            // ロイヤルオーク用
                                // PC用
                                    // メンズ用
                                        if($pc_m_aud1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_aud1_first = array();
                                                $pc_m_aud1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_aud1_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ロイヤルオーク</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_aud1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_aud1_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_aud1);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_aud1_last);
                                        }
                                    // レディース用
                                        if($pc_l_aud1){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_aud1_first = array();
                                                $pc_l_aud1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_aud1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ロイヤルオーク</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_aud1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_aud1_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_aud1);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_aud1_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_aud1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_aud1_first = array();
                                                $sp_m_aud1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_aud1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ロイヤルオーク</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_aud1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_aud1_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_aud1);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_aud1_last);
                                        }
                                    // レディース用
                                        if($sp_l_aud1){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_aud1_first = array();
                                                $sp_l_aud1_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_aud1_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>ロイヤルオーク</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_aud1_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_aud1_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_aud1);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_aud1_last);
                                        }
                            // CODE 11.59用
                                // PC用
                                    // メンズ用
                                        if($pc_m_aud2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_aud2_first = array();
                                                $pc_m_aud2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_aud2_first,"<div class='". $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>CODE 11.59</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_aud2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_aud2_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_aud2);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_aud2_last);
                                        }
                                    // レディース用
                                        if($pc_l_aud2){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_aud2_first = array();
                                                $pc_l_aud2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_aud2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>CODE 11.59</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_aud2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_aud2_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_aud2);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_aud2_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_aud2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_aud2_first = array();
                                                $sp_m_aud2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_aud2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>CODE 11.59</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_aud2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_aud2_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_aud2);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_aud2_last);
                                        }
                                    // レディース用
                                        if($sp_l_aud2){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_aud2_first = array();
                                                $sp_l_aud2_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_aud2_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>CODE 11.59</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_aud2_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_aud2_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_aud2);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_aud2_last);
                                        }

                            // その他モデル
                                // PC用
                                    // メンズ用
                                        if($pc_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_m_other_first = array();
                                                $pc_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_first);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other);
                                                $pc_all_array = array_merge($pc_all_array, $pc_m_other_last);
                                        }
                                    // レディース用
                                        if($pc_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $pc_l_other_first = array();
                                                $pc_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($pc_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($pc_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全PCソースの配列へ合体させる
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_first);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other);
                                                $pc_all_array_l = array_merge($pc_all_array_l, $pc_l_other_last);
                                        }

                                // SP用
                                    // メンズ用
                                        if($sp_m_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_m_other_first = array();
                                                $sp_m_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_m_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_m_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_first);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other);
                                                $sp_all_array = array_merge($sp_all_array, $sp_m_other_last);
                                        }
                                    // レディース用
                                        if($sp_l_other){ 
                                            // 大枠ソース用配列の定義
                                                $sp_l_other_first = array();
                                                $sp_l_other_last = array();
                                            // 大枠ソースの配列化
                                                array_push($sp_l_other_first,"<div class='" . $class_name1 . "6" . $class_name2 . " " . $class_name1 . "7" . $class_name2 . "'><h3 class='model_f'>その他モデル</h3><div class='" . $class_name1 . "18" . $class_name2 . " " . $class_name1 . "16" . $class_name2 . "'></div></div><div class='" . $class_name1 . "19" . $class_name2 . "'>");
                                                array_push($sp_l_other_last,"</div>");
                                            // モデルのソース用配列と大枠用配列を全SPソースの配列へ合体させる
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_first);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other);
                                                $sp_all_array_l = array_merge($sp_all_array_l, $sp_l_other_last);
                                        }
                    }


                // 背景色を交互に指定
                    // メンズPC
                        $pci = 0;
                        foreach($pc_all_array as $var4){
                            //echo $var4 . "<br>";
                            if($pci % 2 != 0){
                                if(strpos($var4,$class_name1 . "5" . $class_name2) !== false){ 
                                    $var4 = str_replace($class_name1 . "5" . $class_name2,$class_name1 . "4" . $class_name2,$var4);
                                }
                            } else {
                                if(strpos($var4,$class_name1 . "4" . $class_name2) !== false){ 
                                    $var4 = str_replace($class_name1 . "4" . $class_name2,$class_name1 . "5" . $class_name2,$var4);
                                }
                            }

                            $pc_html .= $var4; 
                            $pci++;

                        }

                    // メンズSP
                        $spi = 0;
                        foreach($sp_all_array as $var5){
                            //echo $var5 . "<br>";
                            if($spi % 2 != 0){
                                if(strpos($var5,$class_name1 . "5" . $class_name2) !== false){ 
                                    $var5 = str_replace($class_name1 . "5" . $class_name2,$class_name1 . "4" . $class_name2,$var5);
                                }
                            } else {
                                if(strpos($var5,$class_name1 . "4" . $class_name2) !== false){ 
                                    $var5 = str_replace($class_name1 . "4" . $class_name2,$class_name1 . "5" . $class_name2,$var5);
                                }
                            }
                            
                            $sp_html .= $var5; 
                            $spi++;
                        }

                    // レディースPC
                        $pci_l = 0;
                        foreach($pc_all_array_l as $var6){
                            //echo $var6 . "<br>";
                            if($pci_l % 2 != 0){
                                if(strpos($var6,$class_name1 . "5" . $class_name2) !== false){ 
                                    $var6 = str_replace($class_name1 . "5" . $class_name2,$class_name1 . "4" . $class_name2,$var6);
                                }
                            } else {
                                if(strpos($var6,$class_name1 . "4" . $class_name2) !== false){ 
                                    $var6 = str_replace($class_name1 . "4" . $class_name2,$class_name1 . "5" . $class_name2,$var6);
                                }
                            }

                            $pc_l_html .= $var6; 
                            $pci_l++;

                        }

                    // レディースSP
                        $spi_l = 0;
                        foreach($sp_all_array_l as $var7){
                            //echo $var7 . "<br>";
                            if($spi_l % 2 != 0){
                                if(strpos($var7,$class_name1 . "5" . $class_name2) !== false){ 
                                    $var7 = str_replace($class_name1 . "5" . $class_name2,$class_name1 . "4" . $class_name2,$var7);
                                }
                            } else {
                                if(strpos($var7,$class_name1 . "4" . $class_name2) !== false){ 
                                    $var7 = str_replace($class_name1 . "4" . $class_name2,$class_name1 . "5" . $class_name2,$var7);
                                }
                            }
                            
                            $sp_l_html .= $var7; 
                            $spi_l++;
                        }

                    // レディースモデルが存在する場合にメンズと合体させる
                        if($pc_l_html != ""){
                            $pc_html .= "<span id='l_top' class='ladies_link_r'></span><div class='ladies_title'>レディース</div>" . $pc_l_html;
                        }
                        if($sp_l_html != ""){
                            $sp_html .= "<span id='sp_l_top' class='ladies_link_o'></span><div class='ladies_title'>レディース</div>" . $sp_l_html;
                        }

                    /************************************************************************************************************************************************************************************************************************ */
                    // 全体ソースの作成
                    /************************************************************************************************************************************************************************************************************************ */
                    
                            /*// 20211027
                            $pc_float_link_m = "<div class='pc float_cont'>
                            <div class='pc float_mens'>
                            <a href='#m_top'>メンズ買取表</a></div>";
                            $pc_float_link = "";
                            //echo $pc_l_html;
                            //$pc_html = $pc_m_html;
                            if($pc_l_html != ""){
                                // 20211022
                                $pc_float_link = "<div class='float_ladies'><a href='#l_top'>レディース買取表</a></div></div>";

                            } else {
                                $pc_float_link = "</div>";
                            }
                            $pc_html = $pc_float_link_m . $pc_float_link . $pc_html;





                            //20211214$sp_html = $sp_m_html;
                            //$sp_html = $sp_all_array;
                            $sp_float_link_m = "<div class='sp float_cont'>
                            <div class='sp float_mens'><a href='#sp_m_top'>メンズ買取表</a></div>";
                            $sp_float_link = "";
                            
                            if($sp_l_html != ""){
                                $sp_float_link = "<div class='float_ladies'><a href='#sp_l_top'>レディース買取表</a></div></div>";

                            } else {
                                $sp_float_link = "</div>";
                            }
                            $sp_html = $sp_float_link_m . $sp_float_link . $sp_html;*/
                    //echo $pc_l_html;

                    /************************************************************************************************************************************************************************************************************************ */
                    // HTML作成用メソッドの呼び出し（ブランド毎のヘッダーやフッターを取得）
                    /************************************************************************************************************************************************************************************************************************ */

                            $create_temp_html = $this->create_temp_html($file_name,$class_name1,$class_name2);

                            $complate = $create_temp_html['complate'];
                            $brand_color = $create_temp_html['brand_color'];
                            $brand_color2 = $create_temp_html['brand_color2'];
                            $brand_title = $create_temp_html['brand_title'];
                            $brand_header = $create_temp_html['brand_header'];
                            $brand_footer = $create_temp_html['brand_footer'];
                            $js_area = $create_temp_html['js_area'];
                            $sp_header = $create_temp_html['sp_header'];
                            /*.del .box_other .bgc-yellow .bgc-grey .btn_bulldown_ .model_title box title_view title_left title_right inner_sel2 fl-sel1 fc-red bgc-black icon_o icon_c icon down fc-black*/
                            $style_area = "<style type='text/css'>";
                            $style_area .= "." . $class_name1 . "1" . $class_name2 . "{text-decoration: line-through;}";
                            $style_area .= "." . $class_name1 . "3" . $class_name2 . "{color:red !important;}";
                            $style_area .= "." . $class_name1 . "4" . $class_name2 . "{background:#f0f2fc;}";
                            $style_area .= "." . $class_name1 . "5" . $class_name2 . "{background:#f5f5f5;}";
                            $style_area .= "." . $class_name1 . "20" . $class_name2 . "{color:#000000 !important;}";
                            $style_area .= "." . $class_name1 . "23" . $class_name2 . "{display:none !important;}";
                            //20220114 モデル名にh3を指定したので、新しく追加したCSSを優先させる
                            $style_area .= ".kaitori_cont .model_f{color:#000000 !important;font-size:1.5rem !important;}";
                            $style_area .= "@media screen and (min-width: 561px) {";
                            // 20220114
                        // PC追従タイトルの大枠部分（位置固定用）
                            $style_area .= ".kaitori_cont .sticky{position: -webkit-sticky; /* Safari */ position: sticky; z-index:1; top: 100px;margin-bottom:3px;}";
                        // PC追従タイトルの大枠部分（デザイン用）
                            $style_area .= "." . $class_name1 . "2" . $class_name2 . "{width: 100%;display: flex;align-items: stretch;padding:0 0;}";
                        // PC追従タイトルの各項目部分(追従タイトルのみ)
                            $style_area .= ".sticky p{line-height:1.5em !important; padding:1em !important; background:#4f4f4f !important;}";
                        // PC追従タイトルと各商品情報の各項目部分（共通）
                            $style_area .= "." . $class_name1 . "2" . $class_name2 . " p{word-break: break-all;text-align: justify;padding:0.3em;color:#000000; border-right:solid #ffffff; border-top:solid #ffffff; 1px; flex-fl-sel: 1; flex-basis:20%; font-size:0.8vw;}";
                            // 20220114$style_area .= "." . $class_name1 . "7" . $class_name2 . "{box-sizing:border-box;position:relative; padding:.5em 1em; margin-top:3px; width: calc(100% - 2px); border:1px solid #000000;text-align:left;}";
                        // PCモデル名の大枠
                            $style_area .= "." . $class_name1 . "7" . $class_name2 . "{box-sizing:border-box;position:relative; padding:1.5em 1em; margin-top:3px; width: calc(100% - 4px); border:1px solid #000000;text-align:left;margin:0 auto 1px auto;}";
                            // 20220114$style_area .= "." . $class_name1 . "16" . $class_name2 . ":before{position: absolute;bottom: .3em;right: 0px;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(135deg);border-top: 2px solid #111;border-right: 2px solid #111;}";
                            // 20220114$style_area .= "." . $class_name1 . "17" . $class_name2 . ":before{position: absolute;bottom: .3em;right: 0px;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(-45deg);border-top: 2px solid #111;border-right: 2px solid #111;}";
                            /* 20220203 更新時に一瞬開いた状態が見えるのでCSSで対応 */
                            $style_area .= "." . $class_name1 . "19" . $class_name2 . "{display:none;}";
                        // PCモデル名と同時に表示する矢印
                            $style_area .= "." . $class_name1 . "6" . $class_name2 . "{height:auto !important;}";
                            $style_area .= "." . $class_name1 . "18" . $class_name2 . "{position:absolute; bottom:.4em; right:1em; color:black;}";
                            $style_area .= "." . $class_name1 . "16" . $class_name2 . ":before{position: absolute;bottom: 1.2em;right: 0px;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(135deg);border-top: 2px solid #111;border-right: 2px solid #111;}";
                            $style_area .= "." . $class_name1 . "17" . $class_name2 . ":before{position: absolute;bottom: 1.2em;right: 0px;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(-45deg);border-top: 2px solid #111;border-right: 2px solid #111;}";
                        // PC表示ブランド以外のブランドページへのリンク用
                            $style_area .= ".other_brand_link{padding:0 0;box-sizing:border-box;flex-wrap: wrap;width:100%;display:flex;justify-content:left;}";
                            $style_area .= ".other_brand_link li a{ font-size:13px; text-decoration: underline; font-weight:bold;}";
                            $style_area .= ".other_brand_link a:hover{ opacity:0.6;}";
                            $style_area .= ".other_brand_link li:not(:nth-child(6n)):not(:first-child) {box-sizing:border-box;margin-bottom:1em; width:19%;margin-left:1.25%; border:1px solid #666666; padding:.5em;}";
                            $style_area .= ".other_brand_link li:nth-child(1),.other_brand_link li:nth-child(6n) {box-sizing:border-box;margin-bottom:1em; width:19%; border:1px solid #666666; padding:.5em;}";
                            $style_area .= ".innerlink{position: relative;top: -110px !important;display: block;}";
                            // 20220114
                        // PC「メンズ」「レディース」のタイトル部分
                            $style_area .= ".kaitori_cont .mens_title{width:calc(100% - 2px); margin-bottom:.2em !important; background:#192f60; color:#ffffff;padding:.5em 0;}";
                            $style_area .= ".kaitori_cont .ladies_title{width:calc(100% - 2px); margin:.2em 0 !important;background:#192f60; color:#ffffff;padding:.5em 0;}";
                            $style_area .= "}";
                            $style_area .= "@media screen and (max-width: 560px) {";
                            //20220114$style_area .= "." . $class_name1 . "2" . $class_name2 . "{width: 100%;display: flex;flex-wrap: wrap;align-items: stretch;justify-content: center;}";
                            //20220114$style_area .= "." . $class_name1 . "8" . $class_name2 . "{width: 100%;display: flex;flex-wrap: wrap;align-items: stretch;justify-content: center;}";
                            $style_area .= "." . $class_name1 . "2" . $class_name2 . "{width: 90%;display: flex;flex-wrap: wrap;align-items: stretch;justify-content: center;margin:0 auto;}";
                            $style_area .= "." . $class_name1 . "8" . $class_name2 . "{width: 90%;display: flex;flex-wrap: wrap;align-items: stretch;justify-content: center;margin:0 auto;}";
                            $style_area .= "." . $class_name1 . "9" . $class_name2 . "{text-align:center; display:flex;justify-content:space-between; align-items: center; text-align:center !important;}";
                            $style_area .= "." . $class_name1 . "10" . $class_name2 . "{width:20%; padding:.5em 0 0 .5em;}";
                            $style_area .= "." . $class_name1 . "11" . $class_name2 . "{width:80%;}";
                            $style_area .= "." . $class_name1 . "12" . $class_name2 . "{padding:.5em 1em !important; line-height:1.5em !important; font-size:3.2vw !important;color:#ffffff !important;}";
                            // 20220114
                            //$style_area .= "." . $class_name1 . "4" . $class_name2 . " span{text-decoration:underline;cursor:pointer;}";
                            //$style_area .= "." . $class_name1 . "5" . $class_name2 . " span{text-decoration:underline;cursor:pointer;}";
                            $style_area .= "." . $class_name1 . "13" . $class_name2 . "{flex-basis:45%; margin-top:.5em;}";
                            $style_area .= "." . $class_name1 . "13" . $class_name2 . " p{text-align:center;padding:1em 1em; line-height:2em; font-size:3.8vw;}";
                            $style_area .= "." . $class_name1 . "14" . $class_name2 . "{color:rgb(246,6,5) !important;}";
                            $style_area .= "." . $class_name1 . "15" . $class_name2 . "{background:#4f4f4f; border-right:1px dotted #fff;}";
                            // 20220114$style_area .= "." . $class_name1 . "16" . $class_name2 . ":before{position: absolute;bottom: .5em;right: 0px;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(135deg);border-top: 2px solid #111;border-right: 2px solid #111;}";
                            // 20220114$style_area .= "." . $class_name1 . "17" . $class_name2 . ":before{position: absolute;bottom: .5em;right: 0px;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(-45deg);border-top: 2px solid #111;border-right: 2px solid #111;}";
                        
                            // 20220114$style_area .= "." . $class_name1 . "7" . $class_name2 . "{box-sizing:border-box;position:relative; padding:.5em 1em; margin-top:3px; width: calc(100% - 2px); border:1px solid #000000;text-align:left;}";
                        // SPモデル名の大枠
                            $style_area .= "." . $class_name1 . "7" . $class_name2 . "{box-sizing:border-box;position:relative; padding:1.5em 1em; margin-top:3px; width:90%; border:1px solid #000000;text-align:left;margin:0 auto 1px auto;}";
                        // SPモデル名と同時に表示する矢印
                            $style_area .= "." . $class_name1 . "16" . $class_name2 . ":before{position: absolute;bottom: 1.5em;right: 1em;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(135deg);border-top: 2px solid #111;border-right: 2px solid #111;}";
                            $style_area .= "." . $class_name1 . "17" . $class_name2 . ":before{position: absolute;bottom: 1.5em;right: 1em;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(-45deg);border-top: 2px solid #111;border-right: 2px solid #111;}";
                            $style_area .= "." . $class_name1 . "21" . $class_name2 . "{table-cell;display: flex; align-items: center; text-align:center;-webkit-justify-content: center; justify-content: center;}";
                            $style_area .= "." . $class_name1 . "22" . $class_name2 . "{padding:1em 1em; line-height:2em;}";
                        // SP表示ブランド以外のブランドページへのリンク用
                            $style_area .= ".other_brand_link{width:100%; padding:0 0; margin:0 auto; list-style:none; display:flex; flex-wrap: wrap;}";
                            $style_area .= ".other_brand_link li{width:33%; padding:.5em 0 0 0; line-height:1.5em;}";
                            $style_area .= ".other_brand_link li a{ font-size:3.5vw;}";
                            /* 20220203 更新時に一瞬開いた状態が見えるのでCSSで対応 */
                            $style_area .= "." . $class_name1 . "119" . $class_name2 . "{display:none;}";
                            // 20220114 個別商品用の矢印をモデル用と分離する為、新たに作成
                        // SP個別商品名と同時に表示する矢印
                            $style_area .= "." . $class_name1 . "106" . $class_name2 . "{height:auto !important;}";
                            $style_area .= "." . $class_name1 . "118" . $class_name2 . "{position:absolute; bottom:.4em; right:1em; color:black;}";
                            $style_area .= "." . $class_name1 . "116" . $class_name2 . ":before{position: absolute;bottom: 1.2em;right: 0px;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(135deg);border-top: 2px solid #0068b7;border-right: 2px solid #0068b7;}";
                            $style_area .= "." . $class_name1 . "117" . $class_name2 . ":before{position: absolute;bottom: 1.2em;right: 0px;display: block;width: 10px;height: 10px;margin: auto;content: '';transform: rotate(-45deg);border-top: 2px solid #0068b7;border-right: 2px solid #0068b7;}";
                            // 20220114
                            $style_area .= "." . $class_name1 . "4" . $class_name2 . ",." . $class_name1 . "5" . $class_name2 . "{position: relative;}";
                        // SP「メンズ」「レディース」のタイトル部分
                            $style_area .= ".kaitori_cont .mens_title{width:90%; margin:.2em auto;background:#192f60;padding:1em 0;}";
                            $style_area .= ".kaitori_cont .ladies_title{width:90%; margin:.2em auto;background:#192f60;padding:1em 0;}";
                            // 上部HTMLのポイント説明の大枠部分
                            $style_area .= ".point{width:90% !important; margin:0 auto;}";
                            // 上部HTMLのボタン表示の大枠部分
                            $style_area .= ".btn_area2{width:90% !important; margin:0 auto;}";
                        // SP追従タイトル「モデル / 文字盤色 / 品番」部分（デザイン用）
                            $style_area .= ".sp_title{width:90% !important;background:#4f4f4f !important;}";
                        // SP追従タイトル「モデル / 文字盤色 / 品番」部分（位置固定用）
                            $style_area .= ".kaitori_cont .sticky{position: -webkit-sticky; /* Safari */ position: sticky; z-index:100; top: 98px; /* 位置指定 */}";
                            $style_area .= "}";
                            $style_area .= "@media screen and (min-width:559px) and ( max-width:959px) {";
                            $style_area .= "." . $class_name1 . "2" . $class_name2 . " p{font-size:1.3vw;}";
                            $style_area .= "}";
                            $style_area .= "</style>";
                        
                    
                    // 20210605 上にある日付などの要素と少し重なるので余白を追加 $final_source = '<div class="kaitori_cont">' . $brand_header . '<div class="pc mx-auto wid-100">' . $pc_html . '</div><div class="sp mx-auto wid-100">' . $js_area . $sp_html . '</div>' . $brand_footer . '</div>';
                    $final_source = $style_area . $js_area . '<div class="kaitori_cont">' . $brand_header . '<div class="pc mx-auto wid-100 pt1em">' . $pc_html . '</div><div class="sp mx-auto wid-100">' . $sp_header . $sp_html . '</div>' . $brand_footer . '</div>';
                    
                    
                    //return view('parts.kaitori',['final_source'=>$final_source,'brand_color'=>$brand_color,'brand_color2'=>$brand_color2,'brand_title'=>$brand_title,'complate'=>$complate]);
                    return view($file_pass4,['final_source'=>$final_source,'brand_color'=>$brand_color,'brand_color2'=>$brand_color2,'brand_title'=>$brand_title,'complate'=>$complate]);

        }
    
}
