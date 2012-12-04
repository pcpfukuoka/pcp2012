<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//連絡帳のテータベースからデータの取り出し
	$sql = "SELECT contact_book_seq, new_flg, send_date, m_user.user_name AS send_user_name, title
			FROM contact_book
			Left JOIN m_user ON contact_book.send_user_seq = m_user.user_seq
			WHERE contact_book.reception_user_seq = $user_seq
			ORDER BY send_date DESC;";

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
		<title>受信ボックス</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">受信ボックス</font>
		</div>

		<hr color="blue">
		<br>

		<!-- 連絡帳の受信一覧テーブル作成 -->
		<p align="left">
			<font size="5">連絡帳</font>
		</p>

		<div align="center">
			<table class="table_01">
				<tr bgcolor="yellow">
				<td align="center"width="30"></td>
				<td align="center"width="200"><font size="5">日付</font></td>
				<td align="center"width="150"><font size="5">FROM</font></td>
				<td align="center"width="230"><font size="5">件名</font></td>

				<?php
				for ($i = 0; $i < $count; $i++){
					$row = mysql_fetch_array($result);
				?>
					<tr>

					<?php

						if ($row['new_flg'] == 1)
						{
					?>
						<td><img src="../images/mail_icon.jpg"></td>
					<?php
						}
						else
						{
							echo "<td></td>";
						}
					?>
						<th><?= $row['send_date'] ?></th>
						<th><?= $row['send_user_name'] ?></th>
						<th>
							<!-- GETでcontact_book_seqを送る -->
							<a href="view.php?id=<?= $row['contact_book_seq'] ?>"><?= $row['title'] ?></a>
						</th>
					</tr>
				<?php
				}
				?>

			</table>
			<hr>
		</div>

		<?php

			//データベースの呼出
			require_once("../lib/dbconect.php");
			$dbcon = DbConnect();

			//プリント配信用のデータベースからデータの取り出し
			$sql = "SELECT print_delivery_seq, target_group_seq, print_flg, delivery_user_seq, delivery_date, printurl, title, m_user.user_name AS send_user_name
					FROM print_delivery
					LEFT JOIN m_user ON print_delivery.delivery_user_seq = m_user.user_seq
					LEFT JOIN group_details ON print_delivery.target_group_seq = group_details.group_seq
					WHERE group_details.user_seq = $user_seq
					ORDER BY delivery_date DESC;";
			$result = mysql_query($sql);
			$cnt = mysql_num_rows($result);



		?>

		<!-- プリントの受信一覧テーブル作成 -->
		<p align="left">
			<font size="5">配信</font>
		</p>

		<div align="center">
			<table class="table_01">
				<tr bgcolor="yellow">
					<td align="center"width="30"></td>
					<td align="center"width="200"><font size="5">日付</font></td>
					<td align="center"width="150"><font size="5">FROM</font></td>
					<td align="center"width="230"><font size="5">件名</font></td>
				</tr>

				<?php
				for ($i = 0; $i < $cnt; $i++){
					$row = mysql_fetch_array($result);

					$delivery = $row['print_delivery_seq'];

					$sql = "SELECT print_check_flg
							FROM print_check
							WHERE print_delivery_seq = $delivery
							AND user_seq = $user_seq;";

					$result_chk = mysql_query($sql);
					$chk = mysql_fetch_array($result_chk);
				?>
					<tr>

					<?php

						if ($chk['print_check_flg'] == 1)
						{
					?>
						<td><img src="../images/mail_icon.jpg"></td>
					<?php
						}
						else
						{
							echo "<td></td>";
						}
					?>

						<th><?= $row['delivery_date'] ?></th>
						<th><?= $row['send_user_name'] ?></th>
						<th>
							<!-- GETでprint_delivery_seqを送る -->
							<!-- <a href="<?= printurl ?>"><?= $row['title'] ?></a> -->
							<a href="../Print_delivery/pdf_view.php?id=<?= $row['print_delivery_seq'] ?>"><?= $row['title'] ?></a>
						</th>
					</tr>
				<?php
				}
				//データベースを閉じる
				Dbdissconnect($dbcon);
				?>

			</table>
		</div>
		</div>
	</body>
</html>
