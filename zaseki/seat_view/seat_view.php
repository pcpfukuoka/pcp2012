<html>
	<head>
		<title>座席構成</title>
<STYLE Type="text/css">


td.sample {
border: 2px #2b2b2b solid;
}

table.samplse2 {
margin-bottom: 20px;
border: 4px #2b2b2b solid;
border-collapse: separate;
empty-cells: hide;
text-align:justify;
text-justify:distribute-all-lines;
table-layout:fixed;"
}
</STYLE>
	</head>
	<body>

		<table cellspacing="10">

<?php
  $url = "105-pc";
  $user = "root";
  $pass = "";
  $db = "sample";

  // MySQLへ接続する
  $link = mysql_connect($url,$user,$pass) or die("MySQLへの接続に失敗しました。");

  // データベースを選択する
  $sdb = mysql_select_db($db,$link) or die("データベースの選択に失敗しました。");
  //文字コード設定
  mysql_query("SET NAMES UTF8");

  // クエリを送信する
  //$sql = "SELECT * FROM seat";
  //$result = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql);

  //結果セットの行数を取得する
  //$rows = mysql_num_rows($result);

$sql = "select max(outer_row) as mx from seat_config";
$res = mysql_query($sql);
$row = mysql_fetch_assoc($res);
$outer_row_max = $row['mx'];


$sql = "select max(outer_col) as mx from seat_config";
$res = mysql_query($sql);
$col = mysql_fetch_assoc($res);
$outer_col_max = $col['mx'];

// MySQLへの接続を閉じる
  //mysql_close($link) or die("MySQL切断に失敗しました。");

?>
<?php
	$room_no = 1;
	$class_no = 1;

		for($outer_row = 1; $outer_row <= $outer_row_max; $outer_row++)
		{
			echo "<tr>";

			for($outer_col = 1; $outer_col <= $outer_col_max; $outer_col++)
			{
				echo "<td  align='center'>";
				echo"<table class='sample2' >";

				$sql = "select max(inner_row) as mx from seat_config where room_no='$room_no' and outer_row='$outer_row' and outer_col='$outer_col'";
				$res = mysql_query($sql);
				$ret = mysql_fetch_assoc($res);
				$inner_row_max = $ret['mx'];
				$sql = "select max(inner_col) as mx from seat_config where room_no ='$room_no' and outer_row='$outer_row' and outer_col='$outer_col'";
				$res = mysql_query($sql);
				$ret = mysql_fetch_assoc($res);
				$inner_col_max = $ret['mx'];


				for($inner_row = 1; $inner_row <= $inner_row_max; $inner_row++)
				{
					echo "<tr>";

					for($inner_col = 1; $inner_col <= $inner_col_max; $inner_col++)
					{
						$sql = "select * from seat_config where room_no ='$room_no' and outer_row='$outer_row'"
							."and outer_col='$outer_col'and inner_row='$inner_row' and inner_col='$inner_col'";
						$res = mysql_query($sql);
						$ret = mysql_fetch_array($res);
						$seat_no = $ret['seat_no'];

						$sql = "select * from seat where room_no ='$room_no' and class_no = '$class_no' and seat_no = '$seat_no'";
						$res = mysql_query($sql);
						$ret = mysql_fetch_array($res);
						$attendance_no = $ret['attendance_no'];

						//$sql = "select * from name where class_no = '$class_no' and attendance_no = '$attendance_no' ";
						//$res = mysql_query($sql);
						//$ret = mysql_fetch_array($res);
						//$name = $ret['name'];

						$sql = "select * from seat_list where attendance_no = '$attendance_no'";
						$res = mysql_query($sql);
						$ret = mysql_fetch_array($res);
						$student_name = $ret['student_name'];

						if($seat_no == "")
						{
							echo "<td class='sample'width='100'></td>";
						}
						else
						{
							echo "<td class='sample'width='100'> $student_name</td>";
						}

					}
					echo "</tr>";
				}
				echo"</table>";
				echo "</td>";
			}
			echo "</tr>";
		}
?>
		</table>








	</body>
</html>