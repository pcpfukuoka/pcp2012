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
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<title>テスト絞り込み画面</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
	<div align = "center">
			<font class="Cubicfont">テスト絞り込み</font><hr color="blue"><br><br><br>
		</div>

		<form action = "Per_list.php" method = "POST">
			<!-- テーブルの作成 -->
			
			<table class="table_03" >
				<tr>
				<!-- 	<th>学年・クラス</th>  -->
					<th class="subject">教科</th>
					<th >テストチェック</th>
				</tr>
				
				<tr>
				<!-- 教科の選択 --> 
					<td class="subject">
						<select name = "subject_seq">
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
						</select>
					</td>

					<!-- テストのチェック -->
					<td align = "center" width = "300">					
					すべて<input type = "radio" name = "stand_flg" value = -1 checked>&nbsp;&nbsp;
					定期テスト<input type= "radio" name = "stand_flg" value = "1">&nbsp;&nbsp;
					小テスト<input type = "radio" name = "stand_flg" value = "0">
					</td>
				</tr>
			</table><br>
				<input class="button4" type = "submit" value = "一覧へ">
	</form>
	</body>
</html>
