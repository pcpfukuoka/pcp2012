<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$date = $_POST['date'];
	//$class_seq = $_POST['class_seq'];
	$subject_seq = $_POST['subject'];

	//subjectに対応するsubject_nameをデータベースから持ってくる
	$sql = 'SELECT subject_name FROM m_subject WHEREsubject_seq = '. $subject_seq.';';
	$result = mysql_query($sql);
?>

<html>
	<head>
	</head>

	<body>


	</body>
</html>