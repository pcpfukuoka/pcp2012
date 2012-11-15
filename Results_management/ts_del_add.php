<html>
	<head>
		<title>削除画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
	</head>
	<body>
		<form action="ts_del_com.php" method="POST">
		<?php
		require_once("../lib/dbconect.php");
		//$link = DbConnect();
		$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		mysql_select_db("pcp2012");
		
		?>
			<div align = "center">
				<font size = "6">先生削除画面</font>
			</div><br><br>
		<?php 
		$sql = "SELECT teacher_seq, subject_seq, user_seq FROM m_teacher WHERE delete_flg = 0";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		?>
		
		<!-- テーブルの作成 -->
		<table border="1" width="100%"><!-- テーブル作成 -->
			<tr>
				<th width="50%">教師名</th>
				<th width="30%">担当教科</th>
				<th width="20%">チェック</th>
			</tr>
		
			<?php 
			for($i = 0; $i < $count; $i++)//先生ID分ループ
			{
				$row = mysql_fetch_array($result);
				
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
							<td align = "center"><input type="checkbox" name = "teacher_<?= $row['teacher_seq'] ?>"></td>
					</tr>
				<?php
			}
			?>
			</table><br>
			<br><hr>
			<?php 
			$sql = "SELECT subject_name, subject_seq FROM m_subject WHERE delete_flg = 0";
			$result = mysql_query($sql);
			
			$count = mysql_num_rows($result);
			
			?>
			
			<div align = "center">
			<font size = "6">教科削除画面</font></div><br>
			<?php 
			
			
			?>
			<table border="1" width="70%"><!-- 教科のテーブル  -->
				<tr>
					<th width="50%">教科一覧</th>
					<th width="20%">チェック</th>
				</tr>
				<?php 
				for($i = 0; $i < $count; $i++)//教科分データ取り出し
				{
					$row = mysql_fetch_array($result);
					?>
					<tr>
					<td align = "center"><?= $row['subject_name'] ?></td>
					<td align = "center"><input type="checkbox" name = "subject_<?= $row['subject_seq'] ?>"></td>
					</tr>
					<?php 
				}
				?>
				</table><br>
			
			<?php 
			Dbdissconnect($link);
			?>
			<input type = "submit" value = "確認">&nbsp;&nbsp;
			<input type = "reset" value="クリア"><br><br>
			</form>
	</body>
</html>