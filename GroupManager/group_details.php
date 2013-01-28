<?php

	session_start();

	//autho_seq = 7(テスト用)
	//page_seq = 11(プリント配信)
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 8);

	if($page_cla[0]['read_flg'] == 0)
	{
		header("Location:../dummy.html");
	}

	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる

	//グループSEQをGETで取得した場合
	if(isset($_GET['id']))
	{
		//IDを格納
		$group_seq = $_GET['id'];
		//グループの基本情報を取得
		$sql = "SELECT * FROM m_group WHERE group_seq = '$group_seq';";
		$group_info_result = mysql_query($sql);
		$group_info_row = mysql_fetch_array($group_info_result);
		$group_name = $group_info_row['group_name'];
		//グループの詳細情報を取得
		$sql = "SELECT
				m_group.group_name,
				m_user.user_name,
				m_user.user_kana,
				m_user.user_id,
				group_details.group_details_seq,
				group_details.group_seq,
				m_student.student_id
				FROM group_details
				LEFT JOIN m_group ON group_details.group_seq = m_group.group_seq AND m_group.delete_flg = 0
				LEFT JOIN m_user ON group_details.user_seq = m_user.user_seq AND m_user.delete_flg = 0
				LEFT JOIN m_student ON m_user.user_seq = m_student.user_seq
	 			WHERE group_details.group_seq = $group_seq;";
				$result = mysql_query($sql);
				$cnt = mysql_num_rows($result);
	}
	else
	{
		header("Location:./dummy.html");
	}


	Dbdissconnect($dbcon);

?>

<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		<script src="../javascript/jquery-1.8.2.min.js"></script>
		<script src="../javascript/jquery-ui-1.8.24.custom.min.js"></script>
		</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont"><?= $group_name ?></font>
			<hr color = "blue">
			</div>
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

						<?php
							if($page_cla['delete_flg'] == 1)
							{
						?>
								<th class="nosort"><h3>削除</h3></th>
						<?php
							}
						?>
								<th class="nosort"><h3>名前</h3></th>
								<th><h3>(フリガナ)</h3></th>
								<th><h3>ＩＤ</h3></th>
								<th><h3>学籍番号</h3></th>
					</tr>

				</thead>
				<tbody>
					<?php
						for($i = 0; $i < $cnt; $i++)
						{
							$g_user_row = mysql_fetch_array($result);
					?>
						<tr id = "user_<?= $g_user_row['group_details_seq'] ?>">

						<?php
							if($page_cla['delete_flg'] == 1)
							{
						?>
								<td><input id="check_user_<?= $g_user_row['group_details_seq'] ?>" class="checkUser" data-id="<?= $g_user_row['group_details_seq'] ?>" type = "checkbox" value = "<?= $g_user_row['user_name'] ?>"></td>
						<?php
							}
						?>
							<td><?= $g_user_row['user_name'] ?></td>
							<td><?= $g_user_row['user_kana'] ?></td>
							<td><?= $g_user_row['user_id'] ?></td>
							<td><?= $g_user_row['student_id'] ?></td>
						</tr>
					<?php
						}
					?>
				</tbody>
				</table>
			<table>
				<tr>
					<?php
						if($page_cla['delete_flg'] == 0)
						{
					?>
							<td><input class="button4" type = "submit" value = "ユーザを追加" name = "u_add" onclick="user_add()"></td>
					<?php
						}
						else
						{
					?>
							<td><input class="button4" type = "submit" value = "ユーザを追加" name = "u_add" onclick="user_add()"></td>
							<td><input class="button4" type = "submit" value = "グループを削除" name = "g_delete" onclick="group_delete()"></td>
							<td><input class="button4" type = "submit" value = "ユーザ削除完了" name = "u_delete" onclick="user_delete()"></td>
							<td><input class="button4" type = "submit" value = "ユーザ削除中止" name = "u_reset" onclick="user_reset()"></td>
					<?php
						}
					?>
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
	
	<script type="text/javascript">
	function group_delete()
	{
		if(window.confirm('本当に削除してよろしいですか？'))
		{
			location.href = "group_g_delete.php?id=<?= $group_seq ?>";
		}
	}
	function user_delete()
	{
		if(window.confirm('本当に削除を完了してよろしいですか？'))
		{
			location.href = "group_u_delete.php?id=<?= $group_seq ?>";
		}
	}
	function user_reset()
	{
		if(window.confirm('削除したデータをもとに戻してよろしいですか？'))
		{
			location.href = "group_u_reset.php?id=<?= $group_seq ?>";
		}
	}
	function user_add()
	{
		window.open('group_u_add.php?id=<?= $group_seq ?>', 'ユーザ追加', 'width=500,height=400,top=100,left=500,scrollbars=yes,resizable=yes,status=yes');;
	}
	</script>
		<script>
		$(function() {

			//検索結果から権限を追加するための処理
			$(document).on('click', '.checkUser', function() {
				var flg = "false";
				if(window.confirm('本当に削除してよろしいですか？'))
				{
					flg = "true";
				}
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
		        var id = $(this).data('id');
		        var chk = document.getElementById("check_user_"+id);		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('_ajax_user_delete.php', {
		            id: id,
		            flg:flg
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {
			        //選択した要素のIDを指定して削除
			        if(flg == "true")
			        {
			        	$('#user_'+id).fadeOut(800);
			        }
			        else
			        {
				        chk.checked = false;
			        }
	        });
		    });
		});
		</script>
</html>