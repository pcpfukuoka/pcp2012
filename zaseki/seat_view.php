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
		$sql = "select attendance_class_seq, attendance_class_name from attendance_class";
		$res = mysql_query($sql);
?>
			<select name="class" >
<?php
			while($gyo = mysql_fetch_array($res))
			{
?>
				<option value=<?= $gyo['attendance_class_seq']?>> <?=  $gyo['attendance_class_name']?></option>
<?php
			}
?>
			</select>
			<input type = "submit" value = "座席表">
		</form>
	</body>
</html>