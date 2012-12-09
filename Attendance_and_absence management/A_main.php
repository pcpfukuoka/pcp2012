<?php
	//SESSIONでユーザIDの取得
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
	{
		//header("Location:login/index.php");
	}

	//page_seq = 6(座席管理)
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 6);


	if($page_cla[0]['read_flg'] == 0)
	{
		header("Location:../top_left.php");
	}
?>

<html>
	<head>
		<title>出欠管理</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/frame_jump.js"></script>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">出席管理</font>
			</div>

			<hr color="blue">
			<br><br>

			<p align="center">

				<!-- それぞれのリンク先に移動 -->
				<input class="button2" type="button" onclick="jump('A_search.php')" value="座席名簿">
				<br><br>
				<input class="button2" type="button" onclick="jump('A_list.php')" value="一覧">
				<br><br>

			</p>
		</div>
	</body>
</html>

