<?php

	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
	{
		//header("Location:login/index.php");
	}

	//page_seq = 10(成績管理)
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 10);


	if($page_cla[0]['read_flg'] == 0)
	{
		header("Location:../Top/top_left.php");
	}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/frame_jump.js"></script>
		<title>成績管理メイン画面</title>
	</head>

	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont">成績管理</font><hr color="blue"><br><br><br>

			<p>
				<input class="button2" type="button" value="点数一覧"onclick="jump('list_search.php','right')">
				<br><br>
				<input class="button2" type="button" value="テスト・点数登録" onclick="jump('res_test.php?sub=-1','right')">
				<br><br>
				<input class="button2" type="button" value="教師・教科追加"onclick="jump('tea_subj_add.php','right')">
				<br><br>
				<input class="button2" type="button" value="教師・教科削除"onclick="jump('ts_del_add.php','right')">
				<br><br>
			</p>

		</div>

	</div>
	</body>
</html>
