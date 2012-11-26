<?php

	session_start();
	$user_seq = $_POST['id'];
	$class = $_POST['class'];

	require_once("../lib/dbconect.php");
	$link = DbConnect();

	$sql = "INSERT INTO attendance (group_seq, user_seq, date, Attendance_flg, Absence_flg, Leaving_early_flg, Lateness_flg, Absence_due_to_mourning_flg)
    		VALUES ('$class', '$user_seq', now(), '1', '0', '0', '0', '0')";
    mysql_query($sql);

    //データベースを閉じる
    Dbdissconnect($link);
