<?php
/**************************************
 * 権限編集確認画面
 * 
 * autho_edit.phpでチェックされた権限をテーブルで
 * ○×表示させる
 **************************************/
require_once("../lib/dbconect.php");
$link = DbConnect();

//ページ名とページseqを取得するSQL文
$sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg != 1;";
$result = mysql_query($sql);

//SQLで取得した件数を数える
$count_page = mysql_num_rows($result);

Dbdissconnect($link);

?>
<html>
	<head>
		<title>権限編集確認画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	
	<body>
		<img class="bg" src="../../images/blue-big.jpg" alt="" />
		<div id="container">
	<!-- 編集確定画面に飛ぶ -->
		<form action = "autho_edit_dec.php" method = "POST">
			<div align = "center">
				<font class="Cubicfont">権限編集確認</font>
			</div><hr color="blue"><br><br><br>
			
			<!-- 権限グループの名前を表示 -->
			名前：<?= $_POST['edit_name'] ?>
			<input type = "hidden" name = "edit_name" value = "<?= $_POST['edit_name'] ?>">
			
			<!-- テーブルの作成 -->
			<table  class="table_01">
				<tr>
					<th width = "25%" align = "center"><font size="5">ページ名</font></th>
					<th width = "15%" align = "center"><font size="5">read</font></th>
					<th width = "15%" align = "center"><font size="5">write</font></th>
					<th width = "15%" align = "center"><font size="5">update</font></th>
					<th width = "15%" align = "center"><font size="5">delivery</font></th>
					<th width = "15%" align = "center"><font size="5">delete</font></th>
				</tr>
				
				<?php
				$autho_chk = 0;
				for($i = 0; $i < $count_page; $i++)
				{
					//ページseqとページ名を連想配列に入れる
					$page = mysql_fetch_array($result);
				?>
					<tr>
						<td align = "center"><?= $page['page_name'] ?></td>		<!--  ページ名の表示	-->
					<?php
					for($j = 0; $j < 5; $j++)
						{
							$autho_edit = "autho_edit".$autho_chk;
					?>
						<td>
						<?php if($_POST[$autho_edit])
							{
						?>
								<input type = "hidden" name = "edit_data[]" value = "1">
								<?php		
								echo "○" ;
							}
							else
							{
								?>
								<input type = "hidden" name = "edit_data[]" value = "0">
								<?php
								echo "×" ;	
							}
							$autho_chk++;
						?>
						</td>
						<?php 
						}
						?>
					</tr>
				<?php 
				}
				?>	
			</table><br>
			<table>
				<tr>
					<td><input class="button4" type = "submit" value = "登録"></td>
					<td><input class="button4" type="button" value="戻る" onClick="history.back()"></td>
				</tr>
			</table>
			
		</form>
		</div>
	</body>
</html>