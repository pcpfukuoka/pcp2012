<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる

	if(isset($_POST['serch_name']))
	{
		$group_name = $_POST['serch_name'];

		$sql = "SELECT * FROM m_group WHERE group_name LIKE '%$group_name%' AND delete_flg = 0;";
	}
	else
	{
		$sql = "SELECT * FROM m_group WHERE delete_flg = 0;";
	}

	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);

	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<script type="text/javascript" src="../javascript/frame_jump.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<title>グループ一覧	</title>

	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
		<font class="Cubicfont" >グループ</font>
		</div>
		<hr color="blue">
		<br><br><br>

		<!-- グループ追加画面へ -->
		<input class="button3" type = "submit" value = "グループの追加" name = "g_add" onclick="jump('group_g_add.php','right')" id="group_add">
		<br>
		<form action = "group_top.php" method = "POST">
		<table>
			<tr>
				<td><input type = "text" name = "serch_name"></td>
				<td><input class="button4" type = "submit" value = "検索" name = "g_serch"></td>
			</tr>
		</table>
		</form>

		<font class="Cubicfont3"> ----   グループ一覧     ---- </font>



		<?php
			for($i = 0; $i < $cnt; $i++)
			{
				$group_row = mysql_fetch_array($result);
		?>

		<ul>
			<li>
				<input type="text" value=<?= $group_row['group_name'] ?> onclick="jump('group_details.php?id=<?= $group_row['group_seq'] ?>','right')" id="group_select">
			</li>
		</ul>

		<?php
			}
		?>
		</div>
	</body>
</html>