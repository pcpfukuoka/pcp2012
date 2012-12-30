<?php
session_start();


	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//add.phpから送られてくるデータ
	$date = $_POST['date'];
	echo $date;
	$subject_seq = $_POST['subject_seq'];
	$data = $_FILES['upfile'];
	$page_num = $_POST['page_num'];

	//$class_seq = $_POST['class_seq'];




	$img_name = $data['name'];
	$db_img = "url(../images/div/". $data['name']. ")";
	$sql = "INSERT INTO board VALUE(0,'".$date ."', '15','".$subject_seq ."','".$page_num ."','".$db_img ."','0','0');";
	$result = mysql_query($sql);
	$file_name = '../../balckboard/public/images/div/'.$img_name;
	if(move_uploaded_file($data['tmp_name'], $file_name))
	{

	}

	$img_tag_name = '../../balckboard/public/images/div/'.$img_name;


	//データベースを閉じる
	Dbdissconnect($dbcon);

?>
<html>
<head>
	<script src="../javascript/lesson_upload_js.js"></script>
</head>
<body onload="form_create('<?= $date ?>',<?= $page_num + 1?>,<?= $subject_seq ?>,'<?= $img_tag_name ?>')">

</body>
</html>