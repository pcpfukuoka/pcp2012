<html>
	<head>
		<title>座席表</title>
	</head>
	<body>

<?php
	$row = $_POST['row'];
	$col = $_POST['col'];

	echo "行".$row;
	echo "列".$col;

	echo "人数".$count
?>
	<table border = 1  cellspacing="10">

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
	$sql = "SELECT * FROM seat_list";
	$result = mysql_query($sql,$link)or die("クエリの送信に失敗しました。");

	//結果セットの行数を取得する
	$count = mysql_num_rows($result);

	echo $count;

	$row;
	$col;

	for($i = 0; $i < $row;	$i++)
	{
		echo "<tr>"	;

		for($j = 0;	$j < $col;	$j++)
		{
			$gyo = mysql_fetch_array($result);

			$seat_no = $gyo['seat_no'];
			$student_name = $gyo['student_name'];

			echo "<td>$student_name</td>";
		}

		echo "</tr>";
	}

	//mysqlへの接続を閉じる
	mysql_close($link)or die("mysql切断に失敗しました。");
?>
	</table>
</html>