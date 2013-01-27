<?php
	session_start();
	require_once("../lib/autho.php");
	$page_fun = new autho_class();
	$page_cla = $page_fun -> autho_Pre($_SESSION['login_info[autho]'], 9);
	
	$position_flg = $_SESSION['position_flg'];
	
	/*
	if($page_cla[0]['read_flg'] == 0)
	{
		header("Location:../top_left.php");
	}
	*/
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/frame_jump.js"></script>
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">授業（仮）</font>
			</div>
			<hr color="blue"></hr>
			<br><br><br>
			<p align="center">
				<input type="button" onclick="jump('old_lesson.php','right')" value="過去の授業">
				<br><br>
				<!-- 生徒用の画面 -->
				<?php 
				if($position_flg == "student")
				{?>
					<input type="button" onclick="jump('join_lesson.php','right')" value="現在の授業">
					
				<?php 
				}
				?>
				<br><br>
				<!-- 先生用のボタン -->
				<?php 
				if($position_flg == "teacher")
				{?>
				<input type="button" onclick="jump('lesson_preparation.php','right')" value="授業準備">
					
			<?php 
				}
				?>
			
			</p>
		</div>
	</body>
</html>
