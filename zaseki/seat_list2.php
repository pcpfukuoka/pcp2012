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

?>
	<table>

<?php
	mysql_connect("105-pc","root","");
	mysql_select_db("sample");
	mysql_query("SET NAMES UTF8");

	$sql = "SELECT * FROM seat_list";
	$ret = mysql_query($sql);
	//$count = mysql_num_rows($ret);
	$count =mysql_num_rows($);
	$gyo = mysql_fetch_array($ret);

	//echo $count;


	for($i = 0; i < $count; $i++)
	{
			$seat_no = $gyo['seat_no'];
			$student_name = $gyo['student_name'];
			echo $seat_no;
			echo $student_name;
	}


	for($i = 0; $i < $row;	$i++)
	{
		echo "<tr>"	;

		for($j = 0;	$j < $col;	$j++)
		{


			echo "<td>$student_name</td>";
		}

		echo "</tr>";
	}
?>
	</table>
</html>