<?php


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
		FROM m_test, m_subject, m_teacher, m_user, m_group, test_result
		WHERE m_test.subject_seq = m_subject.subject_seq 
		AND m_test.teacher_seq = m_teacher.teacher_seq 
		AND m_test.group_seq = m_group.group_seq 
		AND m_teacher.user_seq = m_user.user_seq 
		AND m_test.delete_flg = 0
		AND test_result.test_seq = m_test.test_seq
		AND test_result.user_seq = '$sesID'";
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
			<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		<title>テスト選択画面</title>
	</head>
	
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont2">テスト結果一覧</font><hr color="blue"><br><br><br>
		</div>
		
		<!-- SQLで取り出したテストデータの表示 -->
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
				<th>日付</th>
				<th>教科</th>
				<th>テスト範囲</th>
				<th>先生</th>
				<th>点数</th>
				<th>平均点</th>
			</tr>
			</thead>
		<tbody>
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
						<font size = "5" color = "blue">
							<div align = "center">
								<b><?= $point['point'] ?></b>
							</div>
						</font>
					<?php 
					}
					elseif ($point['point'] >= $avg['AVG(point)'])
					{
					?>
						<font size = "5" color = "blue">
							<div align = "center">
								<?= $point['point'] ?>
							</div>
						</font>
						
					<?php 
					}
					else 
					{
					?>
						<font size = "5" color = "red" >
							<div align = "center">
								<?= $point['point'] ?>
							</div>
						</font>
					<?php 
					}?>
				</td>
				<td align = "center">
					<font size = "5">
						<?php print round($avg['AVG(point)'],1) ?>
					</font>
				</td>
			</tr>
			<?php
			}
			?>
			</tbody>
		</table>
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
		<?php
			Dbdissconnect($link);
			?>
			</div>
		<input class="button4"  type="button" value="戻る" onClick="history.back()">
		</div>
	</body>
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
	
</html>

