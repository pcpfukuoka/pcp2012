<?php
/*************************************
 * 権限管理編集画面
 * 
 * 登録されている権限グループの権限を変更する。
 *************************************/

//セッションの開始
session_start();

if(!isset($_GET['id']))
{
	header("Location:../dummy.html");
}

//$seq_autho : GETで受け取った権限グループseqをSESSIONに入れる
$_SESSION['autho_sel'] = $_GET['id'];
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
		<title></title>
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
	
		<div align = "center">
			<font class="Cubicfont">権限管理編集画面</font>
		</div><hr color="blue"><br><br><br>
		
		<!-- 確認画面に飛ぶ -->
		<form action = "autho_edit_con.php" method = "POST">
		
		<!-- 元の権限グループ名を表示させ、変更できるようにする -->
			名前<input size ="15" type="text" name="edit_name" value = <?= $edit_name['autho_name'] ?>>
		
		<!-- 		テープルの作成 -->
			<table class="table_01" width = "100%">
				<tr>
					<td width = "25%" align = "center" ><font size="5">ページ名</font></td>
					<td width = "15%" align = "center" ><font size="5">read</font></td>
					<td width = "15%" align = "center" ><font size="5">write</font></td>
					<td width = "15%" align = "center" ><font size="5">delete</font></td>
					<td width = "15%" align = "center" ><font size="5">update</font></td>
					<td width = "15%" align = "center" ><font size="5">delivery</font></td>
				</tr>
				
				<?php
				$autho_chk = 0;
				for ($i = 0; $i < $count_page; $i++)
				{
					$page = mysql_fetch_array($result);
				?>
					<tr>
						<th align = "center"><?= $page['page_name'] ?></th>		<!--  ページ名の表示	-->
					
						<?php 
						require_once("../lib/autho.php");
						$page_fun = new autho_class();
						$page_cla = $page_fun -> autho_Pre($autho_seq, $page['page_seq']);
						
						//チェックボックスの表示
						for($j = 0; $j < 5; $j++)
						{
							if($page_cla[$j] == 1)
							{
						?>
								<input type = "hidden" name = "autho_edit<?= $autho_chk ?>" value = "0">
								<th><input type = "checkbox" name = "autho_edit<?= $autho_chk ?>" value = "1" checked></th>
							<?php
							}
							else
							{
							?>
								<input type = "hidden" name = "autho_edit<?= $autho_chk ?>" value = "0">
								<th><input type = "checkbox" name = "autho_edit<?= $autho_chk ?>" value = "1"></th>
							<?php 
							} 
							$autho_chk++;
						}
							?>
					</tr>
				<?php
				}
				?>
			</table>
			<br>
			<input class="button4" type = "submit" value = "登録"><br>
			<a href="autho_main.php">トップへ戻る</a>
		</form>
		</div>
	</body>
</html>