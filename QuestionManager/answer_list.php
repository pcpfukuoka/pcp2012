<?php
session_start();

//GETで値がなければこのページには遷移させない
//今はテスト用にその処理は欠かないけど最終的には追加する

$user_seq = $_SESSION['login_info[user]'];

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
				<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		
	</head>
	<body>		
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">新規登録</font>
			</div>
		<hr color="blue"><br><br>
		
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
				<th><h3>タイトル</h3></th>
				<th><h3>期間</h3></th>
				<th><h3></h3></th>				
			</tr>
		</thead>
		<tbody>
		<?php 
		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();
		$day = date("Y-m-d");
		//表示用ユーザ情報取得
	$sql = "SELECT * FROM question 
   		 	WHERE question_target_group_seq 
        		IN (SELECT m_group.group_seq 
            		FROM m_group INNER JOIN group_details 
            		ON m_group.group_seq = group_details.group_seq 
            		WHERE group_details.user_seq= '$user_seq'
            	   )
    		AND question_seq 
    			NOT IN (SELECT question_seq 
    					FROM question_awnser 
    					WHERE awnser_user_seq = '$user_seq' ) 
    		AND '".$day."' BETWEEN start_date AND end_date;";
				$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);
		
		for($i = 0; $i < $cnt; $i++)
		{
			$row = mysql_fetch_array($result);
			?>
			<tr>
				<td><?= $row['question_title'] ?></td>
				<td><?= $row['start_date'] ?> ~ <?= $row['end_date'] ?></td>
				<td><a href="answer_regist_view.php?id=<?= $row['question_seq'] ?>">回答する</a></td>
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