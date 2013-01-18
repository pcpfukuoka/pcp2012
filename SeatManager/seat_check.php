
<?php

	$group = $_POST['group'];
	$row_max = $_POST['row_max'];
	$col_max = $_POST['col_max'];

	$check_flg = $_POST['check_flg'];	//０：席替え　１：登録
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//文字コード設定
	mysql_query("SET NAMES UTF8");



?>
<html>
	<head>
		<title>seat_check</title>
	</head>

	<body>
	<p>登録・変更確認画面</p>
<?php
	if($check_flg == 0)
	{
		echo "<form action='seat_change_update.php' method='POST'>";
	}
	else
	{
		echo "<form action='seat_register_add.php' method='POST'>";
	}
?>
		<input name = "group" type = "hidden" value = "<?= $group ?>">
		<input name = "row_max" type = "hidden" value = "<?= $row_max ?>">
		<input name = "col_max" type = "hidden" value = "<?= $col_max ?>">

		<table border = "1">
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
