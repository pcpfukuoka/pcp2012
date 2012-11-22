<html>
	<head>
	  <title>権限追加</title>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
	  <meta http-equiv="Content-Style-Type" content="text/css">
	  <link rel="stylesheet" type="text/css" href="../css/button.css" />
	  <link rel="stylesheet" type="text/css" href="../css/text_display.css" />
	  <link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	  <link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">

	<form action="autho_add_dec.php" method="POST">
      <?php
   require_once("../lib/dbconect.php");
   $link = DbConnect();
   	$sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg = 0";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	Dbdissconnect($link);
	$group_name = $_POST['group_name'];
   ?>
		<div align = "center">
			<font class="Cubicfont">権限管理追加確認画面</font><hr color="blue"><br><br><br></div>
			<?php
						/********************************************************
			 * 権限の新規追加確認画面
			 * 権限新規追加画面から持ってきたデータをfor文で取得　かつ作成
			 *　またfor文内のinputで権限のチェックを送信
			 *　$Read ＝＝　権限新規追加確認画面のテーブル内での○×表示のための入れ物
			 *　$Read_data == 権限新規追加確定画面に送信するための入れ物
			 *　１　＝＝　チェックされてる（許可されてる○）　０　＝＝　チェックされてない（許可されてない×）
			 *　どちらとも権限のページ分使い回し
			 *********************************************************/
			?>
	名前<?= $group_name ?>
	<table width="100%" class="table_01">
    <tr>
     <td width="50%" ><font size="5">ページ名</font></td>
     <td width="10%" ><font size="5">Read</font></td>
     <td width="10%" ><font size="5">Delete</font></td>
     <td width="10%" ><font size="5">Write</font></td>
     <td width="10%" ><font size="5">Update</font></td>
     <td width="10%" ><font size="5">delivery</font></td>
    </tr>
    <?php
    for($i = 0; $i < $count; $i++)
    {
    	$row = mysql_fetch_array($result);

	    $Read_key = "Read_".$row['page_seq'];		//
		if(isset($_POST[$Read_key]))
		{
			$Read = "○";		//
			$Read_data = 1;
			?>
			<input type="hidden" name="Read_<?= $row['page_seq']?>" value="<?= $Read_data ?>">
			<?php
		}
		else
		{
			$Read = "×";
			$Read_data = 0;
			?>
			<input type="hidden" name="Read_<?= $row['page_seq']?>" value="<?= $Read_data ?>">
			<?php

		}
	    $Delete_key = "Delete_".$row['page_seq'];
		if(isset($_POST[$Delete_key]))
		{
			$Delete = "○";
			$Delete_data = 1;
			?>
			<input type="hidden" name="Delete_<?= $row['page_seq']?>" value="<?= $Delete_data?>">
			<?php
		}
		else
		{
			$Delete = "×";
			$Delete_data = 0;
			?>
			<input type="hidden" name="Delete_<?= $row['page_seq']?>" value="<?= $Delete_data ?>">
			<?php

		}
		$Write_key = "Write_".$row['page_seq'];
		if(isset($_POST[$Write_key]))
		{
			$Write = "○";
			$Write_data = 1;
			?>
			<input type="hidden" name="Write_<?= $row['page_seq']?>" value="<?= $Write_data ?>">
			<?php
		}
		else
		{
			$Write = "×";
			$Write_data = 0;
			?>
			<input type="hidden" name="Write_<?= $row['page_seq']?>" value="<?= $Write_data ?>">
			<?php
		}
		$Update_key = "Update_".$row['page_seq'];
		if(isset($_POST[$Update_key]))
		{
			$Update = "○";
			$Update_data = 1;
			?>
			<input type="hidden" name="Update_<?= $row['page_seq']?>" value="<?= $Update_data?>">
			<?php
		}
		else
		{
			$Update = "×";
			$Update_data = 0;
			?>
			<input type="hidden" name="Update_<?= $row['page_seq']?>" value="<?= $Update_data?>">
			<?php

		}
		$delivery_key = "delivery_".$row['page_seq'];
		if(isset($_POST[$delivery_key]))
		{
			$delivery = "○";
			$delivery_data = 1;
			?>
			<input type="hidden" name="delivery_<?= $row['page_seq']?>" value="<?= $delivery_data?>">
			<?php
		}
		else
		{
			$delivery = "×";
			$delivery_data = 0;
			?>
			<input type="hidden" name="delivery_<?= $row['page_seq']?>" value="<?= $delivery_data?>">
			<?php
		}
		?>

	    <tr>
	    <th align = "center"><?= $row['page_name'] ?></th>
	    <th align="center"><?= $Read ?></th>
	    <th align="center"><?= $Delete ?></th>
	    <th align="center"><?= $Write ?></th>
	    <th align="center"><?= $Update ?></th>
	    <th align="center"><?= $delivery ?></th>
	    </tr>
	<?php
    }
    ?>

    </table>
    <input type="hidden" name="group_name" value="<?= $group_name ?>">

   <h1><font size="3">よろしかったら”<font color="red">確定</font>”やり直す場合”<font color="red">戻る</font>”ボタンを押してください</font></h1><br>
    <table>
    	<tr>
    		<td><input class="button4" type="submit" value="確定"></td>
    		<td><input class="button4" type="button" value="戻る" onClick="history.back()"></td>
    	</tr>
    </table>
    </form>
    </div>
	</body>
</html>