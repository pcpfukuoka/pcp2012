<html>
<head>
<title>ページ新規追加画面</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" type="text/css" href="../css/button.css" />
<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
<link rel="stylesheet" type="text/css" href="../css/table.css" />
<script src="../javascript/form_reference.js"></script>
<script src="../javascript/jquery-1.8.2.min.js"></script>
</head>
<body>
<img class="bg" src="../images/blue-big.jpg" alt="" />
<div id="container">
<form action="page_con.php" method="POST">
 <?php
   require_once("../lib/dbconect.php");
   $link = DbConnect();
   $sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg = 0";
   $result = mysql_query($sql);
   $result_del = mysql_query($sql);

    $count = mysql_num_rows($result);

    Dbdissconnect($link);

   ?>

   <div align = "center">
	<font class="Cubicfont">ページ管理</font><hr color="blue"><br><br><br>

	<font class="Cubicfont1">ページ追加</font>
	</div><br><br>
   <table width="50%" class="table_01">
    <tr>
     <th><font size="5">ページ一覧</font></th>
     </tr>
     <?php
    for($i = 0; $i < $count; $i++)
	{
    	$row = mysql_fetch_array($result);
	?>
    <tr>
    	<td align = "center"><?= $row['page_name'] ?></td>

    <?php
	}
    ?>
    </tr></table><br>
    ページ名<input size ="15" type="text" name="page_name" id="page_name" Onblur="check('#page_name', 'ic', 0, 0)"><br><!-- グループ名入力 -->

    <br>
    <table>
    	<tr>
    		<th><input class="button4" type="submit" value="登録確認"></th>
    		<th><input class="button4" type="reset" value="クリア"></th>
    	</tr>
    </table>
    <br>
    </form>
    <br><hr color="blue">

    <?php
    /**********************************
     * ページ削除機能
     *
     * チェックボックスで消したいページを取得し、
     * page_del_con.phpに飛ばす。
     **********************************/
    ?>
    <br>
    <div align = "center">
		<font class="Cubicfont1">ページ削除</font>
	</div><br><br>
	    <form action = "page_del_con.php" method = "POST">

	    <!-- テーブルの作成 -->
	    	<table width="70%" class="table_01">
	    		<tr>
	     			<th width="50%" bgcolor="Yellow"><font size="5">ページ名</font></th>
	     			<th width = "20%" bgcolor="Yellow"><font size="5">削除チェック</font></th>
	     		</tr>

	     		<?php
	     		for($i = 0; $i < $count; $i++)
				{
					$name = mysql_fetch_array($result_del);
				?>
					<input type = "hidden" name = "del_chk<?= $i ?>" value = "0">
					<tr>
					<!-- ページ名の表示とチェックボックスの作成 -->
						<td align = "center"><?= $name['page_name'] ?></td>
						<td align = "center"><input type = "checkbox" name = "del_chk<?= $i ?>" value = "<?= $name['page_seq'] ?>"></td>
					</tr>
				<?php
				}
				?>
			</table><br>

			<table>
				<tr>
					<th><input class="button4" type = "submit" value = "確認"></th>
					<th><input class="button4" type = "reset" value="クリア"></th>
				</tr>
			</table>
			<br>
	    </form>
	    </div>
</body>
</html>