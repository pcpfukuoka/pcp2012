<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];
	
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	
	$id = $_GET['id'];
	
	$sql = "SELECT print_check_seq FROM print_check ORDER BY print_check_seq DESC;";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	
	//UPDATEでリンクを保存
	$sql = "UPDATE print_check SET print_check_flg = 0
			WHERE print_delivery_seq = $id
			AND user_seq = $user_seq;";
	
	mysql_query($sql);
	

	//データベースを閉じる
	Dbdissconnect($dbcon);
	 
	Header('Location: p_preservation.html');
	exit;
	
?>