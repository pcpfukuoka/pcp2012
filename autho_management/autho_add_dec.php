<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	<title>権限確定</title>
	</head>
	<body>

		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
	<?php
						/********************************************************
			 * 権限の新規追加確定画面
			 * 権限新規追加確認画面から持ってきたデータをfor文で取得　かつデータベースへ送信
			 *　またfor文内のinputで権限のチェックを送信
			 *　$Read_key == 権限新規追確認画面の入れ物を取り出すための入れ物
			 *　$Read ＝＝　実際にとりだす入れ物
			 *　どちらとも権限のページ分使い回し
			 *********************************************************/
			?>
	<font size="5">データベースへの登録を承認いたしました。</font>
	<?php
	require_once("../lib/dbconect.php");
	$link = DbConnect();
	$sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg = 0";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	$group_name = $_POST['group_name'];

	$sql = "insert into m_autho values(0,'$group_name' ,0)";
	mysql_query($sql);

	$sql = "SELECT autho_seq FROM m_autho WHERE delete_flg = 0 ORDER BY autho_seq DESC;";
	$autho_newseq = mysql_query($sql);
	$autho_seq_row = mysql_fetch_array($autho_newseq);
	$autho_seq = $autho_seq_row['autho_seq'];

	for($i = 0; $i < $count; $i++)
	{
		$row = mysql_fetch_array($result);

		$Read_key = "Read_".$row['page_seq'];		//
		$Read = $_POST[$Read_key];
		$Delete_key = "Delete_".$row['page_seq'];		//
		$Delete = $_POST[$Delete_key];
		$Write_key = "Write_".$row['page_seq'];		//
		$Write = $_POST[$Write_key];
		$Update_key = "Update_".$row['page_seq'];		//
		$Update = $_POST[$Update_key];
		$delivery_key = "delivery_".$row['page_seq'];		//
		$delivery = $_POST[$delivery_key];

		$pageNo = $row['page_seq'];

		$sql = "insert into m_access_autho
		values(0, '$autho_seq', '$pageNo', '$Read', '$Delete', '$Write', '$Update', '$delivery')";

		mysql_query($sql);
	}

	Dbdissconnect($link);
	?>
	<br><br>
	<a href="autho_main.php">トップへ戻る</a>
	</div>
	</body>
</html>
