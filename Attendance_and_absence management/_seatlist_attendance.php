<?php

	session_start();
	$user_seq = $_POST['id'];
	$class = $_POST['class'];

	require_once("../lib/dbconect.php");
	$link = DbConnect();

/*	$sql = "SELECT Attendance_flg, Absence_flg
			FROM attendance
			WHERE attendance.user_seq = '$user_seq'
			AND attendance.group_seq = '$group_seq'
			GROUP BY attendance.user_seq;";
	$result = mysql_query($sql);
	$cun = mysql_num_rows($result);
*/

	Dbdissconnect($link);

	$sql = "INSERT INTO attendance (group_seq, user_seq, date, Attendance_flg, Absence_flg, Leaving_early_flg, Lateness_flg, Absence_due_to_mourning_flg)
    		VALUES ('$class', '$user_seq', now(), '1', '0', '0', '0', '0')";
    mysql_query($sql);

    //データベースを閉じる
    Dbdissconnect($dbcon);
