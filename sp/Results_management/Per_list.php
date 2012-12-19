0p<?php


session_start();

$sesID = $_SESSION['login_info[user]'];


/***********************************************
 * テスト成績一覧選択画面
 **********************************************/

$subject_seq = $_POST['subject_seq'];
$stand_flg = $_POST['stand_flg'];

//DBの接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");



//テストのデータの一覧表示させるためのSQL文作成
//グループは必ず何かが選択されている

$sql = "SELECT m_test.test_seq, m_test.date, m_subject.subject_name, m_test.contents, 
		m_user.user_name, m_test.group_seq, m_group.group_name, m_test.standard_test_flg 
		FROM m_test, m_subject, m_teacher, m_user, m_group 
		WHERE m_test.subject_seq = m_subject.subject_seq 
		AND m_test.teacher_seq = m_teacher.teacher_seq 
		AND m_test.group_seq = m_group.group_seq 
		AND m_teacher.user_seq = m_user.user_seq 
		AND m_test.delete_flg = 0 ";
		//AND m_test.group_seq = '$group_seq'";

//教科が選択されて、テストチェックはされていない場合
if ($subject_seq != -1 && $stand_flg == -1)
{
	$sql = $sql." AND m_test.subject_seq = '$subject_seq'";
}
//教科が選択されてなく、テストチェックがされている場合
elseif ($subject_seq == -1 && $stand_flg != -1)
{
	$sql = $sql." AND m_test.standard_test_flg = '$stand_flg'";
}
//教科が選択されていて、テストチェックもされている場合
elseif ($subject_seq != -1 && $stand_flg != -1)
{
	$sql = $sql." AND m_test.subject_seq = '$subject_seq' 
					AND m_test.standard_test_flg = '$stand_flg'";
}

//並び替え
$sql = $sql." ORDER BY m_test.test_seq DESC;";

//SQLの実行と数を数える
$result_test = mysql_query($sql);
$count_test = mysql_num_rows($result_test);



//点数の取得
/*$sql = "SELECT m_user.user_seq, m_user.user_name, point
FROM test_result, m_user
WHERE test_result.user_seq = m_user.user_seq
AND test_result.test_seq = '$test_seq'
AND m_user.user_seq = '$sesID';
GROUP BY m_user.user_seq, m_user.user_name, point
ORDER BY m_user.user_seq;";
$result_point = mysql_query($sql);
$count_point = mysql_num_rows($result_point);*/



?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		
		<title>テスト選択画面</title>
	</head>
	
	<body>
		<div align = "center">
		<div data-role="header" data-position="fixed">
			<div data-role="navbar">
				<ul>
					<li><a href="">スケジュール</a></li>
					<li><a href="../contactbook/main.php">連絡帳</a></li>
					<li><a href="">授業</a></li>
					<li><a href="Per_ver.php" class="ui-btn-active">成績確認</a></li>
					<li><a href="../question/answer_list.php">アンケート</a></li>
				</ul>
			</div>
		</div>
			
		<div data-role="content">			
			<font size = "6">テスト選択</font><hr><br><br><br>

			<!-- SQLで取り出したテストデータの表示 -->
			<table border = "1">
			
				<tr>
					<th>日付</th>
					<th>教科</th>
					<th>テスト範囲</th>
					<th>先生</th>
					<th>点数</th>
					<th>平均点</th>
				</tr>
		
				<?php 
				for ($i = 0; $i < $count_test; $i++)
				{
					$test = mysql_fetch_array($result_test);
					
					$test_seq = $test['test_seq'];
					
					$sql = "SELECT point FROM test_result 
							WHERE test_seq = '$test_seq' 
							AND user_seq = '$sesID';";
					$result_point = mysql_query($sql);
					$point = mysql_fetch_array($result_point);
					
					$sql = "SELECT AVG(point) FROM test_result 
							WHERE test_seq = '$test_seq';";
					$result_avg = mysql_query($sql);
					$avg = mysql_fetch_array($result_avg);
				?>
			
				<tr>
					<td><?= $test['date'] ?></td>
					<td><?= $test['subject_name'] ?></td>
					<td><?= $test['contents'] ?></td>
					<td><?= $test['user_name'] ?></td>
					
					<!-- 各生徒の点数を表示させるために、test_seqを持っていく -->
					<td>
					<?php 
					if ($point['point'] == 100)
						{
					?>
							<font size = "5" color = "red">
								<b><?= $point['point'] ?></b>
							</font> 
					<?php 
						}
						elseif ($point['point'] >= $avg['AVG(point)'])
						{
					?>
							<font color = "red" >
								<?= $point['point'] ?>
							</font>						
					<?php 
						}
						else 
						{
					?>
							<font color = "blue" >
								<?= $point['point'] ?>
							</font>
					<?php 
						}
					?>
					</td>
				
					<td align = "center"><?= $avg['AVG(point)'] ?></td>
				</tr>
			
				<?php
					}
				?>
			</table>
			
			<?php
				Dbdissconnect($link);
			?>
			<input type="button" value="戻る" onClick="history.back()">
			
		</div>
	    	 
	    <div data-role="footer" data-position="fixed" >
			<p>PCP2012</p>
			<a href="#" data-rel="back" data-role="button" data-icon="back"  class="ui-btn-left">戻る</a>
			<a href="../index.php" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
		</div>
		</div>
	</body>
</html>

