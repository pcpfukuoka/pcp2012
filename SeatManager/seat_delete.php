<?php
	$group = $_POST['group'];
?>

<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

	$sql = "delete from seat where group_seq = '$group'";

	echo $sql;
	mysql_query($sql)or die("クエリの送信に失敗しました。");
?>