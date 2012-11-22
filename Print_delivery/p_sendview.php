<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	$id = $_GET['id'];

	$sql = "SELECT print_delivery_seq, m_group.group_name AS group_name, title
			FROM print_delivery
			Left JOIN m_group ON print_delivery.target_group_seq = m_group.group_seq
			WHERE print_delivery_seq = '$id';";
	$result = mysql_query($sql);

	$sql = "SELECT print_check_seq, print_delivery_seq, print_check_flg, m_user.user_name AS user_name
			FROM print_check
			Left JOIN m_user ON print_check.user_seq = m_user.user_seq
			WHERE print_check.print_delivery_seq = '$id';";
	$result_print_check = mysql_query($sql);
	$count = mysql_num_rows($result_print_check);

	$sql = "UPDATE print_delivery
			SET print_flg = 0
			WHERE print_delivery_seq = '$id'; ";
	mysql_query($sql);

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<title>確認画面</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
		    <font size = "6">プリント送信済み確認</font><br>
		</div>

		<font size = "4"><a href="p_outbox.php">←戻る</a></font>
		<hr color="blue">
		<br><br>

		<div align="center">
			<table border="1">
				<tr bgcolor="yellow">
					<td align="center"width="200"><font size="5">名前</font></td>
					<td align="center"width="200"><font size="5">確認</font></td>
				</tr>

				<?php
				for ($i = 0; $i < $count; $i++){
					$row = mysql_fetch_array($result_print_check);
				?>

					<tr>
						<td><?= $row['user_name'] ?></td>
						<td>
							<?php
								if($row['print_delivery_seq'] == $id && $row['print_check_flg'] == 1)
								{
									echo "-------";
								}
								else
								{
									echo "確認済み";
								}
							?>
						</td>
					</tr>
				<?php
				}
				?>
			</table>
		</div>
		</div>
	</body>
</html>
