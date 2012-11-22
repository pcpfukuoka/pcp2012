<?php

session_start();
$user_seq = $_POST['id'];
require_once("../lib/dbconect.php");
$link = DbConnect();
$sql = "SELECT * FROM m_user WHERE delete_flg = 0";
$result = mysql_query($sql);
$cnt = mysql_num_rows($result);


$sql = "SELECT attendance.group_seq, attendance.user_seq, date, m_group.group_name AS group_name, m_user.user_name AS user_name, m_student.student_id AS student_id,
			   SUM(Attendance_flg) AS Attendance_flg, SUM(Absence_flg) AS Absence_flg, SUM(Leaving_early_flg) AS Leaving_early_flg, SUM(Lateness_flg) AS Lateness_flg, SUM(Absence_due_to_mourning_flg) AS Absence_due_to_mourning_flg
		FROM attendance
		LEFT JOIN m_group ON attendance.group_seq = m_group.group_seq
		LEFT JOIN m_user ON attendance.user_seq = m_user.user_seq
		LEFT JOIN m_student ON attendance.user_seq = m_student.user_seq
		GROUP BY attendance.user_seq;";
$result = mysql_query($sql);
$num = mysql_num_rows($result);

Dbdissconnect($link);

$result_1 = array();

for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_array($result);
	$result_1[] = array('student_id'=>$row['student_id'], 'group_name'=>$row['group_name'], 'user_name'=>$row['user_name'], 'date'=>$row['date'],
				  'Attendance_flg'=>$row['Attendance_flg'], 'Absence_flg'=>$row['Absence_flg'],
				  'Leaving_early_flg'=>$row['Leaving_early_flg'], 'Lateness_flg'=>$row['Lateness_flg'],
				  'Absence_due_to_mourning_flg'=>$row['Absence_due_to_mourning_flg'],
				  'user_seq'=>$row['user_seq']);
}

$test = json_encode($result_1);
echo $test;
