<html>
	<head>
		<title>seat_list</title>
	</head>
<?php
	$url = "105-pc";
	$user = "root";
	$pass = "";
	$db = "pcp2012";

	//mysqlに接続する
	$link = mysql_connect($url,$user,$pass) or die("MySQLへの接続に失敗しました。");

	//データベースを選択する
	$sdb = mysql_select_db($db,$link)or die("データベースの選択に失敗しました。");

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