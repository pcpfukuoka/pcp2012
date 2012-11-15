<html>
<head>
<title>ページ新規追加確認画面</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" type="text/css" href="../css/button.css" />
<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
</head>
<body>
<img class="bg" src="../../images/blue-big.jpg" alt="" />
<div id="container">
<form action="page_dec.php" method="POST">
 <?php
   require_once("../lib/dbconect.php");
   $link = DbConnect();
   $sql = "SELECT page_name, page_seq FROM m_page WHERE delete_flg = 0" ;
    $result = mysql_query($sql);
    
    $count = mysql_num_rows($result);
    
    Dbdissconnect($link);
    
    $page_name = $_POST['page_name'];
    
   ?>
   
   <div align = "center">
	<font class="Cubicfont">権限ページ新規追加確認画面</font><hr><br><br><br></div>

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
    </tr>
    
    <?php 
	}
    ?>
    <tr>
    <td align = "center"><font color = "Red">"NEW"</font>&nbsp;&nbsp;<?= $page_name ?></td>
    </tr></table><br>
    <input type="hidden" name="page_name" value="<?= $page_name ?>">
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