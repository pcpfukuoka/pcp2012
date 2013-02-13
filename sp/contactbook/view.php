<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	$id = $_GET['id'];
	$link_contact_book_seq = $_GET['link_contact_book_seq'];

	$sql = "SELECT contact_book_seq, contact_book.send_user_seq AS send_user_seq, contact_book.reception_user_seq AS reception_user_seq,
				   aa.user_name AS send_user_name, bb.user_name AS reception_user_name, title, contents, link_contact_book_seq
			FROM contact_book
			LEFT JOIN m_user AS aa ON contact_book.send_user_seq = aa.user_seq
			LEFT JOIN m_user AS bb ON contact_book.reception_user_seq = bb.user_seq
			WHERE contact_book_seq = '$id';";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	$sql = "UPDATE contact_book
			SET new_flg = 0
			WHERE contact_book_seq = '$id'; ";
	$result = mysql_query($sql);

	//返信されたメールに関連するメールを表示するデータの取り出し
	$sql = "SELECT contact_book_seq, contact_book.send_user_seq AS send_user_seq, contact_book.reception_user_seq AS reception_user_seq,
				   a.user_name AS send_user_name, b.user_name AS reception_user_name, title, contents, link_contact_book_seq
			FROM contact_book
			LEFT JOIN m_user AS a ON contact_book.send_user_seq = a.user_seq
			LEFT JOIN m_user AS b ON contact_book.reception_user_seq = b.user_seq
			WHERE contact_book_seq = '$link_contact_book_seq'";
	$abcd = mysql_query($sql);
	$aaaa = mysql_fetch_array($abcd);
	$cnt = mysql_num_rows($abcd);

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, intital-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		<title> 確認画面</title>
	  	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	  	<meta http-equiv="Content-Style-Type" content="text/css">
	  	<link rel="stylesheet" type="text/css" href="../../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../../css/table.css" />
		<link rel="stylesheet" type="text/css" href="../../css/table_search.css" />
		<link rel="stylesheet" href="../css/table.css" />
	</head>

	<body>
		<div id="container">
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

				<div data-role="content" align="left">
					<div align="center">
					    <font class="Cubicfont">確認画面</font><br><br>
					</div>

					<hr color="blue">
					<br><br><br>

					<form action="ReplyBox.php" method="POST">
						<?php
							if($cnt == 1)
							{
						?>
								<font size="5">From：</font>
								<?= $aaaa['send_user_name'] ?><br>
								<font size="5">To： </font>
					  			<?= $aaaa['reception_user_name']?><br>
								<font size="5">件名：</font>
								<?= $aaaa['title'] ?><br><br>
							    <font size="5">本文</font><br>
							    <textarea readonly="readonly" rows="40" cols="50" name="contents"><?= $aaaa['contents'] ?></textarea>
							    <br>
						<?php
							}
						?>

						<font size="5">From：</font>
						<?= $row['send_user_name'] ?><br>
						<font size="5">件名：</font>
						<?= $row['title'] ?><br><br>
					    <font size="5">本文</font><br>
					    <textarea readonly="readonly" id='animated' rows="2" cols="50" name="contents"><?= $row['contents']?></textarea><br>

					    <input type="hidden" value="<?= $row['send_user_name'] ?>" name="sendto">
					    <input type="hidden" value="<?= $row['send_user_seq'] ?>" name="send_seq">
					    <input type="hidden" value="<?= $row['title'] ?>" name="title">
					    <input type="hidden" value="<?= $row['contents'] ?>" name="contents">
					    <input type="hidden" value="<?= $id ?>" name="link_id">
					    <div align="center">
					    	<input class="button4" type="submit" data-role="button" data-inline="true"  value="返信">
					    </div>
				    </form>
		    	</div>
		    	<div data-role="footer" data-position="fixed">
					<p>PCP2012</p>
					<a href="MailBox.php" data-role="button" data-icon="back" class="ui-btn-left">戻る</a>
					<a href="../index.php" data-transition="slide" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
				</div>
			</div>
		</div>
    </body>
</html>


