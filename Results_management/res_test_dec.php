<?php
/*******************************
 * テスト登録画面
 *******************************/

//前画面で入力された値を受け取る
$day = $_POST['day'];
$subject = $_POST['subject'];
$contents = $_POST['contents'];
$teacher = $_POST['teacher'];
$stand_flg = $_POST['stand_flg'];
$delete_flg = 0;

//DBに接続
require_once("../lib/dbconect.php");
//$link = DbConnect();
$link = mysql_connect("tamokuteki41", "root", "");
mysql_select_db("pcp2012");

$sql = "INSERT INTO m_test
VALUES (0, '$subject', '$contents', '$teacher', '$day', '$stand_flg', '$delete_flg');";
mysql_query($sql);

//登録したテストのseqを取得
$sql = "SELECT test_seq 
		FROM m_test
		ORDER BY test_seq DESC;";
$result_test = mysql_query($sql);
$test_seq = mysql_fetch_array($result_test);

Dbdissconnect($link);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<title>テスト登録確定画面</title>
	</head>
	
	<body>
		テストを登録しました。
		
		<form action = "test_group.php" method = "POST">
			<input type = "hidden" name = "test_seq" value = "<?= $test_seq['test_seq'] ?>">
			<input type = "submit" value = "点数を登録します。">
			<a href="res_main.php">トップへ戻る</a>
		</form>
	</body>
</html>