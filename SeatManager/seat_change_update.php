<?php
	$group = $_POST['group'];
	$row_max = $_POST['row_max'];
	$col_max = $_POST['col_max'];
?>

<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");



		//クエリを送信する
	for($row = 1; $row <= $row_max; $row++)
	{
		for($col = 1; $col <= $col_max; $col++)
		{

			$user_seq = $_POST['user_seq'.$row][$col];
			$sql = "UPDATE seat SET user_seq = '$user_seq' WHERE group_seq='$group' AND row = '$row' AND  col = '$col'";

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
		<font size = '5'>席替えが完了しました！！</font>
		</div>


	</body>
</html>