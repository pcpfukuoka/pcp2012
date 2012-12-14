<?php
/**********************************
 * テスト登録確認画面
 *********************************/

//前画面で入力された値を受け取る
$day = $_POST['day'];
$subject = $_POST['subject'];
$contents = $_POST['contents'];
$user = $_POST['teacher'];
$group = $_POST['group'];
$stand_flg = $_POST['stand_flg'];

$contents = nl2br($contents);

//DBの接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

$sql = "SELECT subject_name 
		FROM m_subject 
		WHERE subject_seq = '$subject';";
$result = mysql_query($sql);
$name_subj = mysql_fetch_array($result);

$sql = "SELECT user_name 
		FROM m_user, m_teacher 
		WHERE m_user.user_seq = m_teacher.user_seq 
		AND teacher_seq = '$user';";
$result = mysql_query($sql);
$name_teach = mysql_fetch_array($result);

$sql = "SELECT group_name
		FROM m_group
		WHERE group_seq = '$group';";
$result = mysql_query($sql);
$name_group = mysql_fetch_array($result);

Dbdissconnect($link);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<title>テスト作成確認画面</title>
	</head>
	
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont2">テスト作成確認</font><hr color="blue"><br><br><br>
		</div>
		
	<!-- 点数入力画面に飛ぶ -->
		<form action = "res_test_dec.php" method = "POST">
		
		<!-- ポストで受け取った値を表示する -->
			<table border = "1">
				<tr>
					<th>日付</th>
					<th>教科</th>
					<th>テスト範囲</th>
					<th>先生</th>
					<th>グループ</th>
					<th>定期テスト</th>
				</tr>
				
				<tr>
					<td><?= $day ?></td>
					<td><?= $name_subj['subject_name'] ?></td>
					<td><?= $contents ?></td>
					<td><?= $name_teach['user_name'] ?></td>
					<td><?= $name_group['group_name'] ?></td>
					<td><?php
						if ($stand_flg == 1)
						{
							echo "○";
						}
						else 
						{
							echo "×";
						}?></td>
				</tr>
			</table>
			
			<input type = "hidden" name = "day" value = "<?= $day ?>">
			<input type = "hidden" name = "subject" value = "<?= $subject ?>">
			<input type = "hidden" name = "contents" value = "<?= $contents ?>">
			<input type = "hidden" name = "teacher" value = "<?= $user ?>">
			<input type = "hidden" name = "group" value = "<?= $group ?>">
			<input type = "hidden" name = "stand_flg" value = "<?= $stand_flg ?>">
			
			<Table>
				<tr>
					<th>
						<input class="button4" type = "submit" value = "登録">
					</th>
					<th>
						<input class="button4"type="button" value="戻る" onClick="history.back()">
					</th>
				</tr>
			</Table>


		</form>
			</div>
	</body>
</html>