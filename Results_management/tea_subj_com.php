<html>
	<head>
		<title>ページ新規追加画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
	</head>
	
	<body>
		<form action="tea_subj_dec.php" method="POST">
		
		<?php
		$q1 = $_POST['q1'];//教科の追加か先生の追加のデータ
		require_once("../lib/dbconect.php");
		$link = DbConnect();
		//$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		//mysql_select_db("pcp2012");
		
		if($q1 == 1)//先生追加の場合
		{
			$subj_radio = $_POST['subj_radio'];
		?>
			<div align = "center">
				<font size = "6">先生教科画面</font>
			</div><br><br>
			
			<?php
			if($subj_radio == "subj_name")
			{
				$subj_name = $_POST['subj_name'];
			}
			else
			{
				$sql = "SELECT * FROM m_subject WHERE delete_flg = 0";
				$result = mysql_query($sql);
				$count = mysql_num_rows($result);
				
				for($i = 0; $i < $count; $i++)
				{
					$row = mysql_fetch_array($result);
					$subj_ID = "subj_".$row['subject_seq'];
					
					if($subj_radio == $subj_ID)
					{
						$subj_name = $row['subject_name'];
			?>
						<input type="hidden" name="subj_radio" value="<?= $subj_radio ?>">
			<?php 
					}
				}
			}
			
			$tea_name = $_POST['user_name'];
			$sql = "SELECT teacher_seq, subject_seq, user_seq FROM m_teacher WHERE delete_flg = 0";
			$result = mysql_query($sql);
			$count = mysql_num_rows($result);
			?>
			
			<!-- テーブルの作成 -->
			<table border="1" width="80%">
				<tr>
					<th width="50%">教師名</th>
					<th width="30%">担当教科</th>
				</tr>
				
				<?php 
				for($i = 0; $i < $count; $i++)
				{
					$row = mysql_fetch_array($result);
					
					$subject_seq = $row['subject_seq'];
					$user_seq = $row['user_seq'];
					
					$sql = "SELECT user_name FROM m_user WHERE delete_flg = 0 AND user_seq = $user_seq";
					$res_use = mysql_query($sql);
					$user_name = mysql_fetch_array($res_use);
					
					$sql = "SELECT subject_name FROM m_subject WHERE delete_flg = 0 AND subject_seq = $subject_seq";
					$res_subj = mysql_query($sql);
					$subject_name = mysql_fetch_array($res_subj);
				?>
					<tr>
						<!-- ページ名の表示とチェックボックスの作成 -->
						<td align = "center"><?= $user_name['user_name'] ?></td>
						<td align = "center"><?= $subject_name['subject_name'] ?></td>
					</tr>
				<?php
				}
				?>
				
				<tr>
					<td align = "center"><?= $tea_name ?></td>
					<td align = "center"><?= $subj_name ?></td>
				</tr>
			</table><br>
			
			<?php 
			$user_seq = $_POST['user_seq']
			?>
			<input type="hidden" name="user_seq" value="<?= $user_seq ?>">
		<?php 
		}
		elseif($q1 == 2)//教科追加の場合
		{
			$subj_name = $_POST['subj_name'];
			$sql = "SELECT subject_name FROM m_subject WHERE delete_flg = 0";
			$result = mysql_query($sql);
			
			$count = mysql_num_rows($result);
		?>
			
			<div align = "center">
				<font size = "6">教科追加</font>
			</div><br>
			
			<table border="1" width="70%"><!-- 教科のテーブル  -->
				<tr>
					<th width="70%">教科一覧</th>
				</tr>
				
				<?php
				for($i = 0; $i < $count; $i++)
				{
					$row = mysql_fetch_array($result);
				?>
					<tr>
						<td align = "center"><?= $row['subject_name'] ?></td>
					</tr>
				<?php 
				}
				?>
				
				<tr>
					<td align = "center"><font color = "Red">"NEW"</font>&nbsp;&nbsp;<?= $subj_name ?></td>
				</tr>
			</table><br>
			
			<?php 
			}
			Dbdissconnect($link);
			
			//必要なデータ送信
			?>
			<input type="hidden" name="subj_radio" value="<?= $subj_radio ?>">
			<input type="hidden" name="subj_name" value="<?= $subj_name ?>">
			<input type="hidden" name="q1" value="<?= $q1 ?>">
			<input type = "submit" value = "確定">&nbsp;&nbsp;
			<input class="button4" type="button" value="戻る" onClick="history.back()">
		</form>
	</body>
</html>	