<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる

	$sql = "SELECT autho_seq, autho_name FROM m_autho WHERE delete_flg = 0;";
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);

	Dbdissconnect($dbcon);
?>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>グループ追加</title>
	</head>
	
	<body>
		<form action = "group_g_add_db.php" method = "POST">
		
			<div align = "center">
			
				<font size = "7">グループ追加</font>
				
				<hr color = "blue">
				<br>
				<br>
				
				<table border = "1" bordercolor = "black">
					<tr  bgcolor = "yellow" align = "center">
						<td>グループ名</td>
						<td>権限</td>
					</tr>

					<tr>
						<td>
							<input type="text" size="50" name = "new_group_name">
						</td>

						<td>
							<select name = "autho_select">
								<?php 
									for($i = 0; $i < $cnt; $i++)
									{
										$autho_row = mysql_fetch_array($result);
								?>
								<option value = "<?= $autho_row['autho_seq'] ?>"><?= $autho_row['autho_name'] ?></option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>
				</table>
				
				<input type = "submit" value = "登録" name = "g_entry">
			</div>
		</form>
	</body>
	
</html>
	
