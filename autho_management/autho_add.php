<html>
 <head>
  <title>権限追加画面</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" type="text/css" href="../css/button.css" />
  <link rel="stylesheet" type="text/css" href="../css/text_display.css" />
  <link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
  <link rel="stylesheet" type="text/css" href="../css/table.css" />
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
 </head>
  <body>
  		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
  <form name = "form1" action="autho_add_con.php" method="POST">
   <?php
   require_once("../lib/dbconect.php");
   $link = DbConnect();
   $sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg = 0";
    $result = mysql_query($sql);

    $count = mysql_num_rows($result);

    Dbdissconnect($link);

   ?>
<script>
</script>
		<div align = "center">
			<font class="Cubicfont">権限管理追加</font><hr color="blue"><br><br><br></div>
			<?php
			/********************************************************
			 * 権限の新規追加画面
			 * チェックボタンで権限の選択　テキストボックスでグループ名　を作成
			 *for文でテーブルの作成
			 *********************************************************/
   			?>
   名前<input size ="15" type="text" name="group_name"><!-- グループ名入力 -->

   <table width="100%" class="table_01">
    <tr>
     <th width="50%" ><font size="5">ページ名</font></th>
     <th width="10%" bgcolor="Yellow"><font size="5">Read</font></th>
     <th width="10%" bgcolor="Yellow"><font size="5">Write</font></th>
     <th width="10%" bgcolor="Yellow"><font size="5">Update</font></th>
     <th width="10%" bgcolor="Yellow"><font size="5">delivery</font></th>
     <th width="10%" bgcolor="Yellow"><font size="5">Delete</font></th>
     <th width="10%" bgcolor="Yellow"><font size="5">追加</font></th>
     <th width="10%" bgcolor="Yellow"><font size="5">削除</font></th>
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
			<td><input type="checkbox" name = "Read_<?= $row['page_seq'] ?>" id = "Read_<?= $row['page_seq'] ?>" disabled></td>
			<td><input type="checkbox" name = "Write_<?= $row['page_seq'] ?>" id = "Write_<?= $row['page_seq'] ?>" disabled></td>
			<td><input type="checkbox" name = "Update_<?= $row['page_seq'] ?>" id = "Update_<?= $row['page_seq'] ?>" disabled> </td>
			<td><input type="checkbox" name = "delivery_<?= $row['page_seq'] ?>" id = "delivery_<?= $row['page_seq'] ?>" disabled></td>
			<td><input type="checkbox" name = "Delete_<?= $row['page_seq'] ?>" id = "Delete_<?= $row['page_seq'] ?>" disabled></td>
			<input type="hidden" id = "Value_<?= $row['page_seq'] ?>" value="0">
		 <td><input type="button" class="add_btn" value="追加"  data-id="<?= $row['page_seq'] ?>" id = "id"></td>
	    <td><input type="button" class="delete_btn" data-id="<?= $row['page_seq'] ?>"value="削除" id = "id"></td>
    </tr>
  <?php
    }

    ?>
    </table>
    <br>
    <table>
    	<tr>
    		<td><input class="button4" type="submit" value="確認"></td>
    		<td><input class="button4" type="reset" value="クリア"> </td>
    	</tr>
    </table>

    </form>
    </div>
  </body>
  <script>

	$(function() {

		//検索結果から権限を追加するための処理
		$(document).on('click', '.add_btn', function() 
		{
			var id_list  = new Array("Read_", "Write_", "Update_","delivery_","Delete_");
		  	var id = $(this).data('id');
		  	var name = "Value_" + id;
			var value = document.getElementById(name).value;
			if(value <5)
			{
				var check_name = id_list[value] + id;
				document.getElementById(check_name).checked = true;
				value++;
				document.getElementById(name).value= value;
			}
			
	    });
		$(document).on('click', '.delete_btn', function() 
		{
			var id_list  = new Array("Read_", "Write_", "Update_","delivery_","Delete_");
		  	var id = $(this).data('id');
		  	var name = "Value_" + id;
			var value = document.getElementById(name).value;
			value--;
			if(value  >= 0)
			{
				var check_name = id_list[value] + id;
				document.getElementById(check_name).checked = false;
				document.getElementById(name).value= value;
			}
			
			
	    });
		
	});

  </script>
  
  
</html>
