<html>
<head>
<title>欠席登録</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
</head>
<body>
<div align = "center">
			<font size = "6">欠席者チェック画面</font><hr><br><br><br></div>
			<table border="1" width="100%">
			 <tr>
			 <th width="75%"　align = "center">グループ名</th>
			 <th width="25%"　align = "center">チェック</th>
			 </tr>
			<?php 
				 require_once("../lib/dbconect.php");
				 $link = DbConnect();
				 $sql = "SELECT group_name, group_seq FROM m_group WHERE delete_flg = 0";
				 $result = mysql_query($sql);
				 $count = mysql_num_rows($result);
				 for($i = 0; $i < $count; $i++)
				 {
				 	$row = mysql_fetch_array($result);
			 ?>
			 <tr>
			<td align = "center"><?= $row['group_name'] ?></td>
			<input type="radio" name="q1" value="name" checked>
			<td><input type="radiobotton" name = "group_id" value=""></td>
			 
   
   
   
</body>
</html>

