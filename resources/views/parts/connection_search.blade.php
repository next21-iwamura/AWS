<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>関連商品用CSV出力</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script src="https://sub-jackroad.ssl-lolipop.jp/RMS/tools/op/js/jquery.typist.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    

    <script>

$(function() {
    $('.file-download-btn').on('click', function() {   // DLボタンクリックで発火
        //var fileId = $(this).attr('data-file-id');     // カスタムデータ属性からファイルIDを取得
        //window.open('connection_search');  // URLを指定してタブを開く -> コントローラーでダウンロード処理が実行される
        //location.reload(true);                         // ページをリロードする
        //location.reload();
        //window.location.reload();

        $('.file-download-btn').css('display','none');
        $('.blinking_box').css('display','none');
        $('.comment').html('<p> ！！ ダウンロード終了 ！！</p>');

        
    });
});




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
                                        // その他ブランド用 
                                            //$('#ari').on('click', function() {　// ページ読み込み後に生成された要素には効かない為変更
                                            $(document).on("click", "#ari", function(){
                                                $('#checkbox1').css('display','block');
                                                $('#checkbox2').css('display','none');
                                            });
                                            //$('#nashi').on('click', function() {　// ページ読み込み後に生成された要素には効かない為変更
                                            $(document).on("click", "#nashi", function(){
                                                $('#checkbox1').css('display','none');
                                                $('#checkbox2').css('display','block');
                                            });
                                        // カルティエ用 
                                            $(document).on("click", "#ari2", function(){
                                                $('#checkbox3').css('display','block');
                                                $('#checkbox4').css('display','none');
                                            });
                                            $(document).on("click", "#nashi2", function(){
                                                $('#checkbox3').css('display','none');
                                                $('#checkbox4').css('display','block');
                                            });
                                        // ジョージジェンセン用 
                                            $(document).on("click", "#ari3", function(){
                                                $('#checkbox5').css('display','block');
                                                $('#checkbox6').css('display','none');
                                            });
                                            $(document).on("click", "#nashi3", function(){
                                                $('#checkbox5').css('display','none');
                                                $('#checkbox6').css('display','block');
                                            });


                                            $(function(){
  $('input').on('change', function () {
      var file = $(this).prop('files')[0];
      $(this).next().text(file.name);
      $(this).next().css('color','#dc143c');
      
  });
});
			  	// 処理中の二度押し禁止 
                  $(function () {
  $('form').submit(function () {
    $(this).find(':submit').val('処理中...').css('color','#dc143c').addClass("blinking");
  });
});

    </script>
<script>
    // ブラウザバックを禁止する
    history.pushState(null, null, location.href);
$(window).on('popstate', function(){
  history.go(1);
});







   </script>
<style type ="text/css">
    body{height:100%;background:#f5f5f5;}
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
            fieldset{border:1px dotted #ccc;}
            legend{font-size:15px;}

            label {
  padding: 5px 20px;
  color: #ffffff;
  background-color: #666666;
  font-size:12px;
  cursor: pointer;
  border-radius:10px;
  transition: .3s;
}
label:hover {
  opacity: 0.8;
}
input[type="file"] {
  display: none;
}
.select-image{font-size:12px;margin-left:2em;}
.file_view{border-bottom:1px dotted #ccc; padding-bottom:.5em;}
.box_right{width:700px;border-left:2px solid #f5f5f5;padding:20px 10px 0 40px;}
.box_right p{font-size:15px;}
.right_title{width:100%;border-left:10px solid #ccc;border-bottom:1px dotted #ccc;padding:5px 0 5px 10px;}
.indent{margin-left:30px;}
.btn{width:80%; margin:1em auto 0 auto;padding:.5em 0;}
.message{color:#dc143c;text-align:center;}


.blinking_box{    font-size:12px;
    text-align:center;
}
.blinking{
    color:#dc143c;
    font-size:12px;
    text-align:center;
	-webkit-animation:blink 1.0s ease-in-out infinite alternate;
    -moz-animation:blink 1.0s ease-in-out infinite alternate;
    animation:blink 1.0s ease-in-out infinite alternate;
}
@-webkit-keyframes blink{
    0% {opacity:0;}
    100% {opacity:1;}
}
@-moz-keyframes blink{
    0% {opacity:0;}
    100% {opacity:1;}
}
@keyframes blink{
    0% {opacity:0;}
    100% {opacity:1;}
}
</style>		



</head>

<body>
	
    <div id="loader-bg">
      <div id="loader">
        <img src="./img/img-loading.gif" width="200" height="100" alt="Now Loading..." />
        <p>Now Loading...</p>
      </div>
    </div>
    
    <div class="container">
        <div style="width:100%; color:#666666; text-align:center;padding:.5em 0;font-weight:bold;letter-spacing:.3em;">関連商品用CSV出力</div>
        <div>

        <!-- <form method="POST" action="/laravel/connection_search" accept-charset="UTF-8" enctype="multipart/form-data">-->
       <form method="POST" action="/connection_search" accept-charset="UTF-8" enctype="multipart/form-data">
        
        @csrf
             <div style="width:1280px;display:flex;justify-content:space-around;margin:10px auto 0 auto;border-top:3px double #d3d3d3;padding-top:30px">
                    @if (empty( $db_insert ) && empty( $search ) && empty( $search ) && empty( $create_info ) && empty( $create_info2)  && empty( $create_csv)  && empty( $dl ))
                        <div style="width:480px;border:1px dotted #d3d3d3;padding:20px 40px;background:#ffffff;">
                                    <p class="blinking_box" style="margin-bottom:2em;"><span class="blinking">▼ STEP1 ▼</span>　必要なファイルを選択し、ファイルのアップロードボタン押下</p>
                                    <p class="file_view">
                                        <label for="loadFileName">ファイル選択</label>
                                        <input type="file" name="loadFileName" value="ファイル選択" id="loadFileName">
                                        <span class="select-image">ファイルが選択されていません</span>
                                    </p>
                                    <p style="text-align:center;">
                                    <input type = "submit" name="csvup" class="btn" value="ファイルのアップロード">
                                    </p>
                        </div>
                    @elseif (isset( $comment ))
                        <div style="width:480px;padding:120px 0px;text-align:center;" class="comment">
                            {!! $comment !!}
                        </div>
                    @endif
                    <div class="box_right">

                            <!-- 「フォームの表示」ボタン押下時に足りないファイルなどのエラーがあった場合のコメントを表示 -->
                                @if (isset( $error_comment) && $error_comment <> "" )
                                    {!! $error_comment !!}
                                @else


                                            <!-- 「ファイルのアップロード」ボタン押下時にアップ用コメントと「フォームの表示」ボタンを表示 -->
                                            @if (isset( $db_insert ) && $db_insert == "ON")
                                                <p class="blinking_box" style="margin-top:5em;"><span class="blinking">▼ STEP2 ▼</span>　ファイルの内容をデータベースへ登録</p>
                                                <p style="text-align:center;">
                                                    <input type = "submit" name="db_insert" class="btn" value="送信">
                                                </p>
                                            @endif
                                
                                            @if (isset( $search ) && $search == "ON")
                                                <p class="blinking_box" style="margin-top:5em;"><span class="blinking">▼ STEP3 ▼</span>　情報処理1 [ 処理時間：短 ]</p>
                                                <p style="text-align:center;"><input name = "search" type="submit" value="送信" class="btn"></p>
                                            @endif

                                            @if (isset( $create_info ) && $create_info == "ON")
                                                <p class="blinking_box" style="margin-top:5em;"><span class="blinking">▼ STEP4 ▼</span>　情報処理2 [ 処理時間：中 ]</p>
                                                <p style="text-align:center;"><input id = "create_info" name = "create_info" type="submit" value="送信" class="btn"></p>
                                            @endif
                                            @if (isset( $create_info2 ) && $create_info2 == "ON")
                                                <p class="blinking_box" style="margin-top:5em;"><span class="blinking">▼ STEP5 ▼</span>　情報処理3 [ 処理時間：長 ]</p>
                                                <p style="text-align:center;"><input id = "create_info2" name = "create_info2" type="submit" value="送信" class="btn"></p>
                                            @endif

                                            @if (isset( $create_csv ) && $create_csv == "ON")
                                                <p class="blinking_box" style="margin-top:5em;"><span class="blinking">▼ STEP6 ▼</span>　CSVの作成</p>
                                                <p style="text-align:center;"><input id = "create_csv" name = "create_csv" type="submit" value="送信" class="btn"></p>
                                            @endif

                                            @if (isset( $dl ) && $dl == "ON")
                                                <p class="blinking_box" style="margin-top:5em;"><span class="blinking">▼ STEP7 ▼</span>　CSVダウンロード</p>
                                                <p style="text-align:center;"><input id = "dl" name = "dl" type="submit" value="CSVダウンロード" class="btn file-download-btn"></p>
                                            @endif
                                


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
