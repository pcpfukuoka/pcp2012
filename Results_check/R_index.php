<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
	{
		//header("Location:login/index.php");
	}

	//page_seq = 5(成績確認)
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 5);

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
		<title>成績確認</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align = "center">
				<font class="Cubicfont">成績確認</font>
				<hr color="blue"><br><br><br>

				<input class="button2" type="button" value="成績確認（生徒）"onclick="jump('../ResultsManager/Per.ver.php','right')">
			</div>
		</div>
	</body>
</html>