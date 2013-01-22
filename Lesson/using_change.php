<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//lesson_preparation.phpから送られてくるデータ
	$date = $_POST['date'];
	$subject_seq = $_POST['subject_seq'];


	//準備中の背景画像のflagを使用中に変更
	$using_change="UPDATE board SET end_flg = '1' WHERE date = '".$date."' AND class_seq = '15' AND subject_seq = '".$subject_seq."'AND end_flg='0';";
	echo $using_change;
	$result=mysql_query($using_change);

	//headerでlesson_preparationに移動させる
?>