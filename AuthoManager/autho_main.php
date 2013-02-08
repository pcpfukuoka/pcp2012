<?php
session_start();
$user_seq = $_SESSION['login_info[user]'];

if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
{
	//header("Location:login/index.php");
}

//page_seq = 7(権限管理)
require_once("../lib/autho.php");
$page_fun = new autho_class();
$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 7);


if($page_cla[0]['read_flg'] == 0)
{
		header("Location:../Top/top_left.php");
}

/***********************************
 * 権限管理メイン画面
 *
 * 押されたボタンによって各操作ページに飛ぶ
 * GET送信で権限グループseqを送る
 ***********************************/

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();

//権限seqと権限グループ名を取得し、数を数える
$sql = "SELECT autho_seq, autho_name FROM m_autho WHERE delete_flg != 1;";
$result = mysql_query($sql);
$count_autho = mysql_num_rows($result);

Dbdissconnect($link);

?>

<html>
	<head>
		<title>権限管理メイン画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<script src="../javascript/frame_jump.js"></script>
		<meta http-equiv="Content-Style-Type" content="text/css">
	    <link rel="stylesheet" type="text/css" href="../css/table_search.css" />
	    <link rel="stylesheet" type="text/css" href="../css/table.css" />
	    <link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<script src="../javascript/jquery-1.8.2.min.js"></script>
 		<script src="../javascript/jquery-ui-1.8.24.custom.min.js"></script>
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">権限管理</font>
		</div>
			<hr color="blue">
<?php
/********************************************************
 * $autho_group : DBから取得した権限seqとグループ名を入れる連想配列
 *********************************************************/
?>
	<table>
		<tr>
			<td><input class="longbutton" type="button" onclick="jump('autho_add.php','right')"value = "権限グループ追加"></td>
			<td><input class="longbutton" type="button" onclick="jump('page_add.php','right')"value = "ページの編集"></td>
		</tr>
	</table>
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
					<th><h3>権限名</h3></th>
				</tr>
				</thead>
				<tbody>
			<?php 
			for($i = 0; $i < $count_autho; $i++)
			{
				//権限seqと権限グループ名を連想配列に入れる
				$autho_group = mysql_fetch_array($result);
				?>	
				<tr>
				<td>
				<input type="radio" class="check_autho" name="autho_seq" id="<?= $i ?>" data-id="<?= $autho_group['autho_seq'] ?>" >
				</td>
				<td>
					<?= $autho_group['autho_name'] ?>
				</td>
				</tr>
			
			<?php 
			}			
			?>
			</tbody>
			</table>
			
			<div>
			<table>
				<tr>
					<td><input  disabled id="list_1" class="button2" type="button" data-id="1" value="一覧"></td>
					<td><input  disabled id="list_2" class="button2" type="button" data-id="2" value = "編集"></td>

				</tr>
				<tr>
					<td><input  disabled id="list_3" class="button2" type="button" data-id="3" value="登録"></td>
					<td><input disabled id="list_4" class="button2" type="button" data-id="4" value="削除"></td>
				</tr>
				<tr>
					<td><input  disabled id="list_5" class="button2" type="button" data-id="5" value="ユーザー一覧"></td>
				</tr>
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

		if(type == 1)
		{
			var str = "autho_list.php?id="+id;
			jump(str, 'right');
		}
		else if(type == 2)
		{
			jump('autho_edit.php?id='+id,'right');
		}
		else if(type == 3)
		{
			jump('autho_reg.php?id='+id,'right');
		}
		else if(type == 4)
		{
			jump('autho_del_con.php?id='+id,'right');
		}
		else if(type == 5)
		{
			jump('autho_user_list.php?id='+id,'right');
		}
    });
	$(document).on('click', '.check_autho', function() {

		$("#list_1	").attr('disabled', false);		
		$("#list_2").attr('disabled', false);		
		$("#list_3").attr('disabled', false);		
		$("#list_4").attr('disabled', false);		
		$("#list_5").attr('disabled', false);		
});
  

  </script>
  
  
  


</html>