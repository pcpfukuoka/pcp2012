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
     <td width="50%" ><font size="5">ページ名</font></td>
     <td width="10%" bgcolor="Yellow"><font size="5">Read</font></td>
     <td width="10%" bgcolor="Yellow"><font size="5">Delete</font></td>
     <td width="10%" bgcolor="Yellow"><font size="5">Write</font></td>
     <td width="10%" bgcolor="Yellow"><font size="5">Update</font></td>
     <td width="10%" bgcolor="Yellow"><font size="5">delivery</font></td>
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
    <th align = "center"><?= $row['page_name'] ?></th>
    <th><input  type="checkbox" name = "Read_<?= $row['page_seq'] ?>"></th>
      <SCRIPT>
  echo <<<EOM
function chk_R<?= $i ?>()
{
	
	
	if (document.form1.Read_<?= $row['page_seq'] ?>.checked)　//checked チェックが入っていたら
	{
		document.form1.Write_<?= $row['page_seq'] ?>.disabled = true; // チェック可能
	}
	else
	{
		document.form1.Write_<?= $row['page_seq'] ?>.disabled = false; // チェック不可
	}
}
</SCRIPT>
  EOM;
    <th><input type="checkbox" name = "Write_<?= $row['page_seq'] ?>" onClick = "chk_R<?= $i ?>();"></th>
          <SCRIPT>
  echo <<<EOM
function chk_W<?= $i ?>()
{
	
	
	if (document.form1.Write_<?= $row['page_seq'] ?>.checked)　//checked チェックが入っていたら
	{
		document.form1.Update_<?= $row['page_seq'] ?>.disabled = true; // チェック可能
	}
	else
	{
		document.form1.Update_<?= $row['page_seq'] ?>.disabled = false; // チェック不可
	}
}
</SCRIPT>
  EOM;
    <th><input type="checkbox" name = "Update_<?= $row['page_seq'] ?>" onClick = "chk_W<?= $i ?>();"></th>
              <SCRIPT>
  echo <<<EOM
function chk_U<?= $i ?>()
{
	
	
	if (document.form1.Update_<?= $row['page_seq'] ?>.checked)　//checked チェックが入っていたら
	{
		document.form1.delivery_<?= $row['page_seq'] ?>.disabled = true; // チェック可能
	}
	else
	{
		document.form1.delivery_<?= $row['page_seq'] ?>.disabled = false; // チェック不可
	}
}
</SCRIPT>
  EOM;
    
    <th><input type="checkbox" name = "delivery_<?= $row['page_seq'] ?>" onClick = "chk_U<?= $i ?>();"></th>
                  <SCRIPT>
  echo <<<EOM
function chk_D<?= $i ?>()
{
	
	
	if (document.form1.delivery_<?= $row['page_seq'] ?>.checked)　//checked チェックが入っていたら
	{
		document.form1.Delete_<?= $row['page_seq'] ?>.disabled = true; // チェック可能
	}
	else
	{
		document.form1.Delete_<?= $row['page_seq'] ?>.disabled = false; // チェック不可
	}
}
</SCRIPT>
  EOM;
    
    <th><input type="checkbox" name = "Delete_<?= $row['page_seq'] ?>" onClick = "chk_D<?= $i ?>();"></th>
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
</html>
