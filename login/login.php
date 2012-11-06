<?php
	session_start();
	
	$id = $_POST['id'];
	$pass = $_POST['pass'];
	
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT user_seq, user_name, autho_seq FROM m_user WHERE user_id = '$id' AND pass = '$pass'";

	$result = mysql_query($sql);
	
	$cnt = mysql_num_rows($result);
	
	if($cnt == 1)
	{
		//ログイン成功
		$rows = mysql_fetch_array($result);
		$_SESSION['login_flg'] = "true";
		$_SESSION['login_info[user]'] =  $rows['user_seq'];
		$_SESSION['login_info[login_name]'] =  $rows['user_seq'];
		$_SESSION['login_info[autho]'] = $rows['autho_seq'];
		header("Location: ../index.php");
	}
	else
	{
		//ログイン失敗
		$_SESSION['login_flg'] = "false";
		header("Location:index.php");
	}
?>
	
	