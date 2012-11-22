<html>
<head>
<title>ページ新規追加確定画面</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
</head>
<body>
<img class="bg" src="../images/blue-big.jpg" alt="" />
<div id="container">

<font size="5">データベースに登録しました。</font>
<br><br>
<a href="autho_main.php">トップへ戻る</a>
 <?php
   require_once("../lib/dbconect.php");
   $link = DbConnect();

    $page_name = $_POST['page_name'];

    //m_pageに入力したデータをINSERT
    $sql = "INSERT INTO m_page VALUES(0, '$page_name', 0)";
    mysql_query($sql);

    //INSERTしたSEQを取得
    $sql = "SELECT page_seq FROM m_page ORDER BY page_seq DESC;";
    $page_newseq = mysql_query($sql);
    $page_seq_row = mysql_fetch_array($page_newseq);
    $page_seq = $page_seq_row['page_seq'];
    //今存在している権限をすべて取得
    $sql = "SELECT autho_seq FROM m_autho WHERE delete_flg = 0";
    $result = mysql_query($sql);
    $count = mysql_num_rows($result);

    for($i = 0; $i < $count; $i++)
    {
    	$row = mysql_fetch_array($result);

    	$autho_seq = $row['autho_seq'];		//

    	$sql = "INSERT INTO m_access_autho VALUES(0, '$autho_seq', '$page_seq', 0, 0, 0, 0, 0)";

    	mysql_query($sql);

    }

    Dbdissconnect($link);

   ?>
   </div>
   </body>
   </html>
