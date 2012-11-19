<?php

session_start();
$user_seq = $_POST['id'];
require_once("../lib/dbconect.php");
$link = DbConnect();
$sql = "SELECT * FROM m_user WHERE delete_flg = 0";
$result = mysql_query($sql);
$cnt = mysql_num_rows($result);


$sql = "SELECT group_seq, user_seq, date, m_group.group_name AS group_name, m_user.user_name AS user_name,
			   SUM(Attendance_flg), SUM(Absence_flg), SUM(Leaving_early_flg), SUM(Lateness_flg), SUM(Absence_due_to_mourning_flg)
		FROM attendance
		LEFT JOIN m_group ON attendance.group_seq = m_group.group_seq
		LEFT JOIN m_user ON attendance.user_seq = m_user.user_seq
		GROUP BY user_seq;";
$result = mysql_query($sql);
$num = mysql_num_rows($result);

Dbdissconnect($link);

$result_1 = array();

for ($i = 0; $i < $cnt; $i++)
{
	$row = mysql_fetch_array($result);
	$result_1[] = array('group_name'=>$num['group_name'],'user_name'=>$num['user_name'],'date'=>$num['date'],
				  'Attendance_flg'=>$num['Attendance_flg'], 'Absence_flg'=>$num['Absence_flg'],
				  'Leaving_early_flg'=>$num['Leaving_early_flg'], 'Lateness_flg'=>$num['Lateness_flg'],
				  'Absence_due_to_mourning_flg'=>$num['Absence_due_to_mourning_flg']);
}

$test = json_encode($result_1);
echo $test;
