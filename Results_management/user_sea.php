<html>
	<head>
		<title>ユーザー検索</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
	</head>
	<body>
		<form action="user_sea.php" method="POST"><!-- 検索処理 -->
			<input type="radio" name="q1" value="name" checked>名前
			<input type="radio" name="q1" value="id">ID
			<input type="text" name="query">
			<input type="submit" value="検索">
		</form>
		<?php 
		if(isset($_POST['query']))//検索結果表示
			{
				?>
				<form action="tea_subj_add.php" method="POST">
				<?php
				   require_once("../lib/dbconect.php");
				$link = DbConnect();
				//$link = mysql_connect("tamokuteki41", "root", "");
				//mysql_select_db("pcp2012");
				if($_POST['q1'] == "name")//名前で検索したかIDで検索したか
					{
					$user = $_POST['query'];
					$sql = "SELECT user_name, user_seq FROM m_user WHERE delete_flg = 0 AND user_name LIKE '%$user%'";
					$result = mysql_query($sql);
					$count = mysql_num_rows($result);
					}
				else
				{
					$id = $_POST['query'];
					$sql = "SELECT user_name, user_seq FROM m_user WHERE delete_flg = 0 AND user_name LIKE '$id%'";
					$result = mysql_query($sql);
					$count = mysql_num_rows($result);
				}
				?>
				取り出したいデータをチェックしてください
				<table border="1" width="100%"><!-- 検索で当てはまったデータをテーブルにする  -->
					<tr>
						<th width="50%">名前</th>
						<th width="40%">ID</th>
						<th width="10%">チェック</th>
					</tr>
					<?php
					for($i = 0; $i < $count; $i++)//引っかかった分ループ
						{
						$row = mysql_fetch_array($result);
						?>
						<tr>
							<td align = "center"><?= $row['user_name'] ?></td>
							<td align = "center"><?= $row['user_seq'] ?></td>
							<td align = "center"><input type="radio" name="user_radio" value="user_<?= $row['user_seq'] ?>" ></td>
							
							<?php 
						}
						?>
						</tr></table><br>
						<!-- チェックしたデータを持たせtea_subj_addに戻る -->
					<input type = "submit" value = "送信">&nbsp;&nbsp;
					<input class="button4" type="button" value="戻る" onClick="history.back()">
					
					<?php 
					
				Dbdissconnect($link);
			}
			?>
		</form>
	</body>
</html>