<?php
	$row_max = $_POST['row_max'];
	$col_max = $_POST['col_max'];
	$group = $_POST['group'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//文字コード設定
	mysql_query("SET NAMES UTF8");
?>

<html>
	<head>
		<title>user_select</title>
		<script src="../sp/js/jquery-1.8.2.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
	<div id="container">
	<div align="center">
		<font class="Cubicfont">登録確認画面</font>
	</div>
	<hr color="blue">
<?php

	$user_cnt = 0;
	while($_POST['user'][$user_cnt])
	{
		$user_seq[$user_cnt] = $_POST['user'][$user_cnt];
		$user_cnt++;
	}
?>

	<form action="seat_register_add.php" method="POST">
	<table class="table_01">
<?php
	for($row = 1; $row <= $row_max; $row++)
	{
?>
		<tr>
<?php
		$seat_id = $row - 1;
		for($col = 1; $col <= $col_max; $col++)
		{
			$user_name ="";

			if($user_seq[$seat_id] != "")
			{
				$sql = "select user_name from m_user where user_seq = '$user_seq[$seat_id]'";
				$res = mysql_query($sql);
				$gyo = mysql_fetch_array($res);
				$user_name = $gyo['user_name'];
			}
?>
			<td id="<?=$seat_id?>" class='seat'>
			<p><?= $user_name ?></p>
			<input name = user_seq<?= $row?>[<?= $col?>] type="hidden" value = "<?= $user_seq[$seat_id] ?>">
			<input type="hidden" value="">
			</td>
<?php
			$seat_id = $seat_id + $row_max;
		}
?>
		</tr>
<?php
	}
?>
	</table>

	<input name="row_max" type="hidden" value= "<?= $row_max ?>">
	<input name="col_max" type="hidden" value= "<?= $col_max ?>">
	<input name= "group" type="hidden" value= "<?= $group ?>">
	<input type="submit" value="登録">
	</body>
</html>