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
		<title>時間割表メニュー</title>
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
				<font class="Cubicfont">時間割メニュー</font>
			</div>
		<hr color="blue">
	<br>
	<div align="center">
	<table>
	<!-- 時間割表示ページへ -->
	<tr>
		<form action="TimeTable_view.php" method="POST">
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
				$sql = "select time_table_seq from time_table where group_seq = '$group_seq'";
				$res1 = mysql_query($sql);
				$num = mysql_num_rows($res1);

				//時間割が登録されているクラスを表示
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
			<input type = "submit" value = "時間割表" class="button4" >
		</td>
		</form>
	</tr>
	<!-- 時間割表変更ページへ -->
	<tr>
		<form action="TimeTable_change.php" method="POST">
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
				$sql = "select time_table_seq from time_table where group_seq = '$group_seq'";
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
			<input type = "submit" value = "変更" class="button4" >
		</td>
		</form>
	</tr>
	<!-- 時間割削除ページへ -->
	<tr>
		<form action="TimeTable_delete_check.php" method="POST">
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
				$sql = "select time_table_seq from time_table where group_seq = '$group_seq'";
				$res1 = mysql_query($sql);
				$num = mysql_num_rows($res1);

				//時間割表が登録されているクラスを表示
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
	<!-- 時間割ページへ -->
	<tr>
		<form action="TimeTable_register.php" method="POST">
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
				$sql = "select * from time_table where group_seq = '$group_seq'";
				$res1 = mysql_query($sql);
				$num = mysql_num_rows($res1);

				//時間割が登録されていないクラスを表示
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