<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>		
		<table border="1">
			<tr bgcolor="yellow">
							<th align="center"width="35%"><font size="5">タイトル</font></th>
				<th align="center"width="35%"><font size="5">対象グループ</font></th>
				<th align="center"width="35%"><font size="5">期間</font></th>
				<th align="center"width="30%"><font size="5">回答数</font></th>
			</tr>
		<?php 
		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();
		//表示用ユーザ情報取得
		$sql = "SELECT question_seq, question_title, m_group.group_name, start_date, end_date FROM question LEFT JOIN m_group ON question_target_group_seq = m_group.group_seq;";
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);
		
		for($i = 0; $i < $cnt; $i++)
		{
			$row = mysql_fetch_array($result);
			?>
			<tr>
				<td><a href="question_details.php?id=<?= $row['question_seq'] ?>" ><?= $row['question_title'] ?></a></td>
				<td><?= $row['group_name'] ?></td>
				<td><?= $row['start_date'] ?> ~ <?= $row['end_date'] ?></td>
				<td></td>
			</tr>				
	<?php 
		}
			
		?>
		</table>
	</body>
</html>