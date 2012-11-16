<?php
/***********************************************
 * テスト成績一覧選択画面
 **********************************************/

//DBの接続
require_once("../lib/dbconect.php");
//$link = DbConnect();
$link = mysql_connect("tamokuteki41", "root", "");
mysql_select_db("pcp2012");

//テストのデータの一覧表示させるためのSQL文
$sql = "SELECT m_test.test_seq, m_test.date, m_subject.subject_name, m_test.contents,
		m_user.user_name, m_test.group_seq, m_group.group_name, m_test.standard_test_flg
		FROM m_test, m_subject, m_teacher, m_user, m_group
		WHERE m_test.subject_seq = m_subject.subject_seq
		AND m_test.teacher_seq = m_teacher.teacher_seq
		AND m_test.group_seq = m_group.group_seq
		AND m_teacher.user_seq = m_user.user_seq
		AND m_test.delete_flg = 0
		ORDER BY m_test.test_seq DESC;";

$result_test = mysql_query($sql);
$count_test = mysql_num_rows($result_test);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<title>テスト選択画面</title>
	</head>
	
	<body>
		<div align = "center">
			<font size = "6">テスト選択</font><hr><br><br><br>
		</div>
		
		<form action = "test_point_list.php" method = "POST">
		
			<table border = "1">
			
				<tr>
					<th>日付</th>
					<th>教科</th>
					<th>テスト範囲</th>
					<th>先生</th>
					<th>グループ</th>
					<th>定期テスト</th>
					<th>点数表示</th>
				</tr>
			
				<?php 
				//以前のテストの表示
				for ($i = 0; $i < $count_test; $i++)
				{
					$test = mysql_fetch_array($result_test);
				?>
				
				<tr>
					<td><?= $test['date'] ?></td>
					<td><?= $test['subject_name'] ?></td>
					<td><?= $test['contents'] ?></td>
					<td><?= $test['user_name'] ?></td>
					<td><?= $test['group_name'] ?></td>
					<td align = "center">
					<?php
					//定期テストチェック
					if ($test['standard_test_flg'] == 1)
					{
						echo "○";
					}
					else
					{
						echo "×";
					}
					?>
					</td>
					
					<!-- test_seqを持っていく -->
					<td align = "center">
						<input type = "hidden" name = "subname['<?= $i ?>']" value = "<?= $test['test_seq'] ?>">
						<input type = "submit" name = "submit['<?= $i ?>']" value = "点数表示">
					</td>
				</tr>
				<?php
				} 
				?>
			</table>
		</form>
		<a href="res_main.php">トップへ戻る</a>
	</body>
</html>