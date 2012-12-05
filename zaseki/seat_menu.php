
<?php
	//session_start();

	//$user = $_SESSION['login_info[user]'];
	$user = 11;
?>
<html>
	<head>
		<title>seat_list</title>
	</head>
<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

	//文字コード設定
	mysql_query("SET NAMES UTF8");


?>
	<body>
		<form action="seat_view2.php" method="POST">
<?php
		$sql = "select m_group.group_name,m_group.group_seq
					from m_group,group_details
						where group_details.user_seq = '$user'
							and	 m_group.group_seq = group_details.group_seq";
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
						where group_details.user_seq = '$user'
							and	 m_group.group_seq = group_details.group_seq";
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
	</body>
</html>