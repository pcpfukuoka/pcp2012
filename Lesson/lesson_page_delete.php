<?php
	$date = $_POST['date'];
	$subject_seq = $_POST['id'];
	$page_num=$_POST['num'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//消す前に必要なＵＲＬを退避させる
	$select_sql = "SELECT div_url, page_num FROM board WHERE date='".$date."' AND subject_seq='".$subject_seq."'AND page_num >".$page_num.";";
	$result = mysql_query($select_sql);
	$count = mysql_num_rows($result);
	//削除ボタンをおしたpage_num以降のデータをいったん削除
	$delete_sql = "DELETE FROM board WHERE date='".$date."' AND subject_seq='".$subject_seq."'AND page_num >=".$page_num.";";

	$delete_ = mysql_query($delete_sql);
	$result_1 = array();
	for($i= 0;$i<$count;$i++){
		$row = mysql_fetch_array($result);

		$new_page_num=intval($row['page_num']) -1;
		$max_page= $new_page_num;
		$sql = "INSERT INTO board VALUE(0,'".$date ."', '15','".$subject_seq ."','".$new_page_num ."','".$row['div_url']."','0','0');";
		$result2 = mysql_query($sql);
	}

	//送信するデータを配列に追加
	$result_1[] = array('delete_page'=>$page_num,'max_page'=>$max_page+1);
	Dbdissconnect($dbcon);
	$test = json_encode($result_1);
	echo $test;


?>