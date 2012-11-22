<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		 <link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		 <link rel="stylesheet" type="text/css" href="../css/button.css" />
		<script type="text/javascript">
			function p_newcreate(){
				parent.right.location="p_CreateNew.php";
			}
			function p_transmition(){
				parent.right.location="p_outbox.php";
			}
			function p_draft(){
				parent.right.location="p_draft.php";
			}
		</script>
		<title>プリント配信</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">プリント配信</font>
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
				/*   print_flg（プリント受信時　１：未読　０：既読）                            */
				/*   print_send_flg（プリント未送信時　１：未送信　０：送信済み） */
				/***************************************************/

				//フラグの情報をデータベースから取得し、その件数を数える
				$sql = "SELECT print_send_flg FROM print_delivery
						WHERE print_send_flg = 1
						AND print_delivery.delivery_user_seq = $user_seq;";
				$result = mysql_query($sql);
				$cnt_print_send = mysql_num_rows($result);

				//データベースを閉じる
				Dbdissconnect($dbcon);
			?>

			<input class="button2" type="button"  style="border:0" name="newcreate" value="新規作成" onclick="p_newcreate()">
			<br><br>
			<input class="button2" type="button" style="border:0" name="transmit" value="送信箱 " onclick="p_transmition()">
			<br><br>
			<input class="button2" type="button" style="border:0" name="transmit" value="下書き （<?= $cnt_print_send?> ）" onclick="p_draft()">
		</p>
		</div>
	</body>
</html>