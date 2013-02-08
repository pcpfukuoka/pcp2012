<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];
?>

<html>
	<head>
		<script src="../javascript/frame_jump.js"></script>
	</head>

	<body>
	</body>
</html>

<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

    //一時保存
    if (isset($_POST['Preservation']))
    {
        //保存ボタンの時の処理
    	$data = $_FILES['pdf'];
    	$title = $_POST['title'];
    	$send_seq = $_POST['to'];

    	if($title == "")
    	{
    		$title = "（件名なし）";
    	}

    	$sql = "INSERT INTO print_delivery (title, delivery_user_seq, target_group_seq, print_send_flg, print_flg, delivery_date)
    			VALUES ('$title', '$user_seq', '$send_seq', '1', '0', now())";
    	mysql_query($sql);

    	//INSERTしたSEQを取得
    	$sql = "SELECT print_delivery_seq FROM print_delivery ORDER BY print_delivery_seq DESC;";
    	$result = mysql_query($sql);
    	$row = mysql_fetch_array($result);
    	$pdseq = $row['print_delivery_seq'];

    	//UPDATEでリンクを保存
    	$sql = "UPDATE print_delivery SET printurl = 'print_delivery_seq_$pdseq.pdf'
    			WHERE print_delivery_seq = $pdseq;";
    	mysql_query($sql);
    	move_uploaded_file($data['tmp_name'], 'print_delivery_seq_$pdseq.pdf');

    	//データベースを閉じる
    	Dbdissconnect($dbcon);

    	print "<script language=javascript>leftreload();</script>";
    	print "<script language=javascript>jump('p_preservation.html','right');</script>";
    }
    //送信
    else if(isset($_POST['send']))
    {
    	//送信完了ボタンの時の処理
    	$print_delivery_seq = $_POST['print_delivery_seq'];
    	$title = $_POST['title'];
    	//$delivery_user_seq = $_POST['delivery_user_seq'];
    	//$group_name = $_POST['group_name'];
    	//$group_seq = $_POST['group_seq'];

    	$sql = "UPDATE print_delivery
				SET title = '$title', print_flg = 1, print_send_flg = 0, delivery_date = now()
				WHERE print_delivery_seq = '$print_delivery_seq'; ";
    	mysql_query($sql);

    	$sql = "SELECT group_details.user_seq AS user_seq
    			FROM group_details
    			LEFT JOIN print_delivery ON group_details.group_seq = print_delivery.target_group_seq
    			WHERE print_delivery_seq = $print_delivery_seq";
    	$user_result = mysql_query($sql);
    	$user_cnt = mysql_num_rows($user_result);

    	for ($i = 0; $i < $user_cnt; $i++)
    	{
    		$row = mysql_fetch_array($user_result);
    		$user_seq = $row['user_seq'];
	    	//print_checkにデータをINSERT
	    	$sql = "INSERT INTO print_check (print_delivery_seq, user_seq, print_check_flg)
	    			VALUE ('$print_delivery_seq', '$user_seq', '1')";
	    	mysql_query($sql);
    	}
    	//データベースを閉じる
    	Dbdissconnect($dbcon);

    	print "<script language=javascript>leftreload();</script>";
    	print "<script language=javascript>jump('p_com_disp.php','right');</script>";
    }
    //保存からの保存
    else if(isset($_POST['Re_preservation']))
    {
    	$title = $_POST['title'];
    	$print_delivery_seq = $_POST['print_delivery_seq'];

    	$sql = "UPDATE print_delivery
    			SET title = '$title', delivery_date = now()
    			WHERE print_delivery_seq = '$print_delivery_seq';";
    	mysql_query($sql);

    	//INSERTしたSQLを取得
    	$sql = "SELECT print_delivery_seq FROM print_delivery ORDER BY print_delivery_seq DESC;";
    	$result = mysql_query($sql);
    	$row = mysql_fetch_array($result);
    	$pdseq = $row['print_delivery_seq'];

    	//UPDATEでリンクを保存
    	$sql = "UPDATE print_delivery SET printurl = 'print_delivery_seq_$pdseq.pdf'
    			WHERE print_delivery_seq = $pdseq;";
    	mysql_query($sql);
    	$file_name = "print_delivery_seq_" . $pdseq . ".pdf";
    	move_uploaded_file($data['tmp_name'], $file_name);

    	//データベースを閉じる
    	Dbdissconnect($dbcon);

    	print "<script language=javascript>leftreload();</script>";
    	print "<script language=javascript>jump('p_preservation.html','right');</script>";
    }
?>

