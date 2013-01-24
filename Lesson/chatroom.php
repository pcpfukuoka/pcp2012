<?php

$time = time() + 60 * 60*24;


setcookie("user_seq","9",$time,"/");
setcookie("subject_seq","2",$time,"/");
setcookie("group_seq","15",$time,"/");



setcookie("flg",true,$time,"/");

?>
<html>
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>

		<form action="http://49.212.201.99:3000"method="post">
			<input type="hidden" name="room" value="1">
			<input type="submit" value="1">
		</form>

		<form action="http://49.212.201.99:3000"method="post">
			<input type="hidden" name="room" value="2">
			<input type="submit" value="2">
		</form>

</head>
</html>