<?php
	session_start();
	//SESSIONでログイン確認
	if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
	{
		header("Location:login/index.php");
	}
	//SESSIONでユーザIDの取得
	$user_seq = $_SESSION['login_info[user]'];
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, intital-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		
		<title>連絡帳</title>
	</head>

	<body>
		<div data-role="page" id="contactbook" align="center">
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
				<div align="center">
					<font size = "7">連絡帳</font><br><br>

					<hr color="blue">
					<br><br><br>

					<?php

						//データベースの呼出
						require_once("../lib/dbconect.php");
						$dbcon = DbConnect();
						
						/***************************************************/
						/*         フラグの種類　　　　　　　                            　　　　　　　　　　*/
						/*   new_flg（連絡帳受信時　１：未読　０：既読）                          　　*/
						/*   send_flg（連絡帳未送信時　１：未送信　０：送信済み）              */
						/*   print_flg（プリント受信時　１：未読　０：既読）                            */
						/*   print_send_flg（プリント未送信時　１：未送信　０：送信済み） */
						/***************************************************/
		
						//フラグの情報をデータベースから取得し、その件数を数える　（連絡帳の新着受信）
						$sql = "SELECT new_flg FROM contact_book
								WHERE new_flg = 1
								AND contact_book.reception_user_seq = $user_seq;";
						$result = mysql_query($sql);
						$cnt_new = mysql_num_rows($result);
						
						//フラグの情報をデータベースから取得し、その件数を数える　（連絡帳の未送信）
						$sql = "SELECT send_flg FROM contact_book
								WHERE send_flg = 1
								AND contact_book.reception_user_seq = $user_seq;";
						$result = mysql_query($sql);
						$cnt_send = mysql_num_rows($result);
						
						//フラグの情報をデータベースから取得し、その件数を数える　（プリント配信の新着受信）
						$sql = "SELECT * FROM  print_check 
								WHERE user_seq = '$user_seq' 
								AND print_check_flg = 1;";
						$result = mysql_query($sql);
						$cnt_print_flg = mysql_num_rows($result);
										
						//データベースを閉じる
						Dbdissconnect($dbcon);
						
					?>
			
					<!-- それぞれのリンク先に移動 -->
					<form action="relay.php" method="POST">
						<input type="submit" name="CreateNew" value="新規作成">
						<br><br>
						<input type="submit" name="MAilBox" value="受信箱（<?= $cnt_new + $cnt_print_flg ?>）">
						<br><br>
						<input type="submit" name="OutBox" value="送信箱 ">
						<br><br>
						<input type="submit" name="Draft" value="下書き （<?= $cnt_send?>）">
					</form>
				</div>
			</div>

			<div data-role="footer" data-position="fixed">
	    		<a href="../index.php" data-role="button" data-icon="back"  class="ui-btn-left">戻る</a>
				<p>PCP2012</p>
				<a href="../index.php" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
			</div>
		</div>
	</body>
</html>