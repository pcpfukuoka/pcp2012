<?php

	$date = $_POST['date'];
	$subject_seq = $_POST['subject_seq'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT div_url, canvas_url FROM board WHERE date=". $date ."subject_seq=15;";

	$result = mysql_query($sql);

	$count = mysql_num_rows($result);

	for($i = 1;$i <= $count;$i++){

		$row = mysql_fetch_array($result);

		$aaa = substr($row['div_url'],30);
		$div[$i-1] ="url(../../balckboard/public/".$aaa;
		$canvas[$i-1]=$row['canvas_url'];



	}


?>

	<!DOCTYPE html>
	<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
	<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
	<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
	<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<meta name="viewport" content="width=1024, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name="msapplication-task" content="Japanese Chalkboard">
		<meta property="og:image" content="images/screenshot_small.png"/>
		<meta property="og:title" content="Japanese Chalkboard (for IE10 Test Drive)"/>
		<meta name="description" content="This is an example using HTML5 WebSocket. Multiple users can write this chalkboard at the same time.">

		<link rel="stylesheet" href="../css/old_lesson_style.css">
		<link rel="stylesheet" href="../css/old_lesson_index.css">
		<script src="../js/modernizr-2.0.6.min.js"></script>
			 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>



	</head>
	<body>



			<div id="chalkboard" style="background:<?= $div[0] ?>;background-repeat:no-repeat">
				<img src="<?=$canvas[0] ?>">
			</div>
			<input id="turn" value="戻る" type="button">
	 		<input id="next" value="次へ"type="button">
	 		<br>

		</div>
	</div> <!--! end of #container -->

	<script>window.jQuery || document.write('<script src="../js/jquery-1.7.1.min.js"><\/script>')</script>
	<script src="../js/jquery.i18n.properties-min-1.0.9.js"></script>


	<script src="../javascript/common.js"></script>

	</body>
</html>
