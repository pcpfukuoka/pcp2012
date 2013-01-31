<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

	$group = $_POST['group'];

?>

<html>
	<head>
		<title>時間割表作成画面</title>
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
		<font class="Cubicfont">時間割表作成画面</font>
	</div>
	<hr color="blue">
	<form action="TimeTable_register_perform.php" method="POST">
	<table border="1">
		<tr>
			<td></td>
			<td><input name = "time_table0[0]" type = "hidden" value="月">月</td>
			<td><input name = "time_table0[1]" type = "hidden" value="火">火</td>
			<td><input name = "time_table0[2]" type = "hidden" value="水">水</td>
			<td><input name = "time_table0[3]" type = "hidden" value="木">木</td>
			<td><input name = "time_table0[4]" type = "hidden" value="金">金</td>
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
	<input name= "group" type="hidden" value= "<?= $group ?>">
	<input type="submit" value="作成">
	</form>
</html>