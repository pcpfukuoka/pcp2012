<?php
/************************************
 * テスト点数確定画面
 ***********************************/
//セッションの開始
session_start();

$test_seq = $_SESSION['test_seq'];
$group_seq = $_SESSION['group_seq'];

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

$sql = "SELECT m_user.user_seq 
		FROM m_user, group_details 
		WHERE m_user.user_seq = group_details.user_seq 
		AND group_details.group_seq = '$group_seq' 
		GROUP BY m_user.user_seq 
		ORDER BY m_user.user_seq;";

$result = mysql_query($sql);
$count_user = mysql_num_rows($result);


for ($i = 0; $i < $count_user; $i++)
{
	$user = mysql_fetch_array($result);
	$user_seq = $user['user_seq'];
	$pointNo = "point".$i;
	$point = $_POST[$pointNo];

	$sql = "UPDATE test_result 
			SET point = '$point' 
			WHERE test_seq = '$test_seq' 
			AND user_seq = '$user_seq';";
	
	mysql_query($sql);
}


Dbdissconnect($link);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<META HTTP-EQUIV="Refresh" CONTENT="5;URL=../dummy.html">
		<title>点数確定画面</title>
	</head>
	
	<body>
		点数を登録しました。
	</body>
</html>