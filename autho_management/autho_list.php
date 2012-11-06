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
if(!isset($_GET['id']))
{
	header("Location:../dummy.html");
}

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();

//ページ名とページseqを取得するSQL文
$sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg != 1;";
$result = mysql_query($sql);

//SQLで取得した件数を数える
$count_page = mysql_num_rows($result);

Dbdissconnect($link);


//$seq_autho : GETで受け取った権限グループseqをSESSIONに入れる
$_SESSION['autho_sel'] = $_GET['id'];
$autho_seq = $_SESSION['autho_sel'];
?>

<html>
	<head>
		<title>権限管理一覧</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
	</head>

	<body>
		<div align = "center">
			<font size = "6">権限管理一覧画面</font><hr>
		</div><br><br>

<!-- 		テープルの作成 -->
		<table border = "1" width = "100%">
			<tr>
				<td width = "25%" align = "center">ページ名</td>
				<td width = "15%" align = "center">read</td>
				<td width = "15%" align = "center">write</td>
				<td width = "15%" align = "center">delete</td>
				<td width = "15%" align = "center">update</td>
				<td width = "15%" align = "center">delivery</td>
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

					for($j = 0; $j < 5; $j++)
					{
					?>
					<td align = "center">
					<?php
					//権限の○×表示
					if($page_cla[$j])
						{
							echo "○" ;
						}
						else
						{
							echo "×" ;
						}
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
		<a href="autho_main.php">トップへ戻る</a>
	</body>
</html>