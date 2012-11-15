<?php
/***************************************
 * 権限編集確定画面
 * 
 * autho_edit_con.phpでPOSTで受け取った
 * 値をUPDATE文で更新する。
 ***************************************/

//セッションの開始
session_start();

//$seq_autho : セッションで受け取った権限グループseqを入れる
$autho_seq = $_SESSION['autho_sel'];

require_once("../lib/dbconect.php");
$link = DbConnect();

//delete_flgが立っていないページseqを取得
$sql = "SELECT page_seq FROM m_page WHERE delete_flg != 1;";
$result = mysql_query($sql);
$count_page = mysql_num_rows($result);

$j = 0;
for ($i = 0; $i < $count_page; $i++)
{
	//ページseqを配列に入れる
	$page = mysql_fetch_array($result);

	$page_seq = $page['page_seq'];
	
	$edit_data = $_POST['edit_data'][$j];
	
	$sql = "UPDATE m_access_autho SET read_flg = '$edit_data' WHERE autho_seq = '$autho_seq' AND page_seq = '$page_seq';";
	mysql_query($sql);
	$j++;
	
	$edit_data = $_POST['edit_data'][$j];
	$sql = "UPDATE m_access_autho SET write_flg = '$edit_data' WHERE autho_seq = '$autho_seq' AND page_seq = '$page_seq';";
	mysql_query($sql);
	$j++;
	
	$edit_data = $_POST['edit_data'][$j];
	$sql = "UPDATE m_access_autho SET delete_flg = '$edit_data' WHERE autho_seq = '$autho_seq' AND page_seq = '$page_seq';";
	mysql_query($sql);
	$j++;
	
	$edit_data = $_POST['edit_data'][$j];
	$sql = "UPDATE m_access_autho SET update_flg = '$edit_data' WHERE autho_seq = '$autho_seq' AND page_seq = '$page_seq';";
	mysql_query($sql);
	$j++;
	
	$edit_data = $_POST['edit_data'][$j];
	$sql = "UPDATE m_access_autho SET delivery_flg = '$edit_data' WHERE autho_seq = '$autho_seq' AND page_seq = '$page_seq';";
	mysql_query($sql);
	$j++;
}

$edit_name = $_POST['edit_name'];
$sql = "UPDATE m_autho SET autho_name = '$edit_name' WHERE autho_seq = '$autho_seq';";
mysql_query($sql);

Dbdissconnect($link);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<title>権限確定</title>
	</head>
	
	<body>
		<img class="bg" src="../../images/blue-big.jpg" alt="" />
		<div id="container">
		<font size="5">データベースへ登録しました。</font>
		<br><br>
		<a href="autho_main.php">トップへ戻る</a>
	</div>
	</body>
</html>