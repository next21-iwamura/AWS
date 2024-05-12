<!doctype html>
	<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title>新規UPツール</title>
		<link rel="stylesheet" type="text/css" href="https://www.jackroad.co.jp/css/reset.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<!--<script src="https://sub-jackroad.ssl-lolipop.jp/RMS/tools/op/js/jquery.typist.js"></script>-->
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>


		




<!--// POSTのときはCSRFトークンを付与。自作のbladeを作るときには忘れないように-->
<meta name="csrf-token" content="{{ csrf_token() }}">







		<style type="text/css">
		body{text-align:center; font-size:12px;}
.preview_data{
	border-bottom:1px dotted #ccc;
	width:95%; 
	font-size:10px;
	text-align:left;
	margin:0 auto;
	line-height:2.0em;
	display:flex;justify-content:space-between;
}
.preview_data:first-child{margin-bottom:5px;}
.preview_data:first-child .data4,.preview_data:first-child .data5{font-size:7px;}
.preview_data > div{border-right:1px dotted #ccc; background:#ffffff;}
.data1,.data4,.data5{
	width:4%;
}
.data4,.data5{
	width:5%;
}

.data2,.data6{
	width:26%;
}
.data3{
	width:34%;
}
.bg_red{background:red !important;}
.bg_black{background:black !important; color:#ffffff !important;}

.title{
	width:95%;
	font-size:25px;
	font-weight:bold;
	background-color:#000000;
	color:red;
	line-height:2.0em;
	border-bottom:1px dotted #ccc;
	margin:30px auto 15px auto;
}
.b_button{
	cursor:pointer; 
	font-weight:bold;
	font-size:30px;
	padding:5px 15px; 
	box-shadow: 10px 10px 10px rgba(0,0,0,0.4); 
	border-radius: 12px; color:#ffffff; 
	background-color:#FF3333;
	width:650px;
	height:2em;
	margin:70px auto;
	text-align:center;
	line-height:1.5em;
}
.s_button{
	cursor:pointer; 
	font-weight:bold;
	font-size:13px;
	padding:5px 15px; 
	border-radius: 12px; color:#ffffff; 
	background-color:#FF3333;
	width:310px;
	margin:15px auto;
	text-align:center;
	line-height:1.5em;
}
.s_button2{
	background:#000000 !important;
	color:#ffffffv
}
.s_button:hover,.b_button:hover{opacity:0.7;}

.icon1::before {
    content: "▼ ";
}
.icon2::before {
    content: "▲ ";
}
.icon1::after {
    content: "表示 ▼";
}
.icon2::after {
    content: "閉じる ▲";
}
#box{
font-size:18px; width:500px; text-align:center; font-weight:bold; line-height:2.0em; border-top:1px dotted #ccc;  border-bottom:1px dotted #cccccc; position: relative; top:0px; left:20px; color:#ffc0cb;
}
fieldset {
	margin:50px auto; 
	padding: 10px 20px 15px;
	border: 5px #666666 double;
	background-color:#f5f5f5;
	font-weight:bold;
	width:280px;
	z-index:100;
}

.textarea{width:100%; height:15px; padding:0 0; margin:0 0;}
.ta_title{width:100%; display:flex;justify-content:space-around; margin:10px auto 5px auto;}
.ta_title p{width:70px;}
.form_textarea{width:80px; height:1820px; overflow: hidden;}















ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
 
/* remember to define focus styles! */
:focus {
	outline: 0;
}
 
/* remember to highlight inserts somehow! */
ins {
	text-decoration: none;
}
del {
	text-decoration: line-through;
}
 
/* tables still need 'cellspacing=&quot;0&quot;' in the markup */
table {
	border-collapse: collapse;
	border-spacing: 0;
}

.font_red{
color:red; /*font-weight:bold;*/ line-height:2em;
}
			


#cont{
	width:100%;

}

#link_cont{
	line-height:2.0em; 
	text-align:left;
	font-size:20px; 
	font-weight:bold; 
	width:1400px; 
	border:1px dotted #666666; 
	padding:15px; 
	margin:50px auto; 
	background-color:#f5f5f5;
}
#link_cont a:link { color: blue; }
#link_cont a:visited { color: red; }
#link_cont a:hover { color: #ff0000; }
#link_cont a:active { color: #ff8000; }

.link_cont_left{
	width:600px; 
	padding:15px; 
	float:left; 
	margin-right:20px;
}
.link_cont_right{
	width:640px; 
	padding:15px; 
	float:right;
}
.link_cont_title{
	width:600px; 
	background-color:#000000; 
	color:#ffffff; 
	text-align:center; 
	line-hegiht:1.5em; 
	margin-bottom:10px;
}







.block{
	width:2236px;
	font-size:10px;
	margin:30px auto;
	text-align:left;
}
.block2{
	border-bottom:1px dotted #ccc;
	width:2237px; 
	float:left;
	font-size:10px;
	text-align:left;
	/*background-color:red;*/
}
.block3{
	width:2237px; 
	float:left;
	font-size:20px;
	line-height:2.0em;
	color:red;
	font-weight:bold;
	margin-left:10px;
	text-align:left;
	/*background-color:red;*/
}


.t_id,
.t_raku1,
.t_yahoo{
	width:100px;
	float:left;
	background-color:#000000;
	border-right:1px dotted #ccc;
	line-height:2.0em;
	color:#ffffff;
}

.t_id_com,
.t_raku1_com,
.t_yahoo_com{
	width:100px;
	float:left;
	background-color:#ffffff;
	line-height:2.0em;
	border-right:1px dotted #ccc;
	/*border-bottom:1px dotted #ccc;*/

}



.t_raku3{
	width:445px;
	float:left;
	background-color:#000000;
	border-right:1px dotted #ccc;
	line-height:2.0em;
	color:#ffffff;
}

.t_info{
	width:510px;
	float:left;
	background-color:#000000;
	line-height:2.0em;
	border-right:1px dotted #ccc;
	/*border-left:1px dotted #ccc;*/
	color:#ffffff;
}

.t_janle{
	width:975px;
	float:left;
	background-color:#000000;
	line-height:2.0em;
	border-right:1px dotted #ccc;
	/*border-left:1px dotted #ccc;*/
	color:#ffffff;
}

.t_janle_com{
	width:975px;
	float:left;
	background-color:#ffffff;
	line-height:2.0em;
	border-right:1px dotted #ccc;
	font-size:11px;
	/*border-left:1px dotted #ccc;*/
	/*border-bottom:1px dotted #ccc;*/
}


.t_raku2_com{
	width:445px;
	float:left;
	background-color:#ffffff;
	line-height:2.0em;
	border-right:1px dotted #ccc;
	/*border-bottom:1px dotted #ccc;*/

}

.t_info_com{
	width:510px;
	float:left;
	background-color:#ffffff;
	line-height:2.0em;
	border-right:1px dotted #ccc;
	/*border-left:1px dotted #ccc;*/
	/*border-bottom:1px dotted #ccc;*/
}





/* ↓　背景を赤くする為だけのクラス　↓ */
		.t_janle_red{
			width:975px;
			float:left;
			line-height:2.0em;
			border-right:1px dotted #ccc;
			background-color:red;
		}

		.t_id_com_red,
		.t_raku1_com_red{
			width:100px;
			float:left;
			line-height:2.0em;
			border-right:1px dotted #ccc;
			background-color:red;

		}


		.t_info_com_red{
			width:510px;
			float:left;
			line-height:2.0em;
			border-right:1px dotted #ccc;
			background-color:red;
		}

		.t_janle_com_red{
			width:975px;
			float:left;
			line-height:2.0em;
			border-right:1px dotted #ccc;
			background-color:red;
		}

/* ↑　背景を赤くする為だけのクラス　↑ */


		#loader-bg {
		  display: none;
		  position: fixed;
		  width: 100%;
		  height: 100%;
		  top: 0px;
		  left: 0px;
		  background: #000;
		  z-index: 150;
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
		  z-index: 150;
		}


#form,
#preview,
#sorce{
	
		/*width:1290px;*/
		width:1527px;
		text-decoration:none;
		margin:0 auto;
		text-align:left;
		
		/*
		background-color:red;
		*/
	}

#form2{
	float:left;
	margin-left:55px;
	/*width:1250px; */
	width:1400px;
	/*border:1px solid #ccc; */
	/*padding:20px; */
	/*background-color:#f5f5f5;*/
}


#form3{
	width:1390px; 
	float:left; 
	/*background-color:blue;*/
}



.form_text{
	line-height:1.8em;
	font-size:13px;
	width:700px; 
	float:right;
	/*background-color:red;*/
}

.colred{
	color:red;
}

			
#box_cont{
width:100%; text-align:center; line-height:2.5em; color:#ffffff; background-color:#ffffff; font-size:30px; font-weight:bold; margin:50px 0;
}





</style>



		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
		<!--<script src="./js/jquery.typist.js"></script>-->
		<script type="text/javascript">


			
			// メッセージ表示の動きをカスタマイズする為のロジック
					$(function (){

						$("#box").animate({left:"100%",top:"0px"}, 700
						// 要素を移動させるロジックを差し込む
						, function(){ 
								$("#box").animate({left:"36%",top:"10px"}, 1000);
								$("#box").animate({left:"55%",top:"10px"}, 100);
								$("#box").animate({left:"36%",top:"10px"}, 100);
							// 文字表示ロジックの追記
								$(function (){
									$('#box')
									.typist({ speed: 12 })
									.typistPause(1000)
									.typistAdd('！！　CSV作成作業完了　！！')
									.typistPause(1000)
								});
						});
					});					

	
			  	/* 処理中の二度押し禁止 */
					/*var set=0;
					function double() {
					if(set==0){ set=1; } else {
					alert("只今処理中です。\nそのままお待ちください。");
					return false; }}	*/		
		
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

					function over_col2(){

						var target = document.getElementById('submit');
						target.style.backgroundColor = "#000000";
						/*target.style.color = "#666666";*/
						
					}

					function out_col2(){

						var target = document.getElementById('submit');
						target.style.backgroundColor = "#FF3333";
						target.style.color = "#ffffff";
						
					}		
					
					
			// 手順・注意ポップアップ表示用
					function myopen1()
					{ 
					window.open("./inc/window.php","A","width=1500, height=780, menubar=no, toolbar=no, scrollbars=yes");

	
					} 

					







    // メニュー開閉  
		jQuery(document).ready(function(){
    		jQuery('.down').css('display','none');
			jQuery('.btn_bulldown_').on("click",function(){
				// メニュー開閉  
				var t=jQuery(this).next(".down");	
				jQuery(t).stop().slideToggle();
				// 矢印の方向変更
				$(this).toggleClass('icon2');
			})
		})







</script>

	</head>

	
<body>

	<div>
		<div id="loader-bg">
		<div id="loader">
			<img src="./img/img-loading.gif" width="200" height="100" alt="Now Loading..." />
			<p>Now Loading...</p>
		</div>
		</div>

		<div>

		<div class="title">&nbsp;&nbsp;&nbsp;OP 新規商品アップ用 CSV 作成ツール</div>
		<!--<div class="title">&nbsp;&nbsp;&nbsp;テスト OP 新規商品アップ用 CSV 作成ツール</div>-->
			<div style="width:100%; margin:0 auto;">
					@if(empty($create))
					
							<div class="btn_bulldown_ icon1">操作手順 ・ 注意事項を</div>
            				<div class="down">
									<div style="width:95%; margin:0 auto; text-align:left; display:flex;justify-content:center;">
									<div style="width:40%; background:#f5f5f5; margin:30px 15px; padding:10px 10px;">
										<span style="font-weight:bold; background-color:#000000; color:#ffffff; padding:2px 5px;">注意事項</span><br><br>
										&nbsp;&nbsp;&nbsp;[ 使用のタイミングについて ]<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">※&nbsp;画像情報が必要なので、画像のアップロード作業後に使用</span><br>
										&nbsp;&nbsp;&nbsp;[ ジャンルの前提について ]<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">※&nbsp;「ベティー」or「ジャック」は「登録サイト」(site_id)で判断している</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">※&nbsp;<font color="red">ジャックサイトはジャックのみに掲載、ベティーサイト(両方サイト含む)は両サイトに掲載し、</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;その場合のジャック側ジャンルは「ブランド名」「ブランド名　レディース」となる</font></span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;ただし、「ブランド基準ジャンル」でサイズがメンズの場合は「ブランド名　レディース」には紐付かない</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">※&nbsp;既存の商品でも今後掲載する商品でもロジックで指定していない例外は多数あるはずなので、発見したら</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;その都度ロジック追記の依頼をする</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">※&nbsp;Jack掲載レディース商品（ ボーイズ・男女兼用含む ）は並び順を「100」とし、それ以外は「99」とする</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;（ジャンルの並び順）</span><br>
										&nbsp;&nbsp;&nbsp;[ 参照するデータの更新について ]<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">※&nbsp;ECビーイングから取得した「ジャンルCSV」と楽天・Yahooから取得した「モール用csv」を参照している</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;ので、データに変更や追加があった場合は申告しないと新しく追加された情報が反映されない</span><br>
										&nbsp;&nbsp;&nbsp;[ サイズについて ]<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">※&nbsp;サイズが空の場合は、サイトが「ベティー」であればレディース、「ジャック」であればメンズを自動で指定している</span><br>
										&nbsp;&nbsp;&nbsp;[ 楽天タグIDについて ]<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">※&nbsp;商品によっては参照している楽天の情報と一致する項目が1つも無い為、タグIDが空の場合もありえる</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（ アクセサリー等は空となる可能性が高い。楽天からDLし参照しているCSVに「その他」項目が存在</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;しない為、1つもあてはまらない商品の逃がし所が無い ）</span><br>
										<!--&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;（ もし今後、楽天側でタグIDが空だと弾かれる仕様になってしまった場合は、カラー項目がマルチカラーのIDを指定するなど、強引な方法で対応する予定 ）</span><br>-->
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">※&nbsp;CSVのダウンロードと同時に、取得したデータをページ下部に表示している。値が空である場合は背景が赤で</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;表示されるので必要であれば手動で追記する</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（ ブランドが「フォルティス」の場合も明確なルール付けが出来ないようなので、背景が赤で表示される。</span><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;その場合は、必要に応じて手動でCSVを直接修正 ）</span><br>
										
										<!--&nbsp;&nbsp;<span style="color:red; font-weight:bold;">※&nbsp;取得した情報はページ下部にも表示されるので、商品数が少数であればCSVを使用せず、それぞれコピペで対応できる</span><br><br>
										&nbsp;&nbsp;<span style="color:red; font-weight:bold;">※</span>&nbsp;ジャンル名、ブランド名、モデル名など、ECビーイングに登録されている複数の項目を元に一致する値を取得しており、商品登録が完成した状態でないと<br>&nbsp;&nbsp;正しい値が取得できないので、本作業は情報に不備の無い状態で最後に行う必要がある<br><br>
										&nbsp;&nbsp;<span style="color:red; font-weight:bold;">※</span>&nbsp;メンズ、レディースといったサイズの登録が抜けている場合は、サイトが「Betty」であればレディース、「Jack」であればメンズを自動で指定する<br>
										&nbsp;&nbsp;また、ボーイズで登録されている場合は男女兼用を自動で指定する<br><br>
										&nbsp;&nbsp;<span style="color:red; font-weight:bold;">※</span>&nbsp;商品によっては参照している楽天の情報と一致する項目が1つも無い為、タグIDが空の場合もありえる<br>
										&nbsp;&nbsp;（ベルトやアクセサリーは空となる可能性が高い。楽天からDLし参照しているCSVに「その他」の項目が存在しない為、1つもあてはまらない商品の逃がしどころが無い）<br>
										&nbsp;&nbsp;また、CSVのダウンロードと同時に、取得したデータをページ下部に表示してあり、値が空である場合は背景が赤で表示される<br>
										&nbsp;&nbsp;（もし今後、楽天側でタグIDが空だと弾かれる仕様になってしまった場合は、カラー項目がマルチカラーのIDを指定するなど、強引な方法で対応する予定）<br>-->
										</div>
										<div style="width:40%; background:#f5f5f5; margin:30px 15px; padding:10px 10px;">
										<span style="font-weight:bold; background-color:#000000; color:#ffffff; padding:2px 5px;">操作手順</span><br><br>
										&nbsp;&nbsp;<span class="font_red1"><b>1</b>.</span>&nbsp;「ID入力フォーム」に登録したいIDを入力し、ジャック商品の場合は「J順番」、ベティー商品の場合は「B順番」に商品IDと<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;紐付いた新入荷の並び順を入力（ 複数ある場合はエンターで改行刻み ）<br>
										&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;※&nbsp;<font color="red">新入荷に載せない場合は空欄にすれば「新入荷並び順CSV」に出力されない</font></span><br>
										&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;※&nbsp;フォームに入力できるIDの上限は100商品まで</span><br>
										&nbsp;&nbsp;<span class="font_red1"><b>2</b>.</span>&nbsp;「CSV出力」ボタンを押す<br>
										&nbsp;&nbsp;<span class="font_red">&nbsp;&nbsp;&nbsp;※&nbsp;上記手順を間違った場合は、最初からやりなおせば作成されたCSVは上書きされるので問題ない</span><br>
										&nbsp;&nbsp;<span class="font_red1"><b>3</b>.</span>&nbsp;「全CSVをまとめてダウンロード」を右クリックし、ローカルに保存したZipを解凍して使用<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（ 一部のみ使用する場合は個別にダウンロード ）<br>
										&nbsp;&nbsp;<span class="font_red1"><b>4</b>.</span>&nbsp;取得したCSVファイルをECビーイングへアップロード（ ↓以下、各CSVの取込先 ）<br><br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;■モール情報用CSV （ all_morl_id.csv ）<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; データ管理　→　商品モール拡張情報インポート　→　ファイル選択　→　取込<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;■画像紐付け用CSV （ all_img_up.csv ）<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; データ管理　→　商品インポート　→　商品画像をチェック　→　ファイル選択　→　取込<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;■ジャンルコード用CSV （ all_genre_goods.csv ）<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; データ管理　→　ジャンルインポート　→　ジャンル商品をチェック　→　ファイル選択　→　取込<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;■Jack新入荷用CSV （ all_jack_new_order.csv ）※存在する場合のみ<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; データ管理　→　イベントインポート　→　イベント商品にチェック　→　ファイル選択　→　取込<br><br>
										&nbsp;&nbsp;<span class="font_red1"><b>5</b>.</span>&nbsp;正しく上書きされたかを確認<br><br>
										</div>


									</div>
									&nbsp;&nbsp;&nbsp;&nbsp;<div style="margin:30px 0 0 80px; color:blue; font-size:17px; font-weight:bold;">※&nbsp;登録内容などに不備があったり、ロジック追加漏れがあると出力内容に間違いが発生するので、作業後の内容チェックは必須</div><br>


							</div>

					@endif
					<!--<form action="/laravel/op_create_new" method="POST" onSubmit="return double()" name="prid">-->
					<form action="/op_create_new" method="POST" onSubmit="return double()" name="prid">
						{{ csrf_field() }}
						<div style="width:80%; display:flex;justify-content:space-between; margin:0 auto;">
							@if(empty($create))
								<fieldset>
									<legend class="form_font">&nbsp;[ ID入力フォーム ]&nbsp;</legend>
									
									<div class="ta_title"><p>商品ID</p><p>J順番</p><p>B順番</p></div>
									<textarea name="pid" id="pid" class="form_textarea" wrap="physical"></textarea>
									<textarea name="pid2" id="pid2" class="form_textarea" wrap="physical"></textarea>
									<textarea name="pid3" id="pid3" class="form_textarea" wrap="physical"></textarea>
									<br><br>
								</fieldset>
							@endif

							@if(empty($create))
								<input type = "submit" class="b_button" onmouseover="over_col2()" onmouseout="out_col2()" id="create" name="create" value="CSV作成">
							@endif
						</div>

			</div>
					
			
		</div>
		

		@if(isset($create))
			<div style="width:100%; padding:10px 0;">
				<div id="box"></div>
			</div>
			<div style="background:#000000; color:#ffffff; width:60%;margin:30px auto 0 auto; padding:5px 0; font-weight:bold; font-size:16px;">ダウンロードファイル一覧</div>
			<div style="background:#f5f5f5; width:60%; display:flex;justify-content:space-between; flex-wrap: wrap; margin:0 auto 50px auto;">
				@if(isset($csv_exists_flag7) && $csv_exists_flag7 == 'ON')<input type = "submit" class="s_button" id="dl1" name="dl1" value="モールID用CSV">@endif
				@if(isset($csv_exists_flag8) && $csv_exists_flag8 == 'ON')<input type = "submit" class="s_button" id="dl2" name="dl2" value="商品在庫モール拡張情報用CSV">@endif
				@if(isset($csv_exists_flag9) && $csv_exists_flag9 == 'ON')<input type = "submit" class="s_button" id="dl3" name="dl3" value="ジャンルコード用CSV">@endif
				@if(isset($csv_exists_flag1) && $csv_exists_flag1 == 'ON')<input type = "submit" class="s_button" id="dl4" name="dl4" value="ジャック新入荷並び順用CSV">@endif
				@if(isset($csv_exists_flag2) && $csv_exists_flag2 == 'ON')<input type = "submit" class="s_button" id="dl5" name="dl5" value="ベティー新入荷並び順用CSV">@endif
				@if(isset($csv_exists_flag3) && $csv_exists_flag3 == 'ON')
				<!--20231228<input type = "submit" class="s_button" id="dl6" name="dl6" value="ジャック商品ページおすすめ商品表示用CSV">-->
				<input type = "submit" class="s_button" id="dl6" name="dl6" value="関連商品用CSV">
				@endif
				@if(isset($csv_exists_flag4) && $csv_exists_flag4 == 'ON')<input type = "submit" class="s_button" id="dl8" name="dl8" value="商品コメント追加CSV">@endif
				<input type = "submit" class="s_button" id="dl7" name="dl7" value="画像紐付け用CSV">
				<!-- 【 new_logic26 】20210714追加 -->
				@if(isset($csv_exists_flag5) && $csv_exists_flag5 == 'ON')<input type = "submit" class="s_button" id="dl9" name="dl9" value="注文明細拡張用CSV">@endif
				<!-- 【 new_logic27 】20220825追加 -->
				@if(isset($csv_exists_flag6) && $csv_exists_flag6 == 'ON')<input type = "submit" class="s_button" id="dl10" name="dl10" value="イベント登録用CSV">@endif
				<!-- 【 new_logic26 】20210714変更 -->
				<!--<input type = "submit" class="s_button s_button2" id="dl9" name="dl9" value="全CSVをまとめてダウンロード">-->
				<input type = "submit" class="s_button s_button2" id="dlzip" name="dlzip" value="全CSVをまとめてダウンロード">
			</div>
			<div style="width:100%; margin:0 auto;">
				@if(isset($preview_data)){!! $preview_data !!}@endif
			</div>
			<p><a href='' style="padding:20px 0; font-size:20px;">◀ 最初の画面に戻る</a></p>

		@endif
		</form>



	</div>
</body>
