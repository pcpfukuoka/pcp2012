<?php
	$group = $_POST['group'];

?>

<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

	//クエリ用にデータを整形する
	for($time_cnt = 0; $time_cnt <= 6; $time_cnt++)
	{
		for($day_cnt = 0; $day_cnt < 5; $day_cnt++)
		{

			$time_table[$day_cnt][$time_cnt] = $_POST['time_table'.$time_cnt][$day_cnt];
		}
	}

	//確認用
	for($day_cnt = 0; $day_cnt < 5; $day_cnt++)
	{

		for($time_cnt = 0; $time_cnt <= 6; $time_cnt++)
		{
			//echo $time_table[$day_cnt][$time_cnt];
		}
		//echo"<br>";
	}

	//クエリを送信
	for($day_cnt = 0; $day_cnt < 5; $day_cnt++)
	{
			$sql = "insert into time_table
						values(0,'$group','{$time_table[$day_cnt][0]}',
										  '{$time_table[$day_cnt][1]}',
										  '{$time_table[$day_cnt][2]}',
										  '{$time_table[$day_cnt][3]}',
										  '{$time_table[$day_cnt][4]}',
										  '{$time_table[$day_cnt][5]}',
										  '{$time_table[$day_cnt][6]}')";

			//echo $sql;

			mysql_query($sql)or die("クエリの送信に失敗しました。");
	}


?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<META HTTP-EQUIV="Refresh" CONTENT="5;URL=TimeTable_menu.php">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />

		<title>完了画面</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">完了画面</font>
		</div>
		<hr color="blue">
		<font size = '5'>座席表の登録が完了しました！！</font>
		</div>


	</body>
</html>