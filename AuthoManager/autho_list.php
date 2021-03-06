<?php
/**********************************************
 * 権限管理一覧画面
 *
 * メイン画面で選択された権限グループの権限を表示するページ
 **********************************************/

/**********************************************
 * $count_page : ページの数を格納
 * $autho_seq  : メイン画面で選択された権限グループseqを格納
 * $page       : ページseqとページ名が格納された連想配列
 * $page_seq   : ページseqを格納
 * $page_fun   : autho.phpの自作関数を使うためのクラス
 * $page_cla   : 自作関数の返し値を格納する配列
 **********************************************/

//セッションの開始
session_start();
//$seq_autho : GETで受け取った権限グループseqをSESSIONに入れる
$_SESSION['autho_sel'] = $_GET['id'];
$autho_seq = $_SESSION['autho_sel'];

if(!isset($_GET['id']))
{
	header("Location:../dummy.html");
}

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();

//権限名をとってくる
$sql = "SELECT autho_name FROM m_autho 
		WHERE autho_seq = '$autho_seq';";
$result_autho = mysql_query($sql);
$autho_name = mysql_fetch_array($result_autho);

//ページ名とページseqを取得するSQL文
$sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg != 1;";
$result = mysql_query($sql);

//SQLで取得した件数を数える
$count_page = mysql_num_rows($result);

Dbdissconnect($link);

?>

<html>
	<head>
		<title>権限管理一覧画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont">権限管理一覧</font><hr color="blue">
		</div><br><br>
			名前 :<font class="Cubicfont3"> <?= $autho_name['autho_name'] ?></font>
<!-- 		テープルの作成 -->
		<table class="table_01">
			<tr>
				<th width = "25%" align = "center" ><font size="5">ページ名</font></th>
				<th width = "15%" align = "center" ><font size="5">Read</font></th>
				<th width = "15%" align = "center" ><font size="5">Write</font></th>
				<th width = "15%" align = "center" ><font size="5">Update</font></th>
				<th width = "15%" align = "center" ><font size="5">Delivery</font></th>
				<th width = "15%" align = "center" ><font size="5">Delete</font></th>
			</tr>

			<?php
			for($i = 0; $i < $count_page; $i++)
			{
				//ページseqとページ名を連想配列に入れる
				$page = mysql_fetch_array($result);
			?>
				<tr>
					<td align = "center"><?= $page['page_name'] ?></td>		<!--  ページ名の表示	-->

					<?php
					require_once("../lib/autho.php");
					$page_fun = new autho_class();
					$page_cla = $page_fun -> autho_Pre($autho_seq, $page['page_seq']);

					//権限の○×表示
					?>
					<td align = "center">
					<?php 
						if($page_cla['read_flg'])
						{
							echo "○" ;
						}
						else
						{
							echo "×" ;
						}
					?>
					</td>
						
					<td align = "center">
					<?php 
						if($page_cla['write_flg'])
						{
							echo "○" ;
						}
						else
						{
							echo "×" ;
						}
					?>
					</td>
					
					<td align = "center">
					<?php 
						if($page_cla['update_flg'])
						{
							echo "○" ;
						}
						else
						{
							echo "×" ;
						}
					?>
					</td>
					
					<td align = "center">
					<?php 
						if($page_cla['delivery_flg'])
						{
							echo "○" ;
						}
						else
						{
							echo "×" ;
						}
					?>
					</td>
					
					<td align = "center">
					<?php 
						if($page_cla['delete_flg'])
						{
							echo "○" ;
						}
						else
						{
							echo "×" ;
						}
					?>
					</td>
				</tr>
			<?php
			}
			?>
		</table><br>
		</div>
	</body>
</html>