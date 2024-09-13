<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>変更依頼入力フォーム</title>

    <!--// POSTのときはCSRFトークンを付与。自作のbladeを作るときには忘れないように-->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script src="https://bossanova.uk/jexcel/v4/jexcel.js"></script>
<script src="https://bossanova.uk/jsuites/v2/jsuites.js"></script>

<link rel="stylesheet" href="https://bossanova.uk/jexcel/v4/jexcel.css" />
<link rel="stylesheet" href="https://bossanova.uk/jsuites/v2/jsuites.css" />


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <script type="text/javascript">
$(function(){
  $('.price').on('focus input',function () {
    var num = $(this).val().replace(/\D/g, '');
    $(this).val(num);

  }).on('blur',function () {
    var num = $(this).val().replace(/(\d)(?=(\d\d\d)+$)/g, '$1,');
    $(this).val(num);

  });
});






// エンターキー押下時のsubmitを無効化
$(function(){
        $("input"). keydown(function(e) {
            if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
                return false;
            } else {
                return true;
            }
        });
    });



$(function() {
    $('.input_number_only').on('input', function(e) {
        let value = $(e.currentTarget).val();
        value = value
            .replace(/[０-９]/g, function(s) {
                return String.fromCharCode(s.charCodeAt(0) - 65248);
            })
            .replace(/[^0-9\,]/g, '');
      	$(e.currentTarget).val(value);
          
    });
});

$(function(){
 history.pushState(null, null, null); //ブラウザバック無効化
 //ブラウザバックボタン押下時
 $(window).on("popstate", function (event) {
   history.pushState(null, null, null);
   //ページ内リンクでも表示されてしまうためコメントアウトwindow.alert('ブラウザの戻るボタン禁止');
 });
});

			 // F5禁止用
             window.document.onkeydown = function (e){
				if (e != undefined) {
					if (e.keyCode == 116) {
						e.keyCode = null;
						return false;
					}} else {
						if (event.keyCode == 116) {
							event.keyCode = null;
							return false;
						}
					}
				}

			  	/* 処理中の二度押し禁止 */
                  var set=0;
					function double() {
					if(set==0){ set=1; } else {
					alert("只今処理中です。\nそのままお待ちください。");
					return false; }}



	
                    function delete_alert(e){
$('#comment').css('display', 'block');
    @if (isset($confirm))
    var check = '最終確認項目が表示されています。やり直す場合は「キャンセル」押下後に「編集へ戻る」ボタン、問題なければ「OK」ボタンで依頼を送信してください';
    /*var check = '{{ $confirm }}';*/
    @else
    var check = "OK";
    @endif

   if(!window.confirm(check)){
      window.alert('キャンセルされました');
      return false;
   }
   document.deleteform.submit();
}; 
function delete_alert2(e){
    @if (isset($confirm))
    var check = '本当に依頼を止めますか？問題なければ「OK」ボタンで続行してください';
    /*var check = '{{ $confirm }}';*/
    @else
    var check = "OK";
    @endif

   if(!window.confirm(check)){
      window.alert('キャンセルされました');
      return false;
   }
   document.deleteform.submit();
}; 
jQuery(document).ready(function(){
    jQuery('.down').css('display','none');
	
    jQuery('.btn_bulldown_').on("click",function(){
      // メニュー開閉  
        var t=jQuery(this).next(".down");	
        jQuery(t).stop().slideToggle();
    })
})

</script>
<script>
        // 更新時のローディング
              $(function() {
                var h = $(window).height();
                $('#loader-bg ,#loader').height(h).css('display','block');
              });
              $(window).load(function () { //全ての読み込みが完了したら実行
                $('#loader-bg').delay(900).fadeOut(800);
                $('#loader').delay(600).fadeOut(300);
              });
              //10秒たったら強制的にロード画面を非表示
              $(function(){
                setTimeout('stopload()',20000);
              });
              function stopload(){
                $('#loader-bg').delay(900).fadeOut(800);
                $('#loader').delay(600).fadeOut(300);
              }


    /* ID入力時に全角→半角 */
        function checkForm(elm) {
            // 大文字→小文字
                elm.value = elm.value.toLowerCase();
            // 全角→半角
                elm.value = elm.value.replace(/[Ａ-Ｚａ-ｚ０-９！-～]/g, function(s){
                    return String.fromCharCode(s.charCodeAt(0)-0xFEE0);
                });
        }
        
        /* 上記だと半角変換の二バイト文字自体は入力可能。以下だと英数字と改行以外自動で削除だが、大量のIDをコピペした場合に間違い入力が自動削除されると気づかない可能性がるので上記を採用
        function checkForm($this){
            var str=$this.value;
            while(str.match(/[^A-Z^a-z^\n\d\-]/))
            {
                str=str.replace(/[^A-Z^a-z^\n\d\-]/,"");
            }
            $this.value=str;
        }*/


    </script>



    <style type="text/css">

/* 共通 */
.fc-grey{color:#666666;}
.fs-10{font-size:10px;}
.bgc1{background:#cd5c5c;}
.bgc2{background:#6495ed;}
.class1{color:red;font-weight:bold;}
.class2{color:blue;font-weight:bold;}
.class3{color:brown;font-weight:bold;}
/* 共通 */
.double{background:red !important;}

/* 大枠 */
    body{font-size:.7vw; line-height:1.5em; background:#f5f5f5;padding:0 0;}
    .container{width:100%; margin-bottom:300px;padding:0 0;}
    .cont{/*max-width:1500px;*/ margin:0 auto;display:flex;justify-content:space-around;}
/* 左右大枠 */
    .left_cont{height:auto;width:22%;/*max-width:300px;*//*background:red;*/margin-top:-1em;}
    .right_cont{height:auto;width:75%; /*max-width:1180px;*//*background:blue;*/}
/* ヘッダータイトル */
    .header_title{font-weight:bold;font-size:1.5rem;background:#000000;background-image: -webkit-linear-gradient(transparent 0%,rgba(255,255,255,.3) 50%,transparent 50%,rgba(0,0,0,.1) 100%);margin-bottom:1em;position:relative;top:0px; width:100%; color:#ffffff; line-height:2em; text-align:center;}
    
/* ID入力 */
    .input_id{padding:2%; /*position: fixed;top: 80px;*/ width: 46%;max-width:150px; height:35vh;margin-top:1em; /*margin-left:165px;*/}
    .id_final{width:100%;max-width:150px; height:25vh; background:#f5f5f5; border:none;}
    .id{width:100%;max-width:150px; height:30vh;position: relative;margin: 0px auto 0 auto; padding:0 0;}
    .id2{width:100%;max-width:150px; height:30vh;}
    
/* ステータス表示 */
    .status_title{background:#000000;background-image: -webkit-linear-gradient(transparent 0%,rgba(255,255,255,.3) 50%,transparent 50%,rgba(0,0,0,.1) 100%);position:relative;top:0px; width:100%;max-width:150px; color:#ffffff; line-height:2em; text-align:center;}
    .status_cont{box-sizing: border-box;text-align:center; line-height:1em; /*position: fixed;top: 120px;*/ width: 100%;max-width:150px; height:auto; border:1px dotted #666666; padding:1.5%; background:#ffffff;}

/* 担当 */
.tantou_final{width:100px; background:#f5f5f5; border:none;}

.tantou {
position: relative;
	width: 100%;
	margin: 00px auto 0 auto;
    padding:0 0;
}
.tantou input[type='text'] {
	font: 12px/20px sans-serif;
	box-sizing: border-box;
	width: 100%;
	letter-spacing: 1px;
	text-align:center;
}
.tantou input[type='text']:focus {
	outline: none;
}




/* 各リスト */
    .title{padding:0 0; margin:0 auto 15px auto;display:flex;justify-content:space-around; background:#000000; color:#ffffff; align-items: center;background:#000000;background-image: -webkit-linear-gradient(transparent 0%,rgba(255,255,255,.3) 50%,transparent 50%,rgba(0,0,0,.1) 100%);position:relative;top:0px; width:100%;color:#ffffff;}
    .default{background:#ffffff; width:100%; padding:0 0; margin:15px auto 0 auto;display:flex;justify-content:space-around; border-top:1px solid #000000; /*padding-top:3px;*/ align-items: center;}
    .change{background:#ffe4b5; width:100%; padding:0 0; margin:0 auto 15px auto;display:flex;justify-content:space-around; border-bottom:1px solid #000000; border-top:1px dotted #ccc; /*padding-bottom:3px;*/ align-items: center;}
    .right_cont .list_area li{display:block; width:11%; text-align:center; border-right:1px dotted #ccc; padding:3px 0; height:100%; list-style:none;}
    .right_cont .list_area li:nth-child(9),.right_cont .list_area li:nth-child(10),.right_cont .list_area li:last-child{width:4%; text-align:center; font-size:8px;}
    .right_cont .list_area li:first-child{font-size:11px; width:11%;background:#000000; color:#ffffff;height:100%;background:#000000;background-image: -webkit-linear-gradient(transparent 0%,rgba(255,255,255,.3) 50%,transparent 50%,rgba(0,0,0,.1) 100%);}
    .change > .right_cont .list_area li:nth-child(3),.default > .right_cont .list_area li:nth-child(3),.change > .right_cont .list_area li:nth-child(4),.default > .right_cont .list_area li:nth-child(4){font-size:8px;}

/* FORM */
.stuff_select{width:100%;}

/* 入力内容チェック時のエラー(左) */
.input_check{padding:0px 0; position: relative;top:1em; width:100%; height:auto; background:#f5f5f5}
.input_check_error{box-sizing: border-box;color:red; text-align:center; padding:10px 10px; position: relative; top:1em;width:100%;height:auto; color:red; background:#ffffff;margin-top:2em;}
.btn{width:96%; text-align:center;}
/* 最終確認時のコメント(左) */
.confirm_cont{box-sizing: border-box;padding:0px 0; position: relative;width:100%; height:auto;}
.confirm_text{text-align:center; line-height:1.5em; background:#ffffff; color:red; padding:10px 10px;}
.at{width:95%; font-weight:bold; padding:2px 0; margin:0 auto; color:#ffffff;}
/* 入力内容チェック時のエラー、最終確認時のコメント共通(右) */
.input_error_title{width:75%; /*max-width:1120px;*/position:fixed;bottom:190px; margin:0 0;}
.input_error_title2{background:#000000;background-image: -webkit-linear-gradient(transparent 0%,rgba(255,255,255,.3) 50%,transparent 50%,rgba(0,0,0,.1) 100%);position:relative;top:0px; width:100%; color:#ffffff;line-height:2em;padding:0 0; font-size:1.2rem;text-align:center; font-weight:bold; margin:0 0;}
.input_error{box-sizing: border-box;width:75%; /*max-width:1100px;*/ position:fixed;bottom:0;  padding:10px; margin:0 auto 0px auto; height:190px; overflow:scroll;}
/* 送信依頼ボタン周り */
.order_cont{position: relative;top:0;width:100%; height:auto; background:#f5f5f5;}



/* チェックに問題ない場合のコメント */
.check_ok{text-align:center; font-weight:bold; color:red; font-size:1vw;}



    .select1,.price,.price_sale,.maker_price{width:90%; /*height:2em;*/ background:#f5f5f5; color:#cd5c5c; font-weight:bold; text-align:center; font-size:12px; font-weight:normal;}
    .error p:not(:last-child){color:red;}
    .sticky {
    position: -webkit-sticky; /* Safari */
    position: sticky;
    z-index:10;
    top: 0; /* 位置指定 */
    }
.fc-red{color:red;}

@keyframes blink{
    0% {opacity:0;}
    100% {opacity:1;}
}

.blinking{
    animation:blink 1.2s ease-in-out infinite alternate;
}

.blinking2{
    animation:blink 0.5s ease-in-out infinite alternate;
}


textarea {
	font: 12px/20px sans-serif;
	box-sizing: border-box;
	width: 100%;
	letter-spacing: 1px;
	text-align:center;
}

.ef {
	position: relative;
	padding: 2px 0px;
	border: 0;
	border: 1px solid #1b2538;
	background: transparent;
}
.ef ~ .focus_bg:before,
.ef ~ .focus_bg:after {
	position: absolute;
	z-index: -1;
	top: 0;
	left: 0;
	width: 0;
	height: 0;
	content: '';
	transition: 0.3s;
	background-color: rgba(218,60,65,.3);
}
.ef:focus {
	border: 1px solid #da3c41;
}

.ef:focus ~ .focus_bg:before,
.tantou.ef ~ .focus_bg:before {
	width: 50%;
	height: 100%;
	transition: 0.3s;
}
.ef ~ .focus_bg:after {
	top: auto;
	right: 0;
	bottom: 0;
	left: auto;
}
.ef:focus ~ .focus_bg:after,
.tantou.ef ~ .focus_bg:after {
	width: 50%;
	height: 100%;
	transition: 0.3s;
}
@media screen and (min-width: 1200px) {
    .ef ~ label {
        position: absolute;
        z-index: -1;
        top: 5px;
        left: -35%;
        width: 100%;
        transition: 0.3s;
        letter-spacing: 0.5px;
        color: #aaaaaa;
    }
}
.ef:focus ~ label,
.tantou.ef ~ label {
	font-size: 12px;
	top: -18px;
	left: 0;
	transition: 0.3s;
	color: #da3c41;
}
.cancel{display:block;}
.cancel_com{width:100%; text-align:center;padding-bottom:.5em;}

            /* 更新時のローディング用 */
            #loader-bg {
                display: none;
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0px;
                left: 0px;
                background: #000;
                z-index: 1000;
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
            /* ボタン */
    .btn_reset {
	background: none;
	border: none;
	outline: none;
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
}




    *,
*:before,
*:after {
  -webkit-box-sizing: inherit;
  box-sizing: inherit;
}

html {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  font-size: 85%;
}

.btn,
a.btn,
button.btn {
  font-size: .6vw;
  font-weight: 700;
  line-height: 1.5;
  position: relative;
  display: inline-block;
  padding: .5em 1rem;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-transition: all 0.3s;
  transition: all 0.3s;
  text-align: center;
  vertical-align: middle;
  text-decoration: none;
  letter-spacing: 0.1em;
  color: #212529;
  border-radius: 0.5rem;
  width:100%;
  text-align:center;
  margin-top:.5em;
  color:#4169e1;
}

.btn-flat {
  overflow: hidden;
  margin-top:0em;

  padding: 1.5rem 6rem;

  color: #fff !important;
  border-radius: 0;
  background: #000;
}

.btn-flat span {
  position: relative;
}

.btn-flat:before {
  position: absolute;
  top: 0;
  left: 0;

  width: 100px;
  height: 100px;

  content: '';
  -webkit-transition: all .5s ease-in-out;
  transition: all .5s ease-in-out;
  -webkit-transform: translateX(-50%) translateY(-31px) rotate(45deg);
  transform: translateX(-50%) translateY(-31px) rotate(45deg);

  border-radius: 35%;
  background: #eb6100;
}

.btn-flat:hover:before {
  width: 1400px;
  height: 1400px;

  -webkit-transform: translateX(-10%) translateY(-600px);

  transform: translateX(-10%) translateY(-600px);
}
h3{background:#000000; color:#ffffff; width:5em;text-align:center;padding:.2em 0;}
.btn_bulldown_:hover{opacity:0.6;cursor:pointer;}
.btn:hover{background:#666666;color:#ffffff;}
    </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/ja.js"></script>

</head>
    <body>
    <!-- 全体の大枠 start -->
        <div class="container">
        <div id="loader-bg">
        <div id="loader">
            <img src="./img/img-loading.gif" width="200" height="100" alt="Now Loading..." />
            <p>Now Loading...</p>
        </div>
        </div>
        <div class="header_title">変更依頼入力フォーム</div>


        @if (isset($op_requests)){{ $op_requests }} @endif
        <!-- FORM start -->
            <!--<form action="/laravel/operation" method="POST">-->
            <form action="/operation" method="POST" enctype="multipart/form-data">
                <!--{{ csrf_field() }}-->
                @csrf
            <!-- 左右大枠 start -->
                <div class="cont">
                <!-- 左サイド大枠 start -->
                    <div class="left_cont">
<div style="width:22%;position: fixed;height:100%;margin:0 0; padding:0 0;box-sizing: border-box;padding-right:1em; /*background:green;*/text-align:center; border-right:1px dotted #ccc;">
                   
                    <!-- 担当者入力エリア start -->

                                    <div class="tantou">
                                        <input class="ef" type="hidden" placeholder="" name='stuff' value='@if (isset($stuff)){{ $stuff }} @endif'>
                                        <!--<p style="text-align:left;">担当者選択：</p>
                                        <select name="stuff" class="stuff_select">
                                            @if (empty($db_ok))<option value="">担当者選択</option> @endif
                                            @if (isset($stuff_select)){!!$stuff_select!!} @endif
                                        </select>-->
                                        <p style="width:80%; margin:0 auto; text-align:left;">担当者<span class='red'>（必須）</span></p>

                                        @if ((isset( $db_ok ) && $db_ok == "ON" && empty( $confirm ) && $confirm == "") || isset( $db_ok ) && $db_ok == "ON" && isset( $confirm ) && $confirm != "")
                                            <!-- 最終確認がある場合(選択出来ないようにする) -->
                                            <select id="" name="stuff" style="width:80%;" class="">@if (isset($stuff_name)) <option value="{!!$stuff!!}">{!!$stuff_name!!} @endif</option></select>
                                        @else
                                            <!-- 最終確認が無い場合（サジェスト機能にて選択） -->
                                            <select id="mySelect2" name="stuff" style="width:80%;" class="select2"></select>
                                        @endif

                                    </div>

  <script>
      // 別ページの非同期通信にてサーバー取得した情報(社員名)を表示するためのロジック(IEだと「map型」「arrow関数」が使用できないため代替記述へ修正)
        $(document).ready(function() {
            $(".select2").select2({
                ajax: {
                    url: "/ajax/user",
                    //url: "/laravel/ajax/user",
                    dataType: 'json',
                    //data: (params) => {
                    data: function(params){
                        return {
                        q: params.term,
                        }
                    },
                    //processResults: (data, params) => {
                    processResults: function(data, params){
                        //const results = data.map(stuff_name => {
                        const results = [];
                        data.forEach(function(stuff_name){
                            results.push({
                            //return {
                                //20240906id: stuff_name.sid,
                                //id: stuff_name.id,
                                //20240913 DBのカラム名間違いが原因だったので元に戻すid: stuff_name.id,
                                id: stuff_name.sid,
                                text: stuff_name.full_name,
                            //};
                            });
                        });
                        return {
                        results: results,
                        }
                    },
                },
            });
            language: 'ja' // 日本語化

            @if (isset($stuff_name))
            alert($stuff_name);
                    $("#mySelect2").val("テストテスト").trigger("change");
                    // 選択した項目を表示させるための記述（select2初期値設定記述が通用しない為、開発者ツールで表示部分のID名を拾って該当部分のテキストを動的に変更する事で対応）
                    $("#select2-mySelect2-container").text("{!!$stuff_name!!}");
            @endif

        });
    </script>
                        
<div style="width:100%;margin:1em 0 0 0;display:flex;justify-content:center;height:auto;/*background:red;*/">

                    <!-- 現在のステータス表示エリア start -->
                    <div style="width:50%;/*background:pink;*/">
                            <div class="status_title">ステップ</div>
                            <div id="sutatus" class="status_cont">
                                @if (empty( $check_ng ) && empty( $db_ok ) && empty( $confirm ) && empty($pid))
                                <p class="fc-red">商品IDを入力</p>
                                <p class="blinking2">▼</p>
                                @else
                                <p>商品IDを入力</p>
                                <p>▼</p>
                                @endif            
                                @if (isset($pid))
                                <p class="fc-red">依頼内容を確認</p>
                                <p class="blinking2">▼</p>
                                @else
                                <p>依頼内容を確認</p>
                                <p>▼</p>
                                @endif            
                                @if (isset( $check_ng ) && $check_ng == "ON")
                                <p class="fc-red">エラーを確認</p>
                                <p class="blinking2">▼</p>
                                @else
                                <p>エラーを確認</p>
                                <p>▼</p>
                                @endif
                                @if (isset( $db_ok ) && $db_ok == "ON" && isset( $confirm ) && $confirm != "")
                                <p class="fc-red">最終確認</p>
                                <p class="blinking2">▼</p>
                                @else
                                <p>最終確認</p>
                                @endif
                                @if (isset( $db_ok ) && $db_ok == "ON" && empty( $confirm ) && $confirm == "")
                                <p class="blinking2">▼</p>
                                <p class="fc-red">依頼を送信</p>
                                @else
                                @if (isset( $db_ok ) && $db_ok == "ON" && isset( $confirm ) && $confirm != "")
                                @else
                                <p>▼</p>
                                @endif
                                <p>依頼を送信</p>
                                @endif
                            </div>
                        </div>
                    <!-- 現在のステータス表示エリア end -->

                    <!-- IDの入力エリア start -->
                        <div class="input_id">
                                @if (isset( $db_ok ) && $db_ok == "ON")
                                    ▼ ID<textarea class="id_final" name="pid" id="pid" readonly>@if (isset($pid)){{ $pid }} @elseif (isset($pid2)){{ $pid2 }} @endif</textarea>
                                @else
                                <div class="id">
                                    <textarea class="ef id2" name="pid" id="pid" onInput="checkForm(this)">@if (isset($pid)){{ $pid }} @elseif (isset($pid2)){{ $pid2 }} @endif</textarea>
                                    <label>ID</label>
                                    <span class="focus_bg"></span>
                                </div>

                                    <input class="btn" type="submit" id="idcheck" name="idcheck" value="商品IDを送信する">
                                @endif
                        </div>
                    <!-- IDの入力エリア end -->
</div>
                    <!-- 各ボタンの表示エリア start -->


                            <!-- 「入力内容チェックボタン」押下時にエラーがある場合に表示 -->
                            @if (isset( $check_ng ) && $check_ng == "ON")
                                    @if (isset($check_comment))
                                        <div id="comment" class="input_check_error">
                                            <p class="blinking at bgc1">右下に入力した依頼内容のエラーが表示されています</p>
                                            <p class="fc-grey">内容を確認の上で修正してください。</p>
                                        </div>
                                    @endif
                                @endif

                            <!-- 「最終確認」がある場合の表示 -->
                                @if (isset( $db_ok ) && $db_ok == "ON")
                                    @if (isset( $confirm ) && $confirm != "")
                                        <div class="confirm_cont">
                                            <p class="check_ok">！入力内容チェックOK！</p>
                                            <div class="confirm_text">
                                                <p class="blinking at bgc2">右に最終確認が表示されています</p>
                                                <p class="fc-grey fs-10">内容に問題があれば「編集画面へ戻る」ボタンで修正</p>
                                                <p class="fc-grey fs-10">内容に問題なければ「依頼送信」ボタンで依頼を完了</p>
                                            </div>
                                            <p><input class="btn" type="submit" name="return" id="return" value="編集画面へ戻る"></p>
                                        </div>
                                    @endif
                                @endif




                            <!-- 「入力内容チェックボタン」の表示 -->
                                @if (isset($check_ok) && $check_ok == "ON" && empty( $db_ok ))
                                    <div id="comment" class="input_check">
                                        <p><input class="btn" type="submit" name="info_check" value="入力内容をチェックする"></p>
                                        <!--<p><button class="btn btn-flat btn_reset" type="submit" name="info_check" value="入力内容チェック"><span>入力内容チェック</span></button></p>-->

                                    </div>
                                @endif



                            <!-- 「依頼送信ボタン」の表示（入力内容チェックボタン押下時にエラーが無かった場合に表示） -->
                                <!-- 20220626 送信されたIDが全て存在しない場合には表示しない -->
                                    @if (isset( $noid_flag ) && $noid_flag == "ON")
                                        @if (isset( $db_ok ) && $db_ok == "ON")
                                                @if (isset( $confirm ) && $confirm != "")
                                                    <!-- 最終確認がある場合（ポップアップで本当に登録するかの確認をする為） -->
                                                        <div id="comment" class="order_cont">
                                                            <!-- <p><input class="btn" type="submit" name="db_insert" value="依頼送信" onClick="delete_alert(event);return false;"></p> -->
                                                            <p style="padding:0 0; margin:0 0;";><button class="btn btn-flat btn_reset" type="submit" name="db_insert" value="依頼をNCへ送信する" onClick="delete_alert(event);return false;"><span>依頼をNCへ送信する</span></button></p>
                                                        </div>
                                                @else
                                                    <!-- 最終確認が無い場合 -->
                                                        <div id="comment" class="order_cont">
                                                            <p class="check_ok">！！入力内容チェックOK！！</p>
                                                            <p style="text-align:center;">下のボタンにて変更依頼を送信してください<br>※チェック終了後の登録内容変更はできません</p>

                                                            <!-- <p><input class="btn" type="submit" name="db_insert" value="依頼送信"></p> -->
                                                            <p style="padding:0 0; margin:0 0;";><button class="btn btn-flat btn_reset" type="submit" name="db_insert" value="依頼をNCへ送信する"><span>依頼をNCへ送信する</span></button></p>
                                                            <p style="margin-top:1em;" onClick="delete_alert2(event);return false;"><a href="">依頼を止めて元のページへ戻る</a></p>
                                                        </div>
                                                @endif
                                        @endif

                                    @else 
                                        @if (isset( $db_ok ) && $db_ok == "ON")   
                                                        <div id="comment" class="order_cont">
                                                            <p class="check_ok">！！送信されたIDが全て存在しません！！</p>
                                                            <p style="margin-top:1em;"><a href="">元のページへ戻る</a></p>
                                                        </div>
                                        @endif
                                    
                                    @endif
                                
                    <!-- 各ボタンの表示エリア end -->
                    </div>
</div>
                <!-- 左サイド大枠 end -->
                <!-- 右サイド大枠 start -->
                    <div class="right_cont" id='head'>

                        <!-- 使用方法エリア -->
                            <div style="position:relative; width:100%;">
                                <div>
                                    <div class="btn_bulldown_"><h3>使用方法</h3>
                                    </div>
                                    <div class="down">
                                    <p style="color:red; font-weight:bold;">・本ツールは1ブラウザに1つのみ使用してください<span style ="color:#000000;">（ セキュリティーの関係上、同ブラウザの別タブで本ツールや履歴ツールを併用するとセッションエラーが発生し、やり直しとなる為 ）</span></p>
                                    <p style="color:red; font-weight:bold;">・変更依頼終了後はツールを閉じてください<span style ="color:#000000;">（ セキュリティーの関係上、ツールを長時間開いたままにするとセッションエラーが発生し、やり直しとなる為 ）</span></p>
                                    <p style="font-weight:bold;border-bottom:1px dotted #666666;border-left:5px solid #666666;padding-left:.5em;margin: top 2px;em;">作業の流れ</p>
                                    <ol>
                                    <li> 担当者選択（姓名の一部入力で選択肢を絞る事も可能）</li>
                                    <li> 商品IDを改行区切りで入力</li>
                                    <li>「商品IDを送信する」ボタン押下</li>
                                    <li> 表示された各商品ID毎の下段を変更したい内容に変更（上段は現在の内容）</li>
                                    <li> 「入力内容をチェックする」ボタン押下</li>
                                    <ul>
                                        <li style="list-style-type:none;">→ エラーの場合はメッセージを参照し正しい依頼内容に修正後、再度「入力内容をチェックする」ボタン押下</li>
                                        <li style="list-style-type:none;">→ 価格に問題が無いかなどの確認メッセージが表示された場合、問題があれば「編集画面へ戻る」ボタンでやり直し(エラーとは違い問題なければそのまま依頼可能)</li>
                                    </ul>
                                    <li> 依頼内容に問題が無い場合は「依頼をNCへ送信する」ボタンが表示されるので押下</li>
                                    </ol>
                                    <p style="font-weight:bold;border-bottom:1px dotted #666666;border-left:5px solid #666666;padding-left:.5em;margin-top:2em;">特殊項目について</p>
                                    <p style="text-indent:1em;">キャンセル：「商品IDを送信する」ボタン押下後に依頼をストップしたい項目が発生した場合は、該当箇所をチェックする事でNCへの依頼項目から除外される</p>
                                    <p style="text-indent:1em;">セール外し：セールから外したい場合に該当箇所をチェック。セール価格を「0」や「空」にしてもダメ</p>
                                    <p style="text-indent:1em;">プライスDに入れない：価格を安くした際に「プライスダウン」へ入れたく無い場合は該当箇所をチェック</p>
                                    <p style="font-weight:bold;border-bottom:1px dotted #666666;border-left:5px solid #666666;padding-left:.5em;margin-top:2em;">特記事項</p>
                                    <p style="text-indent:1em;">・チェック通過後の内容変更は不可（キャンセルのみ例外）</p>
                                    <p style="text-indent:1em;">・商品IDの前の記号は、N：新品・U：中古・A：アンティーク</p>
                                    <p style="text-indent:1em;">・ECBに存在しないIDが含まれる場合は自動で削除</p>
                                    <p style="text-indent:1em;">・一度に作業できる上限は120件まで（数が多いとECB側にアクセス拒否されてしまうため）</p>
                                    <p style="text-indent:1em;">・NC作業時に同じIDへの違う依頼が複数あった場合は最新の依頼が反映される（例：「SOLDOUT」依頼をした直後に別のスタッフが「商談中」依頼をした場合は「商談中」で登録される）</p>
                                    <p style="text-indent:1em;">・重複するIDを同時に依頼した場合は背景が赤で表示される（価格と状態変更など、違う内容でも一行で依頼できるので、必要なければ一つのみ残し他はキャンセルする）</p>
                                    <p style="text-indent:1em;">・↓依頼後の作業進捗状況の確認用URL<span style ="color:red;">（ ※必ず本ツールとは別のブラウザにブックマークなどして使用 ）</span></p>
                                    <p style="text-indent:2em;">https://lomo-jackroad.ssl-lolipop.jp/laravel/operation_status</p>
                                    </div>
                                </div>
                            </div>

                        <!-- 依頼一覧のタイトルエリア -->
                            @if ((isset( $db_ok ) && $db_ok == "ON") || (isset($check_ok) && $check_ok == "ON"))
                                <ul class='sticky title list_area'><li class='parts'>担当：@if (isset( $stuff_name )){!!$stuff_name!!}@endif</li><li class='parts'>商品ID</li><li class='parts'>ブランド名</li><li class='parts'>モデル名</li><li class='parts'>ステータス</li><li class='parts'>通常価格</li><li class='parts'>セール価格</li><li class='parts'>定価</li><li class='parts'>セール外し</li><li class='parts'>プライスDに入れない</li><li class='parts'>キャンセル</li></ul>
                            @else
                                <div class='title'></div>
                            @endif

                        <!-- 「入力内容エラー」がある場合の表示 -->
                            @if (isset( $check_ng ) && $check_ng == "ON")
                                <div class="input_error_title"><p class="input_error_title2">▼ エラーあり！内容を確認し、修正してください ▼</p></div>
                                <div id="comment" class="input_error bgc1">
                                    @if (isset($check_comment)){!!$check_comment!!} @endif
                                </div>
                            @endif
                        <!-- 「最終確認」がある場合の表示 -->
                            @if (isset( $db_ok ) && $db_ok == "ON")
                                @if (isset( $confirm ) && $confirm != "")
                                    <div class="comment2 input_error_title"><p class="input_error_title2">▼ 依頼内容の最終確認 ▼</p></div>
                                    <div id="comment" class="input_error bgc2">
                                        {!!$confirm!!} 
                                    </div>
                                @endif
                            @endif
                            <div class="list_area">
                                <!-- IDなしの項目を削除済表示 -->
                                    @if (isset( $noid_com ))
                                            {!!$noid_com!!}
                                    @endif
                                <!-- 依頼商品一覧の表示 -->
                                    @if (isset( $db_ok ) && $db_ok == "ON")
                                        @if (isset( $rec2 ))
                                            {!!$rec2!!}
                                        @endif
                                    @else
                                        @if (isset( $rec ))
                                            {!!$rec!!}
                                        @endif
                                    @endif
                            </div>


                    </div>
                <!-- 右サイド大枠 end -->
                </div>
            <!-- 左右大枠 end -->
            </form>
        <!-- FORM end -->
        </div>
    <!-- 全体の大枠 end -->

    </body>
</html>