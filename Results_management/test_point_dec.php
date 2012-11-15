<?php
/************************************
 * テスト点数確定画面
 ***********************************/

$test_seq = $_POST['test_seq'];
$group = $_POST['group'];

//DBに接続
require_once("../lib/dbconect.php");
//$link = DbConnect();
$link = mysql_connect("tamokuteki41", "root", "");
mysql_select_db("pcp2012");

$sql = "SELECT m_user.user_seq 
		FROM m_user, group_details 
		WHERE m_user.user_seq = group_details.user_seq 
		AND group_details.group_seq = '$group'
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
	
	$sql = "INSERT INTO test_result 
			VALUES (0, '$test_seq', '$user_seq', '$point');";
	mysql_query($sql);
}

Dbdissconnect($link);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<title>点数確定画面</title>
	</head>
	
	<body>
		点数を登録しました。
		<a href="res_main.php">トップへ戻る</a>
	</body>
</html>