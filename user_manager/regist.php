<?php

	//POSTで入力したデータを取得
	$user_id = $_POST['user_id'];
	$pass = $_POST['pass'];
	$user_name = $_POST['user_name'];
	$user_kana = $_POST['user_kana'];
	$user_address = $_POST['user_address'];
	$user_tel = $_POST['user_tel'];
	$user_email = $_POST['user_email'];
	$autho_seq = $_POST['autho_seq'];
	
	//DB接続
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	
	
	//登録処理
	$sql = "INSERT INTO m_user VALUES (0, '$user_name', '$user_kana', '$user_address', '$user_tel', '$user_email', '$user_id', '$pass', '$autho_seq','0'); ";
	mysql_query($sql);
	
	if(isset($_POST['stuent_id']))
	{
		$sql = "SELECT user_seq FROM m_user ORDER BY user_seq DESC;";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$user_seq = $row['user_seq'];
		$student_id = $_POST['stuent_id'];
		$sql = "INSERT INTO m_student VALUES (0,'$user_seq','$student_id');";
		mysql_query($sql);		
	}
	header("Location: comp_dis.html");
?>