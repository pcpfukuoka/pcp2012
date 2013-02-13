<html>
	<head>
		<title>先生削除画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
		<meta http-equiv="Content-Style-Type" content="text/css"></meta>
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<?php
		
		require_once("../lib/dbconect.php");
		$link = DbConnect();
		//$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		//mysql_select_db("pcp2012");
		
		?>
			<div align = "center">
			
				<font class="Cubicfont1">先生削除</font>
			</div><br><br>
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
		<?php 
		
		$sql = "SELECT teacher_seq, subject_seq, user_seq FROM m_teacher WHERE delete_flg = 0";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		?>
		
				<form action="ts_del_add.php" method="POST">
			<input type="text" name="query">
			<input class="button4" type="submit" value="検索">
		</form>
		
		
		<form action="ts_del_com.php" method="POST">
		<?php 
		if(isset($_POST['query']))
		{
				//チェックボックスを確認
				$user = $_POST['query'];
				$sql = "SELECT * FROM m_user WHERE delete_flg = 0 AND user_name LIKE '%$user%';";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				$user = $row['user_seq'];
				$sql = "SELECT * FROM m_teacher WHERE delete_flg = 0 AND user_seq = '$user';";
		}
		
				$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		?>
		
		<!-- テーブルの作成 -->
		<table border="1" width="100%" class="table_01"><!-- テーブル作成 -->
			<tr>
				<th width="50%">教師名</th>
				<th width="30%">担当教科</th>
				<th width="20%">チェック</th>
			</tr>
			<?php 
			
			for($i = 0; $i < $count; $i++)//先生ID分ループ
			{
				$row = mysql_fetch_array($result);
				
				$teacher = $row['teacher_seq'];
				$subject_seq = $row['subject_seq'];
				$user_seq = $row['user_seq'];
				
				//m_teacherを元に名前　担当教科取り出しまた貼り付け
				
				$sql = "SELECT user_name, user_seq FROM m_user WHERE delete_flg = 0 AND user_seq = $user_seq";
				$res_use = mysql_query($sql);
				$user_name = mysql_fetch_array($res_use);
				
				$sql = "SELECT subject_name FROM m_subject WHERE delete_flg = 0 AND subject_seq = $subject_seq";
				$res_subj = mysql_query($sql);
				$subject_name = mysql_fetch_array($res_subj);
				?>
					<tr>
							<td align = "center"><?= $user_name['user_name'] ?></td>
							<td align = "center"><?= $subject_name['subject_name'] ?></td>
							<td align = "center">
							<input type="checkbox" class="checkUser" name="teacher_<?= $teacher ?>">
							</td>
							
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
			<font class="Cubicfont2">教科削除</font></div><br>
			<?php 
			
			
			?>
			<table border="1" width="70%" class="table_01"><!-- 教科のテーブル  -->
				<tr>
					<th width="50%">教科一覧</th>
					<th width="20%">チェック</th>
				</tr>
				<?php 
				for($i = 0; $i < $count; $i++)//教科分データ取り出し
				{
					$chk = 0;
					$row = mysql_fetch_array($result);
					$subj_ID = $row['subject_seq'];
					
					$sql = "SELECT subject_seq
					FROM m_teacher
					WHERE delete_flg = 0
					GROUP BY subject_seq;";
						
					
					$result_user = mysql_query($sql);
					$count_user = mysql_num_rows($result_user);
						
					for ($j = 0; $j < $count_user; $j++)
					{
						$teacher = mysql_fetch_array($result_user);
					
						if ($teacher['subject_seq'] == $subj_ID)
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
						<td align = "center"><input type="checkbox" name = "<?= $row['subject_seq'] ?>">
						</td>
						</tr>
					<?php 
					}
				}
				?>
				</table><br>
			
			<?php 
			Dbdissconnect($link);
			?>
			<input  class="button4" type = "submit" value = "確認">&nbsp;&nbsp;
			<input class="button4" type = "reset" value="クリア"><br><br>
			</form>
			</div>
	</body>
</html>
<?php


