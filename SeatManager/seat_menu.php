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
		<title>seat_menu</title>
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
	<br>
	<div align="center">
	<table>
	<!-- 座席表表示ページへ -->
	<tr>
		<form action="seat_view.php" method="POST">
<?php
		$sql = "select distinct m_group.group_name,m_group.group_seq
					from m_group,group_details
						where m_group.group_seq = group_details.group_seq";
		$res = mysql_query($sql);
?>
		<td width="120px" height="20px" align="center" valign="middle">
			<select name="group" >
<?php
			while($gyo = mysql_fetch_array($res))
			{
				$group_seq = $gyo['group_seq'];
				$sql = "select seat_seq from seat where group_seq = '$group_seq'";
				$res1 = mysql_query($sql);
				$num = mysql_num_rows($res1);

				//座席表が登録されているクラスを表示
				if($num > 0)
				{
?>
					<option style="width:80px;"value=<?= $gyo['group_seq']?>> <?=  $gyo['group_name']?></option>
<?php
				}
			}
?>
			</select>
		</td>
		<td>
			<input type = "submit" value = "座席表" class="button4" >
		</td>
		</form>
	</tr>
	<!-- 席替えページへ -->
	<tr>
		<form action="seat_change.php" method="POST">
<?php
		$sql = "select distinct m_group.group_name,m_group.group_seq
					from m_group,group_details
						where m_group.group_seq = group_details.group_seq";
		$res = mysql_query($sql);
?>
		<td width="120px" height="20px" align="center" valign="middle">
			<select name="group" >
<?php
			while($gyo = mysql_fetch_array($res))
			{
				$group_seq = $gyo['group_seq'];
				$sql = "select seat_seq from seat where group_seq = '$group_seq'";
				$res1 = mysql_query($sql);
				$num = mysql_num_rows($res1);
				//座席表が登録されているクラスを表示
				if($num > 0)
				{
?>
					<option style="width:80px;" value=<?= $gyo['group_seq']?>> <?=  $gyo['group_name']?></option>
<?php
				}
			}
?>
			</select>
		</td>
		<td>
			<input type = "submit" value = "席替え" class="button4" >
		</td>
		</form>
	</tr>
	<!-- 削除ページへ -->
	<tr>
		<form action="seat_delete_check.php" method="POST">
<?php
		$sql = "select distinct m_group.group_name,m_group.group_seq
					from m_group,group_details
						where m_group.group_seq = group_details.group_seq";
		$res = mysql_query($sql);
?>
		<td width="120px" height="20px" align="center" valign="middle">
			<select name="group" >
<?php
			while($gyo = mysql_fetch_array($res))
			{
				$group_seq = $gyo['group_seq'];
				$sql = "select seat_seq from seat where group_seq = '$group_seq'";
				$res1 = mysql_query($sql);
				$num = mysql_num_rows($res1);

				//座席表が登録されているクラスを表示
				if($num > 0)
				{
?>
					<option style="width:80px;" value=<?= $gyo['group_seq']?>> <?=  $gyo['group_name']?></option>
<?php
				}
			}
?>
			</select>
		</td>
		<td>
			<input type = "submit" value = "削除" class="button4" >
		</td>
		</form>
	</tr>
	<!-- 登録ページへ -->
	<tr>
		<form action="seat_register_user_select.php" method="POST">
<?php
		$sql = "select distinct m_group.group_name,m_group.group_seq
					from m_group,group_details
						where m_group.group_seq = group_details.group_seq";
		$res = mysql_query($sql);
?>
		<td width="120px" height="20px" align="center" valign="middle">
			<select name="group" >
<?php
			while($gyo = mysql_fetch_array($res))
			{
				$group_seq = $gyo['group_seq'];
				$sql = "select seat_seq from seat where group_seq = '$group_seq'";
				$res1 = mysql_query($sql);
				$num = mysql_num_rows($res1);

				//座席表が登録されていないクラスを表示
				if($num == 0)
				{
?>
					<option style="width:80px;" value=<?= $gyo['group_seq']?>> <?=  $gyo['group_name']?></option>
<?php
				}
			}
?>
			</select>
		</td>
		<td>
			<input type = "submit" value = "登録" class="button4" >
		</td>
		</form>
	</tr>
	</table>
	</div>
	</body>
</html>