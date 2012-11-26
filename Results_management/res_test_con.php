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
		<title>テスト作成確認画面</title>
	</head>
	
	<body>
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
			
			
			<input type = "submit" value = "確定">
			<input type="button" value="戻る" onClick="history.back()">
		</form>
	</body>
</html>