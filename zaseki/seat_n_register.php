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

	$class = 2;

	$sql = "select max(row) as mx from seat where class='$class'";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	$row_max = $row['mx'];
	echo $row_max;
	$sql = "select max(col) as mx from seat where class='$class'";
	$res = mysql_query($sql);
	$row = mysql_fetch_assoc($res);
	$col_max = $row['mx'];
?>

<html>
	<body>
	<form action="seat_n_register_add.php" method="POST">
		<table border="1">
<?php
	for($row = 1; $row <= $row_max; $row++)
	{
		echo "<tr>";
		for($col = 1; $col <= $col_max; $col++)
		{
			echo "<td>";
			echo "<input name="."student"."$row"."$col"."type=text>";
?>

<?php
			echo "</td>";


		}
		echo "</tr>";
	}

		echo "<input name=row_max type=hidden value=$row_max>";
		echo "<input name=col_max type=hidden value=$col_max>";
?>
		</table>

		<input type="submit" value="登録">
	</form>
	</body>