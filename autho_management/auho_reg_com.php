<?php

//セッションの開始
session_start();

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();

$autho_seq = $_SESSION['autho_sel'];
//ページ名とページseqを取得するSQL文
$sql = "SELECT user_seq, user_name FROM m_user WHERE delete_flg = 0 AND autho_seq = '$autho_seq'";
$result = mysql_query($sql);

//SQLで取得した件数を数える
$count_page = mysql_num_rows($result);

Dbdissconnect($link);


//$seq_autho : セッションで受け取った権限グループseqを入れる
$autho_seq = $_SESSION['autho_sel'];
?>

<html>
	<head>
		<title>権限アカウント確認一覧</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>	
	</head>
	
	<body>
		<div align = "center">
			<font size = "6">権限アカウント一覧画面</font><hr>
		</div><br><br>
		
<!-- 		テープルの作成 -->
		<table border = "1" width = "50%">
			<tr>
				<td width = "50%" align = "center">アカウント名</td>
			</tr>
			
			<?php
			for($i = 0; $i < $count_page; $i++)
			{
				//ページseqとページ名を連想配列に入れる
				$page = mysql_fetch_array($result);
			?>
				<tr>
					<td align = "center"><?= $page['user_name'] ?></td>		<!--  ページ名の表示	-->
				
					<?php 
			}
					?>
		</table><br>
		<a href="autho_main.php">トップへ戻る</a>
		<input type="button" value="戻る" onClick="history.back()">
	</body>
</html>
