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

	$id = "title";
	$cmd = "ic";
	$min = "0";
	$max = "0";
	$span = "print_check";
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		 <link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		 <script src="../javascript/form_reference.js"></script>
		 <script src="../javascript/jquery-1.8.2.min.js"></script>
		<title>新規作成</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">プリント作成</font><br>
		</div>

		<hr color="blue">
		<br><br>
		<br>
		<form action="p_relay.php" method="post" enctype="multipart/form-data" onsubmit="return check('<?= $id ?>', '<?= $cmd ?>', '<?= $min ?>', '<?= $max ?>', '<?= $span ?>')">
			<font size="5">宛　 先</font>
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
			<span class="check_result" name="print_check" id="print_check" ></span>
			<font size="5">件　 名</font>
	 		<input size="30" type="text" name="title" id="title"><br>
	 		<font size="5">プリント</font>
			<input size="30" type="file" name="pdf"><br><br>
	  		<input class="button4" type="submit" value="保存" name="Preservation">
		</form>
		</div>
	</body>
</html>
