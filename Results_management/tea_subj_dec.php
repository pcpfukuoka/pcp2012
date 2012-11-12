<html>
<head>
<title>ページ新規追加画面</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
</head>
<body>
データベースに登録しました
 <?php
 $q1 = $_POST['q1'];
 require_once("../lib/dbconect.php");
   $link = DbConnect();
   
   if($q1 == 1)
   {
   }
   elseif($q1 == 2)
   {
   	$subj_name = $_POST['subj_name'];
   	$sql = "insert into m_subject values(0, '$subj_name', 0)";
   	mysql_query($sql);
   	
   	Dbdissconnect($link);
   }
   ?>
</body>
</html>
	