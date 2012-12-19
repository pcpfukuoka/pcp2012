<?php

	//$date = $_POST['date'];
	$date = '2012-12-14';
	//$subject_seq = $_POST['subject_seq'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT div_url, canvas_url FROM board WHERE date='". $date ."' AND subject_seq=15;";

	$result = mysql_query($sql);

	$count = mysql_num_rows($result);

	$div_str = "";
	$canvas_str = "";

	for($i = 0;$i < $count;$i++){
		$row = mysql_fetch_array($result);

		$aaa = substr($row['div_url'],30);
		$div[$i] ="url(../../balckboard/public/".$aaa;
		$canvas[$i]=$row['canvas_url'];


		if($i < $count-1){
			$div_str = $div_str.$div[$i].",";
			$canvas_str=$canvas_str.$canvas[$i].",";
		}
		else{
			$div_str = $div_str.$div[$i];
			$canvas_str=$canvas_str.$canvas[$i];
		}
	}

	Dbdissconnect($dbcon);

?>

	<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<meta name="viewport" content="width=1024, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name="description" content="This is an example using HTML5 WebSocket. Multiple users can write this chalkboard at the same time.">
		<link rel="stylesheet" href="../css/old_lesson_canvas_css.css">
		<script src="../javascript/old_lesson_canvas_js.js" type = "text/javascript"></script>


	</head>
	<body>
			<div id="chalkboard" style="background:<?= $div[0]?>;background-repeat:no-repeat">
				<img src="<?=$canvas[0] ?>"id="canvas">
			</div>
				<input id="turn" value="戻る" type="button" onclick="turn('<?=$div_str ?>','<?=$canvas_str ?>')">
	 			<input id="next" value="次へ"type="button"onclick="next('<?=$div_str ?>','<?=$canvas_str ?>')">
	 			<input type="hidden" value="0" id="page_num">

	 		<br>
	</body>
</html>
