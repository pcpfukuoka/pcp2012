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

	//前ページでチェックが入ったユーザのデータを削除を取り消す
	$sql = "UPDATE group_details SET delete_flg = 0 WHERE group_seq = '$id';";
	mysql_query($sql);
?>
<html>
	<head>
	<meta http-equiv="Content-Style-Type" content="text/css">
	<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">

			<div align = "center">
			<font size = "7"><?= $group_name ?></font>
			<hr color = "blue">
				<table class="table_01">
					<tr bgcolor = "yellow">
						<td><font size="5">名前</font></td>
						<td><font size="5">ＩＤ</font></td>
						<td><font size="5">学籍番号</font></td>
					</tr>

					<?php
						for($i = 0; $i < $cnt; $i++)
						{
							$g_user_row = mysql_fetch_array($result);
					?>
						<tr id = "user_<?= $g_user_row['group_details_seq'] ?>">
							<th><?= $g_user_row['user_name'] ?></th>
							<th><?= $g_user_row['user_id'] ?></th>
							<th><?= $g_user_row['student_id'] ?></th>
						</tr>
					<?php
						}
					?>
				</table>
		</div>
		<font size="5" >以上のデータの削除を取り消しました。</font>
		</div>
	</body>
</html>
