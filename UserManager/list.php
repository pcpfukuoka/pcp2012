<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TinyTable</title>
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		</head>
<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
	<div id="container">
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
			<th class="nosort"><h3>ユーザ名</h3></th>
			<th><h3>(フリガナ)</h3></th>
			<th><h3>ユーザID</h3></th>
			<th><h3>権限名</h3></th>
		</tr>
		</thead>
        <tbody>
        <?php
		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();
		//表示用ユーザ情報取得
		$sql = "SELECT user_seq,user_name, user_id, m_autho.autho_name,user_kana FROM m_user  left JOIN m_autho ON m_user.autho_seq = m_autho.autho_seq AND m_autho.delete_flg = 0 WHERE m_user.delete_flg = 0 ORDER BY user_kana ASC;";
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);

		for($i = 0; $i < $cnt; $i++)
		{
			$row = mysql_fetch_array($result);
			?>
			<tr>
				<td class="nosort"><a href="change_view.php?id=<?= $row['user_seq'] ?>"><?= $row['user_name'] ?></a></td>
				<td><?= $row['user_kana'] ?></td>
				<td><?= $row['user_id'] ?></td>
				<td><?= $row['autho_name'] ?></td>
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