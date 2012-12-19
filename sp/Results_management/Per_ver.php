<?php
//session_start();

//$sesID = $_SESSION['login_info[user]'];
/******************************
 * テスト検索画面
*****************************/

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

//先生の名前とseqを持ってきて、数を数える
$sql = "SELECT m_user.user_name, m_user.user_seq
		FROM m_user, m_teacher
		WHERE m_user.user_seq = m_teacher.user_seq
		AND m_teacher.delete_flg = 0
		GROUP BY m_user.user_name, m_user.user_seq
		ORDER BY m_user.user_seq;";

$result_teach = mysql_query($sql);
$count_teach = mysql_num_rows($result_teach);

//教科名とseqを持ってきて、数を数える
$sql = "SELECT subject_seq, subject_name
		FROM m_subject
		WHERE delete_flg = 0;";

$result_subj = mysql_query($sql);
$count_subj = mysql_num_rows($result_subj);

//グループ名とseqを持ってきて、数を数える
//$sql = "SELECT group_seq, group_name
//		FROM m_group
//		WHERE delete_flg = 0
//		AND class_flg = 1;";

//$result_group = mysql_query($sql);
//$count_group = mysql_num_rows($result_group);

Dbdissconnect($link);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<meta name="viewport" content="width=device-width, intital-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		<title>テスト絞り込み画面</title>
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
			<font size = "6">テスト絞り込み</font><hr><br><br><br>
		</div>
		
		<form action = "per_list.php" method = "POST">
			<!-- テーブルの作成 -->
			<table border = "1" >
				<tr>
				<!-- 	<th>学年・クラス</th>  -->
					<th>教科</th>
					<th>テストチェック</th>
				</tr>
				
				<tr>
				
					
				<!-- 教科の選択 -->
					<td><select name = "subject_seq" data-native-menu="false">
						<option value = "-1" selected>すべて</option>
						<?php
						for ($i = 0; $i < $count_subj; $i++)
						{
							$subj = mysql_fetch_array($result_subj);
						?>
							<option value = "<?= $subj['subject_seq'] ?>"> <?= $subj['subject_name'] ?></option>
						<?php
						} 
						?>
					</select></td>
					
					<!-- テストのチェック -->
					<td align = "center">
					<input type = "radio" id=test01 name = "stand_flg" value = -1 checked>
					<label for="test01">すべて</label>
					<input type= "radio" id=test02 name = "stand_flg" value = "1">
					<label for="test02">定期テスト</label>
					<input type = "radio" id=test03 name = "stand_flg" value = "0">
					<label for="test03">小テスト</label>
					</td>
				</tr>
			</table>
			<input type = "submit" data-inline="true" value = "一覧へ">
		</form>
		</div>
	    	 
	    	<div data-role="footer" data-position="fixed" >
				<a href="#" data-rel="back" data-role="button" data-icon="back"  class="ui-btn-left">戻る</a>
				<p>PCP2012</p>
				<a href="../index.php" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
			</div>
	
	</body>
</html>
