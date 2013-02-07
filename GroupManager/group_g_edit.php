<?php
$id = $_GET['id'];

require_once("../lib/dbconect.php");
$dbcon = DbConnect();

//表示用データ取得
$sql = "SELECT group_name, class_flg, COUNT(group_details.group_seq) AS cnt
		FROM group_details
		LEFT JOIN m_group ON
		group_details.group_seq = m_group.group_seq
		WHERE group_details.group_seq = '$id'
		GROUP BY group_details.group_seq";

$group_result = mysql_query($sql);
$group_row = mysql_fetch_array($group_result);



?>

<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<script src="../javascript/form_reference.js"></script>
		<script src="../javascript/jquery-1.8.2.min.js"></script>
		<title>グループ追加</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<form action = "group_g_edit_db.php" method = "POST" onSubmit="return check()">
			<div align = "center">

				<font class="Cubicfont">グループ情報</font>

				<hr color = "blue">
				<table class="table_01">
					<tr>
						<th>グループ名</th>
						<th>クラスフラグ</th>
						<th>所属人数</th>
					</tr>
					<tr>
						<td>
							<input type="text" size="50" name = "new_group_name" id="group_name" disabled value="<?= $group_row['group_name'] ?>" Onblur="check('#group_name', ic)">
						</td>
						<td>
							<?php 
							if($group_row['class_flg'] == 0)
							{?>
								<input value="1" type="checkbox" name = "class_flg" disabled >
							
							<?php 
							}
							else 
							{ ?>
								<input  value="1" type="checkbox" name = "class_flg" disabled checked>							
						<?php 
							}
							?>
						</td>
						<td>
							<?= $group_row['cnt'] ?>
						</td>
						</tr>
				</table>
				<br>
				<table>
				<tr>
				<td>
					<input  id="edit" class="button4" data-id="0"  type = "button" value = "編集">
				</td>
				<td>
				
					<input class="button4" type = "submit" value = "登録" disabled  name = "g_entry">
				</td>
				</tr>
				</table>
			</div>
			<input type = "hidden" name="seq" value = "<?= $id ?>">
			
		</form>
		</div>
				<script>
		$(function() {
			//検索結果から権限を追加するための処理
			$(document).on('click', '#edit', function() {

				//対象のinputタグのNameを配列にかくのう
				var input_names = new Array("new_group_name", "class_flg", "g_entry");
				var flg = $(this).data('id');

				if(flg == 0)
				{
					for (i = 0; i < input_names.length; i++)
					{
						$("*[name="+input_names[i]+"]").attr('disabled', false);

					}
					$(this).data('id','1');
				}	
				else
				{
					for (i = 0; i < input_names.length; i++)
					{
						$("*[name="+input_names[i]+"]").attr('disabled', true);

					}
					$(this).data('id','0');
				}
			});
		});

		function check(){
			if(window.confirm('変更してよろしいですか？')){ // 確認ダイアログを表示
				return true; // 「OK」時は送信を実行
			}
			else{ // 「キャンセル」時の処理
				return false; // 送信を中止
			}
		}
			</script>
		
		
	</body>
</html>