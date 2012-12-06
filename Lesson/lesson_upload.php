<?php
session_start();


	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//add.phpから送られてくるデータ
	$date = $_POST['date'];
	$subject_seq = $_POST['subject_seq'];
	$data = $_FILES['upfile'];
	$page_num = $_POST['page_num'];

	//$class_seq = $_POST['class_seq'];



	$img_name = $data['tmp_name'];


	$sql = "INSERT INTO board VALUE(0,". $data. ", 15,". $subject_seq . ",".$page_num .",'0','0',". $img_name . ");";
	move_uploaded_file($data['tmp_name'], 'file/ '.$img_name);

	//データベースを閉じる
	Dbdissconnect($dbcon);

?>