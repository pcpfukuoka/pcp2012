<?php
/*******************************
 * テスト登録画面
 *******************************/

//前画面で入力された値を受け取る
$day = $_POST['day'];
$subject = $_POST['subject'];
$contents = $_POST['contents'];
$teacher = $_POST['teacher'];
$group_seq = $_POST['group'];
$stand_flg = $_POST['stand_flg'];
$delete_flg = 0;

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

$sql = "INSERT INTO m_test
VALUES (0, '$subject', '$group_seq', '$contents', '$teacher', '$day', '$stand_flg', '$delete_flg');";
mysql_query($sql);

//登録したテストのseqを取得
$sql = "SELECT test_seq 
		FROM m_test
		ORDER BY test_seq DESC;";
$result_test = mysql_query($sql);
$test = mysql_fetch_array($result_test);
$test_seq = $test['test_seq'];

//テストの点数0を入力
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
	$point = 0;
	
	$sql = "INSERT INTO test_result
			VALUES (0, '$test_seq', '$user_seq', '$point');";
	mysql_query($sql);
}

Dbdissconnect($link);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<META HTTP-EQUIV="Refresh" CONTENT="10;URL=../dummy.html">
		<title>テスト登録確定画面</title>
	</head>
	
	<body>
		テストを登録しました。
		
		<form action = "res_test_point.php" method = "POST">
			<input type = "hidden" name = "test_seq" value = "<?= $test_seq ?>">
			
			<input type = "submit" name = "test" value = "点数を登録します。">
		</form>
	</body>
</html>