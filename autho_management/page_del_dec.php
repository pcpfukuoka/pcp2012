<?php
/***************************
 * ページ削除確定画面
 * 
 * 消したいページのdelete_flgに
 * '1'をUPDATEする
 ***************************/
require_once("../lib/dbconect.php");
$link = DbConnect();

$sql = "SELECT page_seq FROM m_page WHERE delete_flg != 1;";
$result = mysql_query($sql);

$page_count = mysql_num_rows($result);

$i = 0;
$del_data = "del_data".$i;
while (isset($_POST[$del_data]))
{
	$page_seq = $_POST[$del_data];
	$sql = "UPDATE m_page SET delete_flg = 1 WHERE page_seq = '$page_seq';";
	mysql_query($sql);
	$i++;
	$del_data = "del_data".$i;
}
	

Dbdissconnect($link);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>ページ削除確定</title>
	</head>
	
	<body>
		<div align = "center">
			<font size = "6">ページ削除確定画面</font><hr>
		</div><br><br>
		
		ページを削除しました。
		<a href="autho_main.php">トップへ戻る</a>
	</body>
</html>