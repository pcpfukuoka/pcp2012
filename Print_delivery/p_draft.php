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
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		 <link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		 <link rel="stylesheet" type="text/css" href="../css/table.css" />
		<title>下書き</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">下書き</font>
		</div>

		<hr color="blue">
		<br><br><br>

		<p align="center">
			<div align="center">
				<table class="table_01">
					<tr bgcolor="yellow">
					<td align="center"width="160"><font size="5">日付</font></td>
					<td align="center"width="150"><font size="5">TO</font></td>
					<td align="center"width="230"><font size="5">件名</font></td>

					<?php
					for ($i = 0; $i < $count; $i++){
						$row = mysql_fetch_array($result);
					?>
						<tr>
							<th><?= $row['delivery_date'] ?></th>
							<th><?= $row['group_name'] ?></th>
							<th>

								<a href="p_view.php?id=<?= $row['print_delivery_seq'] ?>"><?= $row['title'] ?></a>
							</th>

						</tr>
					<?php
					}
					?>
				</table>
			</div>
		</div>
	</body>
</html>
