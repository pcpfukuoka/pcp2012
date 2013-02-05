<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//lesson_preparation.phpから送られてくるデータ
	$date = $_POST['date'];
	$subject_seq = $_POST['subject_seq'];
	$group_seq = $_POST['group_seq'];
	$time_table = $_POST['time_table'];

	//準備中の背景画像のflagを使用中に変更
	$using_change="UPDATE board SET end_flg = '1' WHERE date = '".$date."' AND class_seq = '".$group_seq."' AND subject_seq = '".$subject_seq."'AND time_table = '".$time_table."'AND end_flg='0';";
	$result=mysql_query($using_change);
	//headerでjoin_lesson.phpに移動させる
	header("Location: http://49.212.201.99/pcp2012/Lesson/join_lesson.php?id=$subject_seq&id2=$group_seq")
?>