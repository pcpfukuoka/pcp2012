<?php
	session_start();
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
			<font class="Cubicfont">ユーザ管理</font>
		</div>
			<hr color="blue"></hr>
			<br><br><br>
			<p align="center">
				<input class="button2" type="button" onclick="jump('list.php')" value="ユーザ一覧">
				<br><br>
				<input class="button2" type="button" onclick="jump('regist_view.php')" value="新規登録">
			</p>
	</div>
	</body>
</html>
