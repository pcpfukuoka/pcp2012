<?php

require_once("../lib/dbconect.php");
$dbcon = DbConnect();


$details_seq = $_GET['id'];

$sql = "SELECT question_awnser_list.question_awnser_list_seq,m_user.user_name,question_awnser_list.awnser_name 
		FROM question_details 
		right JOIN question_awnser_list ON question_details.question_details_seq = question_awnser_list.question_details_seq
		right JOIN question_awnser ON question_awnser_list.question_awnser_list_seq = question_awnser.question_awnser_list_seq
		left JOIN m_user ON question_awnser.awnser_user_seq = m_user.user_seq
		WHERE question_awnser_list.question_details_seq = '$details_seq'
		ORDER BY question_awnser_list.question_awnser_list_seq, m_user.user_seq";

$result = mysql_query($sql);
$cnt = mysql_num_rows($result);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
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
				<th>回答者</th>
				<th>回答</th>
			</tr>
			</thead>
			<tbody>
		<?php 
			for($i; $i < $cnt; $i++)
			{	
				$row = mysql_fetch_array($result);
			?>
			<tr>
				<td><?= $row['user_name'] ?></td>
				<td><?= $row['awnser_name'] ?></td>
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