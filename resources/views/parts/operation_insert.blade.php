<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <style type="text/css">

    body{font-size:14px; line-height:1.5em;background:#f5f5f5;}
    .cont{width:1280px; margin:0 auto;}
    .default{width:100%; padding:0 0; margin:15px auto 0 auto;display:flex;justify-content:space-around; border-top:1px solid #000000; /*padding-top:3px;*/ align-items: center;}
    .change{background:#ffe4b5; width:100%; padding:0 0; margin:0 auto 15px auto;display:flex;justify-content:space-around; border-bottom:1px solid #000000; border-top:1px dotted #ccc; /*padding-bottom:3px;*/ align-items: center;}
    .title{width:100%; padding:0 0; margin:0 auto 15px auto;display:flex;justify-content:space-around; background:#000000; color:#ffffff; align-items: center;}
    .parts{display:block; width:160px; text-align:center; border-right:1px dotted #ccc; padding:3px 0; height:100%;}
    
    .change > .parts:first-child,.default > .parts:first-child{background:#000000; color:#ffffff; font-size:10px;}
    .change > .parts:nth-child(3),.default > .parts:nth-child(3){font-size:10px;}
    .change > .parts:nth-child(4),.default > .parts:nth-child(4){font-size:5px;}

    .select1,.price,.sale_price,.maker_price{width:100%; /*height:2em;*/ background:#f5f5f5; color:#cd5c5c; font-weight:bold;}
    .error p:not(:last-child){color:red;}
    .sticky {
    position: -webkit-sticky; /* Safari */
    position: sticky;
    z-index:10;
    top: 0; /* 位置指定 */
    }
    .comment{background:#ffffff;width:50%;margin:10% auto 0 auto;border:3px double #ccc; padding:2em 0;text-align:center;}
    .comment p:first-child{font-size:20px; font-weight:bold;color:red;}
    .font1{color:#0000cd !important;}

    </style>

<script type="text/javascript">
$(function(){
 history.pushState(null, null, null); //ブラウザバック無効化
 //ブラウザバックボタン押下時
 $(window).on("popstate", function (event) {
   history.pushState(null, null, null);
   window.alert('前のページに戻る場合、前に戻るボタンから戻ってください。');
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

</script>    
</head>
<body>
@if (isset($check_comment)){!! $check_comment !!} @endif





    
</body>
</html>