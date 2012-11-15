<html>
	<head>
		<title>座席表</title>
	</head>
	<body>

	<form action="">


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
	$sql = "SELECT * FROM seat";
	$result = mysql_query($sql,$link)or die("クエリの送信に失敗しました。");
?>

<?php
	$class = 1;
	$sql = "select max(row) as mx from seat where class ='$class'";
	$res = mysql_query($sql);
	$ret = mysql_fetch_assoc($res);
	$row_max = $ret['mx'];


	$sql = "select max(col) as mx from seat where class ='$class'";
	$res = mysql_query($sql);
	$ret = mysql_fetch_assoc($res);
	$col_max = $ret['mx'];


		for($row = 1; $row <= $row_max; $row++)
		{
			echo "<tr>";

			for($col = 1; $col <= $col_max; $col++)
			{
				$sql = "select * from seat where  class ='$class' and row='$row'and col='$col'";
				$res = mysql_query($sql);
				$ret = mysql_fetch_array($res);
				$name = $ret['name'];
						if($name == "")
						{
							echo "<td class='sample'width='100'></td>";
						}
						else
						{
							echo "<td class='sample'width='100'> $name</td>";
						}

						echo "</td>";
			}
			echo "</tr>";
		}
			//mysqlへの接続を閉じる
	mysql_close($link)or die("mysql切断に失敗しました。");
?>
	</table>

</html>