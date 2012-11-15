<html>
	<head>
		<title>削除画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
	</head>
	<body>
	<form action="tea_subj_dec.php" method="POST">
		<?php
		
		require_once("../lib/dbconect.php");
		//$link = DbConnect();
		$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		mysql_select_db("pcp2012");
		
		$sql = "SELECT teacher_seq, subject_seq, user_seq FROM m_teacher WHERE delete_flg = 0";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		?>
		
		<table border="1" width="100%"><!-- テーブル作成 -->
			<tr>
				<th width="50%">教師名</th>
				<th width="50%">担当教科</th>
			</tr>
			
			
			<?php
			for($i = 0; $i < $count; $i++)
				{
				$row = mysql_fetch_array($result);
				$tea_ID = "teacher_".$row['teacher_seq'];
				
				
				if(isset($_POST[$tea_ID]))
					{
					
					$subject_seq = $row['subject_seq'];
					$user_seq = $row['user_seq'];
					
					//m_teacherを元に名前　担当教科取り出しまた貼り付け
					
					$sql = "SELECT user_name FROM m_user WHERE delete_flg = 0 AND user_seq = $user_seq";
					$res_use = mysql_query($sql);
					$user_name = mysql_fetch_array($res_use);
					
					$sql = "SELECT subject_name FROM m_subject WHERE delete_flg = 0 AND subject_seq = $subject_seq";
					$res_subj = mysql_query($sql);
					$subject_name = mysql_fetch_array($res_subj);
					
					?>
					<tr>
						<td align = "center"><?= $user_name['user_name'] ?></td>
						<td align = "center"><?= $subject_name['subject_name'] ?></td>
					</tr>
					<?php 
					}
				}
				?>
				</table><br>
				
			<table border="1" width="50%"><!-- テーブル作成 -->
			<tr>
				<th width="50%">教科名</th>
			</tr>
			
			<?php 
			$sql = "SELECT subject_name, subject_seq FROM m_subject WHERE delete_flg = 0";
			$result = mysql_query($sql);
			$count = mysql_fetch_array($result);
			
			for($i = 0; $i < $count; $i++)
				{
				$row = mysql_fetch_array($result);
				$sub_ID = "subject_".$row['subject_seq'];
				
				
				if(isset($_POST[$sub_ID]))
					{
					?>
						<tr>
						<td align = "center"><?= $row['subject_name'] ?></td>
						</tr>
					<?php 
					}
				}
			?>
		</table><br>
		</form>
	</body>
</html>
