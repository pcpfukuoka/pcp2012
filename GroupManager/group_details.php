<?php

	session_start();

	//autho_seq = 7(テスト用)
	//page_seq = 11(プリント配信)
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 8);


	if($page_cla[0]['read_flg'] == 0)
	{
		header("Location:../top_left.php");
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
		<script src="../javascript/jquery-1.8.2.min.js"></script>
		<script src="../javascript/jquery-ui-1.8.24.custom.min.js"></script>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont"><?= $group_name ?></font>
			<hr color = "blue">
				<table class="table_01">
					<tr bgcolor = "yellow">

						<?php
							if($page_cla['delete_flg'] == 1)
							{
						?>
								<td><font size="5">削除</font></td>
						<?php
							}
						?>
								<td><font size="5">名前</font></td>
								<td><font size="5">ＩＤ</font></td>
								<td><font size="5">学籍番号</font></td>
					</tr>

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
								<th><input id="check_user_<?= $g_user_row['group_details_seq'] ?>" class="checkUser" data-id="<?= $g_user_row['group_details_seq'] ?>" type = "checkbox" value = "<?= $g_user_row['user_name'] ?>"></th>
						<?php
							}
						?>
							<th><?= $g_user_row['user_name'] ?></th>
							<th><?= $g_user_row['user_id'] ?></th>
							<th><?= $g_user_row['student_id'] ?></th>
						</tr>
					<?php
						}
					?>
				</table>
			<div>
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
		</div>
		</div>
	</body>

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
		window.open('group_u_add.php?id=<?= $group_seq ?>', 'ユーザ追加', 'width=500,height=400,top=100,left=500');;
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