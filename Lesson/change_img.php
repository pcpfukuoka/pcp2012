<?php
session_start();


	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//add.phpから送られてくるデータ
	$date = $_POST['date'];
	$subject_seq = $_POST['subject_seq'];
	$data = $_FILES['upfile'];
	$page_num = $_POST['page_num'];

	//$class_seq = $_POST['class_seq'];



	$img_name = $data['name'];
	$sql = "UPDATE board SET div_url = '" .$img_name .
			"'WHERE date = '". $date .
			"'AND subject_seq = '".$subject_seq.
			"'AND page_num = '".$page_num ."';";
	echo $sql;
	$result = mysql_query($sql);
	$file_name = 'files/ '.$img_name;
	move_uploaded_file($data['tmp_name'], $file_name);

	//データベースを閉じる
	Dbdissconnect($dbcon);

?>
<html>
<head>
</head>
<body>
</body>
</html>
