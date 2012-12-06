<?php
session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$data = $_FILES['upfile'];
	$date = $_POST['date'];
	$class_seq = $_POST['class_seq'];
	$subject_seq = $_POST['subject_seq'];


	$img_name = $data['tmp_name'];


	$sql = "INSERT INTO board VALUE(0, $data, $class_seq, $subject_seq, );";
	move_uploaded_file($data['tmp_name'], '../test/ '.$img_name);

?>