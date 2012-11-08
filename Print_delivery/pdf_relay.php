<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];
	
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	
	$id = $_GET['id'];
	
	//データベースを閉じる
	Dbdissconnect($dbcon);
	
?>