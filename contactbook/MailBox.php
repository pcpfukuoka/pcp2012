<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	
	$sql = "SELECT contact_book_seq, send_date, m_user.user_name AS send_user_name, title 
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
		<title>受信ボックス</title>
	</head>
	
	<body>
		<div align="center">
			<font size="7">受信ボックス</font>
			<br>
		</div>
		<br>
		<hr color="blue">

		<!-- 連絡帳の受信一覧テーブル作成 -->
		<p align="left">
			<font size="5">連絡帳</font>
		</p>
		
		<div align="center">
			<table border="1">
				<tr bgcolor="yellow">
				<td align="center"width="150"><font size="5">日付</font></td>
				<td align="center"width="200"><font size="5">FROM</font></td>
				<td align="center"width="400"><font size="5">件名</font></td>
				
				<?php
				for ($i = 0; $i < $count; $i++){
					$row = mysql_fetch_array($result);
				?>
					<tr>
						<td><?= $row['send_date'] ?></td>
						<td><?= $row['send_user_name'] ?></td>
						<td>
							<a href="view.php?id=<?= $row['contact_book_seq'] ?>"><?= $row['title'] ?></a>
						</td>
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
			
			$sql = "SELECT print_delivery_seq, target_group_seq, delivery_user_seq, delivery_date, printurl, title, m_user.user_name AS send_user_name 
					FROM print_delivery 
					LEFT JOIN m_user ON print_delivery.delivery_user_seq = m_user.user_seq
					LEFT JOIN group_details ON print_delivery.target_group_seq = group_details.group_seq
					WHERE group_details.user_seq = $user_seq
					ORDER BY delivery_date DESC;";
			$result = mysql_query($sql);
			$cnt = mysql_num_rows($result);
			
			//データベースを閉じる
			Dbdissconnect($dbcon);
			
		?>
		
		<!-- プリントの受信一覧テーブル作成 -->
		<p align="left">
			<font size="5">配信</font>
		</p>
					
		<div align="center">
			<table border="1">
				<tr bgcolor="yellow">
					<td align="center"width="150"><font size="5">日付</font></td>
					<td align="center"width="200"><font size="5">FROM</font></td>
					<td align="center"width="400"><font size="5">件名</font></td>	
				</tr>
			
				<?php
				for ($i = 0; $i < $cnt; $i++){
					$row = mysql_fetch_array($result);
				?>
					<tr>
						<td><?= $row['delivery_date'] ?></td>
						<td><?= $row['send_user_name'] ?></td>
						<td>
							<!-- <a href="<?= printurl ?>"><?= $row['title'] ?></a> -->
							<a href="pdf_relay.php?id=<?= $row['print_delivery_seq'] ?>"><?= $row['title'] ?></a>
						</td>
					</tr>
				<?php 
				}
				?>
				
			</table>
		</div>
	</body>
</html>
