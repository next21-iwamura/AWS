<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>売上分析ツール</title>

    <!--// POSTのときはCSRFトークンを付与。自作のbladeを作るときには忘れないように-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
                    $(document).ready(function(){
                        @if(isset($view_select))
                            @if($view_select == "view1")
                                $(".chart1").fadeIn();
                                $(".op2a").fadeIn();
                                $(".chart2").hide();
                                $(".chart3").hide();
                                $(".op1a").fadeIn();
                                $(".op2a").addClass("opena");
                                $(".brand_btn1").css({'background':'#000000','color' :'#ffffff'});
                                $(".brand_btn3").css({'background':'#ffffff','color' :'#000000'});
                                $(".brand_btn2").css({'background':'#ffffff','color' :'#000000'});
                            @elseif($view_select == "view2")
                                $(".chart1").hide();
                                $(".chart2").fadeIn();
                                $(".op2b").fadeIn();
                                $(".chart3").hide();
                                $(".op1b").fadeIn();
                                $(".op2b").addClass("openb");
                                $(".brand_btn2").css({'background':'#000000','color' :'#ffffff'});
                                $(".brand_btn1").css({'background':'#ffffff','color' :'#000000'});
                                $(".brand_btn3").css({'background':'#ffffff','color' :'#000000'});
                            @elseif($view_select == "view3")
                                $(".chart1").hide();
                                $(".chart2").hide();
                                $(".chart3").fadeIn();
                                $(".op1c").fadeIn();
                                $(".op2c").addClass("openc");
                                $(".brand_btn3").css({'background':'#000000','color' :'#ffffff'});
                                $(".brand_btn1").css({'background':'#ffffff','color' :'#000000'});
                                $(".brand_btn2").css({'background':'#ffffff','color' :'#000000'});

                            @endif
                        @endif
                    });
                </script>



<script type="text/javascript">
                                    $(".brand_btn1").on("click", function (e) {
                                        $('.brand_bumon_select').val('jack');
                                    });
                                    $(".brand_btn2").on("click", function (e) {
                                        $('.brand_bumon_select').val('betty');
                                    });
                                    $(".brand_btn3").on("click", function (e) {
                                        $('.brand_bumon_select').val('jewelry');
                                    });
                                </script>


            <!-- 各部門表示ボタン押下時にボタンの部門のみ表示させるためのロジック -->
            <script>
                    /* デフォルト時（全非表示） */
                        $(".op1a").hide();
                        $(".op1b").hide();
                        $(".op1c").hide();
                        $(".chart1").hide();
                        $(".chart2").hide();
                        $(".chart3").hide();
                    /* ジャック表示ボタン押下時 */
                        $(".brand_btn1").on("click", function (e) {
                            $(".brand_btn1").css({'background':'#000000','color' :'#ffffff'});
                            $(".brand_btn2").css({'background':'#ffffff','color' :'#000000'});
                            $(".brand_btn3").css({'background':'#ffffff','color' :'#000000'});
                            $(".op1b").hide();
                            $(".op1c").hide();
                        $(".op1a", ".op2a").slideToggle(200);
                        if ($(".op2a").hasClass("opena")) {
                            $(".op2a").removeClass("opena");
                            $(".op2b").removeClass("openb");
                            $(".op2c").removeClass("openc");
                            $(".chart1").fadeOut();
                            $(".chart2").fadeOut();
                            $(".chart3").fadeOut();
                        } else {
                            $(".op2a").addClass("opena");
                            $(".op2b").removeClass("openb");
                            $(".op2c").removeClass("openc");
                            $(".chart2").fadeOut();
                            $(".chart3").fadeOut();
                            $(".chart1").fadeIn();
                        }  
                        });
                    /* ベティー表示ボタン押下時 */
                        $(".brand_btn2").on("click", function (e) {
                            $(".brand_btn2").css({'background':'#000000','color' :'#ffffff'});
                            $(".brand_btn1").css({'background':'#ffffff','color' :'#000000'});
                            $(".brand_btn3").css({'background':'#ffffff','color' :'#000000'});
                            $(".op1a").hide();
                            $(".op1c").hide();
                        $(".op1b", ".op2b").slideToggle(200);
                        if ($(".op2b").hasClass("openb")) {
                            $(".op2b").removeClass("openb");
                            $(".op2a").removeClass("opena");
                            $(".op2c").removeClass("openc");
                            $(".chart1").fadeOut();
                            $(".chart2").fadeOut();
                            $(".chart3").fadeOut();
                        } else {
                            $(".op2b").addClass("openb");
                            $(".op2a").removeClass("opena");
                            $(".op2c").removeClass("openc");
                            $(".chart1").fadeOut();
                            $(".chart3").fadeOut();
                            $(".chart2").fadeIn();
                        }  
                        });
                    /* ジュエリー表示ボタン押下時 */
                        $(".brand_btn3").on("click", function (e) {
                            $(".brand_btn3").css({'background':'#000000','color' :'#ffffff'});
                            $(".brand_btn2").css({'background':'#ffffff','color' :'#000000'});
                            $(".brand_btn1").css({'background':'#ffffff','color' :'#000000'});
                            $(".op1a").hide();
                            $(".op1b").hide();
                        $(".op1c", ".op2c").slideToggle(200);
                        if ($(".op2c").hasClass("openc")) {
                            $(".op2c").removeClass("openc");
                            $(".op2a").removeClass("opena");
                            $(".op2b").removeClass("openb");
                            $(".chart1").fadeOut();
                            $(".chart2").fadeOut();
                            $(".chart3").fadeOut();
                        } else {
                            $(".op2c").addClass("openc");
                            $(".op2a").removeClass("opena");
                            $(".op2b").removeClass("openb");
                            $(".chart1").fadeOut();
                            $(".chart2").fadeOut();
                            $(".chart3").fadeIn();
                        }  
                        });
                </script> 

            <!-- 各部門表示ボタン押下後に検索ボタンを押した時に元の表示を保持するためのロジック -->
                <script>
                    $(document).ready(function(){
                        @if(isset($brand_bumon_select))
                            @if($brand_bumon_select == "jack")
                                $(".chart1").fadeIn();
                                $(".op2a").fadeIn();
                                $(".chart2").hide();
                                $(".chart3").hide();
                                $(".op1a").fadeIn();
                                $(".op2a").addClass("opena");
                                $(".brand_btn1").css({'background':'#000000','color' :'#ffffff'});
                                $(".brand_btn3").css({'background':'#ffffff','color' :'#000000'});
                                $(".brand_btn2").css({'background':'#ffffff','color' :'#000000'});
                            @elseif($brand_bumon_select == "betty")
                                $(".chart1").hide();
                                $(".chart2").fadeIn();
                                $(".op2b").fadeIn();
                                $(".chart3").hide();
                                $(".op1b").fadeIn();
                                $(".op2b").addClass("openb");
                                $(".brand_btn2").css({'background':'#000000','color' :'#ffffff'});
                                $(".brand_btn1").css({'background':'#ffffff','color' :'#000000'});
                                $(".brand_btn3").css({'background':'#ffffff','color' :'#000000'});
                            @elseif($brand_bumon_select == "jewelry")
                                $(".chart1").hide();
                                $(".chart2").hide();
                                $(".chart3").fadeIn();
                                $(".op1c").fadeIn();
                                $(".op2c").addClass("openc");
                                $(".brand_btn3").css({'background':'#000000','color' :'#ffffff'});
                                $(".brand_btn1").css({'background':'#ffffff','color' :'#000000'});
                                $(".brand_btn2").css({'background':'#ffffff','color' :'#000000'});

                            @endif
                        @endif
                    });
                </script>
                                <script type="text/javascript">
                                    $(".brand_btn1b").on("click", function (e) {
                                        $('.brand_bumon_select').val('jack');
                                    });
                                    $(".brand_btn2b").on("click", function (e) {
                                        $('.brand_bumon_select').val('betty');
                                    });
                                    $(".brand_btn3b").on("click", function (e) {
                                        $('.brand_bumon_select').val('jewelry');
                                    });
                                </script>

            <!-- 各部門表示ボタン押下時にボタンの部門のみ表示させるためのロジック -->
            <script>
                    /* デフォルト時（全非表示） */
                        $(".op1a").hide();
                        $(".op1b").hide();
                        $(".op1c").hide();
                        $(".chart1").hide();
                        $(".chart2").hide();
                        $(".chart3").hide();
                    /* ジャック表示ボタン押下時 */
                        $(".brand_btn1b").on("click", function (e) {
                            $(".brand_btn1b").css({'background':'#000000','color' :'#ffffff'});
                            $(".brand_btn2b").css({'background':'#ffffff','color' :'#000000'});
                            $(".brand_btn3b").css({'background':'#ffffff','color' :'#000000'});
                            $(".op1b").hide();
                            $(".op1c").hide();
                        $(".op1a", ".op2a").slideToggle(200);
                        if ($(".op2a").hasClass("opena")) {
                            $(".op2a").removeClass("opena");
                            $(".op2b").removeClass("openb");
                            $(".op2c").removeClass("openc");
                            $(".chart1").fadeOut();
                            $(".chart2").fadeOut();
                            $(".chart3").fadeOut();
                        } else {
                            $(".op2a").addClass("opena");
                            $(".op2b").removeClass("openb");
                            $(".op2c").removeClass("openc");
                            $(".chart2").fadeOut();
                            $(".chart3").fadeOut();
                            $(".chart1").fadeIn();
                        }  
                        });
                    /* ベティー表示ボタン押下時 */
                        $(".brand_btn2b").on("click", function (e) {
                            $(".brand_btn2b").css({'background':'#000000','color' :'#ffffff'});
                            $(".brand_btn1b").css({'background':'#ffffff','color' :'#000000'});
                            $(".brand_btn3b").css({'background':'#ffffff','color' :'#000000'});
                            $(".op1a").hide();
                            $(".op1c").hide();
                        $(".op1b", ".op2b").slideToggle(200);
                        if ($(".op2b").hasClass("openb")) {
                            $(".op2b").removeClass("openb");
                            $(".op2a").removeClass("opena");
                            $(".op2c").removeClass("openc");
                            $(".chart1").fadeOut();
                            $(".chart2").fadeOut();
                            $(".chart3").fadeOut();
                        } else {
                            $(".op2b").addClass("openb");
                            $(".op2a").removeClass("opena");
                            $(".op2c").removeClass("openc");
                            $(".chart1").fadeOut();
                            $(".chart3").fadeOut();
                            $(".chart2").fadeIn();
                        }  
                        });
                    /* ジュエリー表示ボタン押下時 */
                        $(".brand_btn3b").on("click", function (e) {
                            $(".brand_btn3b").css({'background':'#000000','color' :'#ffffff'});
                            $(".brand_btn2b").css({'background':'#ffffff','color' :'#000000'});
                            $(".brand_btn1b").css({'background':'#ffffff','color' :'#000000'});
                            $(".op1a").hide();
                            $(".op1b").hide();
                        $(".op1c", ".op2c").slideToggle(200);
                        if ($(".op2c").hasClass("openc")) {
                            $(".op2c").removeClass("openc");
                            $(".op2a").removeClass("opena");
                            $(".op2b").removeClass("openb");
                            $(".chart1").fadeOut();
                            $(".chart2").fadeOut();
                            $(".chart3").fadeOut();
                        } else {
                            $(".op2c").addClass("openc");
                            $(".op2a").removeClass("opena");
                            $(".op2b").removeClass("openb");
                            $(".chart1").fadeOut();
                            $(".chart2").fadeOut();
                            $(".chart3").fadeIn();
                        }  
                        });
                </script> 

            <!-- 各部門表示ボタン押下後に検索ボタンを押した時に元の表示を保持するためのロジック -->
                <script>
                    $(document).ready(function(){
                        @if(isset($brand_bumon_select))
                            @if($brand_bumon_select == "jack")
                                $(".chart1").fadeIn();
                                $(".op2a").fadeIn();
                                $(".chart2").hide();
                                $(".chart3").hide();
                                $(".op1a").fadeIn();
                                $(".op2a").addClass("opena");
                                $(".brand_btn1b").css({'background':'#000000','color' :'#ffffff'});
                                $(".brand_btn3b").css({'background':'#ffffff','color' :'#000000'});
                                $(".brand_btn2b").css({'background':'#ffffff','color' :'#000000'});
                            @elseif($brand_bumon_select == "betty")
                                $(".chart1").hide();
                                $(".chart2").fadeIn();
                                $(".op2b").fadeIn();
                                $(".chart3").hide();
                                $(".op1b").fadeIn();
                                $(".op2b").addClass("openb");
                                $(".brand_btn2b").css({'background':'#000000','color' :'#ffffff'});
                                $(".brand_btn1b").css({'background':'#ffffff','color' :'#000000'});
                                $(".brand_btn3b").css({'background':'#ffffff','color' :'#000000'});
                            @elseif($brand_bumon_select == "jewelry")
                                $(".chart1").hide();
                                $(".chart2").hide();
                                $(".chart3").fadeIn();
                                $(".op1c").fadeIn();
                                $(".op2c").addClass("openc");
                                $(".brand_btn3b").css({'background':'#000000','color' :'#ffffff'});
                                $(".brand_btn1b").css({'background':'#ffffff','color' :'#000000'});
                                $(".brand_btn2b").css({'background':'#ffffff','color' :'#000000'});

                            @endif
                        @endif
                    });
                </script>



    <script type="text/javascript">

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

jQuery(document).ready(function(){
    jQuery('.down').css('display','none');
	
    jQuery('.btn_bulldown_').on("click",function(){
      // メニュー開閉  
        var t=jQuery(this).next(".down");	
        jQuery(t).stop().slideToggle();
        var a = $(".view").text();
        var b = $(".view2").text();
        var c = $(".view3").text();

        if (a == '＋') {
            $(".view").text('－');
        } else {
            $(".view").text('＋');
        }
        if (b == '＋') {
            $(".view2").text('－');
        } else {
            $(".view2").text('＋');
        }
        if (c == '＋') {
            $(".view3").text('－');
        } else {
            $(".view3").text('＋');
        }
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

    </script>
    <style type="text/css">
        /* 共通 */
        .ta_c{text-align:center;font-size:max(.7vw,10px);}
        .class1{color:red;font-weight:bold;}
.class2{color:blue;font-weight:bold;}
.class3{color:brown;font-weight:bold;}

        /* 更新時のローディング用 */
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

/* ヘッダー大枠 */
.header{height:auto; top:0;width:100%; margin:0 auto; background:#f5f5f5;z-index:100;padding-bottom:2em;}

/* ヘッダータイトル */
            .title{background:#000000;background-image: -webkit-linear-gradient(transparent 0%,rgba(255,255,255,.3) 50%,transparent 50%,rgba(0,0,0,.1) 100%);margin-bottom:2em;position:relative;top:0px; width:100%; color:#ffffff; font-size:15px; line-height:2em; text-align:center;}

/* ヘッダーボタン */
.btn_cont{height:auto;margin:0 auto; width:100%;display:flex;justify-content:space-between;}
.btn_cont .btn_wrap{width:15%;height:auto;display:flex;flex-wrap:wrap;}
.btn_cont .btn_box2{width:100%;/*border:1px solid #ccc;*/background:#ffffff;height:auto;}
.btn_cont .btn_box{width:100%;/*border:1px solid #ccc;*/background:#ffffff;height:auto;}
.btn_cont .btn_box .period_box{text-align:center;padding:.5em 0;font-size:10px !important;}
.btn_cont .btn_box .sub_title{width:90%;text-align:left;margin:2em auto 1em auto;padding:0 0 0 1em;border-bottom:1px #ccc dotted;border-left:5px solid #000000;}
/* 使用方法 */
.method{position:relative; top:0; width:100%;}
.btn_bulldown_{}
.method_btn{border-radius: 10px;background:#000000; color:#ffffff; width:8em !important;text-align:center;padding:.2em .8em !important;font-weight:bold;font-size:14px;}
.down{}


/* FORM系 */
.period_select{width:24%;font-size:10px;}
.output_select{width:80%;padding:0 0;margin:0 auto;font-size:12px;}



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
    margin-top:2em;
  font-size: 1rem;
  font-weight: 700;
  line-height: 1.5;
  position: relative;
  display: inline-block;
  padding: .8rem 2rem;
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
  color: #ffffff;
  border-radius: 0.5rem;
  background:#000000;

}
.btn:hover{opacity:.7;}










/* 検索結果 */
.search_area{width:100%;position:relative;padding-left:1%;}
.text{font-size:12px;line-height:1.2;}
.mt1{margin-top:1em;}
.ta_c{text-align:center !important;}
.ul_p{width:100%;display: flex; justify-content: space-between;flex-wrap: wrap;}
.sinchoku,.sinchoku_t{
    width:12.5%;
    word-break: break-all;word-wrap:break-word;
    padding:.3em .5em;
    border-right:1px solid #000000;
    border-bottom:1px solid #000000;
    -webkit-box-sizing: border-box;
box-sizing: border-box;
text-align:right;

}
.pt2{padding-top:2em;}
.sinchoku:first-child,.sinchoku_t:first-child{border-left:1px solid #000000;}
.sinchoku_t{background:#696969; color:#ffffff;text-align:center;border-top:1px solid #000000;}
.ul_p div{font-size:.5vw;}
.bg_grey{background:#c0c0c0 !important; color:#000000;}
.bg_green div{background-color: rgba(226, 239, 218) !important; color:#000000 !important;}
.bg_yellow div{background-color: rgba(255, 242, 204) !important; color:#000000 !important;}}

.wid100{width:100%;}
.ul{display: flex; justify-content: space-between;flex-wrap: wrap;}
.ul1,.ul1b,.ul1b_past,.ul4{display: flex; justify-content: space-between;/*flex-wrap: wrap;*/}
.ul1 div:last-child,.ul1 div:nth-last-child(2),.ul1b div:nth-last-child(2),.ul1b div:last-child,.ul1b_past div:last-child,.ul4 div:last-child{background:#b0c4de;}
.ul2{display: flex; justify-content: space-between;/*flex-wrap: wrap;*/}
.ul2 div{background:#696969; color:#ffffff;} 
.ul3{display: flex; justify-content: space-between;/*flex-wrap: wrap;*/}
.ul3 div{background:#c0c0c0; color:#000000;/*font-weight:bold;*/} 
.btn_ul{display: flex; width:100%;margin-bottom:2em;justify-content: center;}
.brand_btn1,.brand_btn2,.brand_btn3,.brand_btn4,.brand_btn5,.brand_btn6,.brand_btn,.brand_btn1b,.brand_btn2b,.brand_btn3b,.brand_btn4b,.brand_btn5b,.brand_btn6b{border-radius:15px;text-align:center; font-weight:bold;font-size:17px;width:30%;padding:15px 0; margin:20px 1% 0 1%;}
.title_a{font-size:20px; font-weight:bold; padding:1em 0 0 0;}
.title_b{font-size:20px; font-weight:bold; padding:1em 0 0 0;}

.ul1 div,.ul1b div,.ul1b_past div,.ul2 div,.ul3 div,.ul4 div{font-size:.5vw;display: flex;align-items: center;}
.ul1 div,.ul1b div,.ul1b_past div,/*.ul2 div,*/.ul3 div{justify-content:right;}
.ul4 div:not(:first-child){justify-content:right;}
.ul2 div{justify-content:center !important;}
.title1,.title5,.ta_c{justify-content:center !important;}
.ta_r{text-align:right;}
.title1,.title2,.title3,.title4,.title5,.title6{
    @if(isset($line_width)) width: {{ $line_width }}% !important; @endif
    word-break: break-all;word-wrap:break-word;
    /*width:50px;*/
    padding:.3em .5em;
    border-right:1px solid #000000;
    border-bottom:1px solid #000000;
    -webkit-box-sizing: border-box;
box-sizing: border-box;
}
/* 各要素の値以外の列が一つのみ用 */
.title7{
    @if(isset($line_width2)) width: {{ $line_width2 }}% !important; @endif
    word-break: break-all;word-wrap:break-word;
    /*width:50px;*/
    padding:.3em .5em;
    border-right:1px solid #000000;
    border-bottom:1px solid #000000;
    -webkit-box-sizing: border-box;
box-sizing: border-box;

}
.fc_red{color:red !important;}
.fc_blue{color:blue !important;}
.box1{width:100%; margin:0 auto;border-top:1px solid #000000;border-right:1px solid #000000;border-left:1px solid #000000;}


.title1:last-child,.title2:last-child,.title3:last-child,.title4:last-child,.title5:last-child,.title6:last-child,.title7:last-child,.sinchoku_t:last-child{
    border-right:initial;
}
.op1a,.op2a,.op1b,.op2b,.op1c,.op2c{width:100%; padding:0 0; margin:0 0;}
.ul1b_past:hover,.ul1b:hover{opacity:0.8;font-weight:bold;/*border-top:1px solid red;border-bottom:1px solid red;*/}

   </style>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/ja.js"></script>


</head>
    <body style="background:#f5f5f5;">
    <div id="loader-bg">
        <div id="loader">
            <img src="./img/img-loading.gif" width="200" height="100" alt="Now Loading..." />
            <p>Now Loading...</p>
        </div>
        </div>


    <!-- 全体の大枠 start -->
        <div id="container">
        @if(isset($all_count_line)) {{ $all_count_line }} @endif  
        <!-- FORM start -->
            <!-- <form action="/laravel/analysis2_test_search" method="POST" enctype="multipart/form-data"> -->
            <form action="/analysis2_test_search" method="POST" enctype="multipart/form-data">
                <!--{{ csrf_field() }}-->
                @csrf
                <!-- 固定ヘッダー START -->
                <div class="header">
                    <!--<div class="title"style="">売上分析</div>-->

                        <!-- 全ボタンの大枠 START -->
                        <div class="btn_cont">
                            <div class="btn_wrap">
                                <!-- 期間指定検索ボタン START -->
                                <div class="btn_box">  
                                    <div class="title">条件の検索</div>
                                        <div>
                                        <div class="ta_c">
                                            <p class="sub_title"><span>出力パターン選択</span></p>
                                            <select name="output" class="output_select">
                                                <option value="0">出力パターンを選択</option>
                                                <option value="1" @if(isset($output) && $output == 1) selected @elseif (empty($output) && $output == 1) selected @endif>[在庫]月別</option>
                                            </select>
                                        </div>
                                        <p class="ta_c"><button type="submit" id="form_view" name="form_view" value="フォームの表示"><span>フォームの表示</span></button></p>
                                        @if(isset($output) && ($output == 1 || $output == 2 || $output == 3))
                                        <p class="sub_title"><span>出力期間の選択</span></p>
                                        <div class="period_box">
                                        開始：<select name="start_year" class="period_select">
                                            <option value="">開始年を選択</option>
                                            <option value="{{ $next_year }}" @if(isset($start_year) && $start_year == $next_year) selected @elseif (empty($start_year)) selected @endif>@if(isset($next_year)){{ $next_year }}@endif年</option>
                                            <option value="{{ $this_year }}" @if(isset($start_year) && $start_year == $this_year) selected @elseif (empty($start_year)) selected @endif>@if(isset($this_year)){{ $this_year }}@endif年</option>
                                            <option value="{{ $last_year }}" @if(isset($start_year) && $start_year == $last_year) selected @endif>@if(isset($last_year)){{ $last_year }}@endif年</option>
                                            <option value="{{ $two_years_ago }}" @if(isset($start_year) && $start_year == $two_years_ago) selected @endif>@if(isset($two_years_ago)){{ $two_years_ago }}@endif年</option>
                                            <option value="{{ $three_years_ago }}" @if(isset($start_year) && $start_year == $three_years_ago) selected @endif>@if(isset($three_years_ago)){{ $three_years_ago }}@endif年</option>
                                        </select>
                                        <select name="start_month" class="period_select">
                                            <option value="">開始月を選択</option>
                                            <option value="1" @if(isset($start_month) && $start_month == 1) selected @elseif (empty($start_month) && $start_month == 1) selected @endif>1月</option>
                                            <option value="2" @if(isset($start_month) && $start_month == 2) selected @elseif (empty($start_month) && $start_month == 2) selected @endif>2月</option>
                                            <option value="3" @if(isset($start_month) && $start_month == 3) selected @elseif (empty($start_month) && $start_month == 3) selected @endif>3月</option>
                                            <option value="4" @if(isset($start_month) && $start_month == 4) selected @elseif (empty($start_month) && $start_month == 4) selected @endif>4月</option>
                                            <option value="5" @if(isset($start_month) && $start_month == 5) selected @elseif (empty($start_month) && $start_month == 5) selected @endif>5月</option>
                                            <option value="6" @if(isset($start_month) && $start_month == 6) selected @elseif (empty($start_month) && $start_month == 6) selected @endif>6月</option>
                                            <option value="7" @if(isset($start_month) && $start_month == 7) selected @elseif (empty($start_month) && $start_month == 7) selected @endif>7月</option>
                                            <option value="8" @if(isset($start_month) && $start_month == 8) selected @elseif (empty($start_month) && $start_month == 8) selected @endif>8月</option>
                                            <option value="9" @if(isset($start_month) && $start_month == 9) selected @elseif (empty($start_month) && $start_month == 9) selected @endif>9月</option>
                                            <option value="10" @if(isset($start_month) && $start_month == 10) selected @elseif (empty($start_month) && $start_month == 10) selected @endif>10月</option>
                                            <option value="11" @if(isset($start_month) && $start_month == 11) selected @elseif (empty($start_month) && $start_month == 11) selected @endif>11月</option>
                                            <option value="12" @if(isset($start_month) && $start_month == 12) selected @elseif (empty($start_month) && $start_month == 12) selected @endif>12月</option>
                                        </select>

                                        </div>     
                                        <div class="period_box">
                                        終了：<select name="end_year" class="period_select">
                                            <option value="">終了年を選択</option>
                                            <option value="{{ $next_year }}" @if(isset($end_year) && $end_year == $next_year) selected @elseif (empty($end_year)) selected @endif>@if(isset($next_year)){{ $next_year }}@endif年</option>
                                            <option value="{{ $this_year }}" @if(isset($end_year) && $end_year == $this_year) selected @elseif (empty($end_year)) selected @endif>@if(isset($this_year)){{ $this_year }}@endif年</option>
                                            <option value="{{ $last_year }}" @if(isset($end_year) && $end_year == $last_year) selected @endif>@if(isset($last_year)){{ $last_year }}@endif年</option>
                                            <option value="{{ $two_years_ago }}" @if(isset($end_year) && $end_year == $two_years_ago) selected @endif>@if(isset($two_years_ago)){{ $two_years_ago }}@endif年</option>
                                            <option value="{{ $three_years_ago }}" @if(isset($end_year) && $end_year == $three_years_ago) selected @endif>@if(isset($three_years_ago)){{ $three_years_ago }}@endif年</option>
                                        </select>
                                        <select name="end_month" class="period_select">
                                            <option value="">終了月を選択</option>
                                            <option value="1" @if(isset($end_month) && $end_month == 1) selected @elseif (empty($end_month) && $end_month == 1) selected @endif>1月</option>
                                            <option value="2" @if(isset($end_month) && $end_month == 2) selected @elseif (empty($end_month) && $end_month == 2) selected @endif>2月</option>
                                            <option value="3" @if(isset($end_month) && $end_month == 3) selected @elseif (empty($end_month) && $end_month == 3) selected @endif>3月</option>
                                            <option value="4" @if(isset($end_month) && $end_month == 4) selected @elseif (empty($end_month) && $end_month == 4) selected @endif>4月</option>
                                            <option value="5" @if(isset($end_month) && $end_month == 5) selected @elseif (empty($end_month) && $end_month == 5) selected @endif>5月</option>
                                            <option value="6" @if(isset($end_month) && $end_month == 6) selected @elseif (empty($end_month) && $end_month == 6) selected @endif>6月</option>
                                            <option value="7" @if(isset($end_month) && $end_month == 7) selected @elseif (empty($end_month) && $end_month == 7) selected @endif>7月</option>
                                            <option value="8" @if(isset($end_month) && $end_month == 8) selected @elseif (empty($end_month) && $end_month == 8) selected @endif>8月</option>
                                            <option value="9" @if(isset($end_month) && $end_month == 9) selected @elseif (empty($end_month) && $end_month == 9) selected @endif>9月</option>
                                            <option value="10" @if(isset($end_month) && $end_month == 10) selected @elseif (empty($end_month) && $end_month == 10) selected @endif>10月</option>
                                            <option value="11" @if(isset($end_month) && $end_month == 11) selected @elseif (empty($end_month) && $end_month == 11) selected @endif>11月</option>
                                            <option value="12" @if(isset($end_month) && $end_month == 12) selected @elseif (empty($end_month) && $end_month == 12) selected @endif>12月</option>
                                        </select>

                                        </div> 
                                <!-- 期間指定検索ボタン END -->
                                       
                                @endif 

                                <!-- DB登録期間の表示 -->
                                    <p style="text-align:center;font-size:10px;">
                                    @if(isset($first_day))登録データ：{{ $first_day }} ～ @endif 
                                    @if(isset($last_day)){{ $last_day }}@endif 
                                    </p>

                                <!-- [在庫]月別用 -->
                                    @if(isset($output) && $output == 1)
                                            <div class="ta_c">
                                            <p class="sub_title">扱い部門</p>
                                                <input type="checkbox" name="out1[]" value="1" checked="checked" disabled="disabled">Jack
                                                <input type="checkbox" name="out1[]" value="2" checked="checked" disabled="disabled">Betty
                                                <input type="checkbox" name="out1[]" value="3" checked="checked" disabled="disabled">Jewelry
                                                <p class="sub_title">商品区分</p>
                                                <input type="checkbox" name="out2[]" value="1" @if(isset($out2_a) && $out2_a <> "OFF") checked @elseif (empty($out2_a)) checked @endif>新品
                                                <input type="checkbox" name="out2[]" value="2" @if(isset($out2_b) && $out2_b <> "OFF") checked @elseif (empty($out2_b)) checked @endif>中古
                                                <input type="checkbox" name="out2[]" value="3" @if(isset($out2_c) && $out2_c <> "OFF") checked @elseif (empty($out2_c)) checked @endif>アンティーク<br>
                                                <p class="sub_title">条件</p>
                                                <input type="checkbox" name="out3[]" value="1" @if(isset($out3_a) && $out3_a <> "OFF") checked @elseif (empty($out3_a)) checked @endif>修理在庫を除く<br>
                                                <input type="checkbox" name="out3[]" value="2" @if(isset($out3_b) && $out3_b <> "OFF") checked @endif>ブランド名無しを除く<br>
                                                <input type="checkbox" name="out3[]" value="3" @if(isset($out3_c) && $out3_c <> "OFF") checked @endif>商品ID無しを除く<br>
                                                <p class="ta_c"><button type="submit" id="search" name="search" class="btn" value="検索"><span>指定した条件を表示</span></button></p>
                                            </div>
                                    @endif

                                </div>

                           
                            </div>
                        </div> 



                            <!-- 検索結果表示 START -->
                                <div class="search_area">
                                <!-- 使用方法エリア -->
                                    <div class="method">
                                        <div>
                                                <div class="btn_bulldown_"><span class="method_btn">補足</span></div>
                                                <div class="down" style="padding-top:2em; padding-bottom:3em;">
                                                <p style="font-weight:bold;border-bottom:1px dotted #666666;border-left:5px solid #666666;padding-left:.5em;margin: top 2px;em;">検索の流れ（共通）</p>
                                                    <ol>
                                                    <li>「出力パターン選択」から使用したいパターンを選択 →「フォームの表示」ボタン押下 → パターン別の検索フォームが表示される</li>
                                                    <li>「出力期間」や任意の要素をチェック後「指定した条件を表示」ボタン押下</li>
                                                    <li> 表示エリア上部のタブで表示を切り替え</li>
                                                    </ol>
                                                    <p style="font-weight:bold;border-bottom:1px dotted #666666;border-left:5px solid #666666;padding-left:.5em;margin: top 2px;em;">検索の流れ（ブランドのみ）</p>
                                                    <ol>
                                                    <li>ボタン押下後、現在期間のブランド名横にチェックボックスが表示されるので、グラフ表示したいブランド名にチェックを入れる（上限5つ）</li>
                                                    <li>「指定した条件を表示」ボタン押下</li>
                                                    </ol>
                                                    <p style="font-weight:bold;border-bottom:1px dotted #666666;border-left:5px solid #666666;padding-left:.5em;margin: top 2px;em;">仕様</p>
                                                    <ol>
                                                    <li>自動で選択した期間の前日から同期間分過去に遡ったデータを取得し、選択期間と比較表示させる</li>
                                                    <li>チャート上の日付はカッコ内が過去のもの</li>
                                                    <li>現在データの累計のカッコ内 → 過去比(上昇は赤、下落は青)</li>
                                                    <li>現在の「金額」「点数」「粗利」の平均について：データ格納最終日がその月の最終日でなければ平均計算に含めない（月のデータが最終日まで揃っていないので、先月までの合計の平均値を表示）</li>
                                                    <li>データを登録する際はデータ内の期間を参照し、過去の余計なデータを残さないためDB上のその期間を削除した上で内容を登録しているので、手動で中身を編集しないよう注意</li>
                                                    <li>登録データは「CSV」形式の文字コードが「UTF-8」のものを使用（<a href="https://lomo-jackroad.ssl-lolipop.jp/laravel/analysis" target="_blank">データを登録する</a>）</li>

                                                    </ol>
                                                    <p style="font-weight:bold;border-bottom:1px dotted #666666;border-left:5px solid #666666;padding-left:.5em;margin: top 2px;em;">備考</p>
                                                    <ol>
                                                    <li>[売上]サマリの「通販」の値と、[売上]通販区分の「各通販区分の合計」の値に差異がある事について</li>
                                                    <p>→稀にある「店舗」にて「通販区分」の売上がたつ事により差が生まれる。[売上]サマリは「店舗」と「通販」で分かれている為、「店舗」の「通販区分」は「通販」には含まれない。よって、全ての「通販区分」を含む[売上]通販区分の「各通販区分の合計」と差が出る。</p>
                                                    </ol>
                                                </div>
                                        </div>
                                    </div>
                                <!-- グラフ表示切り替えボタン用 -->           
                                
                                
<!-- [在庫]月別用 -->
@if(isset($output) && $output == 1 && isset($search) && $search == "ON")  
<div class="" style="width:100%;">
                                            <div class="ul" style="width:100%;margin-bottom:2em;">
                                                <input type="button" class= "brand_btn1 btn1" value="金額・推移表示" style= "background:#000000; color:#ffffff; width:30%;">
                                                <input type="button" class= "brand_btn2 btn2" value="点数・推移表示" style= "width:30%;">
                                                <input type="button" class= "brand_btn3 btn3" value="粗利・推移表示" style= "width:30%;">
                                                <input type="button" class= "brand_btn4 btn4" value="金額構成比・推移表示" style= "width:30%;">
                                                <input type="button" class= "brand_btn5 btn5" value="点数構成比・推移表示" style= "width:30%;">
                                                <input type="button" class= "brand_btn6 btn6" value="粗利率・推移表示" style= "width:30%;">

                        <!-- 上記ボタンを押すと以下のvalue内容が変わる。その内容でどの部門表示用ボタンを押したかを判断する -->
                            <input type="text" class="view_select" style="display:none;" name="view_select" value="">
                                <script type="text/javascript">
                                    $(".brand_btn1").on("click", function (e) {
                                        $('.view_select').val('view1');
                                    });
                                    $(".brand_btn2").on("click", function (e) {
                                        $('.view_select').val('view2');
                                    });
                                    $(".brand_btn3").on("click", function (e) {
                                        $('.view_select').val('view3');
                                    });
                                    $(".brand_btn4").on("click", function (e) {
                                        $('.view_select').val('view4');
                                    });
                                    $(".brand_btn5").on("click", function (e) {
                                        $('.view_select').val('view5');
                                    });
                                    $(".brand_btn6").on("click", function (e) {
                                        $('.view_select').val('view6');
                                    });
                                </script>
                                                
                                            </div>

                                            <div style="width:100%;" class="chart1 section">
                                                <canvas id="mychart"></canvas>
                                            </div>
                                            <div style="width:100%;display:none;" class="chart2 section">
                                                <canvas id="mychart2"></canvas>
                                            </div>
                                            <div style="width:100%;display:none;" class="chart3 section">
                                                <canvas id="mychart3"></canvas>
                                            </div>
                                            <div style="width:100%;display:none;" class="chart4 section">
                                                <canvas id="mychart4"></canvas>
                                            </div>
                                            <div style="width:100%;display:none;" class="chart5 section">
                                                <canvas id="mychart5"></canvas>
                                            </div>
                                            <div style="width:100%;display:none;" class="chart6 section">
                                                <canvas id="mychart6"></canvas>
                                            </div>


                                           <!-- <div class="chart1 section">
                                                <canvas id="mychart"></canvas>
                                            </div>
                                            <div class="chart2 section">
                                                <canvas id="mychart2"></canvas>
                                            </div>
                                            <div class="chart3 section">
                                                <canvas id="mychart3"></canvas>
                                            </div>-->


                                            
                                            <script>
                                                var ctx = document.getElementById('mychart');
                                                var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: [@if(isset($js_month)){!! $js_month !!}@endif],
                                                    datasets: [{
                                                    label: '店舗',
                                                    data: [@if(isset($js_shop_uriage)){!! $js_shop_uriage !!}@endif],
                                                    borderColor: '#c53d43',
                                                @if(isset($js_web_uriage))    
                                                    }, {
                                                    label: '通販',
                                                    data: [{!! $js_web_uriage !!}],
                                                    borderColor: '#007bbb',
                                                @endif      
                                                @if(isset($js_oroshi_uriage))
                                                    }, {
                                                    label: '卸',
                                                    data: [{!! $js_oroshi_uriage !!}],
                                                    borderColor: '#006e54',
                                                @endif
                                                @if(isset($past_js_shop_uriage))
                                                    }, {
                                                    label: '店舗(過去)',
                                                    data: [{!! $past_js_shop_uriage !!}],
                                                    borderColor: '#e198b4',
                                                @endif
                                                @if(isset($past_js_web_uriage))
                                                    }, {
                                                    label: '通販(過去)',
                                                    data: [{!! $past_js_web_uriage !!}],
                                                    borderColor: '#bbc8e6',
                                                @endif
                                                @if(isset($past_js_oroshi_uriage))
                                                    }, {
                                                    label: '卸(過去)',
                                                    data: [{!! $past_js_oroshi_uriage !!}],
                                                    borderColor: '#a2d7dd',
                                                @endif
                                                    }, {
                                                    type: 'bar',
                                                    label: '過去合計',
                                                    data: [@if(isset($js_past_all_month_uriage)){!! $js_past_all_month_uriage !!}@endif],
                                                    backgroundColor: "#dcdcdc",
                                                    borderColor: "rgb(255, 99, 132, 0.5)",
                                                    yAxisID: "temperatureChart",
                                                }, {
                                                    type: 'bar',
                                                    label: '合計',
                                                    data: [@if(isset($js_all_month_uriage)){!! $js_all_month_uriage !!}@endif],
                                                    backgroundColor: "#a9a9a9",
                                                    borderColor: "rgb(255, 99, 132, 0.5)",
                                                    yAxisID: "temperatureChart",
                                                }],
                                                },
                                                options: {
                                                    /*y: {
                                                    min: 3000000,
                                                    max: 1800000000,
                                                    },*/
                                                },
                                                });

                                                var ctx = document.getElementById('mychart2');
                                                var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: [@if(isset($js_month)){!! $js_month !!}@endif],
                                                    datasets: [{
                                                    label: '店舗',
                                                    data: [@if(isset($js_shop_number)){!! $js_shop_number !!}@endif],
                                                    borderColor: '#c53d43',
                                                @if(isset($js_web_number))    
                                                    }, {
                                                    label: '通販',
                                                    data: [{!! $js_web_number !!}],
                                                    borderColor: '#007bbb',
                                                @endif      
                                                @if(isset($js_oroshi_number))
                                                    }, {
                                                    label: '卸',
                                                    data: [{!! $js_oroshi_number !!}],
                                                    borderColor: '#006e54',
                                                @endif
                                                @if(isset($past_js_shop_number))
                                                    }, {
                                                    label: '店舗(過去)',
                                                    data: [{!! $past_js_shop_number !!}],
                                                    borderColor: '#e198b4',
                                                @endif
                                                @if(isset($past_js_web_number))
                                                    }, {
                                                    label: '通販(過去)',
                                                    data: [{!! $past_js_web_number !!}],
                                                    borderColor: '#bbc8e6',
                                                @endif
                                                @if(isset($past_js_oroshi_number))
                                                    }, {
                                                    label: '卸(過去)',
                                                    data: [{!! $past_js_oroshi_number !!}],
                                                    borderColor: '#a2d7dd',
                                                @endif
                                                    }, {
                                                    type: 'bar',
                                                    label: '過去合計',
                                                    data: [@if(isset($js_past_all_month_number)){!! $js_past_all_month_number !!}@endif],
                                                    backgroundColor: "#dcdcdc",
                                                    borderColor: "rgb(255, 99, 132, 0.5)",
                                                    yAxisID: "temperatureChart",
                                                }, {
                                                    type: 'bar',
                                                    label: '合計',
                                                    data: [@if(isset($js_all_month_number)){!! $js_all_month_number !!}@endif],
                                                    backgroundColor: "#a9a9a9",
                                                    borderColor: "rgb(255, 99, 132, 0.5)",
                                                    yAxisID: "temperatureChart",
                                                }],
                                                },
                                                options: {
                                                    /*y: {
                                                    min: 3000000,
                                                    max: 1800000000,
                                                    },*/
                                                },
                                                });

                                                var ctx = document.getElementById('mychart3');
                                                var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: [@if(isset($js_month)){!! $js_month !!}@endif],
                                                    datasets: [{
                                                    label: '店舗',
                                                    data: [@if(isset($js_shop_arari)){!! $js_shop_arari !!}@endif],
                                                    borderColor: '#c53d43',
                                                @if(isset($js_web_arari))    
                                                    }, {
                                                    label: '通販',
                                                    data: [{!! $js_web_arari !!}],
                                                    borderColor: '#007bbb',
                                                @endif      
                                                @if(isset($js_oroshi_arari))
                                                    }, {
                                                    label: '卸',
                                                    data: [{!! $js_oroshi_arari !!}],
                                                    borderColor: '#006e54',
                                                @endif
                                                @if(isset($past_js_shop_arari))
                                                    }, {
                                                    label: '店舗(過去)',
                                                    data: [{!! $past_js_shop_arari !!}],
                                                    borderColor: '#e198b4',
                                                @endif
                                                @if(isset($past_js_web_arari))
                                                    }, {
                                                    label: '通販(過去)',
                                                    data: [{!! $past_js_web_arari !!}],
                                                    borderColor: '#bbc8e6',
                                                @endif
                                                @if(isset($past_js_oroshi_arari))
                                                    }, {
                                                    label: '卸(過去)',
                                                    data: [{!! $past_js_oroshi_arari !!}],
                                                    borderColor: '#a2d7dd',
                                                @endif
                                                    }, {
                                                    type: 'bar',
                                                    label: '過去合計',
                                                    data: [@if(isset($js_past_all_month_arari)){!! $js_past_all_month_arari !!}@endif],
                                                    backgroundColor: "#dcdcdc",
                                                    borderColor: "rgb(255, 99, 132, 0.5)",
                                                    yAxisID: "temperatureChart",
                                                }, {
                                                    type: 'bar',
                                                    label: '合計',
                                                    data: [@if(isset($js_all_month_arari)){!! $js_all_month_arari !!}@endif],
                                                    backgroundColor: "#a9a9a9",
                                                    borderColor: "rgb(255, 99, 132, 0.5)",
                                                    yAxisID: "temperatureChart",
                                                }],
                                                },
                                                options: {
                                                    /*y: {
                                                    min: 3000000,
                                                    max: 1800000000,
                                                    },*/
                                                },
                                                });
                                                var ctx = document.getElementById('mychart4');
                                                var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: [@if(isset($js_month)){!! $js_month !!}@endif],
                                                    datasets: [{
                                                    label: '店舗・金額構成比',
                                                    data: [@if(isset($shop_total_js2)){!! $shop_total_js2 !!}@endif],
                                                    borderColor: '#c53d43',
                                                @if(isset($web_total_js2))    
                                                    }, {
                                                    label: '通販・金額構成比',
                                                    data: [{!! $web_total_js2 !!}],
                                                    borderColor: '#007bbb',
                                                @endif      
                                                @if(isset($oroshi_total_js2))
                                                    }, {
                                                    label: '卸・金額構成比',
                                                    data: [{!! $oroshi_total_js2 !!}],
                                                    borderColor: '#006e54',
                                                @endif
                                                @if(isset($past_shop_total_js2))
                                                    }, {
                                                    label: '店舗・金額構成比(過去)',
                                                    data: [{!! $past_shop_total_js2 !!}],
                                                    borderColor: '#e198b4',
                                                @endif
                                                @if(isset($past_web_total_js2))
                                                    }, {
                                                    label: '通販・金額構成比(過去)',
                                                    data: [{!! $past_web_total_js2 !!}],
                                                    borderColor: '#bbc8e6',
                                                @endif
                                                @if(isset($past_oroshi_total_js2))
                                                    }, {
                                                    label: '卸・金額構成比(過去)',
                                                    data: [{!! $past_oroshi_total_js2 !!}],
                                                    borderColor: '#a2d7dd',
                                                @endif
                                                    }],
                                                },
                                                options: {
                                                    /*y: {
                                                    min: 3000000,
                                                    max: 1800000000,
                                                    },*/
                                                },
                                                });
                                                var ctx = document.getElementById('mychart5');
                                                var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: [@if(isset($js_month)){!! $js_month !!}@endif],
                                                    datasets: [{
                                                    label: '店舗・点数構成比',
                                                    data: [@if(isset($shop_total_js3)){!! $shop_total_js3 !!}@endif],
                                                    borderColor: '#c53d43',
                                                @if(isset($web_total_js3))    
                                                    }, {
                                                    label: '通販・点数構成比',
                                                    data: [{!! $web_total_js3 !!}],
                                                    borderColor: '#007bbb',
                                                @endif      
                                                @if(isset($oroshi_total_js3))
                                                    }, {
                                                    label: '卸・点数構成比',
                                                    data: [{!! $oroshi_total_js3 !!}],
                                                    borderColor: '#006e54',
                                                @endif
                                                @if(isset($past_shop_total_js3))
                                                    }, {
                                                    label: '店舗・点数構成比(過去)',
                                                    data: [{!! $past_shop_total_js3 !!}],
                                                    borderColor: '#e198b4',
                                                @endif
                                                @if(isset($past_web_total_js3))
                                                    }, {
                                                    label: '通販・点数構成比(過去)',
                                                    data: [{!! $past_web_total_js3 !!}],
                                                    borderColor: '#bbc8e6',
                                                @endif
                                                @if(isset($past_oroshi_total_js3))
                                                    }, {
                                                    label: '卸・点数構成比(過去)',
                                                    data: [{!! $past_oroshi_total_js3 !!}],
                                                    borderColor: '#a2d7dd',
                                                @endif
                                                    }],
                                                },
                                                options: {
                                                    /*y: {
                                                    min: 3000000,
                                                    max: 1800000000,
                                                    },*/
                                                },
                                                });


                                                var ctx = document.getElementById('mychart6');
                                                var myChart = new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: [@if(isset($js_month)){!! $js_month !!}@endif],
                                                    datasets: [{
                                                    label: '店舗・粗利率',
                                                    data: [@if(isset($shop_total_js)){!! $shop_total_js !!}@endif],
                                                    borderColor: '#c53d43',
                                                @if(isset($web_total_js))    
                                                    }, {
                                                    label: '通販・粗利率',
                                                    data: [{!! $web_total_js !!}],
                                                    borderColor: '#007bbb',
                                                @endif      
                                                @if(isset($oroshi_total_js))
                                                    }, {
                                                    label: '卸・粗利率',
                                                    data: [{!! $oroshi_total_js !!}],
                                                    borderColor: '#006e54',
                                                @endif
                                                @if(isset($past_shop_total_js))
                                                    }, {
                                                    label: '店舗・粗利率(過去)',
                                                    data: [{!! $past_shop_total_js !!}],
                                                    borderColor: '#e198b4',
                                                @endif
                                                @if(isset($past_web_total_js))
                                                    }, {
                                                    label: '通販・粗利率(過去)',
                                                    data: [{!! $past_web_total_js !!}],
                                                    borderColor: '#bbc8e6',
                                                @endif
                                                @if(isset($past_oroshi_total_js))
                                                    }, {
                                                    label: '卸・粗利率(過去)',
                                                    data: [{!! $past_oroshi_total_js !!}],
                                                    borderColor: '#a2d7dd',
                                                @endif
                                                    }, {
                                                    type: 'bar',
                                                    label: '粗利率合計(過去)',
                                                    data: [@if(isset($past_all_arari_total)){!! $past_all_arari_total !!}@endif],
                                                    backgroundColor: "#dcdcdc",
                                                    borderColor: "rgb(255, 99, 132, 0.5)",
                                                    yAxisID: "temperatureChart",
                                                }, {
                                                    type: 'bar',
                                                    label: '粗利率合計',
                                                    data: [@if(isset($all_arari_total)){!! $all_arari_total !!}@endif],
                                                    backgroundColor: "#a9a9a9",
                                                    borderColor: "rgb(255, 99, 132, 0.5)",
                                                    yAxisID: "temperatureChart",
                                                }],
                                                },
                                                options: {
                                                    /*y: {
                                                    min: 3000000,
                                                    max: 1800000000,
                                                    },*/
                                                },
                                                });


                                            </script>

                                <!-- グラフの表示 -->
                                    <div class="op2a">
                                        <dd class="op1a">
                                            @if(isset($temp1_all_sorce)){!! $temp1_all_sorce !!}@endif
                                            @if(isset($uriage_progress_html)){!! $uriage_progress_html !!}@endif
                                            @if(isset($temp1_all_sorce2)){!! $temp1_all_sorce2 !!}@endif
                                            @if(isset($number_progress_html)){!! $number_progress_html !!}@endif
                                            @if(isset($temp1_all_sorce3)){!! $temp1_all_sorce3 !!}@endif
                                            @if(isset($arari_progress_html)){!! $arari_progress_html !!}@endif
                                            @if(isset($temp1_all_sorce4)){!! $temp1_all_sorce4 !!}@endif
                                            @if(isset($temp1_all_sorce5)){!! $temp1_all_sorce5 !!}@endif
                                            @if(isset($temp1_all_sorce6)){!! $temp1_all_sorce6 !!}@endif
                                            @if(isset($temp1_all_sorce7)){!! $temp1_all_sorce7 !!}@endif
                                            @if(isset($temp1_all_sorce8)){!! $temp1_all_sorce8 !!}@endif
                                            @if(isset($temp1_all_sorce9)){!! $temp1_all_sorce9 !!}@endif
                                            @if(isset($temp1_all_sorce10)){!! $temp1_all_sorce10 !!}@endif
                                        </dd>
                                    </div>                                    
                                    <div class="op2a">
                                        <dd class="op1a">
                                            @if(isset($past_temp1_all_sorce)){!! $past_temp1_all_sorce !!}@endif
                                            @if(isset($past_temp1_all_sorce2)){!! $past_temp1_all_sorce2 !!}@endif
                                            @if(isset($past_temp1_all_sorce3)){!! $past_temp1_all_sorce3 !!}@endif
                                            @if(isset($past_temp1_all_sorce4)){!! $past_temp1_all_sorce4 !!}@endif
                                            @if(isset($past_temp1_all_sorce5)){!! $past_temp1_all_sorce5 !!}@endif
                                            @if(isset($past_temp1_all_sorce6)){!! $past_temp1_all_sorce6 !!}@endif
                                        </dd>
                                    </div>                                    




                                    </div>
                                    

@endif
















<!-- 全ブランド用 end -->
                                </div>
                            <!-- 検索結果表示 END -->

                        </div>
                        <!-- 全ボタンの大枠 END -->
                </div>
                <!-- 固定ヘッダー END -->

            </form>
        <!-- FORM end -->

        </div>
    <!-- 全体の大枠 end -->
    </body>
</html>