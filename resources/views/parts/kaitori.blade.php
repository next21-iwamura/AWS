<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>買取表自動作成ツール</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="https://sub-jackroad.ssl-lolipop.jp/RMS/tools/op/js/jquery.typist.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>    
    <script type="text/javascript">
		<!--
				$(function() {
				  var h = $(window).height();
				 
				  $('#wrap').css('display','none');
				  $('#loader-bg ,#loader').height(h).css('display','block');
				});
				 
				$(window).load(function () { //全ての読み込みが完了したら実行
				  $('#loader-bg').delay(900).fadeOut(800);
				  $('#loader').delay(600).fadeOut(300);
				  $('#wrap').css('display', 'block');
				});
				 
				//10秒たったら強制的にロード画面を非表示
				$(function(){
				  setTimeout('stopload()',20000);
				});
				 
				function stopload(){
				  $('#wrap').css('display','block');
				  $('#loader-bg').delay(900).fadeOut(800);
				  $('#loader').delay(600).fadeOut(300);
				}
				// 登録ボタンのマウスオンアウトで色を変える

					function sub_over_col1(){

						var target = document.getElementById('sub1');
						target.style.backgroundColor = "#FF3333";
						/*target.style.color = "#666666";*/
						
					}
					function sub_out_col1(){

						var target = document.getElementById('sub1');
						target.style.backgroundColor = "#000000";
						target.style.color = "#ffffff";
						
					}
					
				// 画像選択ボタンのマウスオンアウトで色を変える
					function over_col(over){
					
						var target = document.getElementById(over);
						target.style.backgroundColor = "#f5f5f5";
						target.style.color = "#666666";
						
					}

					function out_col(over){
					
						var target = document.getElementById(over);
						target.style.backgroundColor = "#666666";
						target.style.color = "#ffffff";
						
					}

				// メッセージ表示の動きをカスタマイズする為のロジック
                    $(function (){

                            var complate = $('#box_text').text();
                            $("#box").animate({left:"30%",top:"30px"}, 200
                                    // 要素を移動させるロジックを差し込む
                                    , function(){ 

                                            $("#box").animate({left:"-30%",top:"30px"}, 200);
                                            $("#box").animate({left:"30%",top:"30px"}, 200);
                                            $("#box").animate({left:"-30%",top:"30px"}, 200);
                                            $("#box").animate({left:"0%",top:"30px"}, 200);
                                            $("#box").animate({left:"-30%",top:"30px"}, 200);
                                            $("#box").animate({left:"0%",top:"30px"}, 200);
                                            $("#box").animate({left:"-30%",top:"30px"}, 100);
                                            $("#box").animate({left:"0%",top:"30px"}, 100);
                                            $("#box").animate({left:"0%",top:"30px"}, 100);
                                            $("#box").animate({left:"0%",top:"30px"}, 100);
                                            $("#box").animate({left:"0%",top:"-30px"}, 100);
                                            $("#box").animate({left:"0%",top:"30px"}, 100);

                                        // 文字表示ロジックの追記
                                            $(function (){
                                                $('#box')
                                                .typist({ speed: 12 })
                                                .typistPause(1000)
                                                .typistAdd(complate)
                                                .typistPause(1000)
                                            });
                                    });
                            });			


                // メニュー開閉  
                    jQuery(document).ready(function(){
                        jQuery('.ui_pulldown').css('display','none');
                        jQuery('.ui_btn_bulldown_').on("click",function(){
                            // メニュー開閉  
                            var t=jQuery(this).next(".ui_pulldown");	
                            jQuery(t).stop().slideToggle();
                            // 矢印の方向変更
                            $(this).toggleClass('ui_icon2');
                        })
                    })

			-->
				
		</script>


<style type ="text/css">
		<!--
        body{width:100%; text-align:left; background-color:#f5f5f5; padding-bottom:500px;}
        .storong{color:red; font-weight:bold;}
        .pt_10{padding-top:10px;}
        .pt_20{padding-top:20px;}
        .mt_50{margin-top:50px;}
        .ml_10{margin-left:10px;}
        .ml_20{margin-left:20px;}
        .display_none{display:none;}
        .comment_font{color:#dc143c;}
        .container{width:1450px; margin-left:auto; margin-right:auto; font-size:17px; color:#666666; font-weight:bold;}
        .main_title{margin:15px 0 50px 0; background-color:#000000; color:#dc143c; font-size:30px; line-height:2.0em; text-align:center;}
        .ui_pulldown{border:2px dotted #666666; margin:10px 0 40px 0; padding:20px;}
        .ui_pulldown ul{font-size:15px; line-height:1.9em;}
        .ui_pulldown .title{background:#666666; color:#ffffff; padding:3px 0;}
        .file_name{margin:5px 0 0 20px;}
        .file_name p{font-size:15px; line-height:1.2em;}
        .view_cont{width:1450px; float:left; text-align:center;}
        .left_cont{width:700px; float:left;}
        .right_cont{width:700px; float:right;}
        .button_area{width:700px; float:left; margin-bottom:50px;}
        .text_area{width:650px; height:800px; background-color:#@if (isset( $brand_color2 )){{ $brand_color2 }}@endif;}
        .preview_area{width:100%; float:left; margin:30px 0 30px 0; text-align:left; border-left:8px #666666 solid; border-bottom:1px #cccccc dotted; padding:0 0 3px 8px;}
        .read_file{width:150px; background:#000000; color:red; padding:3px 0; text-align:center;}
        .read_file:hover{opacity:0.7;}
        #box{
				width:650px; 
				text-align:center; 
				font-weight:bold; 
				line-height:2.0em; 
				position: relative; 
				top:20px; 
				left:20px; 
			}

			#loader-bg {
				display: none;
				position: fixed;
				width: 100%;
				height: 100%;
				top: 0px;
				left: 0px;
				background: #000;
				z-index: 1;
			}
			#loader {
				display: none;
				position: fixed;
				top: 50%;
				left: 50%;
				width: 200px;
				height: 200px;
				margin-top: -100px;
				margin-left: -100px;
				text-align: center;
				color: #fff;
				z-index: 2;
			}

			#page_main_01A{
				margin:0 50%;
			}
			.content_txtBlock_01B{
				margin-left:375px;
			}

			#form{
				width:1227px;
				text-decoration:none;
				margin:0 auto;
				text-align:left;
			}

			fieldset {
				margin-left:20px; 
				margin-bottom:50px;
				padding: 20px 20px;
				border: 5px #666666 double;
				background-color:#ffffff;
				font-weight:bold;
				width:600px;
				z-index:100;
			}


			/* 送信ボタン */
			.sub{
				cursor:pointer; 
				font-weight:bold;
				font-size:17px;
				padding:20px 15px; 
				box-shadow: 10px 10px 10px rgba(0,0,0,0.4); 
				border-radius: 5px; color:#ffffff; 
				background-color:#000000;
				width:650px;
				margin:30px auto;
				text-align:center;
			}
						
			label {
				color: #ffffff;  
				background-color: #666666;
				box-shadow: 4px 4px 4px 4px rgba(0,0,0,0.4);  
				border-radius: 5px;
				font-weight:bold;
				padding:20px 270px;
				cursor:pointer;
				width:650px;
			}
			
			.img_choice{
				width:670px; height:80px; padding-top:20px; /*border:1px solid #ccc;*/ 
				float:left; margin:35px 0 0 15px; vertical-align:bottom;
				text-align:left;
			}
			
			label > input{
				display:none;	/* アップロードボタンのスタイルを無効にする */	
			}

			#fake_text_box{

				width:500px;
				
			}

            .ui_icon2::before {
            content: "▲ ";
            }
            .ui_icon1::after {
                content: "表示 ▼";
            }
            .ui_icon2::after {
                content: "閉じる ▲";
            }            
		-->
</style>		


<link rel="stylesheet" type="text/css" href="https://stg.jackroad.co.jp/css/lp/new_k_teigaku.css">
<link rel="stylesheet" type="text/css" href="https://stg.jackroad.co.jp/css/lp/teigaku_appeal.css">

</head>

<body>
	
    <div id="loader-bg">
      <div id="loader">
        <img src="./img/img-loading.gif" width="200" height="100" alt="Now Loading..." />
        <p>Now Loading...</p>
      </div>
    </div>
    
    <div class="container">
        <div class="main_title">買取ページ用HTMLソース出力ツール</div>
        <div>
                <div class="ui_btn_bulldown_ ui_icon1">操作手順を</div>
                <div class="ui_pulldown">
                    <p class="title">&nbsp;&nbsp;手順</p>
                    <ul>
                        <li> googleドライブの「定額買取リスト」より上書きするブランドの買取表を「CSV」形式にてダウンロード<br>
                        <li> 出力したCSVをローカルに保存</li>
                        <li> 本機能の「CSVを選択」ボタンでローカルのCSVを選択</li>
                        <li> 「ファイルの読み込み」ボタンを押す</li>
                        <li> 「貼り付け用ソースを出力」ボタンを押す</li>
                        <!--<li> 出力したソースをECビーイング内にある各ページへコピペ(「リスト開始」～「リスト終了」の間)-->
                        <li> 出力したソースを全てコピーし、ECビーイング内にある各ページの該当蘭を全て選択して貼り付け
                    </ul>
                    <p class="title">&nbsp;&nbsp;保存場所</p>
                    <p class="ml_20"><span class="storong">Jack </span>ECビーイング　→　CMS　→　フリーページ</p>
                    <p class="title">&nbsp;&nbsp;ECビーイング・各ファイル名</p>
                    <div class="file_name">
                        <p class="ml_10">IWC            →　j_iwc_kaitori.aspx</p>
                        <p class="ml_10">ブライトリング　→　j_breitling_kaitori.aspx</p>
                        <p class="ml_10">オメガ　　　　　→　j_omega_kaitori.aspx</p>
                        <p class="ml_10">パネライ　　　　→　j_panerai_kaitori.aspx</p>
                        <p class="ml_10">ロレックス　　　→　j_rolex_kaitori.aspx</p>
                        <p class="ml_10">セイコー　　　　→　j_seiko_kaitori.aspx</p>
                        <p class="ml_10">タグ・ホイヤー　→　j_tagheure_kaitori.aspx</p>
                        <p class="ml_10">カルティエ　　　→　j_cartier_kaitori.aspx</p>
                        <p class="ml_10">オーデマ・ピゲ  →　j_ap_kaitori</p>
                    </div>

	                <p class="storong pt_20 ml_20">コピペ先のファイルを間違わないよう注意！</p>

                </div>


        <form method="POST" action="/laravel/kaitori" accept-charset="UTF-8" enctype="multipart/form-data">
        <!--<form method="POST" action="/kaitori" accept-charset="UTF-8" enctype="multipart/form-data">-->
        

        {{ csrf_field() }}
             <div class="ml_20">

                <div class="view_cont">
                    <div class="left_cont">
                        
                        <div class="img_choice">
                            <label for="loadFileName" id="L1" onmouseover="over_col('L1')" onmouseout="out_col('L1')">＋ CSVを選択
                                <input type="file" id="loadFileName" name="loadFileName" onchange="$('#fake_text_box').val($(this).val())">
                                
                                <input type="text" value="ファイル選択" onClick="$('#loadFileName').click();">
                            </label>
                            <input type="text" id="fake_text_box" value="" size="25" readonly onClick="$('#loadFileName').click();" class="mt_50">
                            <input type = "submit" name="csvup" class="read_file" value="ファイルの読み込み">
                            @if (isset( $complate ))
                                <div id="box_text" class="display_none">{!! $complate !!}</div>
                                <p id="box" class='comment_font'></p>
								<div class="mt_50"><a href=''>最初に戻る</a></div>
                            @endif
                            @if (isset( $up_comment ))
                                <p class='comment_font'>!!  {!! $up_comment !!}  !!</p>
                            @endif

                        </div>						
                    
                    </div>
                    @if (isset( $up_comment ) || isset( $complate ))
                    <div class="right_cont">
                        <div class="button_area">
                            <input type="submit" value="貼り付け用ソースを出力" name="create" class="sub" id="sub1" onmouseover="sub_over_col1()" onmouseout="sub_out_col1()">
                        </div>
                        <fieldset>
                            <legend class="form_font">&nbsp;コピペ用ソース&nbsp;</legend>
                            <textarea name="tag" id="tag" class="text_area">@if (isset( $final_source )){{ $final_source }}@endif</textarea>
                        </fieldset>
                    </div>	
                    @endif

                </div>
                
            </form>
            
        </div>
    <br sryle="clear:both;">
    @if (isset( $final_source ))

            <div class="preview_area">プレビュー</div>
            <div style="width:1280px; margin:0 auto;">
             {!! $final_source !!}
            @endif
            </div>
            </div>
            </div>
            </div>



    
</body>
</html>
