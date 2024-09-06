<!doctype html>
	<html lang="ja">
	<head>
		<meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="robots" content="nofollow">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<title>社員名編集</title>

    <!--// POSTのときはCSRFトークンを付与。自作のbladeを作るときには忘れないように-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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

        .fieldset_box{position:relative;height:auto;margin:0 auto; width:100%;display:flex;justify-content:space-around;/*background:blue;*/}
    .left_fieldset,.right_fieldset{text-align:center; border:3px #ccc double;height:auto;width:45%;border-radius: 15px;background:#f5f5f5;}
    .form_font{font-size:.9vw; font-weight:bold;}
    .font1{font-size:12px; color:red;}
/* ヘッダータイトル */
.title{margin-bottom:2em;position:relative;top:0px;left:0; width:100%; color:#ffffff; font-size:15px; line-height:2em; text-align:center;
    background:#000000;background-image: -webkit-linear-gradient(transparent 0%,rgba(255,255,255,.3) 50%,transparent 50%,rgba(0,0,0,.1) 100%);
  background-image:         linear-gradient(transparent 0%,rgba(255,255,255,.3) 50%,transparent 50%,rgba(0,0,0,.1) 100%);
  box-shadow: 0 2px 2px 0 rgba(255,255,255,.2) inset,0 2px 10px 0 rgba(255,255,255,.5) inset,0 -2px 2px 0 rgba(0,0,0,.1) inset;
  border: 1px solid rgba(0,0,0,.2);
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
        <div class="title">社員名登録・削除用フォーム</div>
        <div class="container">
            <!--<form action="/laravel/edit_stuffname" method="POST" onSubmit="return double()" name="">-->
            <form action="/edit_stuffname" method="POST" onSubmit="return double()" name="" enctype="multipart/form-data">
            
                <!--{{ csrf_field() }}-->
                @csrf

                <div class="fieldset_box">
                    <fieldset class="left_fieldset">
                        <legend class="form_font">&nbsp;社員名登録&nbsp;</legend>
                
                        <!-- 登録用 -->
                            <!-- 連続登録がセキュリティで弾かれる為、登録・削除済コメントが無い場合に表示 -->
                            @if(empty($add_comment)) 
                                <p style="padding-bottom:2em;">
                                <select name="stuff" style="width:240px;">
                                    <option value="">登録スタッフ拠点選択</option>
                                    <option value="" >店舗スタッフ</option>
                                    <option value="ON" >NCスタッフ</option>
                                </select><span class="font1">&nbsp;&nbsp;※未選択の場合は店舗スタッフとして登録</span>
                                </p>
                                姓：<input type="text" id="first_name" name="first_name" class="" >
                                名：<input type="text" id="last_name" name="last_name" class="" >
                                <p><input type = "submit" class="btn" value="スタッフ名登録" name="add_btn" style="width:40%;padding:.5em 0;margin-top:1em;"></p>
                            @endif

                    </fieldset>
                    <fieldset class="right_fieldset">
                        <legend class="form_font">&nbsp;社員名削除&nbsp;</legend>
                    
                        <!-- 削除用 -->
                            <!-- 連続登録がセキュリティで弾かれる為、登録・削除済コメントが無い場合に表示 -->
                            @if(empty($add_comment)) 
                                {!!$view!!} 
                                <input type = "submit" class="btn" value="スタッフ名削除" name="del_btn" style="width:40%;padding:.5em 0;margin-top:1em;">
                            @endif

                    </fieldset>
                    
            </form>

        </div>
                <!-- コメント表示用 -->
                    <!-- 登録・削除済コメントがある場合に表示 -->
                        @if(isset($add_comment)) 
                            <p style="color:red; font-weight:bold; line-height:2em;margin-top:5em; text-align:center;">
                                {!!$add_comment!!} 
                                <a href="">元のページへ戻る</a>
                            </p>
                        @endif

    </body>
</html>
