<?php
	session_start();

	if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
	{
		//header("Location:login/index.php");
	}

	//page_seq = 12(アンケート)
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 12);

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
	<h1>アンケート管理</h1>

	<?php
		if($page_cla['delivery_flg'] == 1)
		{

	?>
			<input class="button2" type="button" onclick="jump('list.php')" value="アンケートリスト">
			<input class="button2" type="button" onclick="jump('regist_view.php')" value="新規登録">

	<?php
		}
	?>

			<input class="button2" type="button" onclick="jump('answer_list.php')" value="アンケート回答">
	</body>
</html>