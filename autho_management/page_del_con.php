<?php
require_once("../lib/dbconect.php");
$link = DbConnect();

//delete_flgの立っていないページseqを取得、数を数える
$sql = "SELECT page_seq FROM m_page WHERE delete_flg != 1;";
$result = mysql_query($sql);

$page_count = mysql_num_rows($result);

$count = 0;

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta http-equiv="Content-Style-Type" content="text/css">
	    <link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />		
		<title>ページ削除確認</title>
	</head>
	
	<body>
		<img class="bg" src="../../images/blue-big.jpg" alt="" />
		<div id="container">
		<form action = "page_del_dec.php" method = "POST">
		<!-- テーブルの作成 -->
			<table class="table_01">
				<tr>
					<td><font size="5">ページ名</font></td>
				</tr>
				<?php 
				for ($i = 0; $i < $page_count; $i++)
				{
					$del_chk = "del_chk".$i;
					if ($_POST[$del_chk] != 0)
					{
					
						$page_seq = $_POST[$del_chk];
						
						//前画面でチェックされたページ名とページseqを取得
						$sql = "SELECT page_seq, page_name FROM m_page WHERE page_seq = '$page_seq' AND delete_flg != 1;";
						$result = mysql_query($sql);
						$page = mysql_fetch_array($result);
					?>
						<input type = "hidden" name = "del_data<?= $count ?>" value = "<?= $page_seq ?>">
						
							<tr>
								<th><?= $page['page_name'] ?><th>
							</tr>
				<?php
					$count++;
					}
				}
				Dbdissconnect($link);
				?>
			</table><br>

			<input class="button4" type = "submit" value = "確定"><br>
			<a href="autho_main.php">トップへ戻る</a>
		</form>
		</div>
	</body>
</html>