<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる


	$d_group = $_GET['dt'];
	$sql = "UPDATE m_group SET delete_flg = 1 WHERE group_seq = $d_group;";
	mysql_query($sql);

	Dbdissconnect($dbcon);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>削除完了</title>
	</head>
	
	<body>
		<div align = "center">
			<p>
				<font size = "7">削除完了</font>
			</p>
			<hr color = "blue">
			グループを削除しました。
		</div>
	</body>
</html>