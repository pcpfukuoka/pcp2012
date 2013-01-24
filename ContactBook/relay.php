<?php
	//SESSIONでユーザIDの取得
	session_start();
?>

	<html>
		<head>
			<script src="../javascript/frame_jump.js"></script>
		</head>

		<body>
		</body>
	</html>


<?php
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//新規
    if (isset($_POST['send']))
    {
        //送信完了ボタンの時の処理
        $title = $_POST['title'];
        $contents = $_POST['contents'];
        if(isset($_POST['to']))
        {
        	$send_seq = $_POST['to'];
        }
        else if(isset($_POST['send_seq']))
        {
        	$send_seq = $_POST['send_seq'];
        }
        else if(isset($_POST['reception_user_seq']))
        {
        	$send_seq = $_POST['reception_user_seq'];
        }
        $link_id = $_POST['link_id'];

        if($title == "")
        {
        	$title = "（件名なし）";
        }

        if($contents == "")
        {
        	$contents = "（本文なし）";
        }

    	$sql = "INSERT INTO contact_book (title, contents, send_user_seq, reception_user_seq, link_contact_book_seq, send_date, new_flg, send_flg)
    			VALUES ('$title', '$contents', '$user_seq', '$send_seq', '$link_id', now(), '1', '0')";
    	mysql_query($sql);

    	//データベースを閉じる
    	Dbdissconnect($dbcon);

    	print "<script language=javascript>leftreload();</script>";
    	print "<script language=javascript>jump('comp_dis.html','right');</script>";
    }
    //一時保存
    elseif ( isset($_POST['Preservation']) )
    {
        //保存ボタンの時の処理
    	$title = $_POST['title'];
    	$contents = $_POST['contents'];
    	if(isset($_POST['to']))
    	{
    		$send_seq = $_POST['to'];
    	}
    	else if(isset($_POST['send_seq']))
    	{
    		$send_seq = $_POST['send_seq'];
    	}
    	$link_id = $_POST['link_id'];

    	if($title == "")
    	{
    		$title = "（件名なし）";
    	}

    	if($contents == "")
    	{
    		$contents = "（本文なし）";
    	}

    	$sql = "INSERT INTO contact_book (title, contents, send_user_seq, reception_user_seq, link_contact_book_seq, send_flg, delete_flg, send_date)
    	VALUES ('$title', '$contents', '$user_seq', '$send_seq', '$link_id', '1', '0', now())";
    	mysql_query($sql);

    	//データベースを閉じる
    	Dbdissconnect($dbcon);

    	print "<script language=javascript>leftreload();</script>";
    	print "<script language=javascript>jump('Preservation.html','right');</script>";
    }
    //アップデート
    else if(isset($_POST['send_update']))
    {
    	//送信完了ボタンの時の処理
    	$contact_book_seq = $_POST['contact_book_seq'];
    	$contents = $_POST['contents'];
    	$title = $_POST['title'];
    	if(isset($_POST['to']))
    	{
    		$send_seq = $_POST['to'];
    	}
    	else if(isset($_POST['send_seq']))
    	{
    		$send_seq = $_POST['send_seq'];
    	}
    	else if(isset($_POST['reception_user_seq']))
    	{
    		$send_seq = $_POST['reception_user_seq'];
    	}
    	$link_id = $_POST['link_id'];

    	$sql = "UPDATE contact_book
				SET title = '$title', contents = '$contents', send_flg = 0, new_flg = 1, delete_flg = 1, send_date = now()
				WHERE contact_book_seq = '$contact_book_seq'; ";
    	mysql_query($sql);

    	//データベースを閉じる
    	Dbdissconnect($dbcon);

    	print "<script language=javascript>leftreload();</script>";
    	print "<script language=javascript>jump('comp_dis.html','right');</script>";
    }
    //保存からの保存
    else if(isset($_POST['Re_preservation']))
    {
		//保存ボタンの時の処理
		$contact_book_seq = $_POST['contact_book_seq'];
		$contents = $_POST['contents'];
		$title = $_POST['title'];
		$link_id = $_POST['link_id'];

		$sql = "UPDATE contact_book
				SET title = '$title', contents = '$contents', link_contact_book_seq = '$link_id', send_date = now()
				WHERE contact_book_seq = $contact_book_seq;";
		mysql_query($sql);

		//データベースを閉じる
		Dbdissconnect($dbcon);

    	print "<script language=javascript>leftreload();</script>";
    	print "<script language=javascript>jump('Preservation.html','right');</script>";
	}
?>