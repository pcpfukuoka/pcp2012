

<?php
//============初期設定============
//save
$last_year = 2037;
$wday_color = "#000000"; //平日の文字色は黒
$sat_color = "#0000ff"; //土曜日の文字色は青
$sun_color = "#ff0000"; //日曜日の文字色は赤
$reg_color = "#ffccff"; //今日の日付の背景色は淡いピンク
//================================

//スーパーグローバル変数対策
if(!isset($PHP_SELF)){ $PHP_SELF = $_SERVER["PHP_SELF"]; }
if(!isset($action)){
    if($_GET['action']){
        $action = $_GET['action'];
    }else{
        $action = $_POST['action'];
    }
}
if(!isset($year)){
    if($_GET['year']){
        $year = $_GET['year'];
    }else{
        $year = $_POST['year'];
    }
}
if(!isset($month)){
    if($_GET['month']){
        $month = $_GET['month'];
    }else{
        $month = $_POST['month'];
    }
}
if(!isset($select_date)){
    if($_GET['select_date']){
        $select_date = $_GET['select_date'];
    }


}
if(!isset($day)){ $day = $_GET['day']; }
if(!isset($ayear)){ $ayear = $_POST['ayear']; }
if(!isset($amonth)){ $amonth = $_POST['amonth']; }
if(!isset($aday)){ $aday = $_POST['aday']; }
if(!isset($date)){ $date = $_POST['date']; }
if(!isset($schedule)){ $schedule = $_POST['schedule']; }
if(!isset($comment)){ $comment = $_POST['comment']; }
if(!isset($c_color)){ $c_color = $_POST['c_color']; }
//エスケープ記号対策
$comment = stripslashes($comment);

//変数$yearがセットされていなければ当年
$year = (!isset($year)) ? date("Y") : $year;
//変数$monthがセットされていなければ当月
$month = (!isset($month)) ? date("n") : $month;
//移動用の年月を取得
if($month == 1){
    $pre_month = 12;
    $pre_year = $year - 1;
    $next_month = $month + 1;
    $next_year = $year;
}elseif($month == 12){
    $pre_month = $month - 1;
    $pre_year = $year;
    $next_month = 1;
    $next_year = $year + 1;
}else{
    $pre_month = $month - 1;
    $pre_year = $year;
    $next_month = $month + 1;
    $next_year = $year;
}
//変数$dayがセットされていなければ当日
$day = (!isset($day)) ? date("j") : $day;
$today = date("Y-n-j"); //今日の日付データ
$data_max = 100; //データ最大記録数
$data_file = './log.dat';
$horiday_file = './horiday.dat'; //休日用ファイル
$passwd = '777'; //管理者用パスワード
//書き込み処理
if($action == 'regist')
{
    if($comment)
    {
        //ここから書き込みデータの調整
        $date = $ayear . "-" . $amonth . "-" . $aday;
        //サンプル 特殊記号の変換
		//htmlspecialchars("<a href=\"test\">test</a>)→<a href="test">test</a>
        $comment = htmlspecialchars($comment);

        //サンプル 改行文字の前にHTMLの改行タグを挿入する
        //string nl2br( string string )
        //$comment = nl2br($comment);

        //サンプル 文字列の置き換え
        //str_replace ("検索文字列", "置換え文字列", "対象文字列");
        $comment = str_replace("\r", "", $comment);
        $comment = str_replace("\n", "", $comment);
        //ログファイルの区切文字(",")と区別するために文字コード(&#44)に書き換える。
        //$comment = str_replace(",", "&#44;",$comment);
        //日付の重複をチェック
        //$message = file($data_file);

        $chk_flag = 0;

        mysql_connect("105-pc", "root", "");
        mysql_select_db("sample");
        mysql_query("SET NAMES UTF8");

        $message1 = "select * from schedule where date = '$date'";
        $message = mysql_query($message1);
        $chk_flag = mysql_num_rows($message);
        if($chk_flag < 1)
        {

        	unset($message1);
        	$message1 = "insert into schedule values('$date','$schedule','$comment','$c_color')";
        	mysql_query($message1);


        }
	}
        unset($message);
}
//アップデート処理
elseif($action == 'update'){
	    if($comment)
		{
			mysql_connect("105-pc", "root", "");
	        mysql_select_db("sample");
	        mysql_query("SET NAMES UTF8");

			$message = "UPDATE schedule SET schedule='$schedule',comment='$comment',color='$c_color' WHERE date='$date'";
	        mysql_query($message);
		}

//記事削除処理
}elseif($action == 'delete'){

		mysql_connect("105-pc", "root", "");
        mysql_select_db("sample");
        mysql_query("SET NAMES UTF8");

		$message = "delete  from schedule where date='$select_date'";
        mysql_query($message);
}
?>

<HTML>
<HEAD>
	<script src="../jquery-1.8.2.min.js"></script>
	<script src="jquery.tipTip.js"></script>
	<script src="jquery.tipTip.minified.js"></script>
	<meta http-equiv="Content-Style-Type" content="text/css">
	<link href="tipTip.css" rel="stylesheet" type="text/css" />
	<link href="calrendar.css" rel="stylesheet" type="text/css" />
	<link href="../css/button.css" rel="stylesheet" type="text/css" />

    <META HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=utf-8">
    <TITLE>スケジュール管理</TITLE>
    <STYLE TYPE="text/css">
    <!--
    :link     {
            Color : #00BFFF ;
            Text-Decoration : Underline
        }
    :active     {
            Color : #00BFFF ;
            Text-Decoration : Underline
        }
    :visited     {
            Color : #00BFFF ;
            Text-Decoration : Underline
        }
    A:hover     {
            Color : #00BFFF ;
            Text-Decoration : None
        }
    -->
    </STYLE>
</HEAD>
<BODY>


<!-- カレンダーの背景を設定 -->





<?php
	$date = date("n");
?>

<?php
	if($date == "1")
	{
?>
		<img class="bg" src="1月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "2")
	{
?>
		<img class="bg" src="2月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "3")
	{
?>
		<img class="bg" src="3月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "4")
	{
?>
		<img class="bg" src="4月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "5")
	{
?>
		<img class="bg" src="5月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "6")
	{
?>
		<img class="bg" src="6月.jpg" alt="" />
		<div id="container">
<?php
	}
?>


<?php
	if($date == "7")
	{
?>
		<img class="bg" src="7月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "8")
	{
?>
		<img class="bg" src="8月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "9")
	{
?>
		<img class="bg" src="9月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "10")
	{
?>
		<img class="bg" src="10月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "11")
	{
?>
		<img class="bg" src="11月.jpg" alt="" />
		<div id="container">

<?php
	}
?>


<?php
	if($date == "12")
	{
?>
		<img class="bg" src="12月.jpg" alt="" />
		<div id="container">

<?php
	}
?>

<script>
	$( function(){
		// ホバーで表示させたい場合
		//$( '.tip' ).tipTip({defaultPosition: "right"});
		// クリックで表示させたい場合
		$( '.tip' ).tipTip({ activation: 'click' });
	});
</script>
<P>

<TABLE BORDER="0"  calss="button1">
    <TR>
        <TD>

            <?php echo "<A class='btnLnk2 btnCol' HREF=$PHP_SELF?year=$pre_year&month=$pre_month onMouseOver=this.style.color='#00FFFF' onMouseOut=this.style.color='#00BFFF'><< 前月</A>"; ?>
        </TD>
        <TD><P ALIGN="CENTER">
            <?php echo "<FONT SIZE=6><B>" . $year . "年". $month . "月</B></FONT>"; ?>
        </TD>
        <TD><P ALIGN="RIGHT">
            <?php echo "<A class='btnLnk2 btnCol' HREF=$PHP_SELF?year=$next_year&month=$next_month onMouseOver=this.style.color='#00FFFF' onMouseOut=this.style.color='#00BFFF'>次月 >></A>"; ?>
        </TD>
        <TD>
            &nbsp;
        </TD>
        <TD>
            &nbsp;
        </TD>
    </TR>
    <TR>
        <TD COLSPAN="3">
<TABLE BORDER="3" CELLSPACING="1" CELLPADDING="1">
    <TR>
        <TD BGCOLOR="#CCFFFF">
            <P ALIGN="CENTER"><FONT COLOR="red"><B>日</B></FONT>
        </TD>
        <TD BGCOLOR="#CCFFFF">
            <P ALIGN="CENTER"><B>月</B>
        </TD>
        <TD BGCOLOR="#CCFFFF">
            <P ALIGN="CENTER"><B>火</B>
        </TD>
        <TD BGCOLOR="#CCFFFF">
            <P ALIGN="CENTER"><B>水</B>
        </TD>
        <TD BGCOLOR="#CCFFFF">
            <P ALIGN="CENTER"><B>木</B>
        </TD>
        <TD BGCOLOR="#CCFFFF">
            <P ALIGN="CENTER"><B>金</B>
        </TD>
        <TD BGCOLOR="#CCFFFF">
            <P ALIGN="CENTER"><FONT COLOR="blue"><B>土</B></FONT>
        </TD>
    </TR>

<?php

//その月の初日のタイムスタンプを取得
$time = mktime(0, 0, 0, $month, 1, $year);
//その月の初日の曜日を取得
$day_of_first = date("w", $time);
//その月の日数を取得
$date_of_month = date("t", $time);
//その月の週数を取得
$week_of_month = ceil($date_of_month / 7);
if(($date_of_month % 7 > 7 - $day_of_first) || ($date_of_month % 7 == 0 && $day_of_first != 0)){
    $week_of_month++;
}
//カレンダーを出力
for($i = 1; $i <= $week_of_month * 7; $i++){

    if($i % 7 == 1){
        echo "<tr>";
    }
    if(($i - 1 < $day_of_first) || ($i > $date_of_month + $day_of_first)){
        echo "<td>&nbsp;</td>";
    }else{
        if($i % 7 == 1){
            $color = $sun_color;
        }elseif($i % 7 == 0){
            $color = $sat_color;
        }else{
            $color = $wday_color;
        }
        //日付を整形
        $day_num = $i - $day_of_first;
        $date_str = $year . "-" . $month . "-" . $day_num;

        // 日の0付き表示の補正
        if ($day_num > 0 && $day_num < 10)
        {
        	$day_num2 = "0" . $day_num;
        }
        else
        {
        	$day_num2 = $day_num;
        }

        // 月の0付き表示の補正
    if ($month > 0 && $month < 10)
        {
        	$month2 = "0" . $month;
        }
        else
        {
        	$month2 = $month;
        }

        $date_str2 = $year . "-" . $month2 . "-" . $day_num2;
        if($date_str == $today){
            echo "<td width=70 height=67 valign=top bgcolor=$reg_color>";
        }else{
            echo "<td width=70 height=67 valign=top>";
        }


        //祭日データを抽出

        mysql_connect("105-pc", "root", "");
        mysql_select_db("sample");

        mysql_query("SET NAMES utf8");

        $message1 = "select * from calendar";
        $message = mysql_query($message1);

        $count = mysql_num_rows($message);

        $h_flag = 0;
        for($j=0; $j<$count; $j++){

        	$gyo = mysql_fetch_array($message);

            $tdate = $gyo['date'];
            $h_name = $gyo['horiday'];

            if($date_str2 == $tdate){

                $h_flag++;
                $h_name = chop($h_name);
                break;
            }
        }
        unset($message);

        //コメントデータを抽出
        mysql_connect("105-pc", "root", "");
        mysql_select_db("sample");

        mysql_query("SET NAMES UTF8");

        $message1 = "select * from schedule";
        $message = mysql_query($message1);
		$count = mysql_num_rows($message);

		$today_flag = 0;

        for($j=0; $j<$count; $j++){
        	$gyo = mysql_fetch_array($message);
        	$idate = $gyo['date'];
        	$ischedule =$gyo['schedule'];
            $icomment = $gyo['comment'];
            $ic_color = $gyo['color'];
            if($date_str2 == $idate){

                $today_flag++;
                $schedule = $ischedule;
                $today_comment = str_replace("<br />", "\n", $icomment);
                $today_comment = chop($today_comment);
                $c_color = $ic_color;
                break;
            }
        }
        unset($message);

		//
        if($h_flag){ $color = $sun_color; }
        echo "<font size=5 color=" . $color . ">$day_num</font>";
        if($today_flag){
            echo "　<a href=$PHP_SELF?action=edit&select_date=$idate onMouseOver=this.style.color='#00FFFF' onMouseOut=this.style.color='#00BFFF'><FONT SIZE=2>編集</FONT></a>";
        }
        if($h_flag){
            echo "<br><font size=1 color='red'>" . $h_name . "</font>";
        }
        if($today_flag){
            echo "<br><font class='tip' title='$today_comment' color=" . $c_color . ">" . $schedule . "</font>";
        }
        echo "</td>";
    }
    if($i % 7 == 0){
        echo "</tr>\n";
    }
}
?>

</TABLE>
        </TD>
        <TD>
            &nbsp;
        </TD>
        <TD VALIGN=TOP>
<?php
if($action == 'add'){
    echo "<form action=$PHP_SELF method=POST>\n";
    echo "<input type=hidden name=action value=regist>\n";
    echo "<table border=0>\n";
    echo "<tr><td><B>日付：</B>$date</td></tr><tr><td><select name=ayear>";
    for($i = 2002; $i <= $last_year; $i++){
        echo "<option value=" . $i . (($i == $year) ? ' selected' : '') . ">" . $i . "</option>";
    }
    echo "</select>年<select name=amonth>";
    for($i = 1; $i <= 12; $i++){
        echo "<option value=" . $i . (($i == $month) ? ' selected' : '') . ">" . $i . "</option>";
    }
    echo "</select>月<select name=aday>";
    for($i = 1; $i <= 31; $i++){
        echo "<option value=" . $i . (($i == $day) ? ' selected' : '') . ">" . $i . "</option>";
    }
    echo "</select>日\n";
    echo "</td></tr>\n";
    echo "<tr><td><B>予定：";
    echo "<tr><td><textarea name=schedule rows=1 cols=10></textarea></td></tr>\n";
	echo "<tr><td><B>予定の文字色：</B></td></tr>\n";
	echo "<tr><td><INPUT TYPE=RADIO NAME=c_color VALUE=black checked><B><FONT COLOR='black'>黒</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=blue><B><FONT COLOR='blue'>青</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=red><B><FONT COLOR='red'>赤</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=green><B><FONT COLOR='green'>緑</FONT></B></td></tr>\n";
    echo "<tr><td><B>コメント：</B></td></tr>\n";
    echo "<tr><td><textarea name=comment rows=3 cols=15></textarea></td></tr>\n";
    echo "<tr><td><input type=submit value=登録/更新></td></tr>\n";
    echo "</table></form>\n";
    echo "お好きな日にちにコメントを<BR>登録できます。<BR><FONT SIZE=2 COLOR='red'>※コメントがなければ記事は登録<BR>されません。</FONT>\n";
}elseif($action == 'edit'){

	mysql_connect("105-pc", "root", "");
	mysql_select_db("sample");

	mysql_query("SET NAMES UTF8");

	$message1 = "select * from schedule";
	$message = mysql_query($message1);
	$count = mysql_num_rows($message);
 	for($j=0; $j<$count; $j++){
	 	$gyo = mysql_fetch_array($message);
	 	$idate = $gyo['date'];
	 	$ischedule = $gyo['schedule'];
	  	$icomment = $gyo['comment'];
	  	$ic_color = $gyo['color'];
		if($select_date == $idate){
			$date = $select_date;
			$schedule = $ischedule;
			$comment = $icomment;
			$c_color = $ic_color;
			break;
 		}
	}
    unset($message);
    echo "<form action=$PHP_SELF method=POST>\n";
    echo "<input type=hidden name=action value=update>\n";
    echo "<input type=hidden name=year value=$year>\n";
    echo "<input type=hidden name=month value=$month>\n";
    echo "<table border=0>\n";
    echo "<tr><td><B>日付：</B>$date</td></tr>\n";
    echo "<input type=hidden name=date value=\"$date\">\n";
    echo "<tr><td><B>予定：";
    echo "<tr><td><textarea name=schedule rows=1 cols=10>$schedule</textarea></td></tr>\n";
    echo "<tr><td><B>予定の文字色：</B></td></tr>\n";
	echo "<tr><td><INPUT TYPE=RADIO NAME=c_color VALUE=black" . (($c_color == 'black') ? ' checked' : '') . "><B><FONT COLOR='black'>黒</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=blue" . (($c_color == 'blue') ? ' checked' : '') . "><B><FONT COLOR='blue'>青</FONT></B>　<INPUT TYPE=RADIO NAME=ec_color VALUE=red" . (($c_color == 'red') ? ' checked' : '') . "><B><FONT COLOR='red'>赤</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=green" . (($c_color == 'green') ? ' checked' : '') . "><B><FONT COLOR='green'>緑</FONT></B></td></tr>\n";
    echo "<tr><td><B>コメント：</B></td></tr>\n";
    echo "<tr><td><textarea name=comment rows=3 cols=15>$comment</textarea></td></tr>\n";
    echo "<tr><td><input type=submit value=修正/更新></td></tr>\n";
    echo "<tr><td><a href=$PHP_SELF?action=delete&select_date=$date onMouseOver=this.style.color='red' onMouseOut=this.style.color='blue'>この記事を削除</a>　<a href=$PHP_SELF?action=add onMouseOver=this.style.color='red' onMouseOut=this.style.color='blue'>新規登録</a></td></tr>\n";
    echo "</table></form>\n";
}else{

	echo "<a class='btnLnk btnCol' href=$PHP_SELF?action=add onMouseOver=this.style.color='red' onMouseOut=this.style.color='#FF8C00'>新規登録</a>\n"; ?>
<?php
}
?>

    </TD>
    </TR>
</TABLE>
</FORM>

	</div></div></div></div></div></div></div></div></div></div></div></div>
</div>
</BODY>
</HTML>