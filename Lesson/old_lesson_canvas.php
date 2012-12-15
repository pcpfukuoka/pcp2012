<?php

	$date = $_POST['date'];
	$subject_seq = $_POST['subject_seq'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT div_url, canvas_url FROM board WHERE date=". $date ."subject_seq=".$subject_seq .";";

	$result = mysql_query($sql);

	$count = mysql_num_rows($result);

?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Japanese Chalkboard</title>
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

<div id="container">
    <div id="chalkboardAndOthers">
		<div id="chalkboard" style="background: url(../images/kokuban.jpg);background-repeat:no-repeat">
			<div id="monthOnBoard"></div>
			<div id="dateOnBoard"></div>

			<canvas id="canvas" width="710" height="460">
				Your browser is not supported. Use modern browser (e.g. IE9 or later).
			</canvas>
		</div>
		<input id="turn" value="テスト(戻る)" type="button">
 		<input id="next" value="テスト（次へ）"type="button">
 		<br>

	</div>
</div> <!--! end of #container -->

<script>window.jQuery || document.write('<script src="../js/jquery-1.7.1.min.js"><\/script>')</script>
<script src="../js/jquery.i18n.properties-min-1.0.9.js"></script>


<script src="../javascript/common.js"></script>

</body>
</html>
