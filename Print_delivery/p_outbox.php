<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	/*****************************************************************************/
	//								注意！！！！！！								 //
	//動作確認のため、SQL文のWHERE句の $user_seq を 『　１　』 に変えているので、最後に変えること！！！！ //
	//あと、SESSIONをコメントにしているので、それも変えること！！									 //
	/*****************************************************************************/
	
	$sql = "SELECT print_delivery_seq, delivery_date, title, printurl, m_group.group_name AS group_name
			FROM print_delivery 
			Left JOIN m_group ON print_delivery.target_group_seq = m_group.group_seq
			WHERE print_delivery.delivery_user_seq = $user_seq
			AND print_send_flg = 0
			ORDER BY delivery_date DESC;";			
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	
	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>送信ボックス</title>
	</head>
	
	<body>
		<div align="center">
			<font size = "7">プリント送信ボックス</font><br><br>
		</div>

		<hr color="blue">
		<br><br>
		
		<!-- プリントの送信済み一覧テーブル作成 -->
		<div align="center">
			<table border="1">
				<tr bgcolor="yellow">
					<td align="center"width="160"><font size="5">日付</font></td>
					<td align="center"width="150"><font size="5">TO</font></td>
					<td align="center"width="230"><font size="5">件名</font></td>
					
				<?php 
				for ($i = 0; $i < $count; $i++){
					$row = mysql_fetch_array($result);
				?>
					
				<tr>
					<td><?= $row['delivery_date'] ?></td>
					<td><?= $row['group_name'] ?></td>
					<td>
						<a href="p_sendview.php?id=<?= $row['print_delivery_seq'] ?>"><?= $row['title'] ?></a>
					</td>
				</tr>
				<?php 
					}
				?>		
			</table>
		</div>
	</body>
</html>