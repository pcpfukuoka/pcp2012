<?php
/******************************************
 * 権限所属ユーザー一覧画面
 * 
 * その権限に属しているユーザーを一覧で表示する画面
 ******************************************/

//権限グループseqをGETで受け取る
$autho_seq = $_GET['id'];

if(!isset($_GET['id']))
{
	header("Location:../dummy.html");
}

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();

//ユーザー名と権限名をとってくる
$sql = "SELECT m_user.user_name, m_autho.autho_name,m_user.user_kana FROM m_user, m_autho 
		WHERE m_user.autho_seq = m_autho.autho_seq 
		AND m_autho.autho_seq = '$autho_seq';";
$result_autho = mysql_query($sql);
$autho_user = mysql_fetch_array($result_autho);
$cnt_autho = mysql_num_rows($result_autho);

Dbdissconnect($link);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
				<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		<script type="text/javascript" src="../javascript/jquery-1.8.2.min.js"></script>
		<title>ユーザー一覧</title>
	</head>

	<body>		
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">	
		<div align = "center">
			<font class="Cubicfont">権限管理一覧</font>
			<hr color="blue">
		</div>		
			名前 :<font class="Cubicfont3"> <?= $autho_user['autho_name'] ?></font>
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
			<th class="nosort"><h3>ユーザー名</h3></th>
			<th><h3>（フリガナ）</h3></th>
			</tr>
		</thead>
		<tbody>
			
			<?php 
			for ($i = 0; $i < $cnt_autho; $i++)
			{
			?>
				<tr>
					<td><?= $autho_user['user_name'] ?></td>
					<td><?= $autho_user['user_kana'] ?></td>
					</tr>
			<?php 
				$autho_user = mysql_fetch_array($result_autho);
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
