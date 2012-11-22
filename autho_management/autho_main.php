<?php
/***********************************
 * 権限管理メイン画面
 *
 * 押されたボタンによって各操作ページに飛ぶ
 * GET送信で権限グループseqを送る
 ***********************************/

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();

//権限seqと権限グループ名を取得し、数を数える
$sql = "SELECT autho_seq, autho_name FROM m_autho WHERE delete_flg != 1;";
$result = mysql_query($sql);
$count_autho = mysql_num_rows($result);

Dbdissconnect($link);

?>

<html>
	<head>
		<title>権限管理メイン</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<script src="../javascript/frame_jump.js"></script>
		<meta http-equiv="Content-Style-Type" content="text/css">
	    <link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">

			<font class="Cubicfont">権限管理</font>
		</div>
			<hr color="blue"><br><br>


<?php
/********************************************************
 * $autho_group : DBから取得した権限seqとグループ名を入れる連想配列
 *********************************************************/
?>
			<table>
				<tr>
					<td><input class="longbutton" type="button" onclick="jump('autho_add.php','right')"value = "権限グループ追加"></td>
				</tr>

				<tr>
					<td><input class="longbutton" type="button" onclick="jump('page_add.php','right')"value = "ページの編集"></td>
				</tr>
			</table>

			<?php
			for($i = 0; $i < $count_autho; $i++)
			{
				//権限seqと権限グループ名を連想配列に入れる
				$autho_group = mysql_fetch_array($result);
			?>
				<?= $autho_group['autho_name'] ?>
			<table>
				<tr>
					<td><input class="button2" type="button" onclick="jump('autho_list.php?id=<?= $autho_group['autho_seq'] ?>' , 'right')" value="一覧"></td>
					<td><input class="button2" type="button" onclick="jump('autho_edit.php?id=<?= $autho_group['autho_seq'] ?>','right')" value = "編集"></td>

				</tr>
				<tr>
					<td><input class="button2" type="button" onclick="jump('autho_reg.php?id=<?= $autho_group['autho_seq'] ?>','right')" value = "登録"></td>
					<td><input class="button2" type="button" onclick="jump('autho_del_con.php?id=<?= $autho_group['autho_seq'] ?>','right')"value = "削除"></td>

				</tr>
			</table>
			<?php
				}
    			?>
    		</div>
	</body>
	<script>



	</script>


</html>