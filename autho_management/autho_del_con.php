<?php
/**************************************
 * 権限グループ削除画面
 * 
 * メインで選択された権限グループを表示する 
 **************************************/
session_start();

if(!isset($_GET['id']))
{
	header("Location:../dummy.html");
}

$_SESSION['autho_sel'] = $_GET['id'];
$autho_seq = $_SESSION['autho_sel'];

require_once("../lib/dbconect.php");
$link = DbConnect();

$sql = "SELECT autho_name FROM m_autho WHERE autho_seq = '$autho_seq';";
$result = mysql_query($sql);

$name = mysql_fetch_array($result);
Dbdissconnect($link);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<meta http-equiv="Content-Style-Type" content="text/css">
	  	<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<title>権限削除確認</title>
	</head>

	<body>
		<form action = "autho_del_dec.php">
			<table border = "1">
				<tr>
					<th bgcolor="Yellow">権限グループ名</th>
				</tr>
				<tr>
					<td><?= $name['autho_name'] ?></td>
				</tr>
			</table>
			
			<br>
			<input class="button4" type = "submit" value = "確定"><br>
			<a href="autho_main.php">トップへ戻る</a>
		</form>
	</body>
</html>