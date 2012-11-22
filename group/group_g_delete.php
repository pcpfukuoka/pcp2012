<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる


	$d_group = $_GET['id'];
	//マスタのdelete_flgを更新
	$sql = "UPDATE m_group SET delete_flg = 1 WHERE group_seq = $d_group;";
	mysql_query($sql);
	//group_detailsのデータを削除
	$sql = "DELETE FROM group_details WHERE group_seq = '$d_group';";
	mysql_query($sql);

	Dbdissconnect($dbcon);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<title>削除完了</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<p>
				<font class="Cubicfont">削除完了</font>
			</p>
			<hr color = "blue">
			<font size="5">グループを削除しました。</font>
		</div>
		</div>
	</body>
</html>