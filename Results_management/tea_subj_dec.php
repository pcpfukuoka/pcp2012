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
//   $link = DbConnect();
   $link = mysql_connect("tamokuteki41", "root", "");
   mysql_select_db("pcp2012");
    
   
   $subj_radio = $_POST['subj_radio'];
   if($q1 == 1)
   {
   	$user_seq = $_POST['user_seq'];
   	$sql = "SELECT user_seq FROM m_user WHERE delete_flg = 0 AND user_seq = $user_seq";
   	$res_use = mysql_query($sql);
   	$row = mysql_fetch_array($res_use);
   	$user_seq = $row['user_seq'];
   	
   	if($subj_radio == "subj_name")
   		{
   		$subj_name = $_POST['subj_name'];
   		$sql = "insert into m_subject values(0, '$subj_name', 0)";
   		mysql_query($sql);
   		
   		$sql = "SELECT subject_seq FROM m_subject WHERE delete_flg = 0 AND subject_seq = $user_seq ORDER BY subject_seq DESC";
   		
   		$res_subj = mysql_query($sql);
   		$row = mysql_fetch_array($res_subj);
   		 
   		$subj_seq = $row['subject_seq'];
   		}
   		else 
   		{
   			$sql = "SELECT * FROM m_subject WHERE delete_flg = 0";
   			$result = mysql_query($sql);
   			$count = mysql_num_rows($result);
   			 
   			for($i = 0; $i < $count; $i++)
   			{
   			$row = mysql_fetch_array($result);
   			$subj_ID = "subj_".$row['subject_seq'];
	  
	   	if($subj_radio == $subj_ID)
   				   	{
   				   	$subj_seq = $row['subject_seq'];
   			}
	   	}
   		}
   		$sql = "insert into m_teacher values(0, '$subj_seq', '$user_seq', 0)";
   		mysql_query($sql);
   		 
   }
   elseif($q1 == 2)
   {
   	$subj_name = $_POST['subj_name'];
   	$sql = "insert into m_subject values(0, '$subj_name', 0)";
   	mysql_query($sql);
   	
   }
   Dbdissconnect($link);
   ?>
</body>
</html>