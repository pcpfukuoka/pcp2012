<?php 

session_start();

require_once("../lib/dbconect.php");
$dbcon = DbConnect();

//question登録用SQL生成
//値はセッションから取得する。
echo	$title = $_SESSION['question_info[question_title]'];
echo	$start_date= $_SESSION['question_info[start_date]'];
echo	$end_date= $_SESSION['question_info[end_date]'];
echo	$target_group = $_SESSION['question_info[target_group]'];
echo	$description = $_SESSION['question_info[question_description]'];
echo $sql = "INSERT INTO question VALUES (0,'$title','$target_group','$start_date','$end_date','$description')";

//$question_seq = mysql_insert_id($link);

if(isset($_SESSION['details']))
{
	$aa = $_SESSION['details'];
	print_r($aa);
	echo "aa";
}else
{
	
	echo "bb";
}



//セッションにdetailsの個数のカウントを持たせる
//セッションにはdetailsの連想配列を保持させる。
//detailsが増える再にはその都度連想配列をすべて設定し直す。

//question_details登録用SQL生成
$details_description = $_SESSION['question_info[details_description]'];
$answer_kbn = $_SESSION['question_info[answer_kbn]'];
$details = $_SESSION['question_info[details]'];

$question_name_list = $_SESSION['question_info[awnser_list]'];
$sql = "INSERT INTO question_details VALUES (0,'$details_description','$answer_kbn','$question_seq')";
//mysql_query($sql);
$details_seq = mysql_insert_id($link);

foreach($question_name_list as $value)
{
	$sql = "INSERT INTO question_awnser_list VALUES (0,'$value','$details_seq') ";
	//mysql_query($sql);
}
?>
