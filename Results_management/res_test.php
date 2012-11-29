<?php
/*****************************************
 * テストの登録画面
 ****************************************/

//DBの接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

//教科名とseqを持ってきて、数を数える
$sql = "SELECT subject_seq, subject_name 
		FROM m_subject
		WHERE delete_flg = 0;";

$result_subj = mysql_query($sql);
$count_subj = mysql_num_rows($result_subj);

//グループ名とseqを持ってきて、数を数える
$sql = "SELECT group_seq, group_name 
		FROM m_group 
		WHERE delete_flg = 0 
		AND class_flg = 1;";

$result_group = mysql_query($sql);
$count_group = mysql_num_rows($result_group);

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

if($_POST['sub'] != -1)
{
	$subject = $_POST['sub'];
	
	//先生の名前とseqを持ってきて、数を数える
	$sql = "SELECT m_user.user_name, m_teacher.teacher_seq
			FROM m_user, m_teacher
			WHERE m_user.user_seq = m_teacher.user_seq
			AND m_teacher.delete_flg = 0 
			AND m_teacher.subject_seq = '$subject' 
			GROUP BY m_user.user_name
			ORDER BY m_user.user_seq;";
	
	$result_teach = mysql_query($sql);
	$count_teach = mysql_num_rows($result_teach);
	
	$sql = "SELECT subject_seq, subject_name
			FROM m_subject
			WHERE subject_seq = '$subject' 
			AND delete_flg = 0;";
	
	$result_sub = mysql_query($sql);
	$sbj = mysql_fetch_array($result_sub);
}

Dbdissconnect($link);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
		<title>テスト</title>
	</head>
	
	<body>
		<div align = "center">
			<font size = "6">テスト登録画面</font><hr><br><br><br>
		</div>
		
		<!-- テーブルの作成 -->
		<table border = "1" width = "100%">
			<tr>
				<th width = "13%">教科</th>
				<th width = "8%">日付</th>
				<th width = "30%">テスト範囲</th>
				<th width = "13%">先生</th>
				<th width = "13%">グループ</th>
				<th width = "10%">定期テスト</th>
				<th width = "10%">登録(テスト・点数)</th>
			</tr>
			
			<tr>
				<!-- 教科の選択 -->
				<form name = "req" action = "" method = "POST">
					<td><select name = "sub" onChange = "this.form.submit();">
					
					<?php 
					if ($_POST['sub'] == NULL)
					{
					?>
						<option value = "-1" selected>選択</option>
					<?php
					}
					else 
					{
					?>
						<option value = "<?= $sbj['subject_seq'] ?>"> <?= $sbj['subject_name'] ?></option>
					<?php 
					}	
						for ($i = 0; $i < $count_subj; $i++)
						{
							$subj = mysql_fetch_array($result_subj);
						?>
							<option value = "<?= $subj['subject_seq'] ?>"><?= $subj['subject_name'] ?></option>
						<?php
						} 
						?>
					</select></td>
				</form>
				
				<form action = "res_test_con.php" method = "POST">
				
				<!-- 教科を入力 -->
				<input type = "hidden" name = "subject" value = "<?= $subject ?>">
				
				<!-- 日付の入力 -->
					<td><input type = "text" name = "day" value = "<?= date("Y/m/d") ?>" ></td>
					
				<!-- テスト範囲・内容入力 -->
					<td><textarea rows="2" cols="30" name = "contents"></textarea></td>
					
					<!-- 先生の選択 -->
					<td><select name = "teacher">
						<option value = "-1" selected>選択</option>
						<?php
						for ($i = 0; $i < $count_teach; $i++)
						{
						$teach = mysql_fetch_array($result_teach);
						?>
							<option value = "<?= $teach['teacher_seq'] ?>"><?= $teach['user_name'] ?></option>
						<?php
						} 
						?>
						</select></td>
						
						<!-- グループの選択 -->
					<td><select name = "group">
						<option value = "-1" selected>選択</option>
						<?php
						for ($i = 0; $i < $count_group; $i++)
						{
						$group = mysql_fetch_array($result_group);
						?>
							<option value = "<?= $group['group_seq'] ?>"><?= $group['group_name'] ?></option>
						<?php
						} 
						?>
						</select></td>
						
						<!-- 定期テストのチェック -->
					<td align = "center"><input type = "checkbox" name = "stand_flg" value = "1"></td>
					
					<!-- 登録ボタン -->
					<td align = "center"><input type = "submit" value = "登録"></td>
				</form>
			</tr>
			
			<form action = "res_test_point.php" method = "POST">
				<?php
				//以前のテストの表示
				for ($i = 0; $i < $count_test; $i++)
				{
					$test = mysql_fetch_array($result_test);
				?>
				
				<tr>
					<td><?= $test['subject_name'] ?></td>
					<td><?= $test['date'] ?></td>
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
						<input type = "submit" name = "submit['<?= $i ?>']" value = "点数修正">
					</td>
				</tr>
				<?php
				} 
				?>
			</form>
		</table>
	</body>
</html>