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
$sql = "SELECT m_user.user_seq, m_user.user_name, m_user.user_kana, point
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
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
				
		<title>点数一覧画面</title>
	</head>
	
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont">点数一覧</font><hr color="blue">
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
				<th><h3>名前</h3></th>
				<th><h3>(フリガナ)</h3></th>
				<th><h3>点数</h3></th>
			</tr>
		</thead>
		<tbody>		
		<?php 
		for ($i = 0; $i < $count_point; $i++)
		{
			$point = mysql_fetch_array($result_point);
		?>
			<tr>
				<td><?= $point['user_name'] ?></td>
				<td><?= $point['user_kana'] ?></td>
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