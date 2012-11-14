<?php
/************************************
 * 権限グループ削除確定画面
 * 
 * メイン画面で選択された権限グループの
 * delete_flgに'1'をUPDATEする
 ************************************/
session_start();
$autho_seq = $_SESSION['autho_sel'];

require_once("../lib/dbconect.php");
$link = DbConnect();

$sql = "UPDATE m_user SET autho_seq = 4 WHERE autho_seq = '$autho_seq';";
mysql_query($sql);

$sql = "UPDATE m_autho SET delete_flg = 1 WHERE autho_seq = '$autho_seq';";
mysql_query($sql);

Dbdissconnect($link);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<title>権限削除確定</title>
	</head>
	
	<body>
		<div align = "center">
			<font size = "6">権限削除確定画面</font><hr>
		</div><br><br>
		
		<font size="5">権限グループを削除しました。</font>
		<br><br>
		<a href="autho_main.php">トップへ戻る</a>
	</body>
</html>