<?php
	session_start();
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 9);


	if($page_cla[0]['read_flg'] == 0)
	{
		header("Location:../top_left.php");
	}
?>

<html>
	<head>
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
				<font class="Cubicfont">授業（仮）</font>
			</div>
			<hr color="blue"></hr>
			<br><br><br>
			<p align="center">
				<input type="button" onclick="jump('lesson/past_lesson.php','right')" value="過去の授業">
				<br><br>

				<!-- 生徒用の画面 -->
				<input type="button" onclick="jump('lesson/now_lesson.php','right')" value="現在の授業">
				<br><br>

				<!-- 先生用の画面 -->
				<input type="button" onclick="jump('lesson/lesson.php','right')" value="授業開始">
				<br><br>
				<input type="button" onclick="jump('lesson/lesson_preparation.php','right')" value="授業準備">

			</p>
		</div>
	</body>
</html>
