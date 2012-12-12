<!-- 未完成 -->



<?php

	//$group = $_POST['group'];
	$row_max = $_POST['row_max'];
	$col_max = $_POST['col_max'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//文字コード設定
	mysql_query("SET NAMES UTF8");

	$group = 12;


		//クエリを送信する
	for($row = 1; $row <= $row_max; $row++)
	{
		for($col = 1; $col <= $col_max; $col++)
		{
			//$user_seq = $_POST['user_seq'.$row][$col];
			$user_seq = 100;


			$sql = "insert into seat values('0','$group','$row','$col','$user_seq')";
			echo $sql;
			mysql_query($sql,$link)or die("クエリの送信に失敗しました。");
		}
	}


?>