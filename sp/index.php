<?php
	session_start();
	if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
	{
		header("Location:login/index.php");
	}
	
	$user_seq = $_SESSION['login_info[user]'];
	$day = date("Y-m-d");
	require_once("lib/dbconect.php");
	$dbcon = DbConnect();
	
	//各件数を取得
	//連絡帳の件数
	$sql = "SELECT new_flg FROM contact_book
	WHERE new_flg = 1
	AND contact_book.reception_user_seq = $user_seq;";
	$result = mysql_query($sql);
	$cnt_new = mysql_num_rows($result);
	//プリントの件数
	$sql = "SELECT * FROM  print_check
	WHERE user_seq = '$user_seq'
	AND print_check_flg = 1;";
	$result = mysql_query($sql);
	$cnt_print_flg = mysql_num_rows($result);
	//アンケートの件数
	$sql = "SELECT * FROM question
	WHERE question_seq
	NOT IN ( SELECT question_seq FROM question_awnser WHERE awnser_user_seq = '$user_seq' )
	AND '" . $day . "' BETWEEN start_date AND end_date";
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	//データベースを閉じる
	DBdissconnect($dbcon);
	
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title>PCP2012</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<link rel="stylesheet" href="css/jquery.mobile-1.2.0.min.css" />
		<script src="js/jquery-1.8.2.min.js"></script>
		<script src="js/jquery.mobile-1.2.0.min.js"></script>
	</head>

	<body>
		<div data-role="page" id="top" align="center">
			<div data-role="header" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="">スケジュール</a></li>
						<li><a href="#/sp/contactbook/main.php">連絡帳</a></li>
						<li><a href="">授業</a></li>
						<li><a href="#/sp/Results_management/Per_ver.php">成績確認</a></li>
						<li><a href="#/sp/question/answer_list.php">アンケート</a></li>
					</ul>
				</div>
			</div>
			
			<div data-role="content">
			
						<ul data-role="listview">
				<?php 
					if($cnt_new != 0)
					{?>
						<li><a href="contactbook/MailBox.php">新着のメッセージが<?= $cnt_new ?>件あります。</a></li>
				<?php 
					}

					if($cnt_print_flg != 0)
					{
				?>
						<li><a href="contactbook/MailBox.php">新着のプリントが<?= $cnt_print_flg ?>件あります。</a></li>
				<?php 
					}
					if($cnt != 0)
					{
				?>
						<li><a href="question/answer_list.php">未回答のアンケートが<?= $cnt ?>件あります。</a></li>
				<?php 
					}
					?>
					
			</ul>			 
			
			</div>
			
			<div data-role="footer" data-position="fixed">
				<p>PCP2012</p>
			</div>
		</div>
	</body>	
</html>