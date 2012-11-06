<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる
	
	if((isset($_POST['new_group_name'])) && (isset($_POST['autho_select'])))
	{
		$group_name = $_POST['new_group_name'];
		$autho_seq = $_POST['autho_select'];
		
		$sql = "insert into m_group values(0, '$group_name', '$autho_seq', 0)";
		mysql_query($sql);
		
		$sql = "SELECT * FROM m_group WHERE delete_flg = 0 ORDER BY group_seq DESC;";
		$result = mysql_query($sql);
		$get_group_seq = mysql_fetch_array($result);
		$group_seq = $get_group_seq;
		
	}
	else if((isset($_POST['refresh_id'])) &&(isset($_POST['refresh_name'])))
	{
		$group_seq = $_POST['refresh_id'];
		$group_name = $_POST['refresh_name'];
		
		$sql = "SELECT m_group.group_name, m_user.user_name, m_user.user_id, group_details.group_details_seq, group_details.group_seq,m_student.student_id FROM group_details
		LEFT JOIN m_user ON group_details.user_seq = m_user.user_seq AND m_user.delete_flg = 0
		LEFT JOIN m_student ON m_user.user_seq = m_student.user_seq
		LEFT JOIN m_group ON group_details.group_seq = m_group.group_seq AND m_group.delete_flg = 0
		WHERE group_details.group_seq = $group_seq;";
		
	}
	else
	{
		$group_seq = $_GET['id'];
		$group_name = $_GET['name'];
	
		$sql = "SELECT m_group.group_name, m_user.user_name, m_user.user_id, group_details.group_details_seq, group_details.group_seq,m_student.student_id FROM group_details
				LEFT JOIN m_user ON group_details.user_seq = m_user.user_seq AND m_user.delete_flg = 0
				LEFT JOIN m_student ON m_user.user_seq = m_student.user_seq
				LEFT JOIN m_group ON group_details.group_seq = m_group.group_seq AND m_group.delete_flg = 0
	 			WHERE group_details.group_seq = $group_seq;";
	}
	
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	
	Dbdissconnect($dbcon);

?>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>

	<body>

		<div align = "center">
			<font size = "7"><?= $group_name ?></font>
			
			<hr color = "blue">
	
			<table border = "1" bordercolor = "black">
	
				<tr bgcolor = "yellow">
					<td>&nbsp;&nbsp;</td>
					<td>名前</td>
					<td>ＩＤ</td>
					<td>学籍番号</td>
	
				</tr>
	
				<?php
					for($i = 0; $i < $cnt; $i++)
					{
						if($cnt != 0)
						{
							if(empty($_POST['new_group_name']))
							{
								$g_user_row = mysql_fetch_array($result);
				?>
	
				<tr>
					<td><input type = "checkbox" name = "users[]" value = "<?= $g_user_row['user_name'] ?>"></td>
					<td><?= $g_user_row['user_name'] ?></td>
					<td><?= $g_user_row['user_id'] ?></td>
					<td><?= $g_user_row['student_id'] ?></td>
				</tr>
	
				<?php
							}
						}
					}
				?>
	
			</table>
			
			<form action = "group_details.php" method = "POST">
				<input type = "submit" value = "ユーザを追加" name = "u_add" onclick="window.open('group_u_add.php', 'ユーザ追加', 'width=500,height=400,top=100,left=500');">
				<input type = "hidden" name = "refresh_id" value = "<?= $group_seq ?>">
				<input type = "hidden" name = "refresh_name" value = "<?= $group_name ?>">
			</form>
			
			<form action = "group_details.php" method = "POST">
				<input type = "submit" value = "グループを削除" name = "g_delete" onclick="window.open('group_u_delete.php?group_name=<?= $group_seq ?>', 'ユーザ削除', 'width=500,height=400,top=100,left=500');">
				<input type = "hidden" name = "refresh_id" value = "<?= $group_seq ?>">
				<input type = "hidden" name = "refresh_name" value = "<?= $group_name ?>">
			</form>
			
			<form action = "group_details.php" method = "POST">
				<input type = "submit" value = "グループを削除" name = "g_delete" onclick="window.open('group_g_delete.php?group_name=<?= $group_seq ?>', 'グループ削除', 'width=500,height=400,top=100,left=500');">
				<input type = "hidden" name = "refresh_id" value = "<?= $group_seq ?>">
				<input type = "hidden" name = "refresh_name" value = "<?= $group_name ?>">
			</form>
		</div>
	</body>

</html>