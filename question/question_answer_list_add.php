<?php
$question_name_list = $_POST['name_list'];
$answer_kbn = $_POST['answer_kbn'];
$question_seq = $_POST['seq'];
$details_description = $_POST['question_details_description'];

require_once("../lib/dbconect.php");
$link = DbConnect();

//detailsに１件追加
if(isset($_POST['answer_kbn'])
		&&isset($_POST['seq'])
		&&isset($_POST['question_details_description'])
		)
{
	$sql = "INSERT INTO question_details VALUES (0,'$details_description','$answer_kbn','$question_seq')";
	mysql_query($sql);
	
}

$details_seq = mysql_insert_id($link);

foreach($question_name_list as $value)
{
	$sql = "INSERT INTO question_awnser_list VALUES (0,'$value','$details_seq') ";
	mysql_query($sql);	
}

Dbdissconnect($link);