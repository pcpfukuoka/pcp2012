<!-- 未完成 -->


<html>
	<head>
		<title>change</title>
	</head>
	<body>
	<table>
	<?php
	$url = "105-pc";
	$user = "root";
	$pass = "";
	$db = "sample";

	//mysqlに接続する
	$link = mysql_connect($url,$user,$pass) or die("MySQLへの接続に失敗しました。");

	//データベースを選択する
	$sdb = mysql_select_db($db,$link)or die("データベースの選択に失敗しました。");

	//文字コード設定
	mysql_query("SET NAMES UTF8");

	//クエリを送信する
	$sql = "SELECT * FROM seat";
	$result = mysql_query($sql,$link)or die("クエリの送信に失敗しました。");
?>

<?php

		$class = 1;
		$sql = " SELECT * FROM seat ORDER BY rand()";





?>
	</table>
	</body>
</html>
