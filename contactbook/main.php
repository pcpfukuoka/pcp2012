<?php
	//SESSIONでユーザIDの取得
	session_start();
	$user_seq = $_SESSION['login_info[user]'];
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<script type="text/javascript">
			function newcreate(){
				parent.right.location="CreateNew.php";
			}

			function receved(){
				parent.right.location="MailBox.php";
			}

			function transmition(){
				parent.right.location="OutBox.php";
			}

			function draft(){
				parent.right.location="Draft.php";
			}
		</script>
		<title>連絡帳</title>
	</head>

	<body>
		<div align="center">
			<font size = "7">連絡帳</font><br><br>
		</div>

		<hr color="blue">
		<br><br><br>

		<p align="center">
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
			<input type="text"  style="border:0" name="newcreate" value="新規作成" onclick="newcreate()">
			<br><br>
			<input type="text" style="border:0" name="receve" value="受信箱（<?= $cnt_new + $cnt_print_flg ?> ）" onclick="receved()">
			<br><br>
			<input type="text" style="border:0" name="transmit" value="送信箱 " onclick="transmition()">
			<br><br>
			<input type="text" style="border:0" name="transmit" value="下書き （<?= $cnt_send?> ）" onclick="draft()">
		</p>
	</body>
</html>