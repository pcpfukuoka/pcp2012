<?php
	require_once("../lib/dbconect.php");
	$send_name = $_POST['sendto'];
	$send_seq = $_POST['send_seq'];
	$title = $_POST['title'];
	$link_id = $_POST['link_id'];
	$contents = $_POST['contents'];
?>

<html>
	<head>
		<title> 返信</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
	    <link rel="stylesheet" type="text/css" href="../css/button.css" />
	    <link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	    <link rel="stylesheet" type="text/css" href="../css/text_display.css" />

	    <style>
			textarea {
				border:1px solid #ccc;
			}

			#animated {
				vertical-align: top;
				-webkit-transition: height 0.2s;
				-moz-transition: height 0.2s;
				transition: height 0.2s;
			}

		</style>

		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js'></script>
		<script src='autosize.js'></script>

		<script>
			$(function(){
				$('#normal').autosize();
				$('#animated').autosize({append: "\n"});
			});
		</script>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">返信</font>
			</div>

			<hr color="blue">
			<br><br>

			<form action="relay.php" method="POST" id="input">
				<font size="5">To　： </font>
				<?= "$send_name"?><br>
				<font size="5">件名　： </font>
				<input size="40" type="text" name="title" value="Re: <?= "$title"?>"><br><br>
				<font size="5">本文</font><br>
				<textarea id='animated' rows="2" cols="50" name="contents">＞<?= "$contents" ?></textarea><br>

				<input type="hidden" value="<?= $send_seq ?>" name="send_seq">
				<input type="hidden" value="<?= $link_id ?>" name="link_id">

				<table>
					<tr>
						<td><input class="button4" type="submit" value="送信" name = "send"></td>
						<td><input class="button4" type="submit" value="保存" name="Preservation"></td>
					</tr>
				</table>
			</form>
	    </div>
    </body>
</html>
