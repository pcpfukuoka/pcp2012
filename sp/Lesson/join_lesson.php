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
setcookie("room",$class_seq,$time, "/");

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

<body>
<div data-role="page">
		<div data-role="header" data-position="fixed">
			<div data-role="navbar">
				<ul>
					<li><a href="../contactbook/main.php">連絡帳</a></li>
					<li><a href="join_lesson.php" class="ui-btn-active">授業</a></li>
					<li><a href="../Results_management/Per_ver.php">成績確認</a></li>
					<li><a href="../question/answer_list.php">アンケート</a></li>
				</ul>
			</div>
		</div>
		<div data-role="content">	
		
		<div align="center">
			<font class="Cubicfont">授業参加</font>
		</div>
			<hr color="blue"></hr>
			<br><br><br>

			
			
			<?php 
	//授業があれば黒板ページヘ
	if($cnt > 0)
	{?>
		<a href="http://49.212.201.99:3000" data-role="button">授業参加</a>
	<?php 
	}else
	{
?>
			<span class="Cubicfont1">現在行われている授業はありません。<br>
			もう一度授業を確認してください。<br></span>
		<a href="join_lesson.php" data-role="button">再度確認</a>

<?php 
	}
	?>
					</div>
			
		    <div data-role="footer" data-position="fixed" >
			<p>PCP2012</p>
			<a href="#" data-rel="back" data-role="button" data-icon="back"  class="ui-btn-left">戻る</a>
			<a href="../index.php" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
		</div>
		
</div>
</body>

</html>