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
	$result = mysql_query($sql);

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<title> 確認画面</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />

		<style>
			textarea {
				border:1px solid #ccc;
			}

			#animated {
				vertical-align: top;
				-webkit-transition: height 0.2s;
				-moz-transition: height 0.2s;
				transition: height 0.2s;
			}
		</style>

		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js'></script>
		<script src='autosize.js'></script>

		<script>
			$(function(){
				$('#normal').autosize();
				$('#animated').autosize({append: "\n"});
			});
		</script>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
			    <font class="Cubicfont">確認画面</font>
			</div>

			<hr color="blue">
			<br>

			<form action="ReplyBox.php" method="POST">
				<font size="5">To：</font>
				<?= $row['reception_user_name'] ?><br>
				<font size="5">件名：</font>
				<?= $row['title'] ?><br><br>

			    <font size="5">本文</font><br>
			    <textarea readonly="readonly" id='animated' rows="2" cols="50" name="contents"><?= $row['contents']?></textarea>
			    <br><br>

			    <input type="hidden" value="<?= $row['reception_user_name'] ?>" name="sendto">
			    <input type="hidden" value="<?= $row['title'] ?>" name="title">

	    	</form>
	    </div>
    </body>
</html>
