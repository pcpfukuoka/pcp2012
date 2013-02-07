<?php
session_start();
	//POSTで入力したデータを取得
	$user_id = $_SESSION['user_id'];
	$pass = $_SESSION['pass'];
	$user_name = $_SESSION['user_name'];
	$user_kana = $_SESSION['user_kana'];
	$user_address = $_SESSION['user_address'];
	$user_tel = $_SESSION['user_tel'];
	$user_email = $_SESSION['user_email'];
	$autho_seq = $_SESSION['autho_seq'];

	//DB接続
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();


	//登録処理
	$sql = "INSERT INTO m_user VALUES (0, '$user_name', '$user_kana', '$user_address', '$user_tel', '$user_email', '$user_id', '$pass', '$autho_seq','0','0'); ";
	//mysql_query($sql);

	echo $sql;
	if(isset($_SESSION['student_id']))
	{
		$sql = "SELECT user_seq FROM m_user ORDER BY user_seq DESC;";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$user_seq = $row['user_seq'];
		$student_id = $_SESSION['student_id'];
		$sql = "INSERT INTO m_student VALUES (0,'$user_seq','$student_id');";
		echo $sql;
//		mysql_query($sql);
	}
	header("Location: comp_dis.html");
?>