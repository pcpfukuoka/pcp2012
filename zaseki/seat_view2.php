<html>
	<head>
		<title>座席表</title>
		<meta charset=UTF-8">
	</head>
	<body>


	<table border = 1  cellspacing="10">

<?php
	$url = "105-pc";
	$user = "root";
	$pass = "";
	$db = "pcp2012";

	//mysqlに接続する
	$link = mysql_connect($url,$user,$pass) or die("MySQLへの接続に失敗しました。");

	//データベースを選択する
	$sdb = mysql_select_db($db,$link)or die("データベースの選択に失敗しました。");

	//文字コード設定
	mysql_query("SET NAMES UTF8");


?>

<?php

	$class = $_POST['class'];
	$sql = "select max(row) as mx from seat where attendance_class_seq='$class'";
	$res = mysql_query($sql);
	$gyo = mysql_fetch_assoc($res);
	$row_max = $gyo['mx'];


	$sql = "select max(col) as mx from seat where attendance_class_seq ='$class'";
	$res = mysql_query($sql);
	$gyo = mysql_fetch_assoc($res);
	$col_max = $gyo['mx'];


		for($row = 1; $row <= $row_max; $row++)
		{
			echo "<tr>";

			for($col = 1; $col <= $col_max; $col++)
			{
				$sql = "select user_seq from seat where attendance_class_seq ='$class' and row='$row'and col='$col'";

				$res = mysql_query($sql);
				$gyo = mysql_fetch_assoc($res);
				$user_seq = $gyo['user_seq'];


						if($user_seq == "")
						{
							echo "<td class='sample'width='100'></td>";
						}
						else
						{
							$sql = "select user_name from m_user where  user_seq='$user_seq'";
							$res = mysql_query($sql);
							$gyo = mysql_fetch_array($res);
							$user_name = $gyo['user_name'];
							echo "<td class='sample'width='100'> $user_name</td>";
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