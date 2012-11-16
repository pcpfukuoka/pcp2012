<html>
	<head>
		<title>削除画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
	</head>
	<body>
		<?php
		
		require_once("../lib/dbconect.php");
		//$link = DbConnect();
		$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		mysql_select_db("pcp2012");
		
		$sql = "SELECT teacher_seq, FROM m_teacher WHERE delete_flg = 0";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		
			for($i = 0; $i < $count; $i++)
			{
				$row = mysql_fetch_array($result);
				$tea_ID = "teacher_".$row['teacher_seq'];
				
				
				if(isset($_POST[$tea_ID]))
				{
					$tea_seq = $$_POST[$tea_ID];
					$sql = "UPDATE m_teacher SET delete_flg = 1 WHERE teacher_seq = '$tea_seq';";
					mysql_query($sql);
				}
			}
			
			$sql = "SELECT subject_seq FROM m_subject WHERE delete_flg = 0";
			$result = mysql_query($sql);
			$count = mysql_num_rows($result);
			
			for($i = 0; $i < $count; $i++)
			{
			$row = mysql_fetch_array($result);
			$subject_ID = "subject_".$row['subject_seq'];
			
				if(isset($_POST[$subject_ID]))
				{
				$subject_seq = $$_POST[$subject_ID];
				$sql = "UPDATE m_subject SET delete_flg = 1 WHERE subject_seq = '$subject_seq';";
				mysql_query($sql);
				}
			}
		?>
		データベースへ送信しました。
	</body>
</html>