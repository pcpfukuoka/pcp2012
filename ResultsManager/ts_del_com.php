<html>
	<head>
		<title>削除確認画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>	
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">

	<div align = "center">
			<font class="Cubicfont2">削除確認</font><hr color="blue"><br><br><br>
		</div>
		
	<form action="ts_del_dec.php" method="POST">
		<?php
		
		require_once("../lib/dbconect.php");
		$link = DbConnect();
		//$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		//mysql_select_db("pcp2012");
		
		$sql = "SELECT m_user.user_name, m_subject.subject_name, m_teacher.teacher_seq
				FROM m_teacher 
				LEFT JOIN m_subject ON m_teacher.subject_seq = m_subject.subject_seq 
				LEFT JOIN m_user ON m_teacher.user_seq = m_user.user_seq 
				WHERE m_teacher.delete_flg = 0";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		?>
		
		<!-- テーブルの作成 -->
		<table border="1" width="100%" class="table_01"><!-- テーブル作成 -->
			<tr>
				<th width="50%">教師名</th>
				<th width="50%">担当教科</th>
			</tr>
			<?php 
					
			for($i = 0; $i < $count; $i++)//先生ID分ループ
			{
				$row = mysql_fetch_array($result);
				$teacher_seq = "teacher_".$row['teacher_seq'];
				if(isset($_POST[$teacher_seq]))
				{
				?>
					<tr>
							<td align = "center"><?= $row['user_name'] ?></td>
							<td align = "center"><?= $row['subject_name'] ?></td>
							
					</tr>
					<input type="hidden" name="<?= $teacher_seq ?>" value="<?= $row['teacher_seq'] ?>">
				<?php
				}
			}
			?>
			</table><br>
				
			<table border="1" width="50%" class="table_01"><!-- テーブル作成 -->
			<tr>
				<th width="50%">教科名</th>
			</tr>
			
		<?php 
			$sql = "SELECT subject_name, subject_seq FROM m_subject WHERE delete_flg = 0";
			$result = mysql_query($sql);
			$count = mysql_num_rows($result);
			
			for($i = 0; $i < $count; $i++)
			{
				$row = mysql_fetch_array($result);
				$sub_ID = $row['subject_seq'];
				
				if(isset($_POST[$sub_ID]))
				{
		?>
					<tr>
						<td align = "center"><?= $row['subject_name'] ?>
						<input type="hidden" name="<?= $row['subject_seq'] ?>" value="<?= $row['subject_seq'] ?>">
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
					<input class="button4" type = "submit" value = "削除">&nbsp;&nbsp;
					<input class="button4" type="button" value="戻る" onClick="history.back()">
		</form>
		</div>
	</body>
</html>
