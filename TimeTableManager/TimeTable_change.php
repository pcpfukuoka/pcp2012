<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

	$group = $_POST['group'];

?>

<html>
	<head>
		<title>時間割表変更画面</title>
		<meta charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
	<div id="container">
	<div align="center">
		<font class="Cubicfont">時間割表変更画面</font>
	</div>
	<hr color="blue">
<?php
	$sql = "select * from time_table where group_seq = '$group'";
	$res = mysql_query($sql);

	//データを表示用に整形
	while($gyo = mysql_fetch_array($res))
	{
		switch ($gyo['day']) {
			case "月":
				 $time_table[0][0] = $gyo['time_table_seq'];
      			 $time_table[1][0] = $gyo['one'];
      			 $time_table[2][0] = $gyo['two'];
      			 $time_table[3][0] = $gyo['three'];
      			 $time_table[4][0] = $gyo['four'];
      			 $time_table[5][0] = $gyo['five'];
      			 $time_table[6][0] = $gyo['six'];
      			 break;
			case "火":
			     $time_table[0][1] = $gyo['time_table_seq'];
      			 $time_table[1][1] = $gyo['one'];
      			 $time_table[2][1] = $gyo['two'];
      			 $time_table[3][1] = $gyo['three'];
      			 $time_table[4][1] = $gyo['four'];
      			 $time_table[5][1] = $gyo['five'];
      			 $time_table[6][1] = $gyo['six'];
      			 break;
			case "水":
				 $time_table[0][2] = $gyo['time_table_seq'];
      			 $time_table[1][2] = $gyo['one'];
      			 $time_table[2][2] = $gyo['two'];
      			 $time_table[3][2] = $gyo['three'];
      			 $time_table[4][2] = $gyo['four'];
      			 $time_table[5][2] = $gyo['five'];
      			 $time_table[6][2] = $gyo['six'];
      			 break;
			case "木":
				 $time_table[0][3] = $gyo['time_table_seq'];
      			 $time_table[1][3] = $gyo['one'];
      			 $time_table[2][3] = $gyo['two'];
      			 $time_table[3][3] = $gyo['three'];
      			 $time_table[4][3] = $gyo['four'];
      			 $time_table[5][3] = $gyo['five'];
      			 $time_table[6][3] = $gyo['six'];
      			 break;
			case "金":
				 $time_table[0][4] = $gyo['time_table_seq'];
      			 $time_table[1][4] = $gyo['one'];
      			 $time_table[2][4] = $gyo['two'];
      			 $time_table[3][4] = $gyo['three'];
      			 $time_table[4][4] = $gyo['four'];
      			 $time_table[5][4] = $gyo['five'];
      			 $time_table[6][4] = $gyo['six'];
      			 break;
		}
}
?>
	<form action="TimeTable_change_perform.php" method="POST">
	<table border="1">
		<tr>
			<td></td>
			<td><input name = "time_table0[0]" type = "hidden" value="<?=$time_table[0][0] ?>">月</td>
			<td><input name = "time_table0[1]" type = "hidden" value="<?=$time_table[0][1] ?>">火</td>
			<td><input name = "time_table0[2]" type = "hidden" value="<?=$time_table[0][2] ?>">水</td>
			<td><input name = "time_table0[3]" type = "hidden" value="<?=$time_table[0][3] ?>">木</td>
			<td><input name = "time_table0[4]" type = "hidden" value="<?=$time_table[0][4] ?>">金</td>
		</tr>
<?php
	for($time_cnt = 1;$time_cnt <= 6; $time_cnt++)
	{
?>
		<tr>
			<td><?= $time_cnt?></td>
<?php
		for($day_cnt = 1; $day_cnt <= 5; $day_cnt++)
		{
?>
			<td><input name = "time_table<?= $time_cnt?>[<?= $day_cnt-1?>]"type="text" value="<?= $time_table[$time_cnt][$day_cnt -1] ?>"></td>
<?php
		}

?>
		</tr>
<?php
	}
?>
	</table>

	<input type="submit" value="変更">
	</form>
</html>