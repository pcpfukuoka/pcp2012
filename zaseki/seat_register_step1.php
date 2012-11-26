<!-- 未完成 -->
<?php
	$url = "localhost";
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

<html>
	<head>
		<title>zaseki</title>
	</head>
	<body>
		<form action="seat_register_step2.php" method="POST">
		<table>

			<tr>
				<td>
				クラス
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

				</td>
			</tr>
			<tr>
				<td>
				横列
				</td>
				<td>
					<select name = "row">
					<option value = "1">1</option>
					<option value = "2">2</option>
					<option value = "3">3</option>
					<option value = "4">4</option>
					<option value = "5">5</option>
					<option value = "6">6</option>
					</select>
				</td>
			</tr>

			<tr>
				<td>
				縦列
				</td>
				<td>
					<select name = "col">
					<option value = "1">1</option>
					<option value = "2">2</option>
					<option value = "3">3</option>
					<option value = "4">4</option>
					<option value = "5">5</option>
					<option value = "6">6</option>
					</select>

				</td>
			</tr>

		</table>
		<input type="submit" value="変更">

		</form>
	</body>
</html>