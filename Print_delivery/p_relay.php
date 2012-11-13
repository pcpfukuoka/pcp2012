<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

    //一時保存
    if ( isset($_POST['Preservation']) )
    {
        //保存ボタンの時の処理
    	$data = $_FILES['pdf'];
    	$title = $_POST['title'];
    	$send_seq = $_POST['to'];
    	
    	$sql = "INSERT INTO Print_delivery (title, delivery_user_seq, target_group_seq, print_send_flg, print_flg, delivery_date)
    			VALUES ('$title', '$user_seq', '$send_seq', '1', '0', now())";
    	mysql_query($sql);
    	
    	//INSERTしたSEQを取得
    	$sql = "SELECT print_delivery_seq FROM Print_delivery ORDER BY print_delivery_seq DESC;";
    	$result = mysql_query($sql);
    	$row = mysql_fetch_array($result);
    	$pdseq = $row['print_delivery_seq'];
    	
    	//UPDATEでリンクを保存
    	$sql = "UPDATE Print_delivery SET printurl = 'print_delivery_seq_$pdseq.pdf'
    			WHERE print_delivery_seq = $pdseq;";
    	mysql_query($sql);
    	move_uploaded_file($data['tmp_name'], 'print_delivery_seq_$pdseq.pdf');
    	 
    	//データベースを閉じる
    	Dbdissconnect($dbcon);
    	
		Header('Location: p_preservation.html');
        exit;
    }
    //送信
    else if(isset($_POST['send']))
    {
    	//送信完了ボタンの時の処理
    	$print_delivery_seq = $_POST['print_delivery_seq'];
    	$delivery_user_seq = $_POST['delivery_user_seq'];
    	$title = $_POST['title'];
    	$group_name = $_POST['group_name'];
    	$group_seq = $_POST['group_seq'];
   		    	
    	$sql = "UPDATE Print_delivery
				SET title = '$title', print_flg = 1, print_send_flg = 0, delivery_date = now()
				WHERE Print_delivery_seq = '$print_delivery_seq'; ";
    	mysql_query($sql);
    	    	
    	$sql = "SELECT * FROM group_details WHERE group_seq = '$group_seq'";
    	$group_result = mysql_query($sql);
    	$group_cnt = mysql_num_rows($group_result);
    	
    	for ($i = 0; $i < $group_cnt; $i++)
    	{
    		$row = mysql_fetch_array($group_result);
    		$group_user_seq = $row['user_seq']; 
	    	//print_checkにデータをインサート
	    	$sql = "INSERT INTO print_check (print_delivery_seq, user_seq, print_check_flg)
	    			VALUE ('$print_delivery_seq', '$group_user_seq', '1')";
	    	mysql_query($sql);
    	}
    	
    	//データベースを閉じる
    	Dbdissconnect($dbcon);
    	 
    	Header('Location: p_com_disp.php');
    	exit;
    }
?>

