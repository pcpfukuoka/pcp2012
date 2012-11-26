<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//ユーザのデータベースから名前を取得
	$sql = "SELECT attendance_seq, attendance.group_seq, attendance.user_seq, m_user.user_name AS user_name, date,
			       Attendance_flg, Absence_flg, Leaving_early_flg, Lateness_flg, Absence_due_to_mourning_flg
			FROM attendance
			LEFT JOIN m_user ON attendance.user_seq = m_user.user_seq
			LEFT JOIN m_group ON attendance.group_seq = m_group.group_seq
			WHERE attendance.user_seq = 1
			ORDER BY date";

	//echo $sql;

	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$count = mysql_num_rows($result);

	//データベースを閉じる
	Dbdissconnect($dbcon);

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>詳細</title>
	</head>

	<body>
		<div align="center">
			<font size="7">詳細</font>
			<br>
		</div>
		<br>
		<hr color="blue"><br>

		<div align = "center">
			<table border = "1">
				<tr bgcolor = "pink">
					<td align="center"width="150"><font size="5">名前</font></td>
				</tr>
				<tr>
					<td align="center"width="150"><font size = "5"><?= $row['user_name']?></font></td>
				</tr>
			</table>
		</div>
		<br><br>

		<div align="center">
			<table border="1">
				<tr bgcolor="yellow">
				<td align="center"width="120"><font size="5">日付</font></td>
				<td align="center"width="80"><font size="5">出席</font></td>
				<td align="center"width="80"><font size="5">欠席</font></td>
				<td align="center"width="80"><font size="5">早退</font></td>
				<td align="center"width="80"><font size="5">遅刻</font></td>
				<td align="center"width="80"><font size="5">忌引き</font></td>

				<?php
				for ($i = 0; $i < $count; $i++){
					if($i != 0)
					{
						$row = mysql_fetch_array($result);

					}
				?>
					<tr align="center">
						<td>2012/11/26</td>
						<?php
						// 出席データのチェック
						if ($row['Attendance_flg'] == 1)
						{
							// １の場合は最初にチェックを入れる
							echo '<td><input type="checkbox" name="a" checked></td>';
						}
						else
						{
							echo '<td><input type="checkbox" name="a"></td>';
						}

						if ($row['Absence_flg'] == 1)
						{
							echo '<td><input type="checkbox" name="b" checked></td>';
						}
						else
						{
							echo '<td><input type="checkbox" name="b" ></td>';
						}

						if ($row['Leaving_early_flg'] == 1)
						{
							echo '<td><input type="checkbox" name="c" checked></td>';
						}
						else
						{
							echo '<td><input type="checkbox" name="c" ></td>';
						}

						if ($row['Lateness_flg'] == 1)
						{
							echo '<td><input type="checkbox" name="d" checked></td>';
						}
						else
						{
							echo '<td><input type="checkbox" name="d" ></td>';
						}

						if ($row['Absence_due_to_mourning_flg'] == 1)
						{
							echo '<td><input type="checkbox" name="e" checked></td>';
						}
						else
						{
							echo '<td><input type="checkbox" name="e" ></td>';
						}
						?>
					</tr>
				<?php
				}
				?>

			</table>
			<hr>
		</div>



	</body>
</html>