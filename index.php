<?php
	session_start();
		if(!isset($_SESSION["login_flg"]) || $_SESSION['login_flg'] == "false")
		{
			header("Location:login/index.php");
		}


	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- 画面のひな形 -->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="STYLESHEET"  href="css/frame.css" type="text/css">
		<script type="text/javascript "src="javascript/frame_jump.js"></script>
		<script src="jquery-1.8.2.min.js"></script>
		<title>メイン画面</title>
	</head>

		<!-- 本番は17%、83%ぐらい -->
		<frameset rows=25%,75% >
			<frame src="Top/menu.php" name=top scrolling="no">
			<frameset cols=30%,70% frameborder=no border=no id=direction>
				<frame src="Top/top_left.php" name="left">	<!-- フレーム左部分 -->
				<?php 
				$flg = $_SESSION['position_flg'];
				if($flg == "teacher")
				{?>
					<frame src="Top/teacher_top.php" name="right">	<!-- フレーム右部分 -->					
				<?php 
				}else
				{?>
					<frame src="Top/student_top.php" name="right">	<!-- フレーム右部分 -->				
				<?php 
				}
				?>
			</frameset>
		</frameset>
</html>
