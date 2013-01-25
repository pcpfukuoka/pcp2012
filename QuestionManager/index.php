<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

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
		header("Location:../Top/top_left.php");
	}

	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	$day = date("Y-m-d");
	//表示用ユーザ情報取得
	$cnt = 0;
	$sql = "SELECT * FROM question
	WHERE question_seq
	NOT IN ( SELECT question_seq FROM question_awnser WHERE awnser_user_seq = '$user_seq' )
	AND '" . $day . "' BETWEEN start_date AND end_date";
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);
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

	<?php
		if($page_cla[3]['delivery_flg'] == 1)
		{
			?>
			<input class="button2" type="button" onclick="jump('regist_view.php')" value="新規登録">
			<?php
		}

	?>

	<input class="button2" type="button" onclick="jump('answer_list.php')" value="アンケート回答(<?= $cnt ?>>)">
	</body>
</html>