<?php
session_start();


	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//add.phpから送られてくるデータ
	$date = $_POST['date'];
	//$subject_seq = $_POST['subject_seq'];
	$data = $_FILES['upfile'];
	$page_num = $_POST['page_num'];

	//$class_seq = $_POST['class_seq'];



	$img_name = $data['tmp_name'];


	$sql = "INSERT INTO board VALUE(0,". $date. ", '15','15',".$page_num .",'0','0',". $img_name . ");";
	$result = mysql_query($sql);
	move_uploaded_file($data['tmp_name'], 'file/ '.$img_name);

	echo '終了しました';

	//データベースを閉じる
	Dbdissconnect($dbcon);

?>