<?php

	$group = $_POST['group'];
	$row_max = $_POST['row_max'];
	$col_max = $_POST['col_max'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//文字コード設定
	mysql_query("SET NAMES UTF8");



?>
<html>
	<head>
		<title>seat_check</title>
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
		<font class="Cubicfont">席替え確認画面</font>
	</div>
	<hr color="blue">

		<form action='seat_change_update.php' method='POST'>
		<input name = "group" type = "hidden" value = "<?= $group ?>">
		<input name = "row_max" type = "hidden" value = "<?= $row_max ?>">
		<input name = "col_max" type = "hidden" value = "<?= $col_max ?>">

		<table class="table_01">
<?php
	//クエリを送信する
	for($row = 1; $row <= $row_max; $row++)
	{
?>
		<tr>
<?php
		for($col = 1; $col <= $col_max; $col++)
		{
?>
			<td>
<?php
			$user_seq = $_POST['user_seq'.$row][$col];
			$sql = "select user_name from m_user where user_seq = '$user_seq'";
			$result = mysql_query($sql);
			$gyo = mysql_fetch_array($result);


			//$user_seq = 100;
			echo $gyo['user_name'];
?>
			<input name = user_seq<?= $row?>[<?= $col?>] type="hidden" value = "<?= $user_seq ?>">

<?php

?>
			</td>
<?php
		}
?>
		</tr>
<?php
	}
?>
		</table>
		<input type="submit" value = "登録">
	</form>


	</body>
</html>
