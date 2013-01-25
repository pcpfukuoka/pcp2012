<?php
/***********************************************
 * テスト成績一覧選択画面
 **********************************************/

$subject_seq = $_POST['subject_seq'];
$group_seq = $_POST['group_seq'];
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
		AND m_test.delete_flg = 0 
		AND m_test.group_seq = '$group_seq'";

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

Dbdissconnect($link);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" href="../css/animate.css">
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		<title>テスト選択画面</title>
	</head>
	
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont2">テスト選択</font><hr color="blue">
		</div>
		<!-- 点数を表示させるためのphpファイルに飛ぶ -->
		<form action = "test_point_list.php" method = "POST">
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
					<th><h3>日付</h3></th>
					<th><h3>教科</h3></th>
					<th><h3>テスト範囲</h3></th>
					<th><h3>先生</h3></th>
					<th><h3>グループ</h3></th>
					<th><h3>定期テスト</h3></th>
					<th><h3>点数表示</h3></th>
				</tr>
				</thead>
				<tbody>		
			
				<?php 
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
					
					<!-- 各生徒の点数を表示させるために、test_seqを持っていく -->
					<td align = "center">
						<input type = "hidden" name = "subname['<?= $i ?>']" value = "<?= $test['test_seq'] ?>">
						<input type = "submit" name = "submit['<?= $i ?>']" value = "点数表示">
					</td>
				</tr>
				<?php
				} 
				?>
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
			<br>
			<input class="button4" type="button" value="戻る" onClick="history.back()">
		</form>
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