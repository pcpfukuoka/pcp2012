<?php
session_start();
$user_seq = $_SESSION['login_info[user]'];

if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
{
	//header("Location:login/index.php");
}

//page_seq = 2(スケジュール)
require_once("../lib/autho.php");
$page_fun = new autho_class();
$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 2);


if($page_cla[0]['read_flg'] == 0)
{
	header("Location:../Top/top_left.php");
}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<script src="../javascript/frame_jump.js"></script>
		<meta http-equiv="Content-Style-Type" content="text/css">
	    <link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<script src="../javascript/frame_jump.js"></script>
		<title>カレンダーメイン</title>
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">スケジュール</font>
		</div>
		<hr color="blue">

		<br><br><br>
		<p  align="center">
			<input class="button2" type="button" onclick="jump('calendar.php')" value="カレンダー確認">
			<br><br>
			<input class="button2" type="button" onclick="jump('menu.php')" value="献立表確認">
			<br><br>
			<input class="button2" type="button" onclick="jump('../TimeTableManager/TimeTable_menu.php')" value="時間割">
		</p>


		</div>
	</body>
</html>