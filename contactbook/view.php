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

<html>
	<head>
	  <title> 確認画面</title>
	  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	  <meta http-equiv="Content-Style-Type" content="text/css">
	  <link rel="stylesheet" type="text/css" href="../css/button.css" />
	  <link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	  <link rel="stylesheet" type="text/css" href="../css/text_display.css" />
	  <script src="../javascript/frame_jump.js"></script>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
			    <font class="Cubicfont">確認画面</font>
			</div>
			<div>
				<font size = "4"><a href="MailBox.php">←戻る</a></font>
			</div>

			<hr color="blue">
			<br><br>

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
					    <textarea readonly="readonly" rows="40" cols="50" name="contents"><?= $aaaa['contents']?></textarea>
					    <br><br><br>
				<?php
					}
				?>

				<font size="5">From：</font>
				<?= $row['send_user_name'] ?><br>
				<font size="5">To： </font>
				<?= $row['reception_user_name']?><br>
				<font size="5">件名：</font>
				<?= $row['title'] ?><br><br>

			    <font size="5">本文</font><br>
			    <textarea readonly="readonly" rows="40" cols="50" name="contents"><?= $row['contents']?></textarea>
			    <br><br>

			    <input type="hidden" value="<?= $row['send_user_name'] ?>" name="sendto">
			    <input type="hidden" value="<?= $row['send_user_seq'] ?>" name="send_seq">
			    <input type="hidden" value="<?= $row['title'] ?>" name="title">
			    <input type="hidden" value="<?= $row['contents'] ?>" name="contents">
			    <input type="hidden" value="<?= $id ?>" name="link_id">
			    <input class="button4" type="submit" value="返信">
	    	</form>
	    </div>

	    <?php
	    	print "<script language=javascript>leftreload();</script>";
	    ?>

    </body>
</html>


