<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 11);

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	$id = $_GET['id'];
	$printurl = $_GET['printurl'];

	$sql = "SELECT print_delivery_seq, delivery_user_seq, target_group_seq, delivery_date, m_group.group_name AS group_name, title, printurl
			FROM print_delivery
			Left JOIN m_group ON print_delivery.target_group_seq = m_group.group_seq
			WHERE delivery_user_seq = '$user_seq'
			AND print_delivery_seq = '$id';";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	$sql = "UPDATE print_check
			SET print_check_flg = 0
			WHERE print_delivery_seq = '$id'
			AND user_seq = '$user_seq';";
	$result = mysql_query($sql);

	//データベースを閉じる
	Dbdissconnect($dbcon);

?>

<html>
	<head>
		<title>プリント確認画面</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
	</head>

	<body>
		<div id="container">
		<div align="center">
			<font class="Cubicfont">プリント確認画面</font>
		</div>



		<font size = "4"><a href="../contactbook/MailBox.php">←戻る</a></font>
		<hr color="blue">
		<br><br>

			<font size="3">To ：</font>
			<?= $row['group_name'] ?><br>
			<font size="3">件名 ：</font>
			<?= $row['title'] ?><br><br>
			<object data="test.pdf" width="800" height="400">
			<p>ご覧の環境では、object要素がサポートされていないようです。<a href="images/kaeru.pdf">PDFファイルをダウンロードしてください</a>。</p>
			</object>

		</div>
	</body>
</html>

