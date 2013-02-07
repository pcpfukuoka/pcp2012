<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
	{
		//header("Location:login/index.php");
	}

	//page_seq = 8(グループ管理)
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 8);

	if($page_cla[0]['read_flg'] == 0)
	{
		header("Location:../Top/top_left.php");
	}

	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//これでDBを呼び出す関数が使えるようになる

	if(isset($_POST['serch_name']))
	{
		$group_name = $_POST['serch_name'];

		$sql = "SELECT * FROM m_group WHERE group_name LIKE '%$group_name%' AND delete_flg = 0 ORDER BY group_name ASC;";
	}
	else
	{
		$sql = "SELECT * FROM m_group WHERE delete_flg = 0 ORDER BY group_name ASC;";
	}

	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);

	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<script type="text/javascript" src="../javascript/frame_jump.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
	    <link rel="stylesheet" type="text/css" href="../css/table_search.css" />
	    <link rel="stylesheet" type="text/css" href="../css/table.css" />
		<script src="../javascript/jquery-1.8.2.min.js"></script>
 		<script src="../javascript/jquery-ui-1.8.24.custom.min.js"></script>
	    <title>グループ一覧</title>
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont" >グループ</font>
			</div>
			<hr color="blue">
			<!-- グループ追加画面へ -->
			<input class="button3" type = "submit" value = "グループの追加" name = "g_add" onclick="jump('group_g_add.php','right')" id="group_add">
	<div id="tablewrapper">
		<div id="tableheader">
        	<div class="search">
                <select id="columns" onchange="sorter.search('query')"></select>
                <input type="text" id="query" onkeyup="sorter.search('query')" />
            </div>
            <span class="details">
				<div>Records <span id="startrecord"></span>-<span id="endrecord"></span> of <span id="totalrecords"></span></div>
        	</span>
        </div> 
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="table_01">
							<thead>
					<tr>
						<th class="nosort"><h3></h3></th>
						<th><h3>グループ名</h3></th>
					</tr>
				</thead>
				<tbody>
				<?php
				for($i = 0; $i < $cnt; $i++)
				{
					$group_row = mysql_fetch_array($result);
				?>
				<tr>
					<td>
						<input class="check_group" type="radio" name="group_seq" id="<?= $i ?>" data-id="<?= $group_row['group_seq'] ?>" >
					</td>
					<td>
						<?= $group_row['group_name'] ?> 
					</td>
				</tr>
				<?php
				}
				?>
				</tbody>	
			</table>
			<table>
				<tr>
					<td><input disabled id="list" class="button2" type="button" data-id="1" value="一覧"></td>
				</tr>
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
	                <div class="page">Page <span id="currentpage"></span> of <span id="totalpages"></span></div>
	            </div>
	        </div>	
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
		size:4,
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
  <script>
	$(document).on('click', '.button2', function() {
		var id = $('input:radio:checked').data('id');
		var type = $(this).data('id');
		var str = "group_details.php?id="+id;
		jump(str, 'right');
    });
	$(document).on('click', '.check_group', function() {

		$("#list").attr('disabled', false);		
    });
    
  </script>
	
	
	
</html>