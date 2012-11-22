<!-- 未完成 -->


<?php
	$class = $_POST['class'];
	$row_max = $_POST['row_max'];
	$col_max = $_POST['col_max'];
?>

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
	for($row = 1; $row <= $row_max; $row++)
	{
		for($col = 1; $col <= $col_max; $col++)
		{
			$attendance_no = $_POST['attendance_no'.$row][$col];


			$sql = "insert into seat values('$class','$row','$col','$attendance_no')";
			echo $sql;
			mysql_query($sql,$link)or die("クエリの送信に失敗しました。");
		}
	}


?>