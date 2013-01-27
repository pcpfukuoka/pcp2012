<?php

$time = time() + 60 * 60*24;


setcookie("user_seq","9",$time,"/");
setcookie("subject_seq","2",$time,"/");
setcookie("flg",true,$time,"/");

?>
<html>
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>

</head>
<body>
		<form action="http://49.212.201.99:3000"method="post"enctype="multipart/form-data">
			<input type="hidden" name="room" value="1" >
			<input type="button" value="1" class="page_select"data-id="7">
		</form>

		<form action="http://49.212.201.99:3000"method="post" enctype="multipart/form-data">
			<input type="hidden" name="room" value="2">
			<input type="button" value="2" class="page_select"data-id="8">
		</form>

</body>
<script>
function setCookie(name, value, domain, path, expires, secure) {
	if (!name) return;

	var str = name + "=" + escape(value);
	if (domain) {
		if (domain == 1) domain = location.hostname.replace(/^[^\.]*/, "");
		str += "; domain=" + domain;
	}
	if (path) {
		if (path == 1) path = location.pathname;
		str += "; path=" + path;
	}
	if (expires) {
		var nowtime = new Date().getTime();
		expires = new Date(nowtime + (60 * 60 * 24 * 1000 * expires));
		expires = expires.toGMTString();
		str += "; expires=" + expires;
	}
	if (secure && location.protocol == "https:") {
		str += "; secure";
	}

	document.cookie = str;
}

</script>

<script>
$(function() {

	$(document).on('click', '.page_select', function() {

		//page=入室する場所の番号
		var page= $(this).data('id');
		// クッキーの発行（書き込み）
		setCookie("room",page, "", "/", 1);
		document.location = "http://49.212.201.99:3000";

    });
});
</script>
</html>