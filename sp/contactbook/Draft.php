<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//contact_bookから項目の取り出し
	$sql = "SELECT contact_book.group_seq AS group_seq, contact_book_seq, link_contact_book_seq, send_date, m_user.user_name AS reception_user_name, title, m_group.group_name AS group_name
			FROM contact_book
			LEFT JOIN m_user ON contact_book.reception_user_seq = m_user.user_seq
			LEFT JOIN m_group ON contact_book.group_seq = m_group.group_seq
			WHERE contact_book.send_user_seq = $user_seq
			AND send_flg = 1
			AND contact_book.delete_flg = 0
			ORDER BY send_date DESC;";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, intital-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../../css/table.css" />
		<link rel="stylesheet" type="text/css" href="../../css/table_search.css" />
		<link rel="stylesheet" href="../css/table.css" />
		<title>下書き</title>
	</head>

	<body>
		<div align="center">
			<div data-role="header" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="main.php" class="ui-btn-active">連絡帳</a></li>
						<li><a href="../Lesson/join_lesson.php">授業</a></li>
						<li><a href="../Results_management/Per_ver.php">成績確認</a></li>
						<li><a href="../question/answer_list.php">アンケート</a></li>
					</ul>
				</div>
			</div>

			<div data-role="content">
				<div id="container">
					<div align="center">
						<font class="Cubicfont">下書き</font><br><br>
					</div>

					<hr color="blue">
					<br><br><br>

					<!-- テーブルの作成 -->
					<div align="center">
						<table class="table_01">
							<tr>
								<th align="center" width="150"><font size="5">日付</font></th>
								<th align="center" width="200"><font size="5">TO</font></th>
								<th align="center" width="400"><font size="5">件名</font></th>
							</tr>

							<?php
								for ($i = 0; $i < $count; $i++)
								{
									$row = mysql_fetch_array($result);
							?>
									<tr align="center">
										<td align="center"><?= $row['send_date'] ?></td>
										<?php
											//グループ宛て
											if($row['group_seq'] >= 0)
											{
										?>
												<td align="center"><?= $row['group_name'] ?></td>
										<?php
											}
											//個人宛て
											else
											{
										?>
												<td align="center"><?= $row['reception_user_name'] ?></td>
										<?php
											}
										?>
										<td align="center">
											<!-- GETでcontact_book_seqを送る -->
											<a href="Send.php?id=<?= $row['contact_book_seq'] ?>"><?= $row['title'] ?></a>
										</td>
									</tr>
							<?php
								}
							?>
						</table>
						<hr>
					</div>

			    	<div data-role="footer" data-position="fixed">
						<p>PCP2012</p>
						<a href="main.php" data-role="button" data-icon="back"  class="ui-btn-left">戻る</a>
						<a href="../index.php" data-transition="slide" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>