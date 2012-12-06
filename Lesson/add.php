<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$date = $_POST['date'];
	//$class_seq = $_POST['class_seq'];
	//$subject_seq = $_POST['subject'];

	//subjectに対応するsubject_nameをデータベースから持ってくる
	//$sql = 'SELECT subject_name FROM m_subject WHEREsubject_seq = '. $subject_seq.';';
	//$result = mysql_query($sql);

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html>
	<head>
	</head>

	<body>

	<font size="5"><?= $date ?></font>


	<!-- このあとを繰り返し？ -->
		<form action="lesson_upload.php" method="post" enctype="multipart/form-data" target="targetFrame">
			<input type="hidden" name="date" value=" <?php $date ?>" />
			<input type="hidden" name="subject_seq" value="<?php $subject_seq ?>" />
			<input type= "hidden" name="page_num" value= "1" />
			ファイル：<br/>
			<input type="file" name="upfile" size="30" />


			<input type="submit" value="追加" />
		</form>
		<iframe name="targetFrame" id="targetFrame"></iframe>

	</body>
</html>