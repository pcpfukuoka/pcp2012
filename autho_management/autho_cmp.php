
<?php 
 $check=$_GET['id'];
 
?>
<html>
	<head>
	<META HTTP-EQUIV="Refresh" CONTENT="5;URL=../dummy.html">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	<title>権限確定画面</title>
	</head>
	<body>

	<img class="bg" src="../images/blue-big.jpg" alt="" />
	<div id="container">
	<?php 
	if($check == 1){
	?>
	
		<font size="5">登録しました。</font>
	<?php 
	}
	else if($check == 0)
	{
	?>
		<font size="5">削除しました。</font>
		<?php 
	}
		?>
	</div>
	</body>
</html>
