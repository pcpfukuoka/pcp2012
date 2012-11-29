<?php
/*************************************
 * 点数表示画面
 ************************************/

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

if (isset($_POST['submit']))
{
	$button = key($_POST['submit']);
	$test_seq = $_POST['subname'][$button];
}

//選択されたテストの情報をもってくるSQL文
$sql = "SELECT m_test.test_seq, m_test.date, m_subject.subject_name, m_test.contents, 
		m_user.user_name, m_test.group_seq, m_group.group_name, m_test.standard_test_flg 
		FROM m_test, m_subject, m_teacher, m_user, m_group 
		WHERE m_test.subject_seq = m_subject.subject_seq
		AND m_test.teacher_seq = m_teacher.teacher_seq
		AND m_test.group_seq = m_group.group_seq
		AND m_teacher.user_seq = m_user.user_seq
		AND m_test.test_seq = '$test_seq' 
		AND m_test.delete_flg = 0;";
$result_test = mysql_query($sql);
$test = mysql_fetch_array($result_test);

//点数の平均をとる
$sql = "SELECT AVG(point) 
		FROM test_result 
		WHERE test_seq = '$test_seq'";
$result = mysql_query($sql);
$avg_point = mysql_fetch_array($result);
$avg = $avg_point['AVG(point)'];

//点数の取得
$sql = "SELECT m_user.user_seq, m_user.user_name, point
		FROM test_result, m_user 
		WHERE test_result.user_seq = m_user.user_seq 
		AND test_result.test_seq = '$test_seq' 
		GROUP BY m_user.user_seq, m_user.user_name, point 
		ORDER BY m_user.user_seq;";
$result_point = mysql_query($sql);
$count_point = mysql_num_rows($result_point);

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<title>点数一覧画面</title>
	</head>
	
	<body>
		<div align = "center">
			<font size = "6">点数一覧</font><hr><br><br><br>
		</div>
		
		<!-- テーブルの作成 -->
		<table border = "1">
			<tr>
				<th>日付</th>
				<th>教科</th>
				<th>テスト範囲</th>
				<th>先生</th>
				<th>グループ</th>
				<th>定期テスト</th>
				<th>平均点</th>
			</tr>
			
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
				
				<td><?= $avg ?>
			</tr>
		</table><br><br>
		
		<table border = "1">
			<tr>
				<th>名前</th>
				<th>点数</th>
			</tr>
		
		<?php 
		for ($i = 0; $i < $count_point; $i++)
		{
			$point = mysql_fetch_array($result_point);
		?>
			<tr>
				<td><?= $point['user_name'] ?></td>
				<td>
					<?php 
					/***************************
					 * 点数の表示
					 * 
					 * 100点の場合は太文字赤字
					 * 平均点以上の場合は赤字
					 * 平均点より下の場合は青文字
					 ***************************/
					if ($point['point'] == 100)
					{
					?>
						<font size = "5" color = "red">
						<b><?= $point['point'] ?></b>
						</font> 
					<?php 
					}
					elseif ($point['point'] >= $avg)
					{
					?>
						<font color = "red">
						<?= $point['point'] ?>
						</font>
					<?php 
					}
					else 
					{
					?>
						<font color = "blue">
						<?= $point['point'] ?>
						</font>
					<?php 
					}?>
				</td>
			</tr>
		<?php 
		}
		?>
		</table><br>
		<form action = "res_test_point.php" method = "POST">
			<input type = "hidden" name = "test_seq" value = "<?= $test_seq ?>">
			<input type="button" value="戻る" onClick="history.back()">
			<input type = "submit" value = "点数修正へ">
		</form>
		<a href = "list_search.php">絞り込みに戻る</a>
	</body>
</html>