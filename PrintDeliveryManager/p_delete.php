<?php
	session_start();
	$print_delivery_seq = $_POST['id'];

	//データベースの呼び出し
	require_once("../lib/dbconect.php");
	$link = DbConnect();

	//print_delivery_seq と同じプリントURLを削除（空白に）する。
	$sql = "UPDATE print_delivery
			SET printurl = NULL
			WHERE print_delivery_seq = $print_delivery_seq";
	mysql_query($sql);


	//データベースを閉じる
	Dbdissconnect($link);