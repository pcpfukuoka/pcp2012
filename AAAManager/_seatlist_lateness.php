<?php

	session_start();
	$user_seq = $_POST['id'];
	$class = $_POST['class'];

	require_once("../lib/dbconect.php");
	$link = DbConnect();


	$sql = "SELECT DATE_FORMAT(date, '%Y-%m-%d') AS DATE FROM attendance
			WHERE user_seq = '$user_seq'
			ORDER BY DATE_FORMAT(date, '%Y-%m-%d') DESC";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	$sql = "SELECT DATE_FORMAT(now(),'%Y-%m-%d') AS NOW;";
	$k = mysql_query($sql);
	$m = mysql_fetch_array($k);


	if($row['DATE'] == $m['NOW'])
	{
		$pcp = $row['DATE'];
		$sql = "UPDATE attendance
				SET group_seq = '$class', user_seq = '$user_seq', Attendance_flg = 0, Absence_flg = 0, Leaving_early_flg = 0,
					Lateness_flg = 1, Absence_due_to_mourning_flg = 0
					WHERE user_seq = '$user_seq'
				AND DATE_FORMAT(date, '%Y-%m-%d') = '$pcp';";
		mysql_query($sql);
	}
	else
	{
		$sql = "INSERT INTO attendance (group_seq, user_seq, date, Attendance_flg, Absence_flg, Leaving_early_flg, Lateness_flg, Absence_due_to_mourning_flg)
				VALUES ('$class', '$user_seq', now(), '0', '0', '0', '1', '0')";
		mysql_query($sql);
	}


    //データベースを閉じる
    Dbdissconnect($link);
