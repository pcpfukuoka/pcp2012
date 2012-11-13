<?php
/********************************
 * 点数確認画面
 *******************************/

//test_seqとgroup_seqを受け取る
$test_seq = $_POST['test_seq'];
$group = $_POST['group'];

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

//ユーザ名の取得
$sql = "SELECT m_user.user_seq, m_user.user_name 
		FROM m_user, group_details 
		WHERE m_user.user_seq = group_details.user_seq 
		AND group_details.group_seq = '$group' 
		GROUP BY m_user.user_seq 
		ORDER BY m_user.user_seq;";
$result_user = mysql_query($sql);
$count_user = mysql_num_rows($result_user);

Dbdissconnect($link);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<title>点数確認画面</title>
	</head>
	
	<body>
		<form action = "test_point_dec.php" method = "POST">
		
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
					$point = "point".$i;
					
				?>
					<input type = "hidden" name = "point<?= $i ?>" value = "<?= $_POST[$point] ?>">
					<tr>
						<td><?= $user['user_name'] ?></td>
						<td><?= $_POST[$point] ?></td>
					</tr>
				<?php
				}
				?>
			</table>
			
			<input type = "hidden" name = "group" value = "<?= $group ?>">
			<input type = "hidden" name = "test_seq" value = "<?= $test_seq ?>">
			<input type = "submit" value = "確定">
			<input type="button" value="戻る" onClick="history.back()">
		</form>
	</body>
</html>