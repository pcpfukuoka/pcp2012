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



	$img_name = $data['name'];
	echo $date;


	$sql = "INSERT INTO board VALUE(0,".$date .", '15','15',".$page_num .",'0','0',". $img_name . ");";
	echo $sql;
	$result = mysql_query($sql);
	$file_name = 'files/ '.$img_name;
	echo $file_name;
	move_uploaded_file($data['tmp_name'], $file_name);

	echo '終了しました';

	//データベースを閉じる
	Dbdissconnect($dbcon);

?>