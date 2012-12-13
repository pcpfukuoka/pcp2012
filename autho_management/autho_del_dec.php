<html>
	<head>
		<script src="../javascript/frame_jump.js"></script>	</head>
	<body>
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
<form action="autho_cmp.php" method="POST">
<input type="hidden" name="check" value="0">
</form>
	
	<?php 
	print "<script language=javascript>leftreload();</script>";
	print "<script language=javascript>jump('autho_cmp.php','right');</script>";
	
	?>
	</body>
</html>