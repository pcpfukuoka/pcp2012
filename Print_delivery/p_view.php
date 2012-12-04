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
		<title>確認画面</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>

	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">確認画面</font>
			</div>

			<font size = "4"><a href="p_draft.php">←戻る</a></font>
			<hr color="blue">
			<br><br>

			<form action="p_relay.php" method="POST">
				<font size="3"> T o：</font>
				<?= $row['group_name'] ?><br>
				<font size="3">件名：</font>
				<input size="50" type="text" name="title" value="<?= $row['title'] ?>"><br>

				<font size="3">プリント</font>
				<div id="delete_<?= $row['print_delivery_seq'] ?>">
					<?= $row['printurl'] ?>
					<input type="button" data-id="<?= $row['print_delivery_seq'] ?>" class="p_delete" value="削除">
					<br><br>
				</div>

				<input type="hidden" value="<?= $row['print_delivery_seq'] ?>" name="print_delivery_seq">

				<div id="pdf_upload">

				</div>

			    <?php
			    	//先生・管理者以外の人は送信できないようにする
			    	if($page_cla['delivery_flg'] == 0)
			    	{
			    ?>
			    		<input class="button4" type="submit" value="保存" name="Re-preservation">
			    <?php
			    	}
			    	//先生・管理者のみ送信可能
			    	else
			    	{
			    ?>
			    		<input class="button4" type="submit" value="保存" name="Re_preservation">
			    		<input class="button4" type="submit" value="送信" name="send">
			    <?php
			    	}
			    ?>
			</form>
		</div>
	</body>

	<script>
		$(function() {

			//削除ボタン//
			//削除ボタンを押したら新しくファイル選択できる処理
			$(document).on('click', '.p_delete', function() {
				//選択したli要素からdata-idを取得する(data-idはprint_deliveryのprint_delivery_seq)
		        var id = $(this).data('id');
		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('p_delete.php', {
		            id: id,
		        },
		        //戻り値はなし
		        function(rs) {

		        	$('#delete_'+id).remove();

	                $('#pdf_upload').append('<input size="30" type="file" name="pdf"><br><br>');

		        });
		    });
		});

	</script>
</html>
