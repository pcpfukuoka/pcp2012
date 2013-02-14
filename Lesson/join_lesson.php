<?php
session_start();
require_once("../lib/dbconect.php");
$dbcon = DbConnect();
$time = time() + 60 * 60*24;


$flg = $_SESSION['position_flg'];
//先生だったら
if($flg == "teacher")
{
	$time_table =$_GET['id3'];
	$class_seq = $_GET['id2'];
	$subject_seq = $_GET['id'];
	$access = true;
	$cnt = 99;
}
else
{
	$access = 0;

	//自分が所属しているクラスのグループSEQを取得
	$user_seq = $_SESSION['login_info[user]'];
	$sql = "SELECT m_group.group_seq
	FROM m_group
	INNER JOIN group_details ON m_group.group_seq = group_details.group_seq
	WHERE m_group.class_flg = '1'
	AND group_details.user_seq = '$user_seq'";
	$result = mysql_query($sql);

	$row = mysql_fetch_array($result);

	$class_seq = $row['group_seq'];

	//今現在授業が行われているか調べる
	$sql = "SELECT subject_seq,time_table FROM board WHERE class_seq = '$class_seq' AND end_flg = '1';";
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	$subject_seq = $row['subject_seq'];
	$time_table = $row['time_table'];

	$sql = "SELECT * FROM m_subject WHERE subject_seq = '$subject_seq'";
	$result = mysql_query($sql);

}


//クッキー設定
setcookie("flg",$access,$time,"/");
setcookie("user_seq",$user_seq,$time,"/");
setcookie("subject_seq",$subject_seq,$time,"/");
setcookie("time_table",$time_table,$time,"/");
?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	<link rel="stylesheet" type="text/css" href="../css/button.css" />
	<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
</head>
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
function test(page) {


		//page=入室する場所の番号
		// クッキーの発行（書き込み）
		setCookie("room",page, "", "/", 1);
		window.open("http://49.212.201.99:3000");

    }
</script>
<?php
	//授業があれば黒板ページヘ
	if($cnt > 0)
	{
		print "<script language=javascript>test($class_seq);</script>";
	}
	?>

<body>
		<div id="container">
		<div align="center">
			<font class="Cubicfont">授業参加</font>
		</div>
			<hr color="blue"></hr>
			<br><br><br>
		<span class="Cubicfont1">現在行われている授業はありません。<br>
		もう一度授業を確認するか、過去の授業をご確認下さい。<br></span>
		<table>
			<tr>
			<td>
				<form action="join_lesson.php" method="post">
				<input class="button3"  type="submit" value="再度確認">
			</form>
			</td>
			<td>
				<form action="old_lesson.php" method="post">
				<input class="button3" type="submit" value="過去授業へ">
			</form>
			</td>
			</tr>
		</table>
	</div>
</body>

</html>