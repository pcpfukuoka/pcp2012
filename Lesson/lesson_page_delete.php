<?php
	$date = $_POST['date'];
	$subject_seq = $_POST['id'];
	$page_num=$_POST['num'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//消す前に必要なＵＲＬを退避させる
	$select_sql = "SELECT div_url page_num FROM board WHERE date='". $date ."' AND subject_seq=15 AND page_num >".$page_num.";";
	$result = mysql_query($select_sql);
	$count = mysql_num_rows($result);
	//削除ボタンをおしたpage_num以降のデータをいったん削除
	$delete_sql = "DELETE FROM board WHERE date='". $date ."' AND subject_seq=15 AND page_num >=".$page_num.";";

	$delete_ = mysql_query($delete_sql);

	for($i= 0;$i<$count;$i++){
		$row = mysql_fetch_array($result);
		$new_page_num=$row[page_num] -1;
		$max_page= $new_page_num;
		$sql = "INSERT INTO board VALUE(0,'".$date ."', '15','".$subject_seq ."','".$new_page_num ."','".$row['div_url'] ."','0','0');";
	}

	Dbdissconnect($dbcon);
	$test = json_encode($max_page);
	echo $test;


?>