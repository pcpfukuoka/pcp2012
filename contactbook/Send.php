<?php
	require_once("../lib/dbconect.php");
	$dbcon = dbconnect();
	if(!isset($_GET['id']))
	{
		header("Location:Draft.php");
	}
	else
	{
		$contact_book_seq = $_GET['id'];
	}

	$sql = "SELECT contact_book_seq, link_contact_book_seq, reception_user_seq, m_user.user_name AS reception_user_name, title,
			contents
			FROM contact_book
			Left JOIN m_user ON contact_book.reception_user_seq = m_user.user_seq
			WHERE contact_book_seq = '$contact_book_seq';";
	$result = mysql_query($sql);
	$contact_book_row = mysql_fetch_array($result);
?>

<html>
	<head>
	　　<title> 送信</title>
	  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	  <meta http-equiv="Content-Style-Type" content="text/css">
	  <link rel="stylesheet" type="text/css" href="../css/button.css" />
	  <link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<form action="relay.php" method="POST" id="input">
		  <div align="center">
		    <font size = "7">送信</font><br>
		  </div>
		　　<hr color="blue">
		  <br><br>

		  <font size="3">宛先　： </font>
		  <?= $contact_book_row['reception_user_name']?><br>
		  <font size="3">件名　： </font>
		  <input size="40" type="text" name="title" value="<?= $contact_book_row['title']?>"><br><br>
	      <font size="3">本文</font><br>
	      <textarea rows="40" cols="50" name="contents"><?= $contact_book_row['contents'] ?></textarea><br>

	      <input type="hidden" value="<?= $contact_book_row['contact_book_seq'] ?>" name="contact_book_seq">
	      <input type="hidden" value="<?= $contact_book_row['reception_user_seq'] ?>" name="reception_user_seq">
	      <input type="hidden" value="<?= $contact_book_row['link_contact_book_seq'] ?>" name="link_id">
	      <input class="button4" type="submit" value="送信" name = "send_update">
		  <input class="button4" type="submit" value="保存" name="Preservation"><br>

	    </form>
	    </div>
    </body>
</html>