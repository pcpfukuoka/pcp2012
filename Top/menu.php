<?php
	session_start();
	$position = $_SESSION['position_flg'];
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
	<?php 
	if($_SESSION['position_flg'] == "teacher")
{
	$str = "先生";
}else
{
	$str = "さん";	
}

	?>
		<font size="5" >ようこそ<a onClick="disp()" id="login_user"><?= $_SESSION['login_info[login_name]'] ?></a><?= $str ?></font>
	</div>


	<?php 
	$weekday = date("w");
	if($weekday == "0")
	{
		$today = "日";
	}
	else if($weekday == "1")
	{
		$today = "月";
	}
	else if($weekday == "2")
	{
		$today = "火";
	}
	else if($weekday == "3")
	{
		$today = "水";
	}
	else if($weekday == "4")
	{
		$today = "木";
	}
	else if($weekday == "5")
	{
		$today = "金";
	}
	else if($weekday == "6")
	{
		$today = "土";
	}
	
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	
	$id = $_SESSION['login_info[user]'];
	
	//所属クラス取得SQL
	$sql = "SELECT m_group.group_seq FROM m_group INNER JOIN group_details ON m_group.group_seq = group_details.group_seq WHERE m_group.class_flg = 1 AND group_details.user_seq = '$id' ";
	$group_result = mysql_query($sql);
	$grow = mysql_fetch_array($group_result);
	$group_seq = $grow['group_seq'];
	//時間割の取得
	$time_table_get = "SELECT * FROM time_table WHERE time_table.day = '$today' and time_table.group_seq = '$group_seq'";
	$time_table = mysql_query($time_table_get);
	$cnt = mysql_num_rows($time_table);
	$row = mysql_fetch_array($time_table);
	
	?>
	<!-- テロップ形式で表示する内容（中身：ＤＢから、個数：foreach文？） -->
	<ul id="ticker01">
    	<li><span>1時間目</span><a href="#"><?= $row[3] ?></a></li>
    	<li><span>2時間目</span><a href="#"><?= $row[4] ?></a></li>
    	<li><span>3時間目</span><a href="#"><?= $row[5] ?></a></li>
    	<li><span>4時間目</span><a href="#"><?= $row[6] ?></a></li>
    	<li><span>5時間目</span><a href="#"><?= $row[7] ?></a></li>
    	<li><span>6時間目</span><a href="#"><?= $row[8] ?></a></li>
    	
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

		<!--  下記より先生のみ -->
		<?php if($position == "teacher")
		{
		?>
			<tr>
				<td><input class="button1" type="button" onclick="jump_top()"value="ＴＯＰ"></td>
				<td><input class="button1" type="button" onclick="jump('../Calendar/calendar_main.php' , 'left')" value="スケジュール"></td>
				<td><input class="button1" type="button" onclick="jump('../ContactBook/main.php' , 'left')" value="連絡帳"></td>
				<td><input class="button1" type="button" onclick="jump('../Lesson/index.php','left')" value="授業"></td>
				<td><input class="button1" type="button" onclick="jump('../Results_check/R_index.php' , 'left')" value="成績確認"></td>
				<td><input class="button1" type="button" onclick="jump('../QuestionManager/index.php','left')" value="アンケート"></td>
			</tr>
		<tr>
				<td><input class="button1" type="button" onclick="jump('../AuthoManager/autho_main.php','left')" value="権限管理"></td>
				<td><input class="button1" type="button" onclick="jump('../GroupManager/group_top.php', 'left')" value="グループ管理"></td>
				<td><input class="button1" type="button" onclick="jump('../UserManager/index.php', 'left')" value="ユーザー管理"></td>
				<td><input class="button1" type="button" onclick="jump('../ResultsManager/res_main.php','left')" value="成績管理"></td>
				<td><input class="button1" type="button" onclick="jump('../PrintDeliveryManager/p_main.php','left')" value="プリント配信"></td>
				<td><input class="button1" type="button" onclick="jump('../AAAManager/A_main.php' , 'left')" value="出席管理"></td>
				<td><input class="button1" type="button" onclick="jump('../DataManager/index.php' , 'left')" value="データ管理"></td>
				</tr>	
	<?php 

		}
		else
		{
			//生徒と保護者用のメニュー(ボタンを大きくする。)
			?>
						<tr>
				<td><input class="button10" type="button" onclick="jump_top()"value="ＴＯＰ"></td>
				<td><input class="button10" type="button" onclick="jump('../Calendar/calendar_main.php' , 'left')" value="スケジュール"></td>
				<td><input class="button10" type="button" onclick="jump('../ContactBook/main.php' , 'left')" value="連絡帳"></td>
				<td><input class="button10" type="button" onclick="jump('../Lesson/index.php','left')" value="授業"></td>
				<td><input class="button10" type="button" onclick="jump('../Results_check/R_index.php' , 'left')" value="成績確認"></td>
				<td><input class="button10" type="button" onclick="jump('../QuestionManager/index.php','left')" value="アンケート"></td>
			</tr>
			
			
		<?php 
		}?>
		
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
