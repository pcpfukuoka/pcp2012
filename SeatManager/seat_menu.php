<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

	//文字コード設定
	mysql_query("SET NAMES UTF8");
?>
<html>
	<head>
		<title>seat_list</title>

		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />

	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">座席表メニュー</font>
		</div>
		<hr color="blue">

		<form action="seat_view.php" method="POST">
<?php
		$sql = "select m_group.group_name,m_group.group_seq
					from m_group,group_details
						where m_group.group_seq = group_details.group_seq";
		$res = mysql_query($sql);
?>
			<select name="group" >
<?php
			while($gyo = mysql_fetch_array($res))
			{
?>
				<option value=<?= $gyo['group_seq']?>> <?=  $gyo['group_name']?></option>
<?php
			}
?>
			</select>
			<input type = "submit" value = "座席表">
		</form>
		<form action="seat_change.php" method="POST">
<?php
		$sql = "select m_group.group_name,m_group.group_seq
					from m_group,group_details
						where m_group.group_seq = group_details.group_seq";
		$res = mysql_query($sql);
?>
			<select name="group" >
<?php
			while($gyo = mysql_fetch_array($res))
			{
?>
				<option value=<?= $gyo['group_seq']?>> <?=  $gyo['group_name']?></option>
<?php
			}
?>
			</select>
			<input type = "submit" value = "席替え">
		</form>

		<form action="seat_delete_check.php" method="POST">
<?php
		$sql = "select m_group.group_name,m_group.group_seq
					from m_group,group_details
						where m_group.group_seq = group_details.group_seq";
		$res = mysql_query($sql);
?>
			<select name="group" >
<?php
			while($gyo = mysql_fetch_array($res))
			{
?>
				<option value=<?= $gyo['group_seq']?>> <?=  $gyo['group_name']?></option>
<?php
			}
?>
			</select>
			<input type = "submit" value = "削除">
		</form>

		<form action="seat_register_user_select.php" method="POST">
<?php
		$sql = "select m_group.group_name,m_group.group_seq
					from m_group,group_details
						where m_group.group_seq = group_details.group_seq";
		$res = mysql_query($sql);
?>
			<select name="group" >
<?php
			while($gyo = mysql_fetch_array($res))
			{
?>
				<option value=<?= $gyo['group_seq']?>> <?=  $gyo['group_name']?></option>
<?php
			}
?>
			</select>
			<input type = "submit" value = "登録">
		</form>

	</body>
</html>