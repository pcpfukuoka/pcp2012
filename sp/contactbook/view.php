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
		<form action="ReplyBox.php" method="POST">
			<div align="center">
			    <font size = "7">確認画面</font><br>
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
		    <input class="button4" type="submit" data-role="button" data-inline="true"  value="返信">
	    </form>
	    </div>
	    	
	    	<div data-role="footer" data-position="fixed">
				<p>PCP2012</p>
				
				<a href="MailBox.php" data-role="button" data-icon="back" class="ui-btn-left">戻る</a>
				<a href="../index.php" data-transition="slide" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
			</div>
	</div>
    </body>  
</html>
        
        
