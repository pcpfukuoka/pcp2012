<html>
	<head>
	  <title>権限追加</title>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
	</head>
	<body>
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
			<font size = "6">権限管理追加確認画面</font><hr><br><br><br></div>
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
	<table border="1" width="100%">
    <tr>
     <th width="50%">ページ名</th>
     <th width="10%">Read</th>
     <th width="10%">Delete</th>
     <th width="10%">Write</th>
     <th width="10%">Update</th>
     <th width="10%">delivery</th>
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
	    <td align = "center"><?= $row['page_name'] ?></td>
	    <td align="center"><?= $Read ?></td>
	    <td align="center"><?= $Delete ?></td>
	    <td align="center"><?= $Write ?></td>
	    <td align="center"><?= $Update ?></td>
	    <td align="center"><?= $delivery ?></td>
	    </tr>	    
	<?php
    }
    ?>
    
    </table>
    <input type="hidden" name="group_name" value="<?= $group_name ?>">
   
   <h1><font size="3">よろしかったら”確定”やり直す場合”戻る”ボタンを押してください</font></h1><br>
    <input type="submit" value="確定">
    <input type="button" value="戻る" onClick="history.back()">
    </form>
	</body>
</html>