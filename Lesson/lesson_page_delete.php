<?php
	$date = $_POST['date'];
	$subject_seq = $_POST['id'];
	$page_num=$_POST['num'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//消す前に必要なＵＲＬを退避させる
	$select_sql = "SELECT div_url page_num FROM board WHERE date='".$date."' AND subject_seq='".$subject_seq."'AND page_num >".$page_num.";";
	$result = mysql_query($select_sql);
	$count = mysql_num_rows($result);
	//削除ボタンをおしたpage_num以降のデータをいったん削除
	$delete_sql = "DELETE FROM board WHERE date='".$date."' AND subject_seq='".$subject_seq."'AND page_num >=".$page_num.";";

	$delete_ = mysql_query($delete_sql);
	$result_1 = array();

	for($i= 0;$i<$count;$i++){
		$row = mysql_fetch_array($result);

		$new_page_num=intval($row[page_num]) -1;
		$max_page= $new_page_num;
		$sql = "INSERT INTO board VALUE(0,'".$date ."', '15','".$subject_seq ."','".$new_page_num ."','".$row['div_url']."','0','0');";
		$result = mysql_query($sql);
		$result_1[] = array('div'=>$row['div_url'],'page_num'=>$row['page_num']);
	}

	Dbdissconnect($dbcon);
	$test = json_encode($relult_1);
	echo $test;


?>