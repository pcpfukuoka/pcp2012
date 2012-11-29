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
	<h1>アンケート管理</h1>
	
	
	<input class="button2" type="button" onclick="jump('list.php')" value="アンケートリスト">
	<input class="button2" type="button" onclick="jump('regist_view.php')" value="新規登録">
	<input class="button2" type="button" onclick="jump('answer_list.php')" value="アンケート回答">
	</body>
</html>