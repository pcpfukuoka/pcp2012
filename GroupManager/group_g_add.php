<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる

	$sql = "SELECT autho_seq, autho_name FROM m_autho WHERE delete_flg = 0;";
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);

	Dbdissconnect($dbcon);
	if(isset($_GET['name_error']))
	{
		$group_name = $_GET['name_error'];
	}
?>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<title>グループ追加</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<form action = "group_g_add_db.php" method = "POST">

			<div align = "center">

				<font class="Cubicfont">グループ追加</font>

				<hr color = "blue">
				<br>
				<br>

				<?php
					if(isset($_GET['name_error']))
					{
				?>
				<p><font color="red">※その名前のグループは既に存在しています。</font></p>
				<?php
					}
				?>
				
				<table class="table_01">
					<tr>
						<th>グループ名</th>
						<th>クラスフラグ</th>
					</tr>

					<tr>
						<td>
							<?php
								if(isset($_GET['name_error']))
								{
							?>
							<input type="text" size="50" name = "new_group_name" value="<?= $group_name ?>">
							<?php
								}
								else
								{
							?>
							<input type="text" size="50" name = "new_group_name">
							<?php
								}
							?>
						</td>

						<td>
							<input type="checkbox" name = "class_flg" value = "1">
						</td>
					</tr>
				</table>
				<br>
				<input class="button4" type = "submit" value = "登録" name = "g_entry">
			</div>
		</form>
		</div>
	</body>
</html>