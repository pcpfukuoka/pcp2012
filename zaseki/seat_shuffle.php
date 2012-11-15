<html>
	<head>
		<title>change</title>
	</head>
	<body>
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
		$sql = "select * from seat where  class ='$class'";
		$res = mysql_query($sql);
		$ret = mysql_fetch_array($res);
		$attendance_no = $ret['attendance_no'];

		echo $attendance_no;


		$sql = "select * from seat where  class ='$class'";
		$res = mysql_query($sql);
		$ret = mysql_fetch_array($res);
		$name = $ret['name'];

		//shuffle
		//$numbers = range(1, 100);
		//shuffle($numbers);
		//foreach ($numbers as $number)

		//if($number == $seat_no)
		//{
			//echo "$name";
		//}


?>

	</body>
</html>
