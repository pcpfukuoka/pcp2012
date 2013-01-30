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
		ORDER BY m_test.date DESC;";

$result_test = mysql_query($sql);
$count_test = mysql_num_rows($result_test);

if($_GET['sub'] != -1)
{
	$subject = $_GET['sub'];

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
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" href="../css/animate.css">
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		<script src="../javascript/form_reference.js"></script>
		<title>テスト登録画面</title>
	</head>

	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont">テスト登録</font><hr color="blue">
		</div>

		<!-- テーブルの作成 -->
		<div id="tablewrapper">
			<div id="tableheader">
	        	<div class="search">
	                <select id="columns" onchange="sorter.search('query')"></select>
	                <input type="text" id="query" onkeyup="sorter.search('query')" />
	            </div>
	            <span class="details">
					<div>Records <span id="startrecord"></span>-<span id="endrecord"></span> of <span id="totalrecords"></span></div>
	        		<div><a href="javascript:sorter.reset()">reset</a></div>
	        	</span>
        </div>
		<table cellpadding="0" cellspacing="0" border="0" id="table" class="table_01">
			<thead>
				<tr>
				<th><h3>教科</h3></th>
				<th><h3>日付</h3></th>
				<th><h3>テスト範囲</h3></th>
				<th><h3>先生</h3></th>
				<th><h3>グループ</h3></th>
				<th><h3>定期テスト</h3></th>
				<th><h3>登録(テスト・点数)</h3></th>
			</tr>
			</thead>
		<tbody>
			<tr>
				<!-- 教科の選択 -->
				<form name = "req" action = "" method = "GET">
					<td bgcolor = "blue"><select name = "sub" onChange = "this.form.submit();">

					<?php
					if ($_GET['sub'] == -1)
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
					<td bgcolor = "blue"><input type = "text" name = "day" value = "<?= date("Y/m/d") ?>" ></td>

				<!-- テスト範囲・内容入力 -->
					<td bgcolor = "blue"><textarea rows="2" cols="30" name = "contents"></textarea></td>

					<!-- 先生の選択 -->
					<td bgcolor = "blue"><select name = "teacher">
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
					<td bgcolor = "blue"><select name = "group">
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
					<input type = "hidden" name = "stand_flg" value = "0">
					<td align = "center" bgcolor = "blue"><input type = "checkbox" name = "stand_flg" value = "1"></td>

					<!-- 登録ボタン -->
					<td align = "center" bgcolor = "blue"><input type = "submit" value = "登録"></td>
				</form>
			</tr>

			<form action = "res_test_point.php" method = "POST">
				<?php
				//以前のテストの表示
				for ($i = 0; $i < $count_test; $i++)
				{
					$test = mysql_fetch_array($result_test);

					$contents = nl2br($test['contents']);
				?>

				<tr>
					<td><?= $test['subject_name'] ?></td>
					<td><?= $test['date'] ?></td>
					<td><?= $contents ?></td>
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
						<input class="button4" type = "submit" name = "submit['<?= $i ?>']" value = "点数修正">
					</td>
				</tr>
				<?php
				}
				?>
			</form>
			</tbody>
		</table>
						</div>
		<div id="tablefooter">
          <div id="tablenav">
            	<div>
                    <img src="../images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
                    <img src="../images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
                    <img src="../images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
                    <img src="../images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
                </div>
                <div>
                	<select id="pagedropdown"></select>
				</div>
            </div>
			<div id="tablelocation">
            	<div>
                    <select onchange="sorter.size(this.value)">
                    <option value="5">5</option>
                        <option value="10" selected="selected">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>Entries Per Page</span>
                </div>
                <div class="page">Page <span id="currentpage"></span> of <span id="totalpages"></span></div>
            </div>
        </div>
		<script type="text/javascript" src="../javascript/script.js"></script>
	<script type="text/javascript">
	var sorter = new TINY.table.sorter('sorter','table',{
		headclass:'head',
		ascclass:'asc',
		descclass:'desc',
		evenclass:'evenrow',
		oddclass:'oddrow',
		evenselclass:'evenselected',
		oddselclass:'oddselected',
		paginate:true,
		size:5,
		colddid:'columns',
		currentid:'currentpage',
		totalid:'totalpages',
		startingrecid:'startrecord',
		endingrecid:'endrecord',
		totalrecid:'totalrecords',
		hoverid:'selectedrow',
		pageddid:'pagedropdown',
		navid:'tablenav',
		sortcolumn:1,
		sortdir:-1,
		init:true
	});
  </script>

	</body>
</html>