<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//一覧表示用のデータを取得
	$id = $_GET['id'];
	$sql = "SELECT 
			m_group.group_name, 
			m_user.user_name, 
			m_user.user_id, 
			group_details.group_details_seq, 
			group_details.group_seq,
			m_student.student_id 
			FROM group_details
			LEFT JOIN m_group ON group_details.group_seq = m_group.group_seq AND m_group.delete_flg = 0
			LEFT JOIN m_user ON group_details.user_seq = m_user.user_seq AND m_user.delete_flg = 0
			LEFT JOIN m_student ON m_user.user_seq = m_student.user_seq
 			WHERE group_details.group_seq = '$id' 
			AND group_details.delete_flg = 1;";
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	
	//前ページでチェックが入ったユーザのデータを削除
	$sql = "DELETE FROM group_details WHERE group_seq = '$id' AND delete_flg = 1";
	mysql_query($sql);
?>
<html>
	<head>
	</head>
	<body>
			<div align = "center">
			<font size = "7"><?= $group_name ?></font>
			<hr color = "blue">
				<table border = "1" bordercolor = "black">
					<tr bgcolor = "yellow">
						<td>名前</td>
						<td>ＩＤ</td>
						<td>学籍番号</td>
					</tr>
					
					<?php
						for($i = 0; $i < $cnt; $i++)
						{
							$g_user_row = mysql_fetch_array($result);
					?>
						<tr id = "user_<?= $g_user_row['group_details_seq'] ?>">
							<td><?= $g_user_row['user_name'] ?></td>
							<td><?= $g_user_row['user_id'] ?></td>
							<td><?= $g_user_row['student_id'] ?></td>
						</tr>
					<?php
						}
					?>
				</table>
		</div>
		以上のデータを削除しました。
	</body>
</html>