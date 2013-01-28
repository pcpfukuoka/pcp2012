<?php
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- フレーム上部分のメニュー -->
<html>
<head>

	<META http-equiv="Content-Style-Type" content="text/css">
	<link rel="STYLESHEET"  href="../css/frame.css" type="text/css">
	<script src="../javascript/frame_jump.js"></script>
	<script src="../javascript/jquery-1.8.2.min.js"></script>
	<script src="../javascript/index_menu.js"></script>
	<meta http-equiv="Content-Type" content="text/php; charset=UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script src="../javascript/jquery.li-scroller.1.0.js"></script>
	<!-- <link rel="STYLESHEET"  href="../li-scroller.css" type="text/css">-->
	<link rel="STYLESHEET"  href="../css/frame_top_css.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	<link rel="stylesheet" type="text/css" href="../css/button.css" />
	<link rel="stylesheet" type="text/css" href="../css/top.css" />
	


	<title>メニュー一覧</title>
</head>

<body>
	<img class="bg" src="../images/blue-top.jpg" alt="" />
		<div id="container">
	<div align="right">
		<font size="5" >ようこそ<a onClick="disp()" id="login_user"><?= $_SESSION['login_info[login_name]'] ?></a>さん</font>
	</div>


	<!-- テロップ形式で表示する内容（中身：ＤＢから、個数：foreach文？） -->
	<ul id="ticker01">
    	<li><span>１時間目</span><a href="#">美術</a></li>
    	<li><span>２時間目</span><a href="#">道徳</a></li>

    	<!-- eccetera -->
	</ul>
	<script>
	$(function(){
		$("ul#ticker01").liScroll();
	});
	</script>



	<div align="center" class="button">
		<!-- クリックしてＵＲＬ変更の関数呼び出し（引数：ＵＲＬ、表示位置） -->
		<table>
			<tr>
				<td><input class="button1" type="button" onclick="jump_top()"value="ＴＯＰ"></td>
				<td><input class="button1" type="button" onclick="jump('../Calendar/calendar_main.php' , 'left')" value="スケジュール"></td>
				<td><input class="button1" type="button" onclick="jump('../ContactBook/main.php' , 'left')" value="連絡帳"></td>
				<td><input class="button1" type="button" onclick="jump('../Lesson/index.php','left')" value="授業"></td>
				<td><input class="button1" type="button" onclick="jump('../Results_check/R_index.php' , 'left')" value="成績確認"></td>
				<td><input class="button1" type="button" onclick="jump('../QuestionManager/index.php','left')" value="アンケート"></td>
			</tr>

		<!--  下記より先生のみ -->
			<tr>
				<td><input class="button1" type="button" onclick="jump('../AuthoManager/autho_main.php','left')" value="権限管理"></td>
				<td><input class="button1" type="button" onclick="jump('../GroupManager/group_top.php', 'left')" value="グループ管理"></td>
				<td><input class="button1" type="button" onclick="jump('../UserManager/index.php', 'left')" value="ユーザー管理"></td>
				<td><input class="button1" type="button" onclick="jump('../ResultsManager/res_main.php','left')" value="成績管理"></td>
				<td><input class="button1" type="button" onclick="jump('../PrintDeliveryManager/p_main.php','left')" value="プリント配信"></td>
				<td><input class="button1" type="button" onclick="jump('../AAAManager/A_main.php' , 'left')" value="出席管理"></td>
				</tr>
		</table>
	</div>
	</div>
</body>
<script>

function disp(){

	// 「OK」時の処理開始 ＋ 確認ダイアログの表示

	if(window.confirm('ログアウトしますか？'))
	{
		top.location.href = "../login/logout.php"; // example_confirm.html へジャンプ
	}

};
	</script>

</html>
