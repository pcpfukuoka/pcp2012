<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	</head>
	<body>
		<img class="bg" src="../../images/blue-big.jpg" alt="" />
		<div id="container">
		<table border="1">
			<tr bgcolor="yellow">
				<th align="center"width="35%"><font size="5">ユーザ名</font></th>
				<th align="center"width="35%"><font size="5">ユーザID</font></th>
				<th align="center"width="30%"><font size="5">権限名</font></th>
			</tr>
		<?php
		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();
		//表示用ユーザ情報取得
		$sql = "SELECT user_seq,user_name, user_id, m_autho.autho_name FROM m_user  left JOIN m_autho ON m_user.autho_seq = m_autho.autho_seq AND m_autho.delete_flg = 0 WHERE m_user.delete_flg = 0 ORDER BY user_kana ASC;";
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);

		for($i = 0; $i < $cnt; $i++)
		{
			$row = mysql_fetch_array($result);
			?>
			<tr>
				<td><a href="change_view.php?id=<?= $row['user_seq'] ?>"><?= $row['user_name'] ?></a></td>
				<td><?= $row['user_id'] ?></td>
				<td><?= $row['autho_name'] ?></td>
			</tr>
	<?php
		}

		?>
		</table>
		</div>
	</body>
</html>