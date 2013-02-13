<?php
	//SESSIONでユーザIDの取得
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//ラジオボタンの個人が選択された場合
	if($_POST['switch'] == "user_seq")
	{
		$to_user = $_POST['to_user'];
	}
	//ラジオボタンのグループが選択された場合
	else
	{
		$to_group = $_POST['to_group'];
	}

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	////////////////////////////////////////////
	//新規送信（CreateNew.php と ReplyBox.php）/
	////////////////////////////////////////////
    if (isset($_POST['send']))
    {
        //送信完了ボタンの時の処理
        $title = $_POST['title'];
        $contents = $_POST['contents'];
        $link_id = $_POST['link_id'];

        //件名に何も入力されていないとき
        if($title == "")
        {
        	$title = "（件名なし）";
        }

        //本文に何も入力されていないとき
        if($contents == "")
        {
        	$contents = "（本文なし）";
        }

    	//新規作成の受信者のuser_seq（個人）
        if(isset($to_user))
        {
        	$send_seq = $to_user;
        }
        //返信時の受信者のuser_seq
        else if(isset($_POST['send_seq']))
        {
        	$send_seq = $_POST['send_seq'];
        }
        //新規作成の受信者のgroup_seq（グループ・全ユーザー）
        else if(isset($to_group))
        {
        	$group_seq = $to_group;
        }

    	//グループ宛ての送信なら
        if(isset($group_seq))
        {
        	//グループに所属するuser_seqの件数取り出し
			$sql = "SELECT group_details.user_seq AS user_seq FROM group_details
					LEFT JOIN m_group ON group_details.group_seq = m_group.group_seq
					LEFT JOIN m_user ON group_details.user_seq = m_user.user_seq
        			WHERE group_details.group_seq = '$group_seq'";
			$result = mysql_query($sql);
			$cnt = mysql_num_rows($result);

			for($i = 1; $i <= $cnt; $i++)
			{
				$row = mysql_fetch_array($result);
				$group_user_seq = $row['user_seq'];
				$sql = "INSERT INTO contact_book (title, contents, send_user_seq, reception_user_seq, link_contact_book_seq, send_date, new_flg, send_flg, group_seq)
						VALUE ('$title', '$contents', '$user_seq', '$group_user_seq', 'link_id', now(), '1', '0', '$group_seq')";
				mysql_query($sql);
			}
        }
        //個人宛ての送信なら
        else if(isset($send_seq))
        {
        	$sql = "INSERT INTO contact_book (title, contents, send_user_seq, reception_user_seq, link_contact_book_seq, send_date, new_flg, send_flg, group_seq)
        			VALUES ('$title', '$contents', '$user_seq', '$send_seq', '$link_id', now(), '1', '0', '-1')";
        	mysql_query($sql);
        }

    	//データベースを閉じる
    	Dbdissconnect($dbcon);

        print "<script language=javascript>leftreload();</script>";
    	print "<script language=javascript>jump('comp_dis.php','right');</script>";
    }
    ////////////////////////////////////////////
    //一時保存（CreateNew.php と ReplyBox.php）/
    ////////////////////////////////////////////
    elseif ( isset($_POST['Preservation']) )
    {
        //保存ボタンの時の処理
    	$title = $_POST['title'];
    	$contents = $_POST['contents'];
    	$link_id = $_POST['link_id'];

    	//件名に何も入力されていないとき
    	if($title == "")
    	{
    		$title = "（件名なし）";
    	}

    	//本文に何も入力されていないとき
    	if($contents == "")
    	{
    		$contents = "（本文なし）";
    	}

    	//新規作成の受信者のuser_seq（個人）
    	if(isset($to_user))
    	{
    		$send_seq = $to_user;
    	}
    	//返信時の受信者のuser_seq
    	else if(isset($_POST['send_seq']))
    	{
    		$send_seq = $_POST['send_seq'];
    	}
    	//新規作成の受信者のgroup_seq（グループ・全ユーザー）
    	else if(isset($to_group))
    	{
    		$group_seq = $to_group;
    	}

    	//グループ宛て
    	if(isset($group_seq))
    	{
    		$sql = "INSERT INTO contact_book (title, contents, send_user_seq, reception_user_seq, link_contact_book_seq, send_date, send_flg, delete_flg, group_seq)
    				VALUES ('$title', '$contents', '$user_seq', '$group_seq', '$link_id', now(), '1', '0', '$group_seq')";
    		mysql_query($sql);
    	}
    	//個人宛て
    	else if(isset($send_seq))
    	{
    		$sql = "INSERT INTO contact_book (title, contents, send_user_seq, reception_user_seq, link_contact_book_seq, send_date, send_flg, delete_flg, group_seq)
    				VALUES ('$title', '$contents', '$user_seq', '$send_seq', '$link_id', now(), '1', '0', '-1')";
    		mysql_query($sql);
    	}

    	//データベースを閉じる
    	Dbdissconnect($dbcon);

		//print "<script language=javascript>leftreload();</script>";
    	//print "<script language=javascript>jump('Preservation.html','right');</script>";
    	print "<script language=javascript>jump('Preservation.html');</script>";
    }
    ///////////////////////////
    //アップデート（Send.php）/
    ///////////////////////////
    else if(isset($_POST['send_update']))
    {
    	//送信完了ボタンの時の処理
    	$group_seq = $_POST['group_seq'];
    	$contact_book_seq = $_POST['contact_book_seq'];
    	$reception_user_seq = $_POST['reception_user_seq'];
    	$contents = $_POST['contents'];
    	$title = $_POST['title'];
    	$link_id = $_POST['link_id'];

    	//グループ宛ての送信
    	if($group_seq >= 0)
    	{
    		//グループに所属するuser_seqの件数取り出し
    		$sql = "SELECT group_details.user_seq AS user_seq FROM group_details
    				LEFT JOIN m_group ON group_details.group_seq = m_group.group_seq
    				LEFT JOIN m_user ON group_details.user_seq = m_user.user_seq
    				WHERE group_details.group_seq = '$group_seq'";
    		$result = mysql_query($sql);
    		$count = mysql_num_rows($result);

    		for($i = 1; $i <= $count; $i++)
    		{
	    		$row = mysql_fetch_array($result);
	    		$group_send_user_seq = $row['user_seq'];

				$sql = "INSERT INTO contact_book (title, contents, send_user_seq, reception_user_seq, link_contact_book_seq, send_date, new_flg, send_flg, group_seq)
	    				VALUE ('$title', '$contents', '$user_seq', '$group_send_user_seq', 'link_id', now(), '1', '0', '$group_seq')";
	    		mysql_query($sql);
    		}
    	}
    	//個人宛ての送信
    	else
    	{
    		$sql = "UPDATE contact_book
    				SET title = '$title', contents = '$contents', send_flg = 0, new_flg = 1, delete_flg = 1, send_date = now()
    				WHERE contact_book_seq = '$contact_book_seq'; ";
    		mysql_query($sql);
    	}

    	//データベースを閉じる
    	Dbdissconnect($dbcon);

    	print "<script language=javascript>leftreload();</script>";
    	print "<script language=javascript>jump('comp_dis.php','right');</script>";
    }
    /////////////////////////////
    //保存からの保存（Send.php）/
    /////////////////////////////
    else if(isset($_POST['Re_preservation']))
    {
    	//保存ボタンの時の処理
    	$group_seq = $_POST['group_seq'];
    	$contact_book_seq = $_POST['contact_book_seq'];
    	$reception_user_seq = $_POST['reception_user_seq'];
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
