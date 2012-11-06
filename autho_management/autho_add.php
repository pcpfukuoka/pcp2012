<html>
 <head>
  <title>権限追加</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
 </head>
  <body>
  <form action="autho_add_con.php" method="POST">
   <?php
   require_once("../lib/dbconect.php");
   $link = DbConnect();
   $sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg = 0";
    $result = mysql_query($sql);
    
    $count = mysql_num_rows($result);
    
    Dbdissconnect($link);
    
   ?>
   
     
   
		<div align = "center">
			<font size = "6">権限管理追加画面</font><hr><br><br><br></div>
			<?php 
			/********************************************************
			 * 権限の新規追加画面
			 * チェックボタンで権限の選択　テキストボックスでグループ名　を作成
			 *for文でテーブルの作成 
			 *********************************************************/ 
   			?>
   名前<input size ="15" type="text" name="group_name"><!-- グループ名入力 -->

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
    /********************************************************
     * ここからテーブルのループ
    * $row['pagename']で権限を呼び出す
    *以下5つのチェックボックスで権限の調整
    *********************************************************/
    ?>
    <?php 
    for($i = 0; $i < $count; $i++)
	{
    	$row = mysql_fetch_array($result);
	?>       	
    <tr>
    <td align = "center"><?= $row['page_name'] ?></td>
    <td><input type="checkbox" name = "Read_<?= $row['page_seq'] ?>"></td>
    <td><input type="checkbox" name = "Delete_<?= $row['page_seq'] ?>"></td>
    <td><input type="checkbox" name = "Write_<?= $row['page_seq'] ?>"></td>
    <td><input type="checkbox" name = "Update_<?= $row['page_seq'] ?>"></td>
    <td><input type="checkbox" name = "delivery_<?= $row['page_seq'] ?>"></td>
    </tr>
  <?php
    }
    	
    ?>
    </table>
    <input type="submit" value="登録確認">&nbsp;&nbsp;
    <input type="reset" value="クリア">    
    </form> 
    <a href="autho_main.php">トップへ戻る</a>
  </body>
</html>
