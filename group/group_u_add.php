<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる

	$sql = "SELECT * FROM m_autho WHERE delete_flg = 0;";
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
		<form>
			<div align = "center">
				<p align = "center">
					<font size = "7">ユーザ追加</font>
				</p>
		
				<hr color = "blue">
				<br>
				<br>
				
				
				<table>
					<tr>
						<td>
							<input type = "text" size = "50" name = "serch_word">
						</td>
						<td>
							<input type = "submit" value = "検索" name = "serch_btn">
						</td>
					</tr>
				</table>
			</div>
			
		</form>

	</body>
</html>