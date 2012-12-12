<?php
/*************************************
 * 権限管理編集画面
 * 
 * 登録されている権限グループの権限を変更する。
 *************************************/

//セッションの開始
session_start();

// if(!isset($_GET['id']))
// {
// 	header("Location:../dummy.html");
// }

//$seq_autho : GETで受け取った権限グループseqをSESSIONに入れる
//$_SESSION['autho_sel'] = $_GET['id'];
$_SESSION['autho_sel'] = 2;
$autho_seq = $_SESSION['autho_sel'];

require_once("../lib/dbconect.php");
$link = DbConnect();

//ページ名とページseqを取得するSQL文
$sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg != 1;";
$result = mysql_query($sql);

//SQLで取得した件数を数える
$count_page = mysql_num_rows($result);

//選択された権限グループの名前を取得する
$sql = "SELECT autho_name FROM m_autho WHERE autho_seq = '$autho_seq' AND delete_flg != 1;";
$result2 = mysql_query($sql);
$edit_name = mysql_fetch_array($result2);

Dbdissconnect($link);

?>
<html>
	<head>
		<title>権限管理編集画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
		
	<script>
		$(function()
		{

			//検索結果から権限を追加するための処理
			$(document).on('click', '.add_btn', function() 
			{
				var id = $(this).data('id');
				var edit = "autho_edit" + id;
				var text = "autho_text" + id;
				var value = 1;//document.getElementById(name).value;
				
				if(value < 5)
				{
					document.getElementById(text).value = "○";
					document.getElementById(edit).value = "1";
					value++;
					document.getElementById(name).value= value;
				}
			});
			
			$(document).on('click', '.delete_btn', function() 
			{
				var id = $(this).data('id');
				var edit = "autho_edit" + id;
				var text = "autho_text" + id;
				var value = 1;//document.getElementById(name).value;
				value--;
				
				if(value >= 0)
				{
					document.getElementById(text).value = "×";
					document.getElementById(edit).value = "0";
					document.getElementById(name).value= value;
				}
			});
		});
	</script>
		
	</head>
	
	<body>
		<img class="bg" src="../../images/blue-big.jpg" alt="" />
		<div id="container">
	
		<div align = "center">
			<font class="Cubicfont">権限管理編集</font>
		</div><hr color="blue"><br><br><br>
		
		<!-- 確認画面に飛ぶ -->
		<form name = "edit" action = "autho_edit_con.php" method = "POST">
		
		<!-- 元の権限グループ名を表示させ、変更できるようにする -->
			名前<input size ="15" type="text" name="edit_name" value = <?= $edit_name['autho_name'] ?>>
		
		<!-- 		テープルの作成 -->
			<table class="table_01" width = "80%">
				<tr>
					<th width = "20%" align = "center" ><font size = "5">ページ名</font></th>
					<th width = "10%" align = "center" ><font size = "5">read</font></th>
					<th width = "10%" align = "center" ><font size = "5">write</font></th>
					<th width = "10%" align = "center" ><font size = "5">update</font></th>
					<th width = "10%" align = "center" ><font size = "5">delivery</font></th>
					<th width = "10%" align = "center" ><font size = "5">delete</font></th>
					<th width = "5%" align = "center" ><font size = "5">追加</font></th>
					<th width = "5%" align = "center" ><font size = "5">削除</font></th>
				</tr>
				
				<?php
				$autho_chk = 0;
				$autho_array = Array("read_flg", "write_flg", "update_flg", "delivery_flg", "delete_flg");
				for ($i = 0; $i < $count_page; $i++)
				{
					$page = mysql_fetch_array($result);
				?>
					<tr>
						<td align = "center"><?= $page['page_name'] ?></td>		<!--  ページ名の表示	-->
					
						<?php 
						require_once("../lib/autho.php");
						$page_fun = new autho_class();
						$page_cla = $page_fun -> autho_Pre($autho_seq, $page['page_seq']);
						
						//チェックボックスの表示
						for ($j = 0; $j < 5; $j++)
						{
							$autho = $autho_array[$j];
							
							if($page_cla[$autho] == 1)
							{
								$autho_del = $autho_chk;
								$autho_add = $autho_chk + 1;
							?>
								<input type = "hidden" name = "autho_edit<?= $autho_chk ?>" id = "autho_edit<?= $autho_chk ?>" value = "1">
								<td><input style = "width : 50%; font-size : 100%; text-align : center" type = "text" id = "autho_text<?= $autho_chk ?>" value = "○" readonly></td>
							<?php
							}
							else 
							{
								
							?>
								<input type = "hidden" name = "autho_edit<?= $autho_chk ?>" id = "autho_edit<?= $autho_chk ?>" value = "0">
								<td><input style = "width : 50%; font-size : 100%; text-align : center" type = "text" id = "autho_text<?= $autho_chk ?>" value = "×" readonly></td>
							<?php 
							} 
							$autho_chk++;
						}
						?>
						<input type = "hidden" id = "autho_del" value = "$autho_del">
						<input type = "hidden" id = "autho_add" value = "$autho_add">
						<input type="hidden" id = "Value_<?= $row['page_seq'] ?>" value="0">
						<td><input type = "button" class = "add_btn" data-id = "<?= $autho_add ?>" value="追加" id = "id"></td>
						<td><input type = "button" class = "delete_btn" data-id = "<?= $autho_del ?>" value="削除" id = "id"></td>
					</tr>
				<?php
				}
				?>
			</table>
			<br>
			<input class="button4" type = "submit" value = "確認"><br>
		</form>
		</div>
	</body>
</html>