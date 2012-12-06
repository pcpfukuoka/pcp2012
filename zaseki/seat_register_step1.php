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
		<input type="submit" value="座席表作成へ">

		</form>
	</body>
</html>