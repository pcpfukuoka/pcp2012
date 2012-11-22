<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	$id = $_GET['id'];

	$sql = "SELECT print_delivery_seq, delivery_user_seq, target_group_seq, delivery_date, m_group.group_name AS group_name, title, printurl
			FROM print_delivery
			Left JOIN m_group ON print_delivery.target_group_seq = m_group.group_seq
			WHERE delivery_user_seq = '$user_seq'
			AND print_delivery_seq = '$id';";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	//データベースを閉じる
	Dbdissconnect($dbcon);

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<title>確認画面</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<form action="p_relay.php" method="POST">

			<div align="center">
				<font size = "6">確認画面</font><br><br>
			</div>

			<font size = "4"><a href="p_draft.php">←戻る</a></font>
			<hr color="blue">
			<br><br><br>

			<font size="3">To　：</font>
			<?= $row['group_name'] ?><br>
			<font size="3">件名　：</font>
			<?= $row['title'] ?><br><br>

			<font size="3">本文</font><br>
		    <textarea rows="10" cols="80" name="printurl"><?= $row['printurl'] ?></textarea><br>
		    <input type="hidden" value="<?= $row['print_delivery_seq'] ?>" name="print_delivery_seq">
		    <input type="hidden" value="<?= $row['delivery_user_seq'] ?>" name="delivery_user_seq">
		    <input type="hidden" value="<?= $row['group_name'] ?>" name="group_name">
		    <input type="hidden" value="<?= $row['target_group_seq'] ?>" name="group_seq">
		    <input type="hidden" value="<?= $row['title'] ?>" name="title">
		    <br>
		    <input class="button4" type="submit" value="送信" name="send">
		</form>
		</div>
	</body>
</html>
