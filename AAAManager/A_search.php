<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT group_seq, group_name
			FROM m_group
			WHERE class_flg = 1 AND delete_flg = 0";
	$result = mysql_query($sql);

/*	$sql = "SELECT attendance_class_seq, attendance_class_name
			FROM attendance_class";
	$res = mysql_query($sql);
*/

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<title>座席表</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/frame_jump.js"></script>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">座席表</font>
			</div>

			<hr color="blue">
			<br><br>

			<div align = "center">
				<form action="A_seating_list.php" method="POST">
					<table>
						<tr>
							<td width = "100">
								<select name="group_seq">
									<?php
										while($row = mysql_fetch_array($result))
										{
									?>
										<option value=<?= $row['group_seq']?>> <?=  $row['group_name']?></option>

									<?php
										}
									?>

								</select>
							</td>

							<td><input class="button4" type = "submit" value = "座席表"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>