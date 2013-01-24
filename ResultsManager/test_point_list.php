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
		GROUP BY m_user.user_seq, m_user.user_name
		ORDER BY m_user.user_seq;";
$result_point = mysql_query($sql);
$count_point = mysql_num_rows($result_point);

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />		
		<link rel="stylesheet" href="../css/animate.css">
		<link rel="stylesheet" href="../css/jPages.css">
		<script type="text/javascript" src="../javascript/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="../javascript/jPages.js"></script>
		<script> 
		$(function(){
		$(".holder").jPages({ 
		containerID : "list",
		previous : "←", //前へのボタン
		next : "→", //次へのボタン
		perPage : 30, //1ページに表示する個数
		midRange : 5,
		endRange : 2,
		delay : 20, //要素間の表示速度
		animation: "flipInY" //アニメーションAnimate.cssを参考に
		});
		});
		</script>
		
		<title>点数一覧画面</title>
	</head>
	
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont2">点数一覧</font><hr color="blue"><br><br><br>
		</div>
		
		<!-- テーブルの作成 -->
		<table border = "1" class="table_01">
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
		<div class="holder"></div>
		<table border = "1">
		<thead>
			<tr>
				<th>名前</th>
				<th>点数</th>
			</tr>
		</thead>
		<tbody id="list">		
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
		</tbody>
		</table>
		<br>
		<form action = "res_test_point.php" method = "POST">
			<input type = "hidden" name = "test_seq" value = "<?= $test_seq ?>">
			<table>
				<tr>
					<td>
						<input class="button4" type = "submit" value = "点数修正へ">
					</td>

					<td>
						<input class="button4" type="button" value="戻る" onClick="history.back()">
					</td>
				</tr>
			</table>
		</form>
			</div>
	</body>
</html>