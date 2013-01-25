<?php
	//SESSIONでユーザIDの取得
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
	{
		//header("Location:login/index.php");
	}

	//page_seq = 3(連絡帳)
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 3);


	if($page_cla[0]['read_flg'] == 0)
	{
		header("Location:../Top/top_left.php");
	}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/frame_jump.js"></script>
		<title>連絡帳</title>

	</head>

	<!-- ↓↓１秒ごとにページを自動更新する処理↓↓↓ -->
	<!-- onLoad="setInterval('changeImg()',1000)" -->

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">連絡帳</font>
		</div>

		<hr color="blue">
		<br><br><br>

		<p align="center">
			<?php

				//データベースの呼出
				require_once("../lib/dbconect.php");
				$dbcon = DbConnect();

				/******************************************************************/
				/*         フラグの種類                                           */
				/*   new_flg（連絡帳受信時 １：未読 ０：既読）                    */
				/*   send_flg（連絡帳未送信時 １：未送信 ０：送信済み）           */
				/*   print_flg（プリント受信時 １：未読 ０：既読）                */
				/*   print_send_flg（プリント未送信時 １：未送信 ０：送信済み）   */
				/******************************************************************/

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

			<input class="button2" type="button" onclick="jump('CreateNew.php')" value="新規作成">
			<br><br>
			<input class="button2" type="button" onclick="jump('MailBox.php')" value="受信箱（<?= $cnt_new + $cnt_print_flg ?>）">
			<br><br>
			<input class="button2" type="button" onclick="jump('OutBox.php')" value="送信箱">
			<br><br>
			<input class="button2" type="button" onclick="jump('Draft.php')" value="下書き（<?= $cnt_send ?>）">
		</p>
		</div>
	</body>
</html>