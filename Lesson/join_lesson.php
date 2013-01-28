<?php
session_start();
require_once("../lib/dbconect.php");
$dbcon = DbConnect();


$time = time() + 60 * 60*24;
setcookie("user_seq","9",$time,"/");
setcookie("subject_seq","2",$time,"/");
setcookie("flg",true,$time,"/");

//自分が所属しているクラスのグループSEQを取得
$user_seq = $_SESSION['login_info[user]'];
$sql = "SELECT m_group.group_seq 
		FROM m_group 
		INNER JOIN group_details ON m_group.group_seq = group_details.group_seq
		WHERE m_group.class_flg = '1' 
		AND group_details.user_seq = '$user_seq' ";

$result = mysql_query($sql);

$row = mysql_fetch_array($result);

$class_seq = $row['group_seq'];


//今現在授業が行われているか調べる
$sql = "SELECT subject_seq FROM board WHERE class_seq = '$class_seq' AND end_flg = '1';";
$result = mysql_query($sql);
$cnt = mysql_num_rows($result);
$row = mysql_fetch_array($result);
$subject_seq = $row['subject_seq'];

$sql = "SELECT * FROM m_subject WHERE subject_seq = '$subject_seq'";
$result = mysql_query($sql);

?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
</head>
<body>

	<?php 
	//自分が参加できる授業が行われている場合
	if($cnt > 0)
	{?>
	<form action="http://49.212.201.99:3000" target="_blank" method="post"enctype="multipart/form-data">
		<input type="hidden" name="room" value="<?= $class_seq ?>" >
		<input type="submit" value="" class="page_select"data-id="<?= $class_seq ?>">
	</form>			
	<?php 
	}
	//授業が何も行われていなかった場合
	else
	{?>
		現在行われている授業はありません。<br>
		もう一度授業を確認するか、過去の授業をご確認下さい。<br>
		<form action="join_lesson.php" method="post">
		<input type="submit" value="再度確認">
		</form>
		<form action="old_lesson.php" method="post">
		<input type="submit" value="過去授業へ">
		</form>
<?php 
	}
	?>
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