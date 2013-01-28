<?php 

session_start();

require_once("../lib/dbconect.php");
$dbcon = DbConnect();

//question登録用SQL生成
//値はセッションから取得する。
$title = $_SESSION['question_info[question_title]'];
$start_date= $_SESSION['question_info[start_date]'];
$end_date= $_SESSION['question_info[end_date]'];
$target_group = $_SESSION['question_info[target_group]'];
$description = $_SESSION['question_info[question_description]'];
$sql = "INSERT INTO question VALUES (0,'$title','$target_group','$start_date','$end_date','$description')";
mysql_query($sql);
$question_seq = mysql_insert_id($dbcon);


//セッションにdetailsの個数のカウントを持たせる
//セッションにはdetailsの連想配列を保持させる。
//detailsが増える再にはその都度連想配列をすべて設定し直す。

//question_details登録用SQL生成
foreach($_SESSION['details'] as $details_row)
{
	$test = array();
	foreach($details_row as $value)
	{		
		$test[] = $value;
	}
	print_r($test);
	$details_description = $test[0];
	$answer_kbn = $test[1];
	$question_name_list = $test[2];
	$sql = "INSERT INTO question_details VALUES (0,'$details_description','$answer_kbn','$question_seq')";
	mysql_query($sql);
	
	$details_seq = mysql_insert_id($dbcon);
	foreach($question_name_list as $value)
	{
		$sql = "INSERT INTO question_awnser_list VALUES (0,'$value','$details_seq') ";
		mysql_query($sql);
		
	}
}
?>
