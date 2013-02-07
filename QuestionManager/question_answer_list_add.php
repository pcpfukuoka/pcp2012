<?php
$question_name_list = $_POST['name_list'];
$answer_kbn = $_POST['answer_kbn'];
$question_seq = $_POST['seq'];
$details_description = $_POST['question_details_description'];

//セッションに情報を格納
$details['details_description'] = $details_description;
$details['answer_kbn'] = $answer_kbn;
$details['awnser_list'] = $question_name_list;

if(isset($_SESSION['details']))
{
	$set = $_SESSION['details'];	
}

$set[] = $details;

$_SESSION['details'] = $set;
 
