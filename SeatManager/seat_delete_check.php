<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

	$group = $_POST['group'];

?>
<html>
	<head>

		<title>座席表</title>
		<meta charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">削除確認画面</font>
		</div>
		<hr color="blue">

	<table class="table_01">

<?php



	$sql = "select max(row) as mx from seat where group_seq='$group'";
	$res = mysql_query($sql);
	$gyo = mysql_fetch_assoc($res);
	$row_max = $gyo['mx'];


	$sql = "select max(col) as mx from seat where group_seq ='$group'";
	$res = mysql_query($sql);
	$gyo = mysql_fetch_assoc($res);
	$col_max = $gyo['mx'];


		for($row = 1; $row <= $row_max; $row++)
		{
			echo "<tr>";

			for($col = 1; $col <= $col_max; $col++)
			{
				$sql = "select user_seq from seat where group_seq ='$group' and row='$row'and col='$col'";

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

	<form action="seat_delete.php" method="POST">
		<input class="button4" type="submit" value="削除">
		<input name="group" type="hidden" value="<?= $group ?>">
	</form>

	</body>
</html>