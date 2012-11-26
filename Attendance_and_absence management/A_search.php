<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT group_seq, group_name
			FROM m_group
			WHERE class_flg = 1";
	$result = mysql_query($sql);

	$sql = "SELECT attendance_class_seq, attendance_class_name
			FROM attendance_class";
	$res = mysql_query($sql);

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<title>座席表</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	</head>

	<body>
		<div align="center">
			<font size = "7">座席表</font><br><br>
		</div>

		<hr color="blue">
		<br><br>

		<div align = "center">
			<form action="A_seating_list.php" method="POST">
				<select name="class" >
					<?php
						while($row = mysql_fetch_array($res))
						{
					?>
						<option value=<?= $row['attendance_class_seq']?>> <?=  $row['attendance_class_name']?></option>

					<?php
						}
					?>

				</select>

				<input type = "submit" value = "座席表">
			</form>
		</div>
	</body>
</html>