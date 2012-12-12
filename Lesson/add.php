<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$date = $_POST['date'];
	echo $date;
	$subject_seq = $_POST['subject'];

	//subjectに対応するsubject_nameをデータベースから持ってくる
	$sql = 'SELECT subject_name FROM m_subject WHEREsubject_seq = '. $subject_seq.';';
	$result = mysql_query($sql);


?>

<html>
	<head>
			<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

	</head>

	<body>


	<font size="5"><?= $date ?>:<?=$result ?></font>
	<div id="form">

	<?php
		$sql2 = 'SELECT page_num, div_url FROM board WHERE date ="'.$date .'"AND subject_seq ="'.$subject_seq.'";';
		$result2 = mysql_query($sql2);
		$count2 = mysql_num_rows($result2);
		$page_max = 1;
		if($count2 > 0)
		{
			for ($i = 0; $i < $count2; $i++)
			{
				$row = mysql_fetch_array($result2);


				$now_page = $i + 1;
				echo "now_page:";
				echo $now_page;
				echo "/";

				echo $row['page_num'];
				echo "/";
				echo $row['div_url'];

	?>
				<form action="change_img.php" method="post" enctype="multipart/form-data" target="targetFrame" id="<?= $now_page ?>_form">
					<input type="hidden" name="date" value=" <?= $date ?>" />
					<input type="hidden" name="subject_seq" value=" <?= $subject_seq ?>" />
					<input type= "hidden" name="page_num" value= "<?= $row['page_num'] ?>" />
					<input type="file" name="upfile" size="30" />
					<img border="1" src="../../balckboard/public/images/kokuban.jpg" width="128" height="128" />

				<input type="submit"  id="<?= $now_page?>_submit" value="変更" />
				</form>

	<?php

			$page_max = $row['page_num'];
			}
			$page_max++;
		}




		//データベースを閉じる
		Dbdissconnect($dbcon);
	?>


			<form action="lesson_upload.php" method="post" enctype="multipart/form-data" target="targetFrame" id="<?= $page_max ?>_form">
				<input type="hidden" name="date" value=" <?php

				 echo $date;

				 ?>" />
				<input type="hidden" name="subject_seq" value=" <?= $subject_seq ?>" />
				<input type= "hidden" name="page_num" value= "<?= $page_max ?>" />
				ファイル：<br/>
				<input type="file" name="upfile" size="30" />


				<input type="submit"  id="<?= $page_max ?>_submit" value="追加" />
			</form>
		</div>
		<iframe name="targetFrame" id="targetFrame" ></iframe>
		<!--  style="display:none;"-->

	</body>
</html>