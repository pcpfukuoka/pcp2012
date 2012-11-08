<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	 
	$sql = "SELECT * 
			FROM m_group
			WHERE delete_flg = 0";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	
	//データベースを閉じる
	DBdissconnect($dbcon);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<title>新規作成</title>
	</head>
	
	<body>
		<div align="center">
			<font size = "7">プリント作成</font><br><br>
		</div>

		<hr color="blue">
		<br><br>
		<br>
		<form action="p_relay.php" method="post" enctype="multipart/form-data">
			<font size="3">宛　 先</font>
			<select name="to">
			
			
  				<?php
	   				for ($i = 0; $i < $count; $i++)
	   				{
	   					$row = mysql_fetch_array($result);
  				?>
    					<option value="<?=$row['group_seq']?>"><?= $row['group_name'] ?></option>
  				<?php
    				}
  				?>
  	
  			</select>
			<br>
			<font size="3">件　 名</font>	
	 		<input size="30" type="text" name="title"><br>
	 		<font size="3">プリント</font>
			<input size="30" type="file" name="pdf"><br><br>
	  		<input class="button4" type="submit" value="保存" name="Preservation">
		</form>
	</body>
</html>
