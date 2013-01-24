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
		AND m_autho.autho_seq = '$autho_seq';";
$result_autho = mysql_query($sql);
$autho_user = mysql_fetch_array($result_autho);
$cnt_autho = mysql_num_rows($result_autho);

Dbdissconnect($link);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
				<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
				<link rel="stylesheet" href="../css/animate.css">
		<link rel="stylesheet" href="../css/jPages.css">
		<script type="text/javascript" src="../javascript/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="../javascript/jPages.js"></script>
		<script> 
		$(function(){
		$(".holder").jPages({ 
		containerID : "list",
		previous : "←", //前へのボタン
		next : "→", //次へのボタン
		perPage : 5, //1ページに表示する個数
		midRange : 5,
		endRange : 2,
		delay : 20, //要素間の表示速度
		animation: "flipInY" //アニメーションAnimate.cssを参考に
		});
		});
		</script>
		<title>ユーザー一覧</title>
	</head>

	<body>		
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">	
		<div align = "center">
			<font class="Cubicfont">権限管理一覧</font>
			<hr color="blue">
		</div>		
			名前 :<font class="Cubicfont3"> <?= $autho_user['autho_name'] ?></font>
				<div class="holder"></div>
		<table class="table_01">
		<thead>
			<tr>
				<th>ユーザー名</th>
			</tr>
		</thead>
		<tbody id="list">
			
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
			</tbody>
		</table>
		</div>
	</body>
</html>
