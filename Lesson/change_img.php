<?php
session_start();


	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//add.phpから送られてくるデータ
	$date = $_POST['date'];
	$subject_seq = $_POST['subject_seq'];
	$data = $_FILES['upfile'];
	$page_num = $_POST['page_num_change'];

	//$class_seq = $_POST['class_seq'];


	$img_name = $data['name'];
	$db_img = "url(../images/div/". $data['name']. ")";
	$sql = "UPDATE board SET div_url = '" .$db_img .
			"'WHERE date = '". $date .
			"'AND subject_seq = '".$subject_seq.
			"'AND end_flg='0' AND page_num = '".$page_num ."';";
	echo $sql;
	$result = mysql_query($sql);
	$file_name = 'files/ '.$img_name;
	move_uploaded_file($data['tmp_name'], $file_name);

	//データベースを閉じる
	Dbdissconnect($dbcon);

	echo $page_num;
	$img_tag_name = '../../balckboard/public/images/div/'.$img_name;
?>
<html>
	<head>
		<script src="../javascript/change_img_js.js"></script>
	</head>
	<body onload="change_img('<?= $img_tag_name?>',<?= $page_num ?>)">
	</body>
</html>
