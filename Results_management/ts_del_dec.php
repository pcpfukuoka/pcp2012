<html>
	<head>
		<title>削除画面</title>
		<META HTTP-EQUIV="Refresh" CONTENT="5;URL=../dummy.html">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
	</head>
	<body>
		<?php
		require_once("../lib/dbconect.php");
		$link = DbConnect();
		//$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		//mysql_select_db("pcp2012");
		
			$sql = "UPDATE m_teacher SET delete_flg = 1 WHERE delete_sub_flg = 1;";
			mysql_query($sql);
			$sql = "SELECT subject_seq FROM m_subject WHERE delete_flg = 0";
			$result = mysql_query($sql);
			$count = mysql_num_rows($result);
			
			for($i = 0; $i < $count; $i++)
			{
			$row = mysql_fetch_array($result);
			$subject_ID = $row['subject_seq'];
			
				if(isset($_POST[$subject_ID]))
				{
				$subject_seq = $_POST[$subject_ID];
				$sql = "UPDATE m_subject SET delete_flg = 1 WHERE subject_seq = '$subject_seq';";
				mysql_query($sql);
				}
			}
		?>
		登録しました
	</body>
</html>