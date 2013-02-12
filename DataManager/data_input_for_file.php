
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
				<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		
		<script src="../javascript/jquery-1.8.2.min.js"></script>
		<script src="../javascript/jquery-ui-1.8.24.custom.min.js"></script>
		<script src="../javascript/form_reference.js"></script>
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />	
		<div id="container">
				<div align = "center">
			<font class="Cubicfont">データ取り込み</font>
			<hr color = "blue">
			</div>
		<form action="db_data_insert.php" method="post" enctype="multipart/form-data">
	     <select name="target">
	     	<option value="1">ユーザーデータ</option>
	     </select>
	      ファイル：<br />
	      <input type="file" name="upload_file" size="30" /><br />
	      <input type="hidden" name="mode" value="upload" /><br />
	      <br />
	      
	      <input type="submit" value="アップロード" />
  		</form>
		</div>
	</body>
</html>