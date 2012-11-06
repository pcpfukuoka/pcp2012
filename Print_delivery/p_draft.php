<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];
	
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	
	$sql = "SELECT print_delivery_seq, delivery_user_seq, target_group_seq, delivery_date, m_group.group_name AS group_name, title
			FROM print_delivery
			Left JOIN m_group ON print_delivery.target_group_seq = m_group.group_seq
			WHERE print_delivery.delivery_user_seq = '$user_seq'
			AND print_send_flg = 1
			ORDER BY delivery_date DESC;";
	
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	
	//データベースを閉じる
	Dbdissconnect($dbcon);
	?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>下書き</title>
	</head>
	
	<body>
		<div align="center">
			<font size = "7">下書き</font><br><br>
		</div>

		<hr color="blue">
		<br><br><br>

		<p align="center">
			<div align="center">
				<table border="1">
					<tr bgcolor="yellow">
					<td align="center"width="150"><font size="5">日付</font></td>
					<td align="center"width="200"><font size="5">TO</font></td>
					<td align="center"width="400"><font size="5">件名</font></td>
					
					<?php
					for ($i = 0; $i < $count; $i++){
						$row = mysql_fetch_array($result);
					?>
						<tr>
							<td></td>
							<td><?= $row['group_name'] ?></td>
							<td>
							
								<a href="p_view.php?id=<?= $row['delivery_user_seq'] ?>"><?= $row['title'] ?></a>
							</td>
							
						</tr>
					<?php 
					}
					?>
				</table>
			</div>
	</body>
</html>
	