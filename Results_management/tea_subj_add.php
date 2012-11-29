<html>
	<head>
		<title>教師・教科新規追加画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
	</head>
	<body>
		<form action="tea_subj_com.php" method="POST">
		<?php
		require_once("../lib/dbconect.php");
		$link = DbConnect();
		//$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		//mysql_select_db("pcp2012");
		
		?>
			<div align = "center">
				<font size = "6">先生追加画面</font>
			</div><br><br>
		<?php 
		$sql = "SELECT teacher_seq, subject_seq, user_seq FROM m_teacher WHERE delete_flg = 0";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		?>
		<input type="radio" name="q1" value="1" checked>先生<!--  tea_subj_comまたdecに使用 -->
		<input type="radio" name="q1" value="2">教科
		
		<!-- テーブルの作成 -->
		<table border="1" width="70%"><!-- テーブル作成 -->
			<tr>
				<th width="50%">教師名</th>
				<th width="20%">担当教科</th>
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
				</tr>
			<?php
			}
			?>
				<tr>
					<td align = "center"><!-- 新規先生追加 -->
					<?php 
					if(isset($_POST['user_radio']))//user_seaよりデータを取り出したか
					{
						$sql = "SELECT user_name, user_seq FROM m_user WHERE delete_flg = 0 ";
						$result = mysql_query($sql);
						$count = mysql_num_rows($result);
						
						for($i = 0; $i < $count; $i++)
						{
							$row = mysql_fetch_array($result);
						
							$user_sea = "user_".$row['user_seq'];
							
							if($_POST['user_radio'] == $user_sea)//取り出したデータを貼り付け
							{
								$u_seq = $row['user_seq'];
							?>
								<?= $row['user_name'] ?>
								<input type="hidden" name="user_seq" value="<?= $row['user_seq'] ?>">
								<input type="hidden" name="user_name" value="<?= $row['user_name'] ?>">
								</td>
							<?php
							} 
						}
					}
					else//user_seaよりデータを取り出してない場合
					{
					?>
						<a href="user_sea.php">ユーザー検索へ</a></td><!-- リンクへ飛びデータ取り出し -->
					<?php 
					}
					?>
					<td align = "center">下から選択</td>
				</tr>
			</table><br><br><hr>
			
			<?php 
			$sql = "SELECT subject_name, subject_seq FROM m_subject WHERE delete_flg = 0";
			
			$result = mysql_query($sql);
			$count = mysql_num_rows($result);
			?>
			
			<div align = "center">
				<font size = "6">教科追加</font>
			</div><br>
			
			<table border="1" width="70%"><!-- 教科のテーブル  -->
				<tr>
					<th width="50%">教科一覧</th>
					<th width="20%">チェック</th>
				</tr>
				
				<?php 
				for($i = 0; $i < $count; $i++)//教科分データ取り出し
				{
					$chk = 0;
					$row = mysql_fetch_array($result);
					$subjc = $row['subject_seq'];
					
					if(isset($u_seq))
					{
					$sql = "SELECT subject_seq
					FROM m_teacher
					WHERE user_seq = '$u_seq'
					AND delete_flg = 0
					GROUP BY subject_seq;";
					}
					else 
					{
						$sql = "SELECT subject_name, subject_seq FROM m_subject WHERE delete_flg = 0";
							
						$result_sub = mysql_query($sql);
						$count = mysql_num_rows($result_sub);
						
						for ($i = 0; $i < $count; $i++)
						{
							$row = mysql_fetch_array($result_sub);
						?>
							<tr>
								<td align = "center"><?= $row['subject_name'] ?></td>
								<td align = "center"><input type="radio" name="subj_radio" value="subj_<?= $row['subject_seq'] ?>" ></td>
							</tr>
						<?php 
						}
					}	
					$result_user = mysql_query($sql);
					$count_user = mysql_num_rows($result_user);
					
					for ($j = 0; $j < $count_user; $j++)
					{
						$teacher = mysql_fetch_array($result_user);
						
						if ($teacher['subject_seq'] == $subjc)
						{
							$chk = 1;
							break;
						}
					}
					
					if ($chk == 0)
					{
						
				?>
					<tr>
						<td align = "center"><?= $row['subject_name'] ?></td>
						<td align = "center"><input type="radio" name="subj_radio" value="subj_<?= $row['subject_seq'] ?>" ></td>
					</tr>
				<?php 
					}
				}
				?>
				
				<tr><!-- 新規教科入力 -->
					<td align = "center"><input size ="15" type="text" name="subj_name"></td>
					<td align = "center"><input type="radio" name="subj_radio" value="subj_name" checked></td>
				</tr>
			</table><br>
				
			<?php 
			Dbdissconnect($link);
			?>
			<input type = "submit" value = "確認">&nbsp;&nbsp;
			<input type = "reset" value="クリア"><br><br>
		</form>
	</body>
</html>