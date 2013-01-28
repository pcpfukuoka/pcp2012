<?php
session_start();
$user_seq = $_SESSION['login_info[user]'];
$day = date("Y-m-d");
require_once("../lib/dbconect.php");
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
   		 	WHERE question_target_group_seq 
        		IN (SELECT m_group.group_seq 
            		FROM m_group INNER JOIN group_details 
            		ON m_group.group_seq = group_details.group_seq 
            		WHERE group_details.user_seq= '$user_seq'
            	   )
    		AND question_seq 
    			NOT IN (SELECT question_seq 
    					FROM question_awnser 
    					WHERE awnser_user_seq = '$user_seq' ) 
    		AND '".$day."' BETWEEN start_date AND end_date;";
$result = mysql_query($sql);
$cnt = mysql_num_rows($result);
//データベースを閉じる
DBdissconnect($dbcon);

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/frame_jump.js"></script>  
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">

			<div align="center">
			   <font class="Cubicfont">新着情報</font>
			</div>
			<hr color="blue">
			<!--
			スクロールバージョン
			 <marquee>新着のメッセージが○件あります。</marquee>
			<marquee>新着のプリントが○件あります。</marquee>
			<marquee>未回答のアンケートが○件あります。</marquee>
			<marquee>回答期限が迫っているアンケートは○○○○○です</marquee>
			 -->
			<ul>
				<?php 
					if($cnt_new != 0)
					{?>
						<li><a href="#"onclick="Message()">新着のメッセージが<?= $cnt_new ?>件あります。</a></li>
				<?php 
					}

					if($cnt_print_flg != 0)
					{
				?>
						<li><a href="#"onclick="Message()">新着のプリントが<?= $cnt_print_flg ?>件あります。</a></li>
				<?php 
					}
					if($cnt != 0)
					{
				?>
						<li><a href="#"onclick="Question()">未回答のアンケートが<?= $cnt ?>件あります。</a></li>
				<?php 
					}
					?>
					
			</ul>			 
		</div>
		<script>
			
			function Message()
			{
				menu_jump('../ContactBook/main.php','../ContactBook/MailBox.php');
			}
			function Question()
			{
				menu_jump('../QuestionManager/index.php','../QuestionManager/answer_list.php');
			}
			</script>
	</body>
</html>