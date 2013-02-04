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
	    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	    <meta name="viewport" content="width=device-width, intital-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	
	　　<title> 送信</title>
	  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	  <meta http-equiv="Content-Style-Type" content="text/css">
	  <link rel="stylesheet" type="text/css" href="../css/button.css" />
	  
	  
	</head>
	
	<body>
	   <div align="center">
			<div data-role="header" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="">スケジュール</a></li>
						<li><a href="main.php" class="ui-btn-active">連絡帳</a></li>
						<li><a href="">授業</a></li>
						<li><a href="../Results_management/Per_ver.php">成績確認</a></li>
						<li><a href="../question/answer_list.php">アンケート</a></li>
					</ul>
				</div>
			</div>
			
			<div data-role="content">
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
	      <input class="button4" type="submit"  data-role="button" data-inline="true" value="送信" name = "send_update">
		  <input class="button4" type="submit"  data-role="button" data-inline="true" value="保存" name="Preservation"><br>
		  	
	    </form>
	    </div>
	    	 
	    	<div data-role="footer" data-position="fixed" >
				<p>PCP2012</p>
				<a href="Draft.php" data-role="button" data-icon="back"  class="ui-btn-left">戻る</a>
				<a href="../index.php" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
			</div>
	</div>     
    </body>
</html>