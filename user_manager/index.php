<?php
	session_start();
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<script src="../javascript/frame_jump.js"></script>
	</head>
	<body>
		<img class="bg" src="../../images/blue-big.jpg" alt="" />
		<div id="container">
			<h1>ユーザ管理</h1>
			<li><input class="button1" type="button" onclick="jump('list.php')" value="ユーザ一覧"></li>
			<li><input class="button1" type="button" onclick="jump('regist_view.php')" value="新規登録"></li>
		</div>
	</body>
</html>
