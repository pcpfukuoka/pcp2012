<?php
$user_seq = $_POST['id'];
$subject_seq = $_POST['subj'];
		require_once("../lib/dbconect.php");
		//$link = DbConnect();
		$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		mysql_select_db("pcp2012");
$result_back_seq = mysql_query($sql);
$back_seq_row = mysql_fetch_array($result_back_seq);
$sql = "UPDATE m_teacher SET delet_sub_flg = 1 WHERE user_seq = '$user_seq' AND subject_seq = '$subject_seq';";
mysql_query($sql);
Dbdissconnect($link);
echo $user_seq;
