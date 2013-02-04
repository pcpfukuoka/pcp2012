<?php
	require_once("../lib/dbconect.php");	
	$send_name = $_POST['sendto'];
	$send_seq = $_POST['send_seq'];
	$title = $_POST['title'];
	$link_id = $_POST['link_id'];
	$contents = $_POST['contents'];
		     
?>
     
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, intital-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	　　<title> 返信</title>
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
		    <font size = "7">返信</font><br>
		  </div>
		　　<hr color="blue">
		  <br><br>
		  
		  <font size="3">宛先　： </font>
		  <?= "$send_name"?><br>
		  <font size="3">件名　： </font>
		  <input size="40" type="text" name="title" value="Re: <?= "$title"?>"><br><br>
	      <font size="3">本文</font><br>
	      <textarea rows="40" cols="50" name="contents">＞<?= "$contents" ?></textarea><br>
	      
	      <input type="hidden" value="<?= $send_seq ?>" name="send_seq">
	      <input type="hidden" value="<?= $link_id ?>" name="link_id">
	      <input class="button4" type="submit"  data-role="button" data-inline="true" value="送信" name = "send">
		  <input class="button4" type="submit"  data-role="button" data-inline="true" value="保存" name="Preservation"><br>
		  	
	    </form>
	    </div>
	    	 
	    	<div data-role="footer" data-position="fixed" >
				<p>PCP2012</p>
				<a href="#" data-rel="back" data-role="button" data-icon="back"  class="ui-btn-left">戻る</a>
				<a href="../index.php" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
			</div>
	</div>     
    </body>
</html>
        