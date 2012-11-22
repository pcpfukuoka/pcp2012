<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	$id = $_GET['id'];

	$sql = "SELECT contact_book_seq, contact_book.send_user_seq AS send_user_seq, m_user.user_name AS send_user_name, title, contents
			FROM contact_book
			Left JOIN m_user ON contact_book.send_user_seq = m_user.user_seq
			WHERE contact_book_seq = '$id';";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$sql = "UPDATE contact_book
			SET new_flg = 0
			WHERE contact_book_seq = '$id'; ";
	$result = mysql_query($sql);

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
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<form action="ReplyBox.php" method="POST">
			<div align="center">
			    <font size = "7">確認画面</font><br>
			</div>
			<div>
				<font size = "4"><a href="MailBox.php">←戻る</a></font>
			</div>

			<hr color="blue">
			<br><br>

			<font size="3">From　：</font>
			<?= $row['send_user_name'] ?><br>
			<font size="3">件名　：</font>
			<?= $row['title'] ?><br><br>

		    <font size="3">本文</font><br>
		    <?= $row['contents']?><br><br><br>
		    <input type="hidden" value="<?= $row['send_user_name'] ?>" name="sendto">
		    <input type="hidden" value="<?= $row['send_user_seq'] ?>" name="send_seq">
		    <input type="hidden" value="<?= $row['title'] ?>" name="title">
		    <input type="hidden" value="<?= $row['contents'] ?>" name="contents">
		    <input type="hidden" value="<?= $id ?>" name="link_id">
		    <input class="button4" type="submit" value="返信">
	    </form>
	    </div>
    </body>
</html>


