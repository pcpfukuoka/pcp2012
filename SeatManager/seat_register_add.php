
<?php

	$group = $_POST['group'];
	$row_max = $_POST['row_max'];
	$col_max = $_POST['col_max'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//文字コード設定
	mysql_query("SET NAMES UTF8");



		//クエリを送信する
	for($row = 1; $row <= $row_max; $row++)
	{
		for($col = 1; $col <= $col_max; $col++)
		{
			$user_seq = $_POST['user_seq'.$row][$col];
			$sql = "insert into seat values(0,'$group','$row','$col','$user_seq')";
			mysql_query($sql)or die("クエリの送信に失敗しました。");
		}
	}


?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<META HTTP-EQUIV="Refresh" CONTENT="5;URL=seat_menu.php">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />

		<title>完了画面</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">完了画面</font>
		</div>
		<hr color="blue">
		<div id="container">
		<font size = '5'>座席表の登録が完了しました！！</font>

	</body>
</html>