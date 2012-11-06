<?php
//============初期設定============
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
if(!isset($code)){
    if($_GET['code']){
        $code = $_GET['code'];
    }else{
        $code = $_POST['code'];
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
if(!isset($day)){ $day = $_GET['day']; }
if(!isset($ayear)){ $ayear = $_POST['ayear']; }
if(!isset($amonth)){ $amonth = $_POST['amonth']; }
if(!isset($aday)){ $aday = $_POST['aday']; }
if(!isset($date)){ $date = $_POST['date']; }
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
$today = date("Y/n/j"); //今日の日付データ
$data_max = 100; //データ最大記録数
$data_file = './log.dat';
$horiday_file = './horiday.dat'; //休日用ファイル
$passwd = '777'; //管理者用パスワード
//書き込み処理
if($action == 'regist'){
    if($comment){
        //ここから書き込みデータの調整
        $date = $ayear . "/" . $amonth . "/" . $aday;
        $code = time(); //現在の秒数をゲット
        $comment = htmlspecialchars($comment);
        $comment = nl2br($comment);
        $comment = str_replace("\r", "", $comment);
        $comment = str_replace("\n", "", $comment);
        //ログファイルの区切文字(",")と区別するために文字コード(&#44)に書き換える。
        $comment = str_replace(",", "&#44;",$comment);
        //日付の重複をチェック
        $message = file($data_file);
        $chk_flag = 0;
        for($i = 0; $i <= count($message); $i++){
            list($ccode,$cdate,$cc_color,$ccomment) = split( ",", $message[$i]);
            if($date == $cdate){
                $chk_flag++;
                break;
            }
        }
        unset($message);
        if($chk_flag < 1){
            $message = file($data_file);
            //配列要素を文字列により連結
            $input_msg = implode(",", array($code,$date,$c_color,$comment));
            $fp = fopen($data_file, "w");
            rewind($fp);
            fputs($fp, "$input_msg\n");
            //最大記録数の調整
            if($data_max <= count($message)){
                $msg_num = $data_max - 1;
            }else{
                $msg_num = count($message);
            }
            for($i = 0; $i < $msg_num; $i++){
                fputs($fp, $message[$i]);
            }
            fclose($fp);
            unset($message);
        }
    }
//アップデート処理
}elseif($action == 'update'){
    $comment = str_replace(" ", "", $comment);
    $comment = str_replace("　", "", $comment);
    if($comment){
        $repdata = file($data_file);
        $fp = fopen($data_file, "w");
        for($i=0; $i<count($repdata); $i++){
            list($rcode,$rdate,$rc_color,$rcomment) = split( ",", $repdata[$i]);
            if ($date == $rdate) {
                $comment = htmlspecialchars($comment);
                $comment = nl2br($comment);
                $comment = str_replace("\r", "", $comment);
                $comment = str_replace("\n", "", $comment);
                $repdata[$i] = "$code,$date,$c_color,$comment\n";
                fputs($fp, $repdata[$i]);
            } else {
                fputs($fp, $repdata[$i]);
            }
        }
        fclose($fp);
    }
//記事削除処理
}elseif($action == 'delete'){
    $deldata = file($data_file);
    $fp = fopen($data_file, "w");
    for($i=0; $i<count($deldata); $i++){
        list($dcode,$ddate,$dc_color,$dcomment) = split(",", $deldata[$i]);
        if ($code != $dcode) {
            fputs($fp, $deldata[$i]);
        }
    }
    fclose($fp);
}
?>

<HTML>
<HEAD>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=utf-8">
    <TITLE>スケジュール管理</TITLE>
    <STYLE TYPE="text/css">
    <!--
    :link     {
            Color : blue ;
            Text-Decoration : Underline
        }
    :active     {
            Color : blue ;
            Text-Decoration : Underline
        }
    :visited     {
            Color : blue ;
            Text-Decoration : Underline
        }
    A:hover     {
            Color : blue ;
            Text-Decoration : None
        }
    -->
    </STYLE>
</HEAD>
<BODY>
<P>
<TABLE BORDER="0">
    <TR>
        <TD>
            <?php echo "<A HREF=$PHP_SELF?year=$pre_year&month=$pre_month onMouseOver=this.style.color='red' onMouseOut=this.style.color='blue'>前月</A>"; ?>
        </TD>
        <TD><P ALIGN="CENTER">
            <?php echo "<FONT SIZE=6><B>" . $year . "年". $month . "月</B></FONT>"; ?>
        </TD>
        <TD><P ALIGN="RIGHT">
            <?php echo "<A HREF=$PHP_SELF?year=$next_year&month=$next_month onMouseOver=this.style.color='red' onMouseOut=this.style.color='blue'>次月</A>"; ?>
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
        $date_str = $year . "/" . $month . "/" . $day_num;
        $date_str2 = $month . "/" . $day_num;
        if($date_str == $today){
            echo "<td width=70 height=70 valign=top bgcolor=$reg_color>";
        }else{
            echo "<td width=70 height=70 valign=top>";
        }

        //ログデータを抽出
        $message = file($data_file);
        $today_flag = 0;
        for($j=0; $j<count($message); $j++){
            list($icode,$idate,$ic_color,$icomment) = split( ",", $message[$j]);
            if($date_str == $idate){
                $today_flag++;
                $today_comment = $icomment;
                $today_comment = str_replace("<br />", "\n", $today_comment);
                $today_comment = chop($today_comment);
                $today_code = $icode;
                $c_color = $ic_color;
                break;
            }
        }
        unset($message);
        //祭日データを抽出
        $message = file($horiday_file);
        $h_flag = 0;
        for($j=0; $j<count($message); $j++){
            list($tdate,$h_name) = split( ",", $message[$j]);
            if($date_str2 == $tdate){
                $h_flag++;
                $h_name = chop($h_name);
                break;
            }
        }
        unset($message);

        if($h_flag){ $color = $sun_color; }
        echo "<font size=5 color=" . $color . ">$day_num</font>";
        if($today_flag){
            echo "　<a href=$PHP_SELF?action=edit&code=$today_code&year=$year&month=$month onMouseOver=this.style.color='red' onMouseOut=this.style.color='blue'><FONT SIZE=2>編集</FONT></a>";
        }
        if($h_flag){
            echo "<br><font size=2 color='red'>" . $h_name . "</font>";
        }
        if($today_flag){
            echo "<br><font color=" . $c_color . ">" . $today_comment . "</font>";
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
    echo "<tr><td><B>コメント：</B></td></tr>\n";
    echo "<tr><td><textarea name=comment rows=3 cols=15></textarea></td></tr>\n";
    echo "<tr><td><B>コメント文字色：</B></td></tr>\n";
    echo "<tr><td><INPUT TYPE=RADIO NAME=c_color VALUE=black checked><B><FONT COLOR='black'>黒</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=blue><B><FONT COLOR='blue'>青</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=red><B><FONT COLOR='red'>赤</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=green><B><FONT COLOR='green'>緑</FONT></B></td></tr>\n";
    echo "<tr><td><input type=submit value=登録/更新></td></tr>\n";
    echo "</table></form>\n";
    echo "お好きな日にちにコメントを<BR>登録できます。<BR><FONT SIZE=2 COLOR='red'>※コメントがなければ記事は登録<BR>されません。</FONT>\n";
}elseif($action == 'edit'){
    $message = file($data_file);
    for($i = 0; $i <= count($message); $i++){
        list($ecode,$edate,$ec_color,$ecomment) = split( ",", $message[$i]);
        if($code == $ecode){
            $code = $ecode;
            $date = $edate;
            $c_color = $ec_color;
            $comment = str_replace("<br />", "\n", $ecomment);
            $comment = chop($comment);
            break;
        }
    }
    unset($message);
    echo "<form action=$PHP_SELF method=POST>\n";
    echo "<input type=hidden name=action value=update>\n";
    echo "<input type=hidden name=code value=$code>\n";
    echo "<input type=hidden name=year value=$year>\n";
    echo "<input type=hidden name=month value=$month>\n";
    echo "<table border=0>\n";
    echo "<tr><td><B>日付：</B>$date</td></tr>\n";
    echo "<input type=hidden name=date value=\"$date\">\n";
    echo "<tr><td><B>コメント：</B></td></tr>\n";
    echo "<tr><td><textarea name=comment rows=3 cols=15>$comment</textarea></td></tr>\n";
    echo "<tr><td><B>コメント文字色：</B></td></tr>\n";
    echo "<tr><td><INPUT TYPE=RADIO NAME=c_color VALUE=black" . (($c_color == 'black') ? ' checked' : '') . "><B><FONT COLOR='black'>黒</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=blue" . (($c_color == 'blue') ? ' checked' : '') . "><B><FONT COLOR='blue'>青</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=red" . (($c_color == 'red') ? ' checked' : '') . "><B><FONT COLOR='red'>赤</FONT></B>　<INPUT TYPE=RADIO NAME=c_color VALUE=green" . (($c_color == 'green') ? ' checked' : '') . "><B><FONT COLOR='green'>緑</FONT></B></td></tr>\n";
    echo "<tr><td><input type=submit value=修正/更新></td></tr>\n";
    echo "<tr><td><a href=$PHP_SELF?action=delete&code=" . $code . "&year=$year&month=$month onMouseOver=this.style.color='red' onMouseOut=this.style.color='blue'>この記事を削除</a>　<a href=$PHP_SELF?action=add onMouseOver=this.style.color='red' onMouseOut=this.style.color='blue'>新規登録</a></td></tr>\n";
    echo "</table></form>\n";
}else{
    echo "■<a href=$PHP_SELF?action=add onMouseOver=this.style.color='red' onMouseOut=this.style.color='blue'>新規登録</a>\n";
}
?>

    </TD>
    </TR>
</TABLE>
</FORM>
</BODY>
</HTML>