<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../css/kajiwara.css" />
		<title>座席表</title>
		<meta charset=UTF-8">
	</head>
	<body>


	<table class="kajiwara"  cellspacing="10">

<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

?>

<?php

	$class = $_POST['group'];
	$sql = "select max(row) as mx from seat where group_seq='$class'";
	$res = mysql_query($sql);
	$gyo = mysql_fetch_assoc($res);
	$row_max = $gyo['mx'];


	$sql = "select max(col) as mx from seat where group_seq ='$class'";
	$res = mysql_query($sql);
	$gyo = mysql_fetch_assoc($res);
	$col_max = $gyo['mx'];


		for($row = 1; $row <= $row_max; $row++)
		{
			echo "<tr>";

			for($col = 1; $col <= $col_max; $col++)
			{
				$sql = "select user_seq from seat where group_seq ='$class' and row='$row'and col='$col'";

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

?>
	</table>

</html>