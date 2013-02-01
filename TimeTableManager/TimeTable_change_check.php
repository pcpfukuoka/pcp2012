<?php
	$group = $_POST['group'];

?>

<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

	for($time_cnt = 0; $time_cnt <= 6; $time_cnt++)
	{
		for($day_cnt = 0; $day_cnt < 5; $day_cnt++)
		{
			$time_table[$time_cnt][$day_cnt] = $_POST['time_table'.$time_cnt][$day_cnt];
		}
	}


?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/time_table.css" />

		<title>時間割表変更確認画面</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">時間割表変更確認画面</font>
		</div>
		<hr color="blue">

		<form action="TimeTable_change_perform.php" method="POST">
			<table class="time_table"border="1">
				<tr id="week">
					<td></td>
					<th><input name = "time_table0[0]" type = "hidden" value="<?=$time_table[0][0] ?>">月</th>
					<th><input name = "time_table0[1]" type = "hidden" value="<?=$time_table[0][1] ?>">火</th>
					<th><input name = "time_table0[2]" type = "hidden" value="<?=$time_table[0][2] ?>">水</th>
					<th><input name = "time_table0[3]" type = "hidden" value="<?=$time_table[0][3] ?>">木</th>
					<th><input name = "time_table0[4]" type = "hidden" value="<?=$time_table[0][4] ?>">金</th>
				</tr>
<?php
			for($time_cnt = 1;$time_cnt <= 6; $time_cnt++)
			{
?>
				<tr id="time">
					<th><?= $time_cnt?></th>
<?php
				for($day_cnt = 1; $day_cnt <= 5; $day_cnt++)
				{
?>
					<td>
						<input name = "time_table<?= $time_cnt?>[<?= $day_cnt-1?>]"type="hidden" value="<?= $time_table[$time_cnt][$day_cnt -1] ?>">
						<p><?= $time_table[$time_cnt][$day_cnt -1] ?></p>
					</td>
<?php
				}

?>
				</tr>
<?php
			}
?>
			</table>

			<input class="button4"type="submit" value="変更">
		</form>
		</div>
	</body>
</html>