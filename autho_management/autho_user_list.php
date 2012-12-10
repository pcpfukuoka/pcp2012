<?php
/******************************************
 * 権限所属ユーザー一覧画面
 * 
 * その権限に属しているユーザーを一覧で表示する画面
 ******************************************/

//権限グループseqをGETで受け取る
$autho_seq = $_GET['id'];

if(!isset($_GET['id']))
{
	header("Location:../dummy.html");
}

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();

//ユーザー名と権限名をとってくる
$sql = "SELECT m_user.user_name, m_autho.autho_name FROM m_user, m_autho 
		WHERE m_user.autho_seq = m_autho.autho_seq 
		AND autho_seq = '$autho_seq';";
$result_autho = mysql_query($sql);
$autho_user = mysql_fetch_array($result_autho);
$cnt_autho = mysql_num_rows($result_autho);

Dbdissconnect($link);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<title>ユーザー一覧</title>
	</head>

	<body>
		<div align = "center">
			<font class="Cubicfont">権限管理一覧</font><hr color="blue">
		</div><br><br>
		
		名前 : <?= $autho_user['autho_name'] ?><br>
		
		<table border = "1">
			<tr>
				<th>ユーザー名</th>
			</tr>
			
			<?php 
			for ($i = 0; $i < $cnt_autho; $i++)
			{
			?>
				<tr>
					<td><?= $autho_user['user_name'] ?></td>
				</tr>
			<?php 
				$autho_user = mysql_fetch_array($result_autho);
			}
			?>
		</table>
	</body>
</html>
