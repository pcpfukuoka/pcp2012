<?php
	//出欠席取得
	session_start();

//今日の曜日取得
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

//スーパーグローバル変数対策
if(!isset($PHP_SELF)){ $PHP_SELF = $_SERVER["PHP_SELF"]; }
if(!isset($action)){
    if($_GET['action']){
        $action = $_GET['action'];
    }else{
        $action = $_POST['action'];
    }
}
?>

<?php
//カレンダーの生成
function calendar($year = "", $month = "") {
	if(empty($year) && empty($month)) {
		$year = date("Y");
		$month = date("n");
	}
	//月末の取得
	$l_day = date("j", mktime(0, 0, 0, $month + 1, 0, $year));
	//初期出力
	$tmp = <<<EOM
	<table cellspacing="0" cellpadding="0" border="0" class="calendar">
	<caption>{$year}年{$month}月</caption>

	<tr>
		<th class="red">日</th>
		<th>月</th>
		<th>火</th>
		<th>水</th>
		<th>木</th>
		<th>金</th>
		<th class="blue">土</th>
	</tr>\n
EOM;
	$lc = 0;
	//月末分繰り返す
	for ($i = 1; $i < $l_day + 1;$i++) {
		//曜日の取得
		$week = date("w", mktime(0, 0, 0, $month, $i, $year));
		//曜日が日曜日の場合
		if ($week == 0) {
			$tmp .= "\t<tr>\n";
			$lc++;
		}
		//1日の場合
		if ($i == 1) {
			if($week != 0) {
				$tmp .= "\t<tr>\n";
				$lc++;
			}
			$tmp .= repeat($week);
		}
		if ($i == date("j") && $year == date("Y") && $month == date("n")) {
			//現在の日付の場合
			$tmp .= "\t\t<td class=\"today\">{$i}</td>\n";
		} else {
			//現在の日付ではない場合
			//土曜日の場合
			if($week == 6)
			{
				$tmp .= "\t\t<td><font color = 'blue'>{$i}</font></td>\n";
			}
			//日曜日の場合
			else if($week == 0)
			{
				$tmp .= "\t\t<td><font color = 'red'>{$i}</font></td>\n";
			}
			else
			{
				$tmp .= "\t\t<td>{$i}</td>\n";
			}
		}
		//月末の場合
		if ($i == $l_day) {
			$tmp .= repeat(6 - $week);
		}
		//土曜日の場合
		if($week == 6) {
			 $tmp . "\t</tr>\n";
		}
	}
	if($lc < 6) {
		$tmp .= "\t<tr>\n";
		$tmp .= repeat(7);
		$tmp .= "\t</tr>\n";
	}
	if($lc == 4) {
		$tmp .= "\t<tr>\n";
		$tmp .= repeat(7);
		$tmp .= "\t</tr>\n";
	}
	$tmp .= "</table>\n";
	return $tmp;
}

function repeat($n) {
	return str_repeat("\t\t<td> </td>\n", $n);
}
?>

<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

?>

<?php
//天気予報表示区域の設定
$dbconfig = parse_ini_file("../lib/config.ini");

$tnk = $dbconfig['weather'];
?>

<!--
道北　1a
道央　1b
道東　1c
道南　1d
青森　2
岩手  3
宮城  4
秋田  5
山形  6
福島  7
茨城  8
栃木  9
群馬  10
埼玉  11
千葉  12
東京  13
神奈川  14
新潟  15
富山  16
石川  17
福井  18
山梨  19
長野  20
岐阜  21
静岡  22
愛知  23
三重  24
滋賀  25
京都  26
大阪  27
兵庫  28
奈良  29
和歌山  30
鳥取  31
島根  32
岡山  33
広島  34
山口  35
徳島  36
香川  37
愛媛  38
高知  39
福岡  40
佐賀  41
長崎  42
熊本  43
大分  44
宮崎  45
鹿児島  46
沖縄  47
-->


<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="top.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">

		<br>
		<br>
		<br>
		<div align="center">
		<table width = "60%">
			<tr>
		<!-- カレンダーの表示 -->
				<td width = "20%">
					<?= calendar() ?>
				</td>


				<td width = "20%">


				</td>
				<!-- 天気予報の表示 -->
				<td width = "20%">
				<script language="javascript" charset="euc-jp" type="text/javascript" src="http://weather.livedoor.com/plugin/common/forecast/<?= $tnk ?>.js"></script>
				</td>

			</tr>
		</table>
		</div>

		<br><br>

		</div>
	</body>
</html>
