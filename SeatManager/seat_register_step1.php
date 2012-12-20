<!-- 未完成 -->
<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

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
				グループ
<?php
					$sql = "select group_name, group_seq from m_group";
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

				</td>
			</tr>
			<table>
				<tr><td>
					<table>
						<tr><th>横列</th></tr>
						<tr><td><input type = "radio" name = "row" value = "6">6</input></td></tr>
						<tr><td><input type = "radio" name = "row" value = "7">7</input></td></tr>
						<tr><td><input type = "radio" name = "row" value = "8">8</input></td></tr>
						<tr><td><input type = "radio" name = "row" value = "9">9</input></td></tr>
					</table>
				</td>
				<td>
					<table>
						<tr><th>縦列</th></tr>
						<tr><td><input type = "radio" name = "col" value = "6">6</input></td></tr>
						<tr><td><input type = "radio" name = "col" value = "7">7</input></td></tr>
						<tr><td><input type = "radio" name = "col" value = "8">8</input></td></tr>
						<tr><td><input type = "radio" name = "col" value = "9">9</input></td></tr>
					</table>
				</td></tr>
			</table>
		<input type="submit" value="座席表作成へ">

		</form>
	</body>
</html>