<?php
	$class = $_POST['class'];
	$row = $_POST['row'];
	$col = $_POST['col'];
?>

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
	for($i = 1; $i <= $row; $i++)
	{
		for($j = 1; $j <= $col; $j++)
		{
			$sql = "insert into seat values('$class','$i','$j','')";
		}
	}
	mysql_query($sql,$link)or die("クエリの送信に失敗しました。");
