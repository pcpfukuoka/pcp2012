<?php
	$class = $_POST['class'];
	$row_max = $_POST['row_max'];
	$col_max = $_POST['col_max'];
?>

<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");



		//クエリを送信する
	for($row = 1; $row <= $row_max; $row++)
	{
		for($col = 1; $col <= $col_max; $col++)
		{

			$user_seq = $_POST['user_seq'.$row][$col];
			$sql = "update seat set user_seq = '$user_seq' where attendance_class_seq='$class' and row = '$row' and  col = '$col'";
			echo $sql;
			mysql_query($sql)or die("クエリの送信に失敗しました。");
		}
	}


?>