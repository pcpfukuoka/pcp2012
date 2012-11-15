<html>
<head>
<title>ページ新規追加画面</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" type="text/css" href="../css/button.css" />
</head>
<body>
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
	<font size = "6">ページ管理画面<hr><br>

	ページ追加</font>
	</div><br><br>
   <table border="1" width="50%">
    <tr>
     <th width="50%" bgcolor="Yellow">ページ一覧</th>
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
    ページ名<input size ="15" type="text" name="page_name"><br><!-- グループ名入力 -->
    
    <br>
    <table>
    	<tr>
    		<td><input class="button4" type="submit" value="登録確認"></td>
    		<td><input class="button4" type="reset" value="クリア"></td>
    	</tr>
    </table>
    <br>
    <a href="autho_main.php">トップへ戻る</a>
    </form>
    <br><hr>
    
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
		<font size = "6">ページ削除</font>
	</div><br><br>
	    <form action = "page_del_con.php" method = "POST">
	    
	    <!-- テーブルの作成 -->
	    	<table border="1" width="70%">
	    		<tr>
	     			<th width="50%" bgcolor="Yellow">ページ名</th>
	     			<th width = "20%" bgcolor="Yellow">削除チェック</th>
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
						<td align = "center"><input type = "checkbox" name = "del_chk<?= $i ?>" value = "<?= $name['page_seq'] ?>">
					</tr>
				<?php
				}
				?>
			</table><br>
			
			<table>
				<tr>
					<td><input class="button4" type = "submit" value = "確認"></td>
					<td><input class="button4" type = "reset" value="クリア"></td>
				</tr>
			</table>
			<br>
			<a href="autho_main.php">トップへ戻る</a>
	    </form>
</body>
</html>