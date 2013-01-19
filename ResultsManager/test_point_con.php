<?php
/********************************
 * 点数確認画面
 *******************************/

//セッションの開始
session_start();

//test_seqとgroup_seqを受け取る
$test_seq = $_SESSION['test_seq'];
$group_seq = $_SESSION['group_seq'];

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

//ユーザ名の取得
$sql = "SELECT m_user.user_seq, m_user.user_name 
		FROM m_user, group_details 
		WHERE m_user.user_seq = group_details.user_seq 
		AND group_details.group_seq = '$group_seq' 
		GROUP BY m_user.user_seq 
		ORDER BY m_user.user_seq;";
$result_user = mysql_query($sql);
$count_user = mysql_num_rows($result_user);

Dbdissconnect($link);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<title>点数確認画面</title>
	</head>
	
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">

		<div align = "center">
			<font class="Cubicfont2">点数確認</font><hr color="blue"><br><br><br>
		</div>
		
			<!-- テーブルの作成 -->
		<form action = "test_point_dec.php" method = "POST">
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
			
			<input class="button4" type = "submit" value = "確定">
			
		</form>
		<a href = "list_search.php">絞り込みに戻る</a>
	</div>
	</body>
</html>