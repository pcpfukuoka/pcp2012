<?php
/******************************
 * 点数入力画面
 ******************************/

//前画面で入力された値を受け取る
$day = $_POST['day'];
$subject = $_POST['subject'];
$contents = $_POST['contents'];
$teacher = $_POST['teacher'];
$group = $_POST['group'];
$stand_flg = $_POST['stand_flg'];
$delete_flg = 0;

//値をDBに登録
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

$sql = "INSERT INTO m_test 
		VALUES (0, '$subject', '$group', '$contents', '$teacher', '$day', '$stand_flg', '$delete_flg');";
mysql_query($sql);

//ユーザ名とseqの取得
$sql = "SELECT m_user.user_name 
		FROM m_user, group_details 
		WHERE m_user.user_seq = group_details.user_seq 
		AND group_details.group_seq = '$group'
		GROUP BY m_user.user_name;";
$result_user = mysql_query($sql);
$count_user = mysql_num_rows($result_user);

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
		<title>点数入力画面</title>
	</head>
	
	<body>
	<!-- 点数確認画面に飛ぶ -->
		<form action = "test_point_con.php" method = "POST">
		
			<!-- テーブルの作成 -->
			<table border = "1">
				<tr>
					<th>名前</th>
					<th>点数</th>
				</tr>
				<?php 
				for ($i = 0; $i < $count_user; $i++)
				{
					$user = mysql_fetch_array($result_user);
				?>
				<tr>
					<td><?= $user['user_name'] ?></td>
					<td><input type = "text" name = "point<?= $i ?>"></td>
				</tr>
				<?php 
				}
				?>
			</table>
			<input type = "hidden" name = "group" value = "<?= $group ?>">
			<input type = "hidden" name = "test_seq" value = "<?= $test_seq['test_seq'] ?>">
			<input type = "submit" value = "確認">
		</form>
	</body>
</html>