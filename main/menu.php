<?php
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- フレーム上部分のメニュー -->
<html>
<head>

	<META http-equiv="Content-Style-Type" content="text/css">
	<link rel="STYLESHEET"  href="../css/frame.css" type="text/css">
	<script src="../javascript/frame_jump.js"></script>
	<script src="../jquery-1.8.2.min.js"></script>
	<script src="../javascript/index_menu.js"></script>
	<meta http-equiv="Content-Type" content="text/php; charset=UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script src="../jquery.li-scroller.1.0.js"></script>
	<!-- <link rel="STYLESHEET"  href="../li-scroller.css" type="text/css">-->
	<link rel="STYLESHEET"  href="../frame_top_css.css" type="text/css">




	<title>メニュー一覧</title>
</head>

<body>
	<div align="right">
		<font size="2" >ようこそ<u><!--<?= $_SESSION['login_info[user_name]'] ?>--></u>さん</font>
	</div>


	<!-- テロップ形式で表示する内容（中身：ＤＢから、個数：foreach文？） -->
	<ul id="ticker01">
    	<li><span>１時間目</span><a href="#">美術</a></li>
    	<li><span>２時間目</span><a href="#">道徳</a></li>

    	<!-- eccetera -->
	</ul>
	<script>
	$(function(){
		console.log("テロップ");
		$("ul#ticker01").liScroll();
	})();
	</script>



	<div align="center" class="button">
		<!-- クリックしてＵＲＬ変更の関数呼び出し（引数：ＵＲＬ、表示位置） -->
		<input type="button" onclick="jump_top()"value="ＴＯＰ">
		<input type="button" onclick="jump()" value="スケジュール">
		<input type="button" onclick="jump('../contactbook/main.php' , 'left')" value="連絡帳">
		<input type="button" onclick="jump_class()" value="授業">
		<input type="button" onclick="jump('../autho_management/jump.php' , 'left')" value="成績確認">

		<!--  下記より先生のみ -->
		<input type="button" onclick="jump('../autho_management/autho_main.php','left')" value="権限管理">
		<input type="button" onclick="jump('../group/group_top.php', 'left')" value="グループ管理">
		<input type="button" onclick="jump('../user_manager/index.php', 'left')" value="ユーザー管理">
		<input type="button" onclick="jump()" value="成績管理">
		<input type="button" onclick="jump('../print_delivery/p_main.php','left')" value="プリント配信">
		<input type="button" onclick="jump()" value="アンケート">

	</div>
</body>
</html>