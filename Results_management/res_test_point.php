<?php
/*****************************************
 *点数入力画面
 *
 ****************************************/

//セッションの開始
session_start();

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

$test_seq = $_POST['test_seq'];

if (isset($_POST['submit']))
{
	$button = key($_POST['submit']);
	$test_seq = $_POST['subname'][$button];
}

//test_seqに対応したgroup_seqの取得
$sql = "SELECT group_seq 
		FROM m_test 
		WHERE test_seq = '$test_seq';";
$result_group = mysql_query($sql);
$group = mysql_fetch_array($result_group);
$group_seq = $group['group_seq'];

//ユーザ名とseqの取得
$sql = "SELECT m_user.user_seq, m_user.user_name
		FROM m_user, group_details
		WHERE m_user.user_seq = group_details.user_seq
		AND group_details.group_seq = '$group_seq'
		GROUP BY m_user.user_name
		ORDER BY m_user.user_seq;";
$result_user = mysql_query($sql);
$count_user = mysql_num_rows($result_user);

	//点数の取得	
	$sql = "SELECT user_seq, point
			FROM test_result 
			WHERE test_seq = '$test_seq' 
			ORDER BY user_seq;";
	$result_point = mysql_query($sql);


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
					$point = mysql_fetch_array($result_point);
				?>
				<tr>
					<td><?= $user['user_name'] ?></td>
					<td><input size = "3" type = "text" name = "point<?= $i ?>" value = "<?= $point['point'] ?>"></td>
				</tr>
				<?php 
				}
				?>
			</table>
			<?php 
			$_SESSION['group_seq'] = $group_seq;
			$_SESSION['test_seq'] = $test_seq;
			?>
			
			<input type = "submit" value = "確認">
		</form>
	</body>
</html>