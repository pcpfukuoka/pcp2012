<?php
session_start();
$user_seq = $_SESSION['login_info[user]'];
//処理する件数を取得その件数分処理を行う。
$question_seq = $_POST['question_seq'];
$details_seq_list = $_POST['details_seq'];
$details_cnt = count($details_seq_list);
require_once("../lib/dbconect.php");
$link = DbConnect();

//質問数分処理
for($i=1;$i<=$details_cnt;$i++)
{
	//POSTで受け取るようの文字列作成
	$post_string = 'question_'.$i;
	$awnser_cnt = count($_POST[$post_string]);
	$awnser_list = $_POST[$post_string];
	//回答数分処理を行う。
	$text_string = 'etc_'.$i;
	if($_POST[$text_string] != "")
	{
		$sql = "INSERT INTO question_awnser_coments VALUES (0,$_POST[$text_string],$user_seq, $details_seq_list[$t],$question_seq);";
		echo $sql;
		mysql_query($sql);
	}
	
	for($j=0;$j<$awnser_cnt;$j++)
	{
		//値が入っていればSQL作成
		if(isset($awnser_list[$j]))
		{
			$t = $i - 1;
			$sql = "INSERT INTO question_awnser VALUES (0,$user_seq, $awnser_list[$j], $details_seq_list[$t],$question_seq);";
			mysql_query($sql);
			echo $sql;
		}		
	}
}
Dbdissconnect($link);

?>
