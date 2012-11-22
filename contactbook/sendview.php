<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	$id = $_GET['id'];

	$sql = "SELECT contact_book_seq, m_user.user_name AS reception_user_name, title, contents
			FROM contact_book
			Left JOIN m_user ON contact_book.reception_user_seq = m_user.user_seq
			WHERE contact_book_seq = '$id';";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$sql = "UPDATE contact_book
			SET send_flg = 0
			WHERE contact_book_seq = '$id'; ";

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html>
	<head>
	　　<title> 確認画面</title>
	  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	  <link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<form action="ReplyBox.php" method="POST">
			<div align="center">
			    <font size = "7">確認画面</font><br>
			</div>

			<font size = "4"><a href="OutBox.php">←戻る</a></font>

			<hr color="green">
			<br><br>

			<font size="3">宛先　：</font>
			<?= $row['reception_user_name'] ?><br>
			<font size="3">件名　：</font>
			<?= $row['title'] ?><br><br>

		    <font size="3">本文</font><br>
		    <?= $row['contents']?><br>

		    <input type="hidden" value="<?= $row['reception_user_name'] ?>" name="sendto">
		    <input type="hidden" value="<?= $row['title'] ?>" name="title">

	    </form>
	    </div>
    </body>
</html>
