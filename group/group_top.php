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
		<title>グループ一覧	</title>

	</head>

	<body>
		<p align = "center">
			<font size = "7">グループ一覧</font>
		</p>

		<hr color = "blue">

		<!-- グループ追加画面へ -->
		<input type = "submit" value = "グループの追加" name = "g_add" onclick="jump('group_g_add.php','right')" id="group_add">
			
		<form action = "group_top.php" method = "POST">
			<input type = "text" name = "serch_name">
			<input type = "submit" value = "検索" name = "g_serch">
		</form>
		
		<font size = "2">グループ一覧</font>



		<?php
			for($i = 0; $i < $cnt; $i++)
			{
				$group_cnt = mysql_fetch_array($result);
		?>

		<ul>
			<li>
				<input type="text" value=<?= $group_cnt['group_name'] ?> onclick="jump('group_details.php?id=<?= $group_cnt['group_seq'] ?>&name=<?= $group_cnt['group_name'] ?>','right')" id="group_select">
			</li>
		</ul>

		<?php
			}
		?>
	</body>
</html>