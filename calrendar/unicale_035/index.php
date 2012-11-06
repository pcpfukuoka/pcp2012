<?php
//---------------------------------------------
//  UNICALE - a Simple Calendar System -
//---------------------------------------------
//  copyright. UNICALE Project Team, 2007-2010
//---------------------------------------------

define("UNICALE_VERSION","0.35");

if(file_exists("./conf/config.php")){
	include_once "./conf/config.php";
}else{
	if(file_exists("./conf/config.sample.php")){
		include_once "./conf/config.sample.php";
		define('DEMO_MODE',true);
	}
}
if(!defined('DEMO_MODE')){
	define('DEMO_MODE',false);
}
include_once "./conf/config_common.php";
include_once "./conf/config_init.php";
date_default_timezone_set(TIMEZONENAME);

$basedirTmp = __FILE__;
//$basedirTmp = str_replace("\\","/",$basedirTmp); //WIN32
$basedirTmp = str_replace("index.php","",$basedirTmp);
$basedirTmp = $basedirTmp."data/";
$basedir = $basedirTmp;

set_time_limit(SETTIME_LIMIT);

if(!defined('STARTYEAR')){
	define('STARTYEAR',2005);
}
if(!defined('ENDYEAR')){
	define('ENDYEAR',STARTYEAR+3);
}

if(!defined('TIMEZONEHOUR')){
	define('TIMEZONEHOUR',substr(date("O"),0,3));
}

if(!defined('EVENT_MAX')){
	define('EVENT_MAX',50);
}

if(!defined('KOSU_ALL1')){
	define('KOSU_ALL1',8);
}

if(!defined('KOSU_ALL2')){
	define('KOSU_ALL2',8);
}
if(!defined('KOSU_AM')){
	define('KOSU_AM',3);
}

if(!defined('KOSU_PM')){
	define('KOSU_PM',4);
}

if(!defined('KOSU_STARTONLY_HOUR')){
	define('KOSU_STARTONLY_HOUR',2);
}

if(!defined('HOUR_UNIT_TYPE')){
	define('HOUR_UNIT_TYPE',0);
}

if (!@opendir($basedir)) {
	mkdir ($basedir, 0666);
	if(PERM_CHG)chmod($basedir,0666);
}

if (!@opendir($basedir."lock/")) {
	mkdir ($basedir."lock/", 0777);
	if(PERM_CHG)chmod($basedir."lock/",0777);
}
$phpSelf = $_SERVER['SCRIPT_NAME'];
$phpSelfABS = scriptURI();
$currentDate = 0;

$getRef   = Sanitize(getRequest('ref'));
$getYear  = 0;
$getMonth = 0;
$getDay   = 0;
switch ($getRef){
	case "bm":
		$currentDate = mktime();
		$getYear  = date("Y",$currentDate);
		$getMonth = sprintf("%02d",date("m",$currentDate));
		$getDay   = sprintf("%02d",date("d",$currentDate));
		break;
	default:
		$getYear  = Sanitize(getRequest('y'));
		$getMonth = Sanitize(getRequest('m'));
		$getDay   = Sanitize(getRequest('d'));
		break;
}

$getStartTime   = Sanitize(getRequest('starttime'));
$getEndTime     = Sanitize(getRequest('endtime'));
$getEventInfo   = Sanitize(getRequest('eventinfo'));
if($getRef == "bm"){
	$getEventInfo = mb_convert_encoding($getEventInfo, "EUC-JP", "utf-8");
}
$getPlace       = Sanitize(getRequest('place'));
$getMember      = getRequest('chkMember', null);
$getCurrentDate = Sanitize(getRequest('curdate'));
$getMode        = Sanitize(getRequest('mode'));
$getDatetime    = Sanitize(getRequest('date'));
$getSbmt        = Sanitize(getRequest('sbmt', ($getRef == "bm") ? "登録" : ''));
$getDetail      = Sanitize(getRequest('detail'));
$getFno         = Sanitize(getRequest('fno'));
$getCdate       = Sanitize(getRequest('cdate'));
$getChgType     = Sanitize(getRequest('chgtype'));
$getGenre       = Sanitize(getRequest('genre'));
$getWEEK        = Sanitize(getRequest('WEEK'));
$getKosu        = Sanitize(getRequest('kosu', null));
$getKeiji       = Sanitize(getRequest('keiji'));
$getSilent      = (getRequest('silent') != '') ? 1 : 0;
$getCSVMode     = Sanitize(getRequest('csvmode', 0));	//getMode=csvexportの時有効。[0]:デフォルト，1:人ごとに出す

$kosuFileExists = false;
if(file_exists("./kosu.php")){
	include_once "./kosu.php";
	$kosuFileExists = true;
}
if($getMode == "kosu"){
	if(!$kosuFileExists){
		$getMode = "";
	}
}



$getWeeks   = Sanitize(getRequest('weeks', 6));
$dispWeeks  = $getWeeks;
$dayCounter = $dispWeeks * 7;

$getKosuDet = Sanitize(getRequest('kosudet'));
if(($getKosuDet == 1)||($getKosuDet == 0)){
}else{
	$getKosuDet = 0;
}

$YY = "";
$MM = "";
$DD = "";

$Message = "";
if(KEIJI_MODE == true){
	if($getMode =="keijiwrt"){
		$keijiFile = $basedir."keiji.dat";
		if(file_exists($keijiFile)){
			if(FILE_LOCK)lock($keijiFile);
			$handle = fopen($keijiFile, 'w');
			if($handle){
				fwrite($handle, $getKeiji);
				fclose($handle);
			}
			if(FILE_LOCK)unlock($keijiFile);

			if(PERM_CHG){
				set_error_handler("permChangeError");
				chmod($keijiFile, 0666);
				set_error_handler("");
			}
			$Message = "掲示板に書き込みました。";
		}
	}
	if($getMode =="keiji"){
		$basedirPerm = fileperms($basedir."keiji.dat");
		if(($basedirPerm & 0x0002)!=true){;
			echo("data/keiji.datファイルに書き込み権限がありません。<br>");
			echo("コマンドラインなどから下記コマンドを入力し，dataディレクトリに書き込み権限を与えてください。<br>");
			echo("chmod 666 -R ".$basedir."keiji.dat<br>");
			exit;
		}
		$keijiFile = $basedir."keiji.dat";
		if(file_exists($keijiFile)){
			$readKeijiFile = "";
			if(FILE_LOCK)lock($keijiFile);
			$handle = fopen($keijiFile, "r");
			if($handle){
				$readKeijiFile = file_get_contents($keijiFile);
				if($readKeijiFile != ""){
					$readKeijiFile = str_replace("<br>","\n",$readKeijiFile);
				}
				fclose($handle);
			}
			if(FILE_LOCK)unlock($keijiFile);
			echo("<html>\n");
			echo("<head>\n");
			echo("<title>".$title." ほぼ１行掲示板</title>\n");
			echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"ucal_common.css\"  media=\"all\">\n");
			echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"ucal.css\"  media=\"all\">\n");
			echo("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=EUC-JP\">\n");
			echo("</head>\n");
			echo("<body>\n");
			echo("<div id=\"pageimage\">\n");
			echo("<a href=\"".$phpSelf."\" class=\"headerh1\">\n");
			echo("<h1>".$title." </h1>\n");
			echo("</a>\n");
			echo("<h2>ほぼ１行掲示板</h2>\n");
			echo("<form action=\"".$phpSelf."\" method=\"get\">\n");
			echo("<textarea cols=\"50\" rows=\"4\" name=\"keiji\">\n");
			echo($readKeijiFile);
			echo("</textarea>\n");
			echo("<br>\n");
			echo("<input type=\"submit\" name=\"sbmt\" value=\"更新\">\n");
			echo("<input type=\"hidden\" name=\"mode\" value=\"keijiwrt\">\n");
			echo("</form>\n");
			echo("</div>\n");
			echo("</body>\n");
			echo("</html>\n");
			exit;
		}
	}
}

$basedirPerm = fileperms($basedir);
if(($basedirPerm & 0x0002)!=true){;
	echo("dataディレクトリに書き込み権限がありません。<br>");
	echo("コマンドラインなどから下記コマンドを入力し，dataディレクトリに書き込み権限を与えてください。<br>");
	echo("chmod 666 -R ".$basedir."<br>");
	exit;
}

if(($getMode == "export")||($getMode == "exportforce")){
	$exportforce = 0;
	if($getMode == "exportforce"){
		$exportforce = 1;
	}
	exportData(STARTYEAR,ENDYEAR,$basedir,$phpSelf,$title,$exportforce,HOUR_UNIT_TYPE);
	exit;
}

if(($getMode == "csvexport")||($getMode == "csvexportforce")){
	$exportforce = 0;
	if($getMode == "csvexportforce"){
		$exportforce = 1;
	}
	CSVexportData(STARTYEAR,ENDYEAR,$basedir,$phpSelf,$title,$exportforce,$getPsn,$getCSVMode,HOUR_UNIT_TYPE);
	exit;
}


if($getMode == "import"){
	$importFileName = $basedir."import.dat";
	if(!file_exists($importFileName)){
		echo("インポートファイル無いよ！");
		exit;
	}

	$fSize = filesize($importFileName) + 1;
	$handle = fopen($importFileName, "r");
	$buffer = array();
	$readCounter = 0;
	if($handle){
		while ($line = fgets($handle, $fSize)) {
			$buffer[$readCounter] = chop($line);
			$readCounter++;
		}
		fclose($handle);
	}
	if(empty($buffer)){
		echo("インポートファイルが変！");
		exit;
	}

	for($i=0;$i<count($buffer);$i++){
		if((trim($buffer[$i]) != "")&&(substr($buffer[$i],0,1) != "#")){
			if($buffer[$i] != ""){
				$buffer1Line = explode(",",$buffer[$i]);
				if(ereg("^[0-9]+$", $buffer1Line[0])){
					$wrtDate = $buffer1Line[0];
					$wrtTime = explode("-",trim($buffer1Line[1]));
					$wrtStartTime = $wrtTime[0];
					$wrtStartTime = str_replace(":","",$wrtStartTime);
					$wrtStartTime = str_pad($wrtStartTime,4,"0",STR_PAD_LEFT); //ゼロサプレス
					$wrtEndTime = $wrtTime[1];
					$wrtEndTime = str_replace(":","",$wrtEndTime);
					$wrtEventInfo = $buffer1Line[2];
					$wrtPlace = $buffer1Line[3];
					$wrtMember = str_replace("_"," ",$buffer1Line[4]);
					$wrtMember = ereg_replace("^ ","",$wrtMember);
					$wrtEventDetail = $buffer1Line[5];
					$wrtSilent = $buffer1Line[6];
					$YY = substr($wrtDate,0,4);
					$MM = substr($wrtDate,4,2);
					$newFileName = searchNewFileName($basedir,$YY,$MM,$wrtDate);
					if($newFileName != ""){

	/*
						echo("---------------------------------------------<br>\n");
						echo($newFileName."<br>\n");
						echo("---------------------------------------------<br>\n");
						echo($wrtDate."<br>\n");
						echo($wrtStartTime."<br>\n");
						echo($wrtEndTime."<br>\n");
						echo($wrtEventInfo."<br>\n");
						echo($wrtPlace."<br>\n");
						echo($wrtMember."<br>\n");
						echo("<br>\n"); //ジャンル
						echo($wrtSilent."<br>\n"); 
						echo("<br>\n"); //予備
						echo("<br>\n"); //予備
						echo($wrtEventDetail."<br>\n");
						echo("<br>\n");
	*/

						$handle = fopen($newFileName, "w");
						if($handle){
							fwrite($handle, $wrtDate."\n");
							fwrite($handle, $wrtStartTime."\n");
							fwrite($handle, $wrtEndTime."\n");
							fwrite($handle, $wrtEventInfo."\n");
							fwrite($handle, $wrtPlace."\n");
							fwrite($handle, $wrtMember."\n");
							fwrite($handle, "\n"); //ジャンル
							fwrite($handle, $wrtSilent."\n"); 
							fwrite($handle, "\n"); //予備
							fwrite($handle, "\n"); //予備
							fwrite($handle, $wrtEventDetail."\n");
							fclose($handle);
						}
						if(PERM_CHG){
							set_error_handler("permChangeError");
							chmod($newFileName,0666);
							set_error_handler("");
						}
					}
				}else{
					echo("インポートファイルが変！(おそらく".($i+1)."行目の日付のあたり)<br>");
				}
			}else{
				echo("空行をスキップしました。".($i+1)."行目<br>");
			}
		}else{
			echo("インポートファイルが変！(おそらく".($i+1)."行目の日付)<br>");
		}
	}
echo("終了");
exit;
}


$errorFlag = 0;
if(($getSbmt == "登録")||($getSbmt == "実行")){
	if($getChgType != "delete"){
		if(trim($getEventInfo)==""){
			$Message = "用事ないよ！";
			$errorFlag = 1;
			$getSbmt = "";
		}
	}
}

if(($getSbmt == "登録")||($getSbmt == "実行")){
	$YY = sprintf("%04d", $getYear);
	$MM = sprintf("%02d", $getMonth);
	$DD = sprintf("%02d", $getDay);
	$startDateFormat = $YY.$MM.$DD;

	$flagWriteFile = 0;
	$flagDelFile = 0;
	$newFileName = "";
	$delFileName = "";
	switch($getSbmt){
		case "登録":
			$newFileName = searchNewFileName($basedir,$YY,$MM,$startDateFormat);
			$flagWriteFile = 1;
			break;
		case "実行":
			switch($getChgType){
				case "change";
					if($YY.$MM.$DD == $getCdate){
						$fNumber = sprintf("%02d",$getFno);
						$newFileName = $basedir.$YY."/".$MM."/".$startDateFormat."_".$fNumber.".dat";
						$flagWriteFile = 1;
					}else{
						$newFileName = searchNewFileName($basedir,$YY,$MM,$startDateFormat);

						$delYY = substr($getCdate,0,4);
						$delMM = substr($getCdate,4,2);
						$fNumber = sprintf("%02d",$getFno);
						$delFileName = $basedir.$delYY."/".$delMM."/".$getCdate."_".$fNumber.".dat";
						$flagWriteFile = 1;
						$flagDelFile = 1;
					}
					break;
				case "copy";
					$newFileName = searchNewFileName($basedir,$YY,$MM,$startDateFormat);
					$flagWriteFile = 1;
					break;
				case "delete";
					$delYY = substr($getCdate,0,4);
					$delMM = substr($getCdate,4,2);
					$fNumber = sprintf("%02d",$getFno);
					$delFileName = $basedir.$delYY."/".$delMM."/".$getCdate."_".$fNumber.".dat";
					$flagDelFile = 1;
					break;
			}
			break;
		default:
	}
	if($flagWriteFile == 1){
		if($newFileName == ""){
			$Message = "1日に登録できる用事は".EVENT_MAX."件までです！";
			$errorFlag = 1;
		}
	}
	if($flagDelFile == 1){
		if($flagWriteFile == 1){
			if(chofukuData($startDateFormat,$getEventInfo,$basedir,$YY,$MM)){
				$Message = "データが重複！";
				$errorFlag = 1;
			}
		}
		if($errorFlag == 0){
			if(file_exists($delFileName)){
				$result = unlink($delFileName);
				if($result == true){
					$Message = "削除しました。";
				}else{
					$Message = "削除しようとしましたが，エラーのため削除を行いませんでした。";
				}
			}else{
					$Message = "そのデータは削除済み";
			}
			$currentDate = mktime();
			$YY = date("Y",$currentDate);
			$MM = sprintf("%02d",date("m",$currentDate));
			$DD = sprintf("%02d",date("d",$currentDate));
		}
	}
	if($errorFlag == 0){
		if($flagWriteFile == 1){
			if(chofukuData($startDateFormat,$getEventInfo,$basedir,$YY,$MM)&&($getChgType == "copy")){
				$Message = "データが重複！";
				$errorFlag = 1;
			}
			if($errorFlag == 0){
				if(FILE_LOCK)lock($newFileName);
				$handle = fopen($newFileName, 'w');
				if($handle){
					fwrite($handle, $startDateFormat."\n");
					fwrite($handle, $getStartTime."\n");
					fwrite($handle, $getEndTime."\n");
					fwrite($handle, $getEventInfo."\n");
					fwrite($handle, $getPlace."\n");
					if(isset($getMember) == true){
						fwrite($handle, implode(" ", $getMember)."\n");
					}else{
						fwrite($handle, "\n");
					}
					fwrite($handle, $getGenre."\n");//ジャンル
					fwrite($handle, $getSilent."\n");//ひっそり
					fwrite($handle, "\n");//予備3
					fwrite($handle, "\n");//予備4
					fwrite($handle, $getDetail."\n");
					fclose($handle);
				}
				if(FILE_LOCK)unlock($newFileName);
				if(PERM_CHG){
					set_error_handler("permChangeError");
					chmod($newFileName,0666);
					set_error_handler("");
				}
				putRSS($getEventInfo,$getPlace,$startDateFormat,$getStartTime,$getEndTime,$getDetail,$getMember,$YY,$MM,$DD,$title,$basedir,$getSbmt,HOUR_UNIT_TYPE);
				$Message = "変更しました。";
			}else{
				$YY = substr($getCdate,0,4);
				$MM = substr($getCdate,4,2);
				$DD = substr($getCdate,6,2);
			}
			$currentDate = mktime(0,0,0,$MM,$DD,$YY);
		}
	}else{
		$YY = substr($getCdate,0,4);
		$MM = substr($getCdate,4,2);
		$DD = substr($getCdate,6,2);
		$currentDate = mktime(0,0,0,$MM,$DD,$YY);
	}
}else{
	if($getWEEK != ""){
		$YY = substr($getWEEK,0,4);
		$DD = 7*(substr($getWEEK,5,2)-1);
		$currentDate = strtotime("+".$DD." day",mktime(0,0,0,01,01,$YY));
		$YY = date("Y",$currentDate);
		$MM = sprintf("%02d",date("m",$currentDate));
		$DD = sprintf("%02d",date("d",$currentDate));
	}else{

		switch($getMode){
			case "month":
			case "day":
			case "daydet":
			case "day2":
			case "kosu":
				$YY = trim(substr($getDatetime,0,4));
				$MM = trim(substr($getDatetime,4,2));
				$DD = trim(substr($getDatetime,6,2));
				$currentDate = mktime(0,0,0,$MM,$DD,$YY);
				break;
			default:
				$currentDate = mktime();
				$YY = date("Y",$currentDate);
				$MM = sprintf("%02d",date("m",$currentDate));
				$DD = sprintf("%02d",date("d",$currentDate));
				break;
		}
	}
}

if(DEMO_MODE){
	$Message .="<br>./conf/config.sample.phpファイルが存在します。config.phpに内容を移し終えたらconfig.sample.phpを削除するか名前を変更してください。";
}

$currentWeekday = date('w',$currentDate);

// 週数カウント対応
$currentWeekNumber = getWeekNumber($currentDate);
$startSundayTS = mktime(0,0,0,date("n",$currentDate),date("d",$currentDate)-$currentWeekday,date("Y",$currentDate));
$dayBuffer = array();
$dayinfo = array();
$dataDate = array();
$outputStringDay = array();
for($i=0;$i<=$dayCounter;$i++){
	$strtoTimeStr = "+".$i." day";
	$dayinfo[$i] = strtotime($strtoTimeStr, $startSundayTS);
	$dataDate[$i] = date("Ymd",$dayinfo[$i]);
	$readYY = date("Y",$dayinfo[$i]);
	$readMM = date("m",$dayinfo[$i]);

	$outputStringDay[$i] = "";
	$eventBuffer = array();
	for($j=0;$j<EVENT_MAX;$j++){
		$fNumber = sprintf("%02d", $j);
		$checkFileName = $basedir.$readYY."/".$readMM."/".$dataDate[$i]."_".$fNumber.".dat";
		$outputString = "";
		if(file_exists($checkFileName)){
			$lastModified = filemtime($checkFileName);
			$fileCreatedDate = filectime($checkFileName);
			$fSize = filesize($checkFileName) + 1;
			if(FILE_LOCK)lock($checkFileName);
			$handle = fopen($checkFileName, "r");
			$buffer = array();
			$readCounter = 0;
			if($handle){
				while ($line = fgets($handle, $fSize)) {
					$buffer[$readCounter] = chop($line);
					$readCounter++;
				}
				fclose($handle);
			}
			if(FILE_LOCK)unlock($checkFileName);
			$Member = explode(" ",trim($buffer[5]));
			$strMember = "";

			$realMember = 0;
			if(isset($Member)){
				if($Member != ""){
					for($k=0;$k<count($Member);$k++){
						if($Member[$k] != ""){
							$memberMiddle = searchFullMemberList($Member[$k],2);
							$strMember .= "<a href=\"#\" title=\"".$memberMiddle."\"><span class=\"mem".$Member[$k]."colorTEXT\">■</span></a>";
							$realMember++;
						}
					}
				}else{
					$strMember = "";
				}
			}else{
				$strMember = "";
			}
			
			$startTime = searchStartTime($buffer[1],HOUR_UNIT_TYPE);
			$endTime = searchEndTime($buffer[2],HOUR_UNIT_TYPE);
			if(trim($endTime) != ""){
				$endTime = $endTime."&nbsp; ";
				$startTime = $startTime . "-";
			}
			$place = trim($buffer[4]);
			if($place != ""){
				$place = "(".$place.")";
			}
			if($startTime != ""){
				$endTime .= "<br>";
			}
			$eventInfo = $buffer[3];
			if($buffer[10] != ""){
				$eventInfo .= "...";
			}
			$genreName = searchGenreArray($buffer[6]);
			$eventOutString = $startTime.$endTime.$eventInfo.$place;
			if($buffer[7]==1){	// silent=1
				$eventOutString = "<span class=\"silent\">".$eventOutString."</span>";
			}
			$outputString .= "<a href=\"".$phpSelf."?mode=daydet&date=".$buffer[0]."&fno=".sprintf("%02d",$j)."\" title=\"".$genreName."\">".$eventOutString."</a>".$strMember;
			$outputString = "<span class=\"genre".$buffer[6]."color\">".$outputString."</span>";

			$modifiedDateDiff = floor((mktime()-$lastModified)/(60*60*24));
			if($lastModified == $fileCreatedDate){
				if($modifiedDateDiff < NEWICONDISP_DAYS){
					if($modifiedDateDiff == 0){
						$outputString = $outputString."<img src=\"img/new.gif\" alt=\"24時間以内\" class=\"imgicon\">";
					}else{
						$outputString = $outputString."<img src=\"img/new.gif\" alt=\"".$modifiedDateDiff."日前\" class=\"imgicon\">";
					}
				}
			}else{
				if($modifiedDateDiff < NEWICONDISP_DAYS){
					if($modifiedDateDiff == 0){
						$outputString = $outputString."<img src=\"img/up.gif\" alt=\"24時間以内\" class=\"imgicon\">";
					}else{
						$outputString = $outputString."<img src=\"img/up.gif\" alt=\"".$modifiedDateDiff."日前\" class=\"imgicon\">";
					}
				}
			}
			$useHour = calcUseHour($buffer[1], $buffer[2]);
			$ninzu = 0;
			if(isset($Member)){
				$ninzu = $realMember;
			}
			$ninHour = 0;

			if($ninzu > 0){
				if($useHour != ""){
					if(isset($Member)){
						$ninHour = $useHour * $realMember;
					}
				}
			}

			$outputString = $outputString."<br><br class=\"br1\">";
			if($buffer[6]==""){
				$buffer[6] = "999";
			}
			if($buffer[6]=="000"){
				$buffer[6] = "999";
			}

									//0         1           2           3           4           5        6           7               8      9      10            11                12                13        14      15        16             17
								    //Date      StartTIme   EndTime     EventInfo   Place       member   Genre       Silent          Dummy  Dummy  EventDetail   ファイル作成日時  ファイル更新日時  時間      人数    人時      出力用文字列   fileNumber
			$eventBuffer[$j] = Array($buffer[0], $buffer[1], $buffer[2], $buffer[3], $buffer[4], $Member, $buffer[6], $buffer[7],    "",    "",    $buffer[10],  $fileCreatedDate, $lastModified,   $useHour, $ninzu ,$ninHour, $outputString, $fNumber);

			if(isset($getKosu)){
				if($getKosu=="month"){
					if(floor($readMM) != $MM){
											   //0  1  2  3  4  5  6  7  8  9  10 11 12 13 14 15 16 17
						$eventBuffer[$j] = Array("","","","","","","","","","","","","","","","","","");
					}
				}
			}
		}
		$outputStringDay[$i] .= $outputString;
	}
	$dayBuffer[$i] = $eventBuffer;
}

for($i=0;$i<count($dayBuffer);$i++){
	if(1 < count($dayBuffer[$i])){
		switch(EVENT_SORTORDER){
			case 0:
				usort($dayBuffer[$i], "sortByFileNumber");
				break;
			case 1:
				usort($dayBuffer[$i], "sortByGenre");
				break;
			case 2:
				usort($dayBuffer[$i], "sortByFilecreateTime");
				break;
			case 3:
				usort($dayBuffer[$i], "sortByFilemodifiedTime");
				break;
			case 4:
				usort($dayBuffer[$i], "sortByStartTime");
				break;
			default:
				usort($dayBuffer[$i], "sortByFileNumber");
				break;
		}
	}
}

$readKeijiFile = "";
if(KEIJI_MODE == true){
	$keijiFile = $basedir."keiji.dat";	
	if(file_exists($keijiFile)){		
		if(FILE_LOCK)lock($keijiFile);
		$handle = fopen($keijiFile, "r");
		if($handle){
			$readKeijiFile = file_get_contents($keijiFile);
			if($readKeijiFile != ""){
				$readKeijiFile = "<a href=\"".$phpSelf."?mode=keiji\">".$readKeijiFile."</a>";
			}else{
				$readKeijiFile = "<a href=\"".$phpSelf."?mode=keiji\">ほぼ1行掲示板...</a>";
			}
			fclose($handle);
		}
		if(FILE_LOCK)unlock($keijiFile);
	}else{
		touch($keijiFile);
		if(PERM_CHG){
			set_error_handler("permChangeError");
			chmod($keijiFile,0666);
			set_error_handler("");
		}
	}
}
?>
<html>
<head>
<title><?php echo($title); ?></title>
<link rel="stylesheet" type="text/css" href="ucal_common.css"  media="all">
<link rel="stylesheet" type="text/css" href="ucal.css"  media="all">
<link rel="stylesheet" type="text/css" href="ucalp.css" media="print">
<link rel="alternate" type="application/rss+xml" title="RSS" href="index.rdf">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<script type="text/javascript">
$('.keiji').corner();

$.get("<?php echo($phpSelf); ?>", { mode: "export" },
	function(data){
	$("#res").html("<span style='background: #BFDF5E'><a href='data/export.ics' title=\"ICS Generated\">iCal</a></span>");
	});

$.get("<?php echo($phpSelf); ?>", { mode: "csvexport" },
	function(data){
	$("#rescsv").html("<span style='background: #BFDF5E'><a href='data/export.csv' title=\"CSV Generated\">CSV</a></span>");
	});

$.get("<?php echo($phpSelf); ?>", { mode: "csvexport", csvmode: "1" },
	function(data){
	$("#rescsvpsn").html("<span style='background: #BFDF5E'><a href='data/exportpsn.csv' title=\"CSV(Person) Generated\">CSV(Person)</a></span>");
	});

</script>
</head>
<body>
<div id="pageimage">
<a href="<?php echo($phpSelf);?>" class="headerh1">
<h1><?php echo($title); ?></h1>
</a>
<span class="forprint">
<?php echo(showHanreiFooter(1));?>&nbsp;<?php echo(date("Y/m/d H:i現在",mktime()));?>
</span>
<div class="keiji"><?php echo($readKeijiFile); ?></div>
<div class="alert"><?php echo($Message); ?></div>
<div id="header1">
<form action="<?php echo($phpSelf);?>" method="post">
<table border="0" class="inputbar">
<tr>
<td class="normal" rowspan="2">
<?php
	echo("\t<select name=\"y\">\n");
	$selectedValue = "";
	for($i=STARTYEAR;$i<=ENDYEAR;$i++){
		if($i==$YY){
			$selectedValue = " SELECTED";
		}else{
			$selectedValue = "";
		}
		echo("\t\t<option value=\"$i\"$selectedValue>$i</option>\n");
	}
	echo("\t</select>年\n");
	echo("\t<select name=\"m\">\n");

	$selectedValue = "";
	for($i=1;$i<=12;$i++){
		if(sprintf("%02d",$i)==$MM){
			$selectedValue = " SELECTED";
		}else{
			$selectedValue = "";
		}
		echo("\t\t<option value=\"$i\"$selectedValue>$i</option>\n");
	}
	echo("\t</select>月\n");

	echo("\t<select name=\"d\">\n");
	$selectedValue = "";
	for($i=1;$i<=31;$i++){
		if(sprintf("%02d",$i)==$DD){
			$selectedValue = " SELECTED";
		}else{
			$selectedValue = "";
		}
		echo("\t\t<option value=\"$i\"$selectedValue>$i</option>\n");
	}
	echo("\t</select>日\n");
	echo("\t</td>\n");
	
	switch ($getMode){
		case "day":
			dispTimeListBox("","","","","登録","000",HOUR_UNIT_TYPE);
			echo(showHanrei());
			echo("<div class=\"inputform\">\n");
			echo("<table border=\"0\" class=\"table1\">\n");
			echo("<tr>\n");
			echo("<td>\n");
			echo("<textarea name=\"detail\" cols=\"80\" rows=\"20\"></textarea>\n");
			echo("</td>\n");
			echo("<td>\n");

			echo("</td>\n");
			echo("</tr>\n");
			echo("<tr>\n");
			echo("<td colspan=\"2\" align=\"center\" class=\"normalgray\">\n");
			echo("<input type=\"radio\" name=\"chgtype\" value=\"change\" disabled=true>変更");
			echo("<input type=\"radio\" name=\"chgtype\" value=\"copy\" disabled=true>複製");
			echo("<input type=\"radio\" name=\"chgtype\" value=\"delete\" disabled=true>削除\n");
			echo("</td>\n");
			echo("</tr>\n");

			echo("<tr>\n");
			echo("\t<td colspan=\"2\" align=\"center\" class=\"normalgray\">\n");
			echo("\t<input type=\"checkbox\" name=\"silent\" value=\"silent\">ひっそり");
			echo("\t</td>\n");
			echo("</tr>\n");

			echo("</table>\n");
			echo("</div>\n");
			echo("<br>\n");
			echo("<input type=\"hidden\" value=\"$getFno\" name=\"fno\">\n");
			echo("<input type=\"hidden\" value=\"wrt\" name=\"mode\">\n");
			echo("<input type=\"hidden\" value=\"".$YY.$MM.$DD."\" name=\"cdate\">\n");
			break;
		case "daydet":
			$checkedMember = array();
			$detailValue = "";
			$selectedStartTime = "";
			$selectedEndTime = "";
			$eventinfo = "";
			$place = "";
			$genre = "";
			$sbmtName = "";
			$silentChecked = "";
			$fNumber = sprintf("%02d", $getFno);
			$checkFileName = $basedir.$YY."/".$MM."/".$getDatetime."_".$fNumber.".dat";
			if(file_exists($checkFileName)){
				$fSize = filesize($checkFileName) + 1;
				if(FILE_LOCK)lock($checkFileName);
				$handle = fopen($checkFileName, "r");
				$buffer = array();
				$readCounter = 0;
				if($handle){
					while ($line = fgets($handle, $fSize)) {
						$buffer[$readCounter] = chop($line);
						$readCounter++;
					}
					fclose($handle);
				}
				if(FILE_LOCK)unlock($checkFileName);
				$checkedMember = explode(" ",trim($buffer[5]));
				$detailValue = $buffer[10];
				$detailValue = str_replace("<br>","\n",$detailValue);
				$selectedStartTime = $buffer[1];
				$selectedEndTime = $buffer[2];
				$eventinfo = $buffer[3];
				$place = $buffer[4];
				$genre = $buffer[6];
				$silent = $buffer[7];
				if($silent == 1){
					$silentChecked = " CHECKED";
				}
				$sbmtName = "実行";
			}

			dispTimeListBox($selectedStartTime,$selectedEndTime, $eventinfo, $place, $sbmtName, $genre, HOUR_UNIT_TYPE);
			echo(showHanrei($checkedMember));
			echo("<div class=\"inputform\">\n");
			echo("<table border=\"0\" class=\"table1\">\n");
			echo("<tr>\n");
			echo("<td>\n");
			echo("<textarea name=\"detail\" cols=\"80\" rows=\"20\">".$detailValue."</textarea>\n");
			echo("</td>\n");
			echo("<td>\n");

			echo("</td>\n");
			echo("</tr>\n");
			echo("<tr>\n");
			echo("<td colspan=\"2\" align=\"center\" class=\"normal\">\n");
			echo("<input type=\"radio\" name=\"chgtype\" value=\"change\" CHECKED>変更");
			echo("<input type=\"radio\" name=\"chgtype\" value=\"copy\">複製");
			echo("<input type=\"radio\" name=\"chgtype\" value=\"delete\">削除\n");
			echo("</td>\n");
			echo("</tr>\n");

			echo("<tr>\n");
			echo("\t<td colspan=\"2\" align=\"center\" class=\"normalgray\">\n");

			echo("\t<input type=\"checkbox\" name=\"silent\" value=\"silent\"".$silentChecked." >ひっそり");

			echo("\t</td>\n");
			echo("</tr>\n");

			echo("</table>\n");
			echo("</div>\n");
			echo("<br>\n");
			echo("<input type=\"hidden\" value=\"$getFno\" name=\"fno\">\n");
			echo("<input type=\"hidden\" value=\"wrt\" name=\"mode\">\n");
			echo("<input type=\"hidden\" value=\"".$YY.$MM.$DD."\" name=\"cdate\">\n");
			break;
		
		default:

			dispTimeListBox("","","","","登録","000",HOUR_UNIT_TYPE);
			echo(showHanrei());
			echo("<br>\n");
			if($getMode == "kosu"){
				if($getKosu == "week"){
					echo("<h3>週間工数</h3>");
					echo("<h4>".$YY."年".$MM."月".$DD."日〜".$dispWeeks."週間</h4>");
				}
				if($getKosu == "month"){
					echo("<h3>月間工数</h3>");
					echo("<h4>".$YY."年".$MM."月</h4>");
				}

			}
			echo("<div class=\"navi\">\n");
			echo("\t<div class=\"size1\">\n");

			// 週数カウント対応
			$pYear = $YY;
			$pWeek = $currentWeekNumber - 1;
			$nYear = $YY;
			$nWeek = $currentWeekNumber + 1;
			if($pWeek < 1){
				$pEnd  = mktime(0, 0, 0, 12, 31, $YY - 1);
				$pYear --;
				$pWeek = getWeekNumber($pEnd);
				if(date("w", $pEnd) < 6){
					$pWeek --;
				}
			}
			if(getWeekNumber(mktime(0, 0, 0, 12, 31, $YY)) < $nWeek){
				$nTop = mktime(0, 0, 0, 1, 1, $YY + 1);
				$nYear ++;
				$nWeek = 1;
				if(0 < date("w", $nTop)){
					$nWeek ++;
				}
			}
			if($getMode == "kosu"){
				if($getKosu =="week"){
					echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=week&WEEK=".$pYear."-".$pWeek."\">↑前の週の工数</a>&nbsp;");
					echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=week&WEEK=".$nYear."-".$nWeek."\">次の週の工数↓</a>&nbsp;&nbsp;&nbsp;\n");
				}
			}else{
				if(CUSTOM_LINK){
					echo("\t<a href=\"".CUSTOM_LINK_URI."\">".CUSTOM_LINK_NAME."</a>&nbsp&nbsp;");
				}
				echo("\t<a href=\"".$phpSelf."\">今週</a>&nbsp&nbsp;");
				echo("\t<a href=\"".$phpSelf."?WEEK=".$pYear."-".$pWeek."\">↑前の週</a>&nbsp;");
				echo("\t<a href=\"".$phpSelf."?WEEK=".$nYear."-".$nWeek."\">次の週↓</a>&nbsp;&nbsp;&nbsp;\n");
			}

			if($kosuFileExists){
				if($getMode != "kosu"){
					echo("\t&nbsp;&nbsp;<a href=\"".$phpSelf."?mode=kosu&kosu=week&date=".$YY.$MM.$DD."\">週間工数の表示</a>&nbsp;&nbsp;\n");
				}
				if(($getMode == "kosu")&&($getKosu=="month")){
					echo("\t&nbsp;&nbsp;<a href=\"".$phpSelf."?mode=kosu&kosu=week&date=".$YY.$MM.$DD."\">週間工数の表示</a>&nbsp;&nbsp;\n");
				}
				if(isset($getKosu)){
					if($getKosu == "month"){
						if(floor($MM)==1){
							$weeksOfMonth = getWeeksCount($YY-1,12);
							echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=month&date=".($YY-1)."1201&weeks=".$weeksOfMonth."&kosudet=".$getKosuDet."\">↑12月の工数</a>&nbsp;&nbsp;\n");
						}else{
							$weeksOfMonth = getWeeksCount($YY,$MM-1);
							echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=month&date=".$YY.sprintf("%02d",($MM-1))."01&weeks=".$weeksOfMonth."&kosudet=".$getKosuDet."\">↑".floor($MM-1)."月の工数</a>&nbsp;&nbsp;\n");
						}

						$weeksOfMonth = getWeeksCount($YY,$MM);
						if($getKosuDet == 1){
							echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=month&date=".$YY.$MM."01&weeks=".$weeksOfMonth."&kosudet=0\">".floor($MM)."月の工数サマリ</a>&nbsp;&nbsp;\n");
						}else{
							echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=month&date=".$YY.$MM."01&weeks=".$weeksOfMonth."&kosudet=1\">".floor($MM)."月の工数詳細</a>&nbsp;&nbsp;\n");
						}

						if(floor($MM)==12){
							$weeksOfMonth = getWeeksCount($YY+1,01);
							echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=month&date=".($YY+1)."0101&weeks=".$weeksOfMonth."&kosudet=".$getKosuDet."\">↓1月の工数</a>&nbsp;&nbsp;\n");
						}else{
							$weeksOfMonth = getWeeksCount($YY,$MM+1);
							echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=month&date=".$YY.sprintf("%02d",($MM+1))."01&weeks=".$weeksOfMonth."&kosudet=".$getKosuDet."\">↓".floor($MM+1)."月の工数</a>&nbsp;&nbsp;\n");
						}
					}else{
						$weeksOfMonth = getWeeksCount($YY,$MM);
						echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=month&date=".$YY.$MM."01&weeks=".$weeksOfMonth."&kosudet=0\">月間工数</a>&nbsp;&nbsp;\n");
					}
				}else{
					$weeksOfMonth = getWeeksCount($YY,$MM);
					echo("\t<a href=\"".$phpSelf."?mode=kosu&kosu=month&date=".$YY.$MM."01&weeks=".$weeksOfMonth."&kosudet=0\">月間工数</a>&nbsp;&nbsp;\n");
				}
			}
			if($getMode == "kosu"){
				echo("&nbsp;|&nbsp;\n");
				echo("\t<a href=\"".$phpSelf."?date=".$YY.$MM.$DD."\">通常表示に戻る</a>\n");
			}
			echo("\t</div>\n");
			echo("\t<br>\n");
			echo("</div>\n");

			if(DISP_GENRE_FLAT == 1){	//予定ジャンルの凡例表示
				dispGenreFlat();
			}

			if(DISP_NAVI_MONTH == 1){	//月移動ナビゲーションの表示
				dispNaviMonth($phpSelf);
			}
			echo("<table border=\"0\" class=\"calendar1\" cellspacing=\"0\">\n");
			$lastMonth = "";
			$sumHourGenreMember = array();
			$sumUseHourWeek = array();
			$sumHourGenreMember_sumUseHourWeek = array();
			$sumKosuWeek = array();
			$sumMembersHour = array();
			$sumUseNinHourWeek = array();
			$callMode = array();

			if((DISP_WEEK == 1)&&($getMode != "kosu")){
				$strWeeks = array("日","月","火","水","木","金","土");
				echo("\t<tr>\n");
				for($i=0;$i<=6;$i++){
					echo("\t\t<td width=\"100\" class=\"weektd_".$i."\">");
					echo("<div class=\"week\">".$strWeeks[$i]."</div>");
					echo("</td>\n");
				}
				echo("\t</tr>\n");
			}
			for($i=0;$i<=($dispWeeks-1);$i++){
				switch($getMode){
					case "kosu":
						$dispMode = "normal";
						$callMode[0] = $dispMode;
						$callMode[1] = $getKosu;
						$callMode[2] = $MM;
						$callMode[3] = $getKosuDet;
						$callMode[4] = HOUR_UNIT_TYPE;

						$sumHourGenreMember_sumUseHourWeek[0] = $sumHourGenreMember;
						$sumHourGenreMember_sumUseHourWeek[1] = $sumUseHourWeek;
						$sumHourGenreMember_sumUseHourWeek[2] = $sumUseNinHourWeek;

						if(!isset($realMember)){
							$realMember = 0;
						}
						$sumKosuWeek = dispKosu($i,$dayinfo,$dataDate,$lastMonth,$phpSelf,$dayBuffer,$realMember,$getKosu,$sumHourGenreMember_sumUseHourWeek,$callMode);
						for($j=0;$j<count($sumKosuWeek[0]);$j++){
							if(!isset($sumMembersHour[$j])){
								$sumMembersHour[$j] = 0;
							}
							if(!isset($sumKosuWeek[0][$j])){
								$sumKosuWeek[0][$j] = 0;
							}
							$sumMembersHour[$j] = $sumMembersHour[$j] + $sumKosuWeek[0][$j];
						}
						$sumHourGenreMember = $sumKosuWeek[1];
						$sumUseHourWeek = $sumKosuWeek[2];
						$sumUseNinHourWeek = $sumKosuWeek[3];

						//サマリ表示
						if($i == ($dispWeeks-1)){
							$dispMode = "sum";
							$callMode[0] = $dispMode;
							$callMode[1] = $getKosu;
							$sumHourGenreMember_sumUseHourWeek[0] = $sumHourGenreMember;
							$sumHourGenreMember_sumUseHourWeek[1] = $sumUseHourWeek;
							$sumHourGenreMember_sumUseHourWeek[2] = $sumUseNinHourWeek;
							$sumKosuWeek = dispKosu($i,$dayinfo,$dataDate,$lastMonth,$phpSelf,$dayBuffer,$realMember,$getKosu,$sumHourGenreMember_sumUseHourWeek,$callMode);
						}
						
						break;
					default:
						echo("\t<tr>\n");
						for($j=0;$j<=6;$j++){
							$arrayDispCalendarDay = dispCalendarDay($i,$j,$dayinfo,$dataDate, $lastMonth);
							$style           = $arrayDispCalendarDay[0];
							$dispHolidayData = $arrayDispCalendarDay[1];
							$dispDate        = $arrayDispCalendarDay[2];
							$lastMonth       = $arrayDispCalendarDay[3];
							echo("\t\t<td width=\"100\">");
							echo("<div class=\"".$style."\"><a href=\"".$phpSelf."?mode=day&date=".$dataDate[$i*7+$j]."\">".$dispDate."</a></div>");
							if(date("Ymd") == $dataDate[$i*7+$j]){
								echo("<div class='today'>&nbsp;</div>\n");
							}
							echo($dispHolidayData);
							echo("<span class=\"c1\">");
							foreach($dayBuffer[$i*7+$j] as $key => $value){
								echo $dayBuffer[$i*7+$j][$key][16];
							}
							echo("</span>");
							echo("</td>\n");
						}
						echo("\t</tr>\n");
						break;
				}
			}
		echo("</table>\n");
		break;
	}

	if(($getMode != "day")&&($getMode != "daydet")){
		echo("\n");
		echo("<div class=\"footer\">\n");
		for($i=STARTYEAR;$i<=ENDYEAR;$i++){
			$weeksOfYear = getWeekNumber(mktime(0, 0, 0, 12, 31, $i));
			if(date("Y") == $i){
				echo("<span class='currentYear'>\n");
			}
			echo("\t<a href=\"".$phpSelf."?mode=month&date=".$i."0101&weeks=".$weeksOfYear."\">".$i."年</a>&nbsp;&nbsp;");
			for($j=1;$j<=12;$j++){
				echo("<a href=\"".$phpSelf."?mode=month&date=".$i.sprintf("%02d",$j)."01\">".$j."月</a>&nbsp;&nbsp;");
			}
			if(date("Y") == $i){
				echo("</span>\n");
			}
			echo("<br>\n");
		}
		echo("\t<input type=\"hidden\" value=\"$currentDate\" name=\"curdate\">\n");
		echo("\t<br>");
		echo(showHanreiFooter(1));
		echo("</div>\n");
		echo("<div class=\"footer2\">\n");
		if(LOGO_DISP != false){
			echo("<span class='footerlogo'><a href='http://www.unicale.com'><img src='img/title_s.gif' alt='UNICALE' border='0'></a></span>");
		}
		echo("<br><a href=\"index.rdf\"><img src=\"img/rss.gif\" border=\"0\">&nbsp;RSS1.0</a>&nbsp;&nbsp;\n");
//		echo("<a href=\"".$phpSelf."?mode=export\"><img src=\"img/iCal2.0.png\" alt=\"iCalendar\" border=\"0\"></a>&nbsp;&nbsp;\n");
		echo("<span id=\"res\" style='background: #FFB0B0' title=\"Now Generating\">iCal</span>&nbsp;<a href=\"".$phpSelf."?mode=export\" title=\"Now Generating\">rebuild</a>&nbsp;&nbsp;\n");
		echo("<span id=\"rescsv\" style='background: #FFB0B0'\" title=\"Now Generating\">CSV</span>&nbsp;<a href=\"".$phpSelf."?mode=csvexport\" title=\"Now Generating\">rebuild</a>&nbsp;&nbsp;\n");
		echo("<span id=\"rescsvpsn\" style='background: #FFB0B0'\" title=\"Now Generating\">CSV(Person)</span>&nbsp;<a href=\"".$phpSelf."?mode=csvexport&csvmode=1\" title=\"Now Generating\">rebuild</a>\n");
		echo("<br>\n");
		echo("ブックマークレット：&nbsp;");
		echo("<a href=\"javascript:(function(){x=document;y=window;if(x.selection) {Q=x.selection.createRange().text;} else if (y.getSelection) {Q=y.getSelection();} else if (x.getSelection) {Q=x.getSelection();};m='".$phpSelfABS."?mode=wrt&ref=bm&bw=ie&eventinfo='+encodeURIComponent(Q);y.open(m,'_blank','');})();\">".$title."クイックメモ</a>&nbsp;");
		if(LOGO_DISP != false){
			echo(dispCopyright(UNICALE_VERSION)."\n");
		}
		echo("</div>\n");
	}
?>
</form>
</div>

</body>
</html>

<?php
function getRequest($name, $default = ''){
	if(isset($_GET[$name])) {
		return($_GET[$name]);
	} else {
		if(isset($_POST[$name])){
			return($_POST[$name]);
		}
	}
	return($default);
}

function Sanitize($str){
	$tempStr = trim($str);
	$tempStr = htmlspecialchars($tempStr, ENT_QUOTES);
	$sanitizeTableArray = array();
	$sanitizeTableArray[0] = array("\r\n", "<br>");
	$sanitizeTableArray[1] = array("\n",   "<br>");
	$sanitizeTableArray[2] = array("\t",   " ");
	for($i=0;$i<count($sanitizeTableArray);$i++){
		$tempStr = str_replace($sanitizeTableArray[$i][0],$sanitizeTableArray[$i][1],$tempStr);
	}
	return($tempStr);
}

function scriptURI(){
	$fullURI = "http://";
	if(isset($_SERVER['HTTPS'])){
		if(!is_null($_SERVER['HTTPS'])){
			$fullURI = "https://";
		}
	}
	$fullURI .= $_SERVER['HTTP_HOST'];
	if($_SERVER['SERVER_PORT'] != 80){
		$fullURI .= ":". $_SERVER['SERVER_PORT'];
	}
	$fullURI .= $_SERVER['SCRIPT_NAME'];
	return($fullURI);
}

function showHanrei($Member = array()){
	$fullMemberList = fullMemberList();
	$outputStrHeader  = "<div id=\"header2\">\n";
	$outputStrHeader .= "\t<div class=\"hanrei\">\n";
	$outputStrMain = "";
	for($i=0;$i<count($fullMemberList);$i++){
		if($fullMemberList[$i][3] != 0){
			$checked = "";
			if(!empty($Member)){
				$tmpMember = $fullMemberList[$i][0];
				if(array_search($tmpMember,$Member) !== FALSE){
					$checked = " CHECKED";
				}
			}
			$separateSpace = "";
			for($j=0;$j<=$fullMemberList[$i][5];$j++){
				$separateSpace .= "&nbsp;";
			}
			if($fullMemberList[$i][6] == 1){
				$outputStrMain .= "\t\t".$separateSpace."<span class=\"mem".$fullMemberList[$i][0]."color\"><input type=\"checkbox\" name=\"chkMember[]\" value=\"".$fullMemberList[$i][0]."\"".$checked."></span><span class=\"size1\">".$fullMemberList[$i][1]."</span>&nbsp;\n";
			}else{
				$outputStrMain .= "\t\t".$separateSpace."<span class=\"mem".$fullMemberList[$i][0]."color\"><input type=\"checkbox\" name=\"chkMember[]\" value=\"".$fullMemberList[$i][0]."\"".$checked."></span>".$fullMemberList[$i][1]."\n";
			}
		}
	}
	$outputStrFooter  = "\t</div>\n";
	$outputStrFooter .= "</div>\n";
	$outputStr = $outputStrHeader.$outputStrMain.$outputStrFooter;
	return($outputStr);
}

function showHanreiFooter($col){
	$fullMemberList = fullMemberList();
	$outputStrHeader = "\n\t<div class=\"hanrei2\">\n";
	$outputStrMain = "";
	for($i=0;$i<count($fullMemberList);$i++){
		if($fullMemberList[$i][3] != 0){
			$outputStrMain .= "\t\t<span class=\"mem".$fullMemberList[$i][0]."colorTEXT\">■</span>".$fullMemberList[$i][$col]." \n";
		}
	}
	$outputStrFooter  = "\t</div>\n";

	$outputStr = $outputStrHeader.$outputStrMain.$outputStrFooter;
	return($outputStr);
}

function searchFullMemberList($searchString,$col){
	$fullMemberList = fullMemberList();
	for($i=0;$i<count($fullMemberList);$i++){
		if($searchString == $fullMemberList[$i][0]){
			return($fullMemberList[$i][$col]);
		}
	}
}

function startTimeArray($hourunit_type){
	$startTimeArray = array();
	if($hourunit_type == 1){
		$startTimeArray = array();
		$startTimeArray[0] = Array("ALL1","(未定)");
		$startTimeArray[1] = Array("ALL2","終日");
		$startTimeArray[2] = Array("午前","午前");
		$startTimeArray[3] = Array("午後","午後");
		$startTimeArray[4] = Array("0500"," 5:00");
		$startTimeArray[5] = Array("0515"," 5:15");
		$startTimeArray[6] = Array("0530"," 5:30");
		$startTimeArray[7] = Array("0545"," 5:45");
		$startTimeArray[8] = Array("0600"," 6:00");
		$startTimeArray[9] = Array("0615"," 6:15");
		$startTimeArray[10] = Array("0630"," 6:30");
		$startTimeArray[11] = Array("0645"," 6:45");
		$startTimeArray[12] = Array("0700"," 7:00");
		$startTimeArray[13] = Array("0715"," 7:15");
		$startTimeArray[14] = Array("0730"," 7:30");
		$startTimeArray[15] = Array("0745"," 7:45");
		$startTimeArray[16] = Array("0800"," 8:00");
		$startTimeArray[17] = Array("0815"," 8:15");
		$startTimeArray[18] = Array("0830"," 8:30");
		$startTimeArray[19] = Array("0845"," 8:45");
		$startTimeArray[20] = Array("0900"," 9:00");
		$startTimeArray[21] = Array("0915"," 9:15");
		$startTimeArray[22] = Array("0930"," 9:30");
		$startTimeArray[23] = Array("0945"," 9:45");
		$startTimeArray[24] = Array("1000","10:00");
		$startTimeArray[25] = Array("1015","10:15");
		$startTimeArray[26] = Array("1030","10:30");
		$startTimeArray[27] = Array("1045","10:45");
		$startTimeArray[28] = Array("1100","11:00");
		$startTimeArray[29] = Array("1115","11:15");
		$startTimeArray[30] = Array("1130","11:30");
		$startTimeArray[31] = Array("1145","11:45");
		$startTimeArray[32] = Array("1200","12:00");
		$startTimeArray[33] = Array("1215","12:15");
		$startTimeArray[34] = Array("1230","12:30");
		$startTimeArray[35] = Array("1245","12:45");
		$startTimeArray[36] = Array("1300","13:00");
		$startTimeArray[37] = Array("1315","13:15");
		$startTimeArray[38] = Array("1330","13:30");
		$startTimeArray[39] = Array("1345","13:45");
		$startTimeArray[40] = Array("1400","14:00");
		$startTimeArray[41] = Array("1415","14:15");
		$startTimeArray[42] = Array("1430","14:30");
		$startTimeArray[43] = Array("1445","14:45");
		$startTimeArray[44] = Array("1500","15:00");
		$startTimeArray[45] = Array("1515","15:15");
		$startTimeArray[46] = Array("1530","15:30");
		$startTimeArray[47] = Array("1545","15:45");
		$startTimeArray[48] = Array("1600","16:00");
		$startTimeArray[49] = Array("1615","16:15");
		$startTimeArray[50] = Array("1630","16:30");
		$startTimeArray[51] = Array("1645","16:45");
		$startTimeArray[52] = Array("1700","17:00");
		$startTimeArray[53] = Array("1715","17:15");
		$startTimeArray[54] = Array("1730","17:30");
		$startTimeArray[55] = Array("1745","17:45");
		$startTimeArray[56] = Array("1800","18:00");
		$startTimeArray[57] = Array("1815","18:15");
		$startTimeArray[58] = Array("1830","18:30");
		$startTimeArray[59] = Array("1845","18:45");
		$startTimeArray[60] = Array("1900","19:00");
		$startTimeArray[61] = Array("1915","19:15");
		$startTimeArray[62] = Array("1930","19:30");
		$startTimeArray[63] = Array("1945","19:45");
		$startTimeArray[64] = Array("2000","20:00");
		$startTimeArray[65] = Array("2015","20:15");
		$startTimeArray[66] = Array("2030","20:30");
		$startTimeArray[67] = Array("2045","20:45");
		$startTimeArray[68] = Array("2100","21:00");
		$startTimeArray[69] = Array("2115","21:15");
		$startTimeArray[70] = Array("2130","21:30");
		$startTimeArray[71] = Array("2145","21:45");
		$startTimeArray[72] = Array("2200","22:00");
		$startTimeArray[73] = Array("2215","22:15");
		$startTimeArray[74] = Array("2230","22:30");
		$startTimeArray[75] = Array("2245","22:45");
		$startTimeArray[76] = Array("2300","23:00");
		$startTimeArray[77] = Array("2315","23:15");
		$startTimeArray[78] = Array("2330","23:30");
		$startTimeArray[79] = Array("2345","23:45");
		$startTimeArray[80] = Array("2400","24:00");
	}else{
		$startTimeArray[0] = Array("ALL1","(未定)");
		$startTimeArray[1] = Array("ALL2","終日");
		$startTimeArray[2] = Array("午前","午前");
		$startTimeArray[3] = Array("午後","午後");
		$startTimeArray[4]  = Array("0500"," 5:00");
		$startTimeArray[5]  = Array("0530"," 5:30");
		$startTimeArray[6]  = Array("0600"," 6:00");
		$startTimeArray[7]  = Array("0630"," 6:30");
		$startTimeArray[8]  = Array("0700"," 7:00");
		$startTimeArray[9]  = Array("0730"," 7:30");
		$startTimeArray[10] = Array("0800"," 8:00");
		$startTimeArray[11] = Array("0830"," 8:30");
		$startTimeArray[12] = Array("0900"," 9:00");
		$startTimeArray[13] = Array("0930"," 9:30");
		$startTimeArray[14] = Array("1000","10:00");
		$startTimeArray[15] = Array("1030","10:30");
		$startTimeArray[16] = Array("1100","11:00");
		$startTimeArray[17] = Array("1130","11:30");
		$startTimeArray[18] = Array("1200","12:00");
		$startTimeArray[19] = Array("1230","12:30");
		$startTimeArray[20] = Array("1300","13:00");
		$startTimeArray[21] = Array("1330","13:30");
		$startTimeArray[22] = Array("1400","14:00");
		$startTimeArray[23] = Array("1430","14:30");
		$startTimeArray[24] = Array("1500","15:00");
		$startTimeArray[25] = Array("1530","15:30");
		$startTimeArray[26] = Array("1600","16:00");
		$startTimeArray[27] = Array("1630","16:30");
		$startTimeArray[28] = Array("1700","17:00");
		$startTimeArray[29] = Array("1730","17:30");
		$startTimeArray[30] = Array("1800","18:00");
		$startTimeArray[31] = Array("1830","18:30");
		$startTimeArray[32] = Array("1900","19:00");
		$startTimeArray[33] = Array("1930","19:30");
		$startTimeArray[34] = Array("2000","20:00");
		$startTimeArray[35] = Array("2030","20:30");
		$startTimeArray[36] = Array("2100","21:00");
		$startTimeArray[37] = Array("2130","21:30");
		$startTimeArray[38] = Array("2200","22:00");
		$startTimeArray[39] = Array("2230","22:30");
		$startTimeArray[40] = Array("2300","23:00");
		$startTimeArray[41] = Array("2330","23:30");
		$startTimeArray[42] = Array("2400","24:00");
	}
	return($startTimeArray);
}
function searchStartTime($searchString,$hourunit_type){
	$startTimeArray = startTimeArray($hourunit_type);
	for($i=2;$i<count($startTimeArray);$i++){
		if($searchString == $startTimeArray[$i][0]){
			return($startTimeArray[$i][1]);
		}
	}
	if(($searchString != "")&&(is_numeric($searchString))){
		$neartime = substr($searchString,0,2).":00";
		return($neartime);
	}
}

function endTimeArray($hourunit_type){
	if($hourunit_type == 1){
		$endTimeArray = array();
		$endTimeArray[0]  = Array(""," --- ");
		$endTimeArray[1] = Array("0500"," 5:00");
		$endTimeArray[2] = Array("0515"," 5:15");
		$endTimeArray[3] = Array("0530"," 5:30");
		$endTimeArray[4] = Array("0545"," 5:45");
		$endTimeArray[5] = Array("0600"," 6:00");
		$endTimeArray[6] = Array("0615"," 6:15");
		$endTimeArray[7] = Array("0630"," 6:30");
		$endTimeArray[8] = Array("0645"," 6:45");
		$endTimeArray[9] = Array("0700"," 7:00");
		$endTimeArray[10] = Array("0715"," 7:15");
		$endTimeArray[11] = Array("0730"," 7:30");
		$endTimeArray[12] = Array("0745"," 7:45");
		$endTimeArray[13] = Array("0800"," 8:00");
		$endTimeArray[14] = Array("0815"," 8:15");
		$endTimeArray[15] = Array("0830"," 8:30");
		$endTimeArray[16] = Array("0845"," 8:45");
		$endTimeArray[17] = Array("0900"," 9:00");
		$endTimeArray[18] = Array("0915"," 9:15");
		$endTimeArray[19] = Array("0930"," 9:30");
		$endTimeArray[20] = Array("0945"," 9:45");
		$endTimeArray[21] = Array("1000","10:00");
		$endTimeArray[22] = Array("1015","10:15");
		$endTimeArray[23] = Array("1030","10:30");
		$endTimeArray[24] = Array("1045","10:45");
		$endTimeArray[25] = Array("1100","11:00");
		$endTimeArray[26] = Array("1115","11:15");
		$endTimeArray[27] = Array("1130","11:30");
		$endTimeArray[28] = Array("1145","11:45");
		$endTimeArray[29] = Array("1200","12:00");
		$endTimeArray[30] = Array("1215","12:15");
		$endTimeArray[31] = Array("1230","12:30");
		$endTimeArray[32] = Array("1245","12:45");
		$endTimeArray[33] = Array("1300","13:00");
		$endTimeArray[34] = Array("1315","13:15");
		$endTimeArray[35] = Array("1330","13:30");
		$endTimeArray[36] = Array("1345","13:45");
		$endTimeArray[37] = Array("1400","14:00");
		$endTimeArray[38] = Array("1415","14:15");
		$endTimeArray[39] = Array("1430","14:30");
		$endTimeArray[40] = Array("1445","14:45");
		$endTimeArray[41] = Array("1500","15:00");
		$endTimeArray[42] = Array("1515","15:15");
		$endTimeArray[43] = Array("1530","15:30");
		$endTimeArray[44] = Array("1545","15:45");
		$endTimeArray[45] = Array("1600","16:00");
		$endTimeArray[46] = Array("1615","16:15");
		$endTimeArray[47] = Array("1630","16:30");
		$endTimeArray[48] = Array("1645","16:45");
		$endTimeArray[49] = Array("1700","17:00");
		$endTimeArray[50] = Array("1715","17:15");
		$endTimeArray[51] = Array("1730","17:30");
		$endTimeArray[52] = Array("1745","17:45");
		$endTimeArray[53] = Array("1800","18:00");
		$endTimeArray[54] = Array("1815","18:15");
		$endTimeArray[55] = Array("1830","18:30");
		$endTimeArray[56] = Array("1845","18:45");
		$endTimeArray[57] = Array("1900","19:00");
		$endTimeArray[58] = Array("1915","19:15");
		$endTimeArray[59] = Array("1930","19:30");
		$endTimeArray[60] = Array("1945","19:45");
		$endTimeArray[61] = Array("2000","20:00");
		$endTimeArray[62] = Array("2015","20:15");
		$endTimeArray[63] = Array("2030","20:30");
		$endTimeArray[64] = Array("2045","20:45");
		$endTimeArray[65] = Array("2100","21:00");
		$endTimeArray[66] = Array("2115","21:15");
		$endTimeArray[67] = Array("2130","21:30");
		$endTimeArray[68] = Array("2145","21:45");
		$endTimeArray[69] = Array("2200","22:00");
		$endTimeArray[70] = Array("2215","22:15");
		$endTimeArray[71] = Array("2230","22:30");
		$endTimeArray[72] = Array("2245","22:45");
		$endTimeArray[73] = Array("2300","23:00");
		$endTimeArray[74] = Array("2315","23:15");
		$endTimeArray[75] = Array("2330","23:30");
		$endTimeArray[76] = Array("2345","23:45");
		$endTimeArray[77] = Array("2400","24:00");
	}else{
		$endTimeArray[0]  = Array(""," --- ");
		$endTimeArray[1]  = Array("0500"," 5:00");
		$endTimeArray[2]  = Array("0530"," 5:30");
		$endTimeArray[3]  = Array("0600"," 6:00");
		$endTimeArray[4]  = Array("0630"," 6:30");
		$endTimeArray[5]  = Array("0700"," 7:00");
		$endTimeArray[6]  = Array("0730"," 7:30");
		$endTimeArray[7]  = Array("0800"," 8:00");
		$endTimeArray[8]  = Array("0830"," 8:30");
		$endTimeArray[9]  = Array("0900"," 9:00");
		$endTimeArray[10] = Array("0930"," 9:30");
		$endTimeArray[11] = Array("1000","10:00");
		$endTimeArray[12] = Array("1030","10:30");
		$endTimeArray[13] = Array("1100","11:00");
		$endTimeArray[14] = Array("1130","11:30");
		$endTimeArray[15] = Array("1200","12:00");
		$endTimeArray[16] = Array("1230","12:30");
		$endTimeArray[17] = Array("1300","13:00");
		$endTimeArray[18] = Array("1330","13:30");
		$endTimeArray[19] = Array("1400","14:00");
		$endTimeArray[20] = Array("1430","14:30");
		$endTimeArray[21] = Array("1500","15:00");
		$endTimeArray[22] = Array("1530","15:30");
		$endTimeArray[23] = Array("1600","16:00");
		$endTimeArray[24] = Array("1630","16:30");
		$endTimeArray[25] = Array("1700","17:00");
		$endTimeArray[26] = Array("1730","17:30");
		$endTimeArray[27] = Array("1800","18:00");
		$endTimeArray[28] = Array("1830","18:30");
		$endTimeArray[29] = Array("1900","19:00");
		$endTimeArray[30] = Array("1930","19:30");
		$endTimeArray[31] = Array("2000","20:00");
		$endTimeArray[32] = Array("2030","20:30");
		$endTimeArray[33] = Array("2100","21:00");
		$endTimeArray[34] = Array("2130","21:30");
		$endTimeArray[35] = Array("2200","22:00");
		$endTimeArray[36] = Array("2230","22:30");
		$endTimeArray[37] = Array("2300","23:00");
		$endTimeArray[38] = Array("2330","23:30");
		$endTimeArray[39] = Array("2400","24:00");
	}
	return($endTimeArray);
}
function searchEndTime($searchString,$hourunit_type){
	$endTimeArray = endTimeArray($hourunit_type);
	for($i=1;$i<count($endTimeArray);$i++){
		if($searchString == $endTimeArray[$i][0]){
			return($endTimeArray[$i][1]);
		}
	}
	if(($searchString != "")&&(is_numeric($searchString))){
		$neartime = substr($searchString,0,2).":00";
		return($neartime);
	}
}

function searchGenreArray($searchString){
	$genreArray = genreArray();
	for($i=0;$i<count($genreArray);$i++){
		if($searchString == $genreArray[$i][0]){
			return($genreArray[$i][1]);
		}
	}
}

function KosuArray(){
	$kosuArray = array();
	for($i=0;$i<=12;$i++){
		$kosuArray[$i] = Array($i,$i);
	}
	return($kosuArray);
}
function searchKosuArray($searchString){
	$kosuArray = kosuArray();
	for($i=0;$i<count($kosuArray);$i++){
		if($searchString == $kosuArray[$i][0]){
			return($kosuArray[$i][1]);
		}
	}
}

function dispTimeListBox($selectedStartTime = "",$selectedEndTime = "", $eventinfo = "", $place = "", $sbmtName = "登録", $genre = "000",$hourunit_type){
	echo("<td class=\"normal\">\n");
	echo("\t時刻<select name=\"starttime\" title=\"開始時刻\">\n");
	$startTimeArray = startTimeArray($hourunit_type);	
	for($i=0;$i<count($startTimeArray);$i++){
		$selected = "";
		if($startTimeArray[$i][0] == $selectedStartTime){
			$selected = " SELECTED";
		}
		echo("\t\t<option value=\"".$startTimeArray[$i][0]."\"".$selected.">".$startTimeArray[$i][1]."</option>\n");
	}
	echo("\t</select>〜\n");
	echo("\t<select name=\"endtime\" title=\"終了時刻\">\n");
	$endTimeArray = endTimeArray($hourunit_type);	
	for($i=0;$i<count($endTimeArray);$i++){
		$selected = "";
		if($endTimeArray[$i][0] == $selectedEndTime){
			$selected = " SELECTED";
		}
		echo("\t\t<option value=\"".$endTimeArray[$i][0]."\"".$selected.">".$endTimeArray[$i][1]."</option>\n");
	}
	echo("\t</select>\n");
	echo("</td>\n");
	echo("<td class=\"normal\">\n");
	echo("\t用事<input type=\"text\" name=\"eventinfo\" size=\"30\" value=\"".$eventinfo."\">&nbsp;\n");
	echo("\t場所<input type=\"text\" name=\"place\" size=\"24\" value=\"".$place."\">\n");

	echo("\t<select name=\"genre\" title=\"予定のジャンル\">\n");
	$genreArray = genreArray();	
	for($i=0;$i<count($genreArray);$i++){
		$selected = "";
		if($genreArray[$i][0] == $genre){
			$selected = " SELECTED";
		}
		$optionCaption = $genreArray[$i][1];
		if($genreArray[$i][2] ==1){
			$optionCaption = "[集計] ".$optionCaption;
		}
		echo("\t\t<option class=\"genre".sprintf("%03d",$i)."color\" value=\"".$genreArray[$i][0]."\"".$selected.">".$optionCaption."</option>\n");
	}
	echo("</select>\n");
	echo("</td>\n");
	echo("<td class=\"normal\">\n");
	echo("\t<input type=\"submit\" name=\"sbmt\" value=\"".$sbmtName ."\">\n");
	echo("</td>\n");
	echo("</tr>\n");
	echo("</table>\n");
	echo("</div>\n");
}
function chofukuData($startDateFormat,$getEventInfo,$basedir,$YY,$MM){
	$sameFlag = false;
	for($j=0;$j<EVENT_MAX;$j++){
		$fNumber = sprintf("%02d", $j);
		$checkFileName = $basedir.$YY."/".$MM."/".$startDateFormat."_".$fNumber.".dat";
		if(file_exists($checkFileName)){
			$fSize = filesize($checkFileName) + 1;
			if(FILE_LOCK)lock($checkFileName);
			$handle = fopen($checkFileName, "r");
			$readCounter = 0;
			$buffer = array();
			if($handle){
				while ($line = fgets($handle, $fSize)) {
					$buffer[$readCounter] = chop($line);
					$readCounter++;
				}
				fclose($handle);
			}
			if(FILE_LOCK)unlock($checkFileName);
			$eventInfo = $buffer[3];
			if(trim($getEventInfo) == trim($eventInfo)){
				$sameFlag = true;
				break;
			}
		}
	}
	return($sameFlag);
}

function searchNewFileName($basedir,$YY,$MM,$searchDateFile){
	$newFileName = "";
	$dataDir = $basedir.$YY."/".$MM;
	if (!@opendir($dataDir)) {
		mkdir($dataDir, 0777, true); // WIN32(Writable),UNIX/Linux (Guess Writable)
	}
	for($i=0;$i<EVENT_MAX;$i++){
		$fNumber = sprintf("%02d", $i);
		$checkFileName = $dataDir."/".$searchDateFile."_".$fNumber.".dat";
		if(!file_exists($checkFileName)){
			$newFileName = $checkFileName;
			break;
		}
	}
	return($newFileName);
}

function calcUseHour($startTime, $endTime){
	$useHour = 0;
	switch ($startTime){
		case "ALL1":
			$useHour = KOSU_ALL1;
			break;
		case "ALL2":
			$useHour = KOSU_ALL2;
			break;
		case "午前":
			$useHour = KOSU_AM;
			break;
		case "午後":
			$useHour = KOSU_PM;
			break;
		default:
			if(ereg("^[0-9]+$", $startTime)){
			//StartTimeが数字
				$tmpStartTime = str_pad($startTime,4,"0",STR_PAD_LEFT);
				$minStartTime = substr($tmpStartTime,0,2)*60 + substr($tmpStartTime,2,2);
				if(ereg("^[0-9]+$", $endTime)){
					$tmpEndTime = str_pad($endTime,4,"0",STR_PAD_LEFT);
					$minEndTime = substr($tmpEndTime,0,2)*60 + substr($tmpEndTime,2,2);
					$useHour = ($minEndTime - $minStartTime)/60;
				}else{
					if($endTime == ""){
						$useHour = KOSU_STARTONLY_HOUR; //開始だけ時刻指定の場合は2時間
					}else{
						$useHour = KOSU_STARTONLY_HOUR;
						echo("終了時刻が変！");
					}
				}
			}
	}
	return($useHour);
}
function permChangeError(){
}

function sortByGenre($p1, $p2) {
	if($p1 == "")$p1 = "999";
	if($p2 == "")$p2 = "999";
	if($p1 == "000")$p1 = "999";
	if($p2 == "000")$p2 = "999";
	if ($p1[6] == $p2[6]) return 0;
	return ($p1[6] < $p2[6]) ? -1 : 1;
}

function sortByFilecreateTime($p1, $p2) {
	if ($p1[11] == $p2[11]) return 0;
	return ($p1[11] < $p2[11]) ? -1 : 1;
}

function sortByFilemodifiedTime($p1, $p2) {
	if ($p1[12] == $p2[12]) return 0;
	return ($p1[12] < $p2[12]) ? -1 : 1;
}

function sortByFileNumber($p1, $p2) {
	if ($p1[17] == $p2[17]) return 0;
	return ($p1[17] < $p2[17]) ? -1 : 1;
}

function sortByStartTime($p1, $p2) {
	if($p1[1]=="午前"){$p1[1]="0800";}
	if($p2[1]=="午前"){$p2[1]="0800";}
	if($p1[1]=="午後"){$p1[1]="1250";}
	if($p2[1]=="午後"){$p2[1]="1250";}
	if($p1[1]=="ALL2"){$p1[1]="0600";}
	if($p2[1]=="ALL2"){$p2[1]="0600";}
	if($p1[1]=="ALL1"){$p1[1]="0500";}
	if($p2[1]=="ALL1"){$p2[1]="0500";}

	if ($p1[1] == $p2[1]) return 0;
	return ($p1[1] < $p2[1]) ? -1 : 1;
}

function dispCalendarDay($i,$j,$dayinfo,$dataDate,$lastMonth){
	$holidayData = holidayData();
	$holidayDataStatic = holidayDataStatic();
	$style = "";
	$dispDate = "";
	switch($j){
		case 0:
			$style = "datesun";
			break;
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
			$style = "datenormal";
			break;
		case 6:
			$style = "datesat";
			break;
	}	
	$dispHolidayData = "";

	$holidayMMDD = substr($dataDate[$i*7+$j],-4);
	if(isset($holidayDataStatic[$holidayMMDD])){
		if($holidayDataStatic[$holidayMMDD] != ""){
			$dispHolidayData = "<span class=\"holiday\">".$holidayDataStatic[$holidayMMDD]."</span><br>";
			$style = "datesun";
		}
	}

	//preferred holiday
	if(isset($holidayData[$dataDate[$i*7+$j]])){
		if($holidayData[$dataDate[$i*7+$j]] != ""){
			$dispHolidayData = "<span class=\"holiday\">".$holidayData[$dataDate[$i*7+$j]]."</span><br>";
			$style = "datesun";
		}
	}

	if(($i==0)&&($j==0)){
		$dispDate = date("Y",$dayinfo[$i*7+$j])."/".date("n",$dayinfo[$i*7+$j])."/".date("j",$dayinfo[$i*7+$j]);
		$lastMonth = date("n",$dayinfo[$i*7+$j]);
	}else{
		if(date("j",$dayinfo[$i*7+$j])=="1"){
			$dispDate = date("Y",$dayinfo[$i*7+$j])."/".date("n",$dayinfo[$i*7+$j])."/".date("j",$dayinfo[$i*7+$j]);
			$lastMonth = date("n",$dayinfo[$i*7+$j]);
		}else{
			$tmpMonth = date("n",$dayinfo[$i*7+$j]);
			if($lastMonth != $tmpMonth){
				$dispDate = date("n",$dayinfo[$i*7+$j])."/".date("j",$dayinfo[$i*7+$j]);
				$lastMonth = date("n",$dayinfo[$i*7+$j]);
			}else{
				$dispDate = date("j",$dayinfo[$i*7+$j]);
			}
		}
	}
	return(Array($style, $dispHolidayData, $dispDate,$lastMonth));
}

function rssHeader($title,$thisScriptURL,$last20PublishDate){
	$rssHeader  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$rssHeader .= "<rdf:RDF xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns=\"http://purl.org/rss/1.0/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\" xml:lang=\"ja\">\n";
	$rssHeader .= "	<channel rdf:about=\"".$thisScriptURL."\">\n";
	$rssHeader .= "		<title>".$title."</title>\n";
	$rssHeader .= "		<link>".$thisScriptURL."</link>\n";
	$rssHeader .= "		<description />\n";
	$rssHeader .= "		<dc:language>ja</dc:language>\n";
	$rssHeader .= "		<dc:date>".$last20PublishDate."</dc:date>\n";
	return($rssHeader);
}

function putRSS($getEventInfo,$getPlace,$startDateFormat,$getStartTime,$getEndTime,$getDetail,$getMember,$YY,$MM,$DD,$title,$basedir,$getSbmt,$hourunit_type){
	//rss用データ加工
	$last20PublishDateFirst = date("Y-m-d",mktime());
	$last20PublishDateSecond = date("H:i:s",mktime());
	$last20PublishDateThird = substr(date("O",mktime()),0,3).":".substr(date("O",mktime()),3,2);
	$last20PublishDate = $last20PublishDateFirst."T".$last20PublishDateSecond.$last20PublishDateThird;
	$last20Time = "";
	if($getEndTime != ""){
		$last20Time = searchStartTime(trim($getStartTime),$hourunit_type) ."-".searchEndTime($getEndTime,$hourunit_type);
	}else{
		$last20Time = searchStartTime(trim($getStartTime),$hourunit_type);
	}
	$last20Time = $YY."/".$MM."/".$DD." ".$last20Time;
	$last20title = "";
	if($getSbmt == "登録"){
		$last20title = "[NEW] ".$last20Time." ".$getEventInfo;
	}else{
		if($getSbmt == "実行"){
			$last20title = "[UP] " .$last20Time ." ".$getEventInfo;
		}else{
			$last20title = $last20Time ." ".$getEventInfo;
		}
	}
	if($getPlace != ""){
		$last20title .= "(".$getPlace.")";
	}
	$thisScriptURL = scriptURI();
	$last20link = $thisScriptURL."?mode=day2&amp;date=".$startDateFormat."&amp;ref=rss";	
	$last20Member = "";
	if(isset($getMember) == true){
		$last20MemberTmp = array();
		for($i=0;$i<count($getMember);$i++){
			$last20MemberTmp[$i] = searchFullMemberList($getMember[$i],1);
		}
		$last20Member = implode(" ", $last20MemberTmp);
		
	}else{
		$last20Member = "";
	}
	$last20Description = $last20Member ." ". $getDetail;
	$last20Description = str_replace("<br>"," ",$last20Description);

	$last20FileName = $basedir."last20.dat";

	$buffer = array();
	if(file_exists($last20FileName)){
		$handle = fopen($last20FileName, "r");
		$readCounter = 0;
		if($handle){
			while ($line = fgets($handle)) {
				$buffer[$readCounter] = chop($line);
				$readCounter++;
			}
			fclose($handle);
		}
	}
	array_push($buffer, $last20PublishDate."\t".$last20title."\t".$last20link."\t".$last20Description);
	$tailLast20Line = array_slice($buffer, -20);

	if(FILE_LOCK)lock($last20FileName);
	$handle = fopen($last20FileName, 'w');
	if($handle){
		for($i=0;$i<count($tailLast20Line);$i++){
			fwrite($handle, $tailLast20Line[$i]."\n");
		}
		fclose($handle);
	}
	if(FILE_LOCK)unlock($last20FileName);

	$rssHeader = rssHeader($title,$thisScriptURL,$last20PublishDate);
	$rdfLI  = "\t\t<items>\n";
	$rdfLI .= "\t\t\t<rdf:Seq>\n";
	$rdfITEM = "";
	for($i=0;$i<count($tailLast20Line);$i++){
		$rdfEntry = explode("\t",$tailLast20Line[$i]);
		$rdfLI   .= "\t\t\t<rdf:li rdf:resource=\"".$rdfEntry[2]."\" />\n";
		$rdfITEM .= "\t<item rdf:about=\"".$rdfEntry[2]."\">\n";
		$rdfITEM .= "\t\t<title>".$rdfEntry[1]."</title>\n";
		$rdfITEM .= "\t\t<link>".$rdfEntry[2]."</link>\n";
		$rdfITEM .= "\t\t<description>".$rdfEntry[3]."</description>\n";
		$rdfITEM .= "\t\t<dc:date>".$rdfEntry[0]."</dc:date>\n";
		$rdfITEM .= "\t</item>\n";
	}
	$rdfLI .= "\t\t\t</rdf:Seq>\n";
	$rdfLI .= "\t\t</items>\n";
	$rdfLI .= "\t</channel>\n";
	$rssFooter = "</rdf:RDF>";
	$rss = $rssHeader.$rdfLI.$rdfITEM.$rssFooter;

	$rss = mb_convert_encoding($rss, "UTF-8", "EUC-JP");
	if(FILE_LOCK)lock("index.rdf");
	$handle = fopen("index.rdf", 'w');
	if($handle){
		fwrite($handle, $rss);
		fclose($handle);
	}
	if(FILE_LOCK)unlock("index.rdf");
}

function lock($fileName){
	$lockdir= "data/lock/";
	$fileNamePathSlice = explode("/",$fileName);
	$fileNameOnly = array_pop($fileNamePathSlice);

	$lockfile= "$lockdir"."$fileNameOnly";
	$retryTimes = 5;

	if (file_exists($lockfile)) {
		$mtime = filemtime($lockfile);
		if ($mtime < time() - 30) { 
			if(FILE_LOCK)unlock($fileNameOnly);
		}
	}
	while (!@mkdir($lockfile, 0777)) {
		if ($retryTimes-- <= 0) {
			echo("<h2>只今アクセスが集中しています。</h2>しばらくしてからアクセスしてください。");
			exit;
		}
		sleep(1);
	}
}

function unlock($fileName) {
	$lockdir= "data/lock/";
	$fileNamePathSlice = explode("/",$fileName);
	$fileNameOnly = array_pop($fileNamePathSlice);
	$lockfile= "$lockdir"."$fileNameOnly";
	if (file_exists($lockfile)) {
		rmdir($lockfile);
	}
}

function dispGenreFlat(){
	$genreArray = genreArray();
	for($i=0;$i<count($genreArray);$i++){
		$optionCaption = $genreArray[$i][1];
		if($genreArray[$i][2] ==1){
			$optionCaption = "[集計] ".$optionCaption;
		}
		echo("\t\t<span class=\"genre".sprintf("%03d",$i)."color\" value=\"".$genreArray[$i][0]."\" style=\"font-size:80%; color: #666666; padding: 0.5em;\">".$optionCaption."</span>\n");
	}
	echo("<br>\n");
	echo("<br>\n");
}

// 週数カウント対応
function getWeekNumber($inDate){
	$dayNumber   = date('z', $inDate) + 1;
	$weekStart   = date("w", mktime(0, 0, 0, 1, 1, date("Y",$inDate)));
	$weeksOfYear = ceil($dayNumber / 7);
	if((($dayNumber % 7) > (7 - $weekStart)) || (($dayNumber % 7) == 0 && 0 < $weekStart)){
		$weeksOfYear ++;
	}
	return($weeksOfYear);
}

// 週数カウント対応
function getWeeksCount($inYear,$inMonth){
	$weekNumStart = getWeekNumber(mktime(0,0,0,$inMonth,1,$inYear));
	$weekNumEnd   = getWeekNumber(mktime(0,0,0,$inMonth,date("t", mktime(0,0,0,$inMonth,1,$inYear)),$inYear));
	return($weekNumEnd - $weekNumStart + 1);
}

function dispNaviMonth($phpSelf){
	$currentDate = mktime();
	$getYear =  date("Y",$currentDate);
	$getMonth = sprintf("%02d",date("m",$currentDate));
	$arrDispMonth = Array("04","05","06","07","08","09","10","11","12","01","02","03");
	$naviYear = $getYear;
	if($getMonth <= 3){
		$naviYear --;
	}
	$monthNaviStr = "";
	for($i=0;$i<12;$i++){
		$linkStr = "";
		if(($i==0)||($i==9)){
			if($i==9){
				$naviYear ++;
				$linkStr .= "&nbsp;&nbsp;";
			}
			$linkStr .= "<span class=\"silent\">".$naviYear."</span>";
		}
		$naviMonth = $arrDispMonth[$i];
		if($getMonth == $arrDispMonth[$i]){
			$naviMonth = "<span class=\"currentMonth\">".$naviMonth."</span>";
		}
		$linkStr .= "&nbsp;&nbsp;<a href=\"".$phpSelf."?mode=month&date=".$naviYear.$arrDispMonth[$i]."01\">".$naviMonth."</a>";
		$monthNaviStr .= $linkStr;
	}
	$monthNaviStr = "<span class=\"monthNavi\">".$monthNaviStr."</span>";
	echo($monthNaviStr);
}


function exportData($startYear,$endYear,$basedir,$phpSelf,$title,$exportforce,$hourunit_type){
	//$exportforce =1 : exportforce
	echo("<html>\n");
	echo("<head>\n");
	echo("<title>".$title." iCalendar出力</title>\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"ucal_common.css\"  media=\"all\">\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"ucal.css\"  media=\"all\">\n");
	echo("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=EUC-JP\">\n");
	echo("</head>\n");
	echo("<body>\n");
	echo("<div id=\"pageimage\">\n");
	echo("<a href=\"".$phpSelf."\" class=\"headerh1\">\n");
	echo("<h1>".$title." </h1>\n");
	echo("</a>\n");

	$icalTempFileName = $basedir."exporttemp.ics";
	$icalFileName = $basedir."export.ics";
	$icalFilelastModified = 0;
	if(!file_exists($icalFileName)){
		$icalFilelastModified = time();
		$exportforce = 1;
	}else{
		$icalFilelastModified = filemtime($icalFileName);
	}
	$currentTime = time();
	$outputStringDay = array();
	if(((($currentTime - $icalFilelastModified)/60) > ICAL_CREATE_INTERVAL)||($exportforce == 1)){
		echo("<h2>iCalendar出力処理中です</h2>\n");
		echo("iCalendarファイル作成間隔は".ICAL_CREATE_INTERVAL."分です。");

		$outputStringDay[0] = "";
		$lineCounter = 0;
		$checkFileName = "";
		for($readYY=$startYear;$readYY<=$endYear;$readYY++){
			for($readMM=1;$readMM<=12;$readMM++){
				$currentLastday = date("t", mktime(0, 0, 0, $readMM, 1, $readYY));
				for($readDD = 1; $readDD <= $currentLastday; $readDD++){
					for($j=0;$j<EVENT_MAX;$j++){
						$fNumber = sprintf("%02d", $j);
						$YY = sprintf("%04d",$readYY);
						$MM = sprintf("%02d",$readMM);
						$DD = sprintf("%02d",$readDD);
						$checkFileName = $basedir.$YY."/".$MM."/".$YY.$MM.$DD."_".$fNumber.".dat";
						
						$buffer = array();
						$eventOutString = "";
						if(file_exists($checkFileName)){
							$fSize = filesize($checkFileName) + 1;
							if(FILE_LOCK)lock($checkFileName);
							$handle = fopen($checkFileName, "r");
							$readCounter = 0;
							if($handle){
								while ($line = fgets($handle, $fSize)) {
									$buffer[$readCounter] = chop($line);
									$readCounter++;
								}
								fclose($handle);
							}
							if(FILE_LOCK)unlock($checkFileName);
							$Member = explode(" ",trim($buffer[5]));
							
							$startTime = searchStartTime($buffer[1],$hourunit_type);
							if($startTime > 2){
								$startTime = $startTime . "-";
							}
							$endTime = searchEndTime($buffer[2],$hourunit_type);
							if(trim($endTime) != ""){
								$endTime = $endTime."&nbsp; ";
							}
							$place = trim($buffer[4]);
							if($place != ""){
								$place = "(".$place.")";
							}
							$eventInfo = $buffer[3];
							if($buffer[10] != ""){
								$eventInfo .= "...";
							}
							$genreName = searchGenreArray($buffer[6]);
							$eventOutString = $startTime.$endTime.$eventInfo.$place;
							if($buffer[6]==""){
								$buffer[6] = "999";
							}
							if($buffer[6]=="000"){
								$buffer[6] = "999";
							}

							//0         1           2           3           4           5        6           7               8      9      10            11                12                13        14      15        16             17
						    //Date      StartTIme   EndTime     EventInfo   Place       member   Genre       Silent          Dummy  Dummy  EventDetail   ファイル作成日時  ファイル更新日時  時間      人数    人時      出力用文字列   fileNumber
	//						$buffer[0], $buffer[1], $buffer[2], $buffer[3], $buffer[4], $Member, $buffer[6], $buffer[7],    "",    "",    $buffer[10],  $fileCreatedDate, $lastModified,   $useHour, $ninzu ,$ninHour, $outputString, $fNumber

							$outputStringforSearch = "";

							$outputMemberList = "";
							for($k=0;$k<count($Member);$k++){
								$memberMiddle = searchFullMemberList($Member[$k],1);
								if($memberMiddle != ""){
									$outputMemberList .= "[".$memberMiddle."]";
								}
							}
							if($outputMemberList != ""){
								$outputMemberList = "/". $outputMemberList;
							}

							$genreName = searchGenreArray($buffer[6]);
							$outputGenre = "";
							if($buffer[6] != "999"){
								$outputGenre = "[".trim($genreName)."]";
							}
							$outputStringforSearch .= "BEGIN:VEVENT\n";
							if(is_numeric($buffer[1])){
								$dtStart =  mktime(substr($buffer[1],0,2),substr($buffer[1],2,2),0,substr($buffer[0],4,2),substr($buffer[0],6,2),substr($buffer[0],0,4));
								$dtStart = strtotime(TIMEZONEHOUR."hours",$dtStart);
								$dtStart = date("Ymd\THis\Z",$dtStart);
								$outputStringforSearch .= "DTSTART:".$dtStart;
							}else{
								$outputStringforSearch .= "DTSTART;VALUE=DATE:".trim($buffer[0]);
							}
							$outputStringforSearch .= "\n";
							if(is_numeric($buffer[2])){
								$dtEnd =  mktime(substr($buffer[2],0,2),substr($buffer[2],2,2),0,substr($buffer[0],4,2),substr($buffer[0],6,2),substr($buffer[0],0,4));
								$dtEnd = strtotime(TIMEZONEHOUR ."hours",$dtEnd);
								$dtEnd = date("Ymd\THis\Z",$dtEnd);
								$outputStringforSearch .= "DTEND:".$dtEnd;
							}else{
								$outputStringforSearch .= "DTEND;VALUE=DATE:".trim($buffer[0]);
							}
							$outputStringforSearch .= "\n";
							$outputStringforSearch .= "DESCRIPTION:".trim(str_replace("<br>","\\n",$buffer[10]));
							$outputStringforSearch .= "\n";
							$outputStringforSearch .= "CATEGORIES:".$genreName."\n";
							$outputStringforSearch .= "LOCATION:".$buffer[4]."\n";
							$outputStringforSearch .= "SEQUENCE:0\n";
							$outputStringforSearch .= "STATUS:CONFIRMED\n";

							if(is_numeric($buffer[1])){
								$outputStringforSearch .= "SUMMARY:".trim($buffer[3]).$outputGenre.$outputMemberList."\n";
							}else{
								if(($buffer[1]=="ALL1")||($buffer[1]=="ALL2")){
									$outputStringforSearch .= "SUMMARY:".trim($buffer[3]).$outputGenre.$outputMemberList."\n";
								}else{
									$outputStringforSearch .= "SUMMARY:".$buffer[1]." ".trim($buffer[3]).$outputGenre.$outputMemberList."\n";
								}
							}
							$outputStringforSearch .= "TRANSP:OPAQUE\n";
							$outputStringforSearch .= "END:VEVENT\n";

							$outputStringDay[$lineCounter] = $outputStringforSearch;
							$lineCounter++;
						}
					}
				}
			}
		}

		$outputStringHeader  = "BEGIN:VCALENDAR\n";
		$outputStringHeader .= "PRODID:-//UNICALE//".UNICALE_VERSION."//JP\n";
		$outputStringHeader .= "VERSION:2.0\n";
		$outputStringHeader .= "CALSCALE:GREGORIAN\n";
		$outputStringHeader .= "METHOD:PUBLISH\n";
		$outputStringHeader .= "X-WR-CALNAME:".mb_convert_encoding($title, "UTF-8", "EUC-JP")."\n";
		$outputStringHeader .= "X-WR-TIMEZONE:".TIMEZONENAME."\n"; //ex. Asia/Tokyo
		$outputStringHeader .= "X-WR-CALDESC:\n";

		$outputStringFooter  = "END:VCALENDAR\n";
		$UTF8outputStringFooter = mb_convert_encoding($outputStringFooter, "UTF-8", "EUC-JP");

		if(FILE_LOCK)lock($icalTempFileName);
		$handle = fopen($icalTempFileName, 'w');
		if($handle){
			fwrite($handle, $outputStringHeader);
			for($i=0;$i<$lineCounter;$i++){
				$UTF8outputStringDay = mb_convert_encoding($outputStringDay[$i], "UTF-8", "EUC-JP");
				fwrite($handle, $UTF8outputStringDay);
			}
			fwrite($handle, $UTF8outputStringFooter);
			fclose($handle);
		}
		if(FILE_LOCK)unlock($icalTempFileName);
		if(PERM_CHG){
			set_error_handler("permChangeError");
			chmod($icalTempFileName,0666);
		}
		if(file_exists($checkFileName)){
			if(unlink($icalFileName)){
				copy($icalTempFileName,$icalFileName);
				if(PERM_CHG)chmod($icalFileName,0666);
			}
			unlink($icalTempFileName);
		}else{
			copy($icalTempFileName,$icalFileName);
			if(PERM_CHG)chmod($icalFileName,0666);
			unlink($icalTempFileName);
		}
		if(PERM_CHG)set_error_handler("");

		echo("<br>出力が終わりました。<br><br>\n");
		echo("<a href=\"data/export.ics\">export.ics</a><br><br>");
		echo("このファイルをダウンロードしてください。<br>\n");
	}else{
		echo("<h2>iCalendarファイル</h2>\n");
		echo("<a href=\"data/export.ics\">export.ics</a><br><br>");
		echo("<br>iCalendarファイル作成間隔は".ICAL_CREATE_INTERVAL."分です。<br><br>");
		echo("<a href=\"".$phpSelf."?mode=exportforce\">再作成する</a>（時間がかかる場合があります。）");

	}	
	echo("</div>\n");
	echo("</body>\n");
	echo("</html>\n");
}


function CSVexportData($startYear,$endYear,$basedir,$phpSelf,$title,$exportforce,$getPsn,$getCSVMode,$hourunit_type){
	//$getCSVMode: getMode=csvexportの時有効。[0]:デフォルト，1:人ごとに出す
	//$exportforce =1 : exportforce

	echo("<html>\n");
	echo("<head>\n");
	echo("<title>".$title." CSV出力</title>\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"ucal_common.css\"  media=\"all\">\n");
	echo("<link rel=\"stylesheet\" type=\"text/css\" href=\"ucal.css\"  media=\"all\">\n");
	echo("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=EUC-JP\">\n");
	echo("</head>\n");
	echo("<body>\n");
	echo("<div id=\"pageimage\">\n");
	echo("<a href=\"".$phpSelf."\" class=\"headerh1\">\n");
	echo("<h1>".$title." </h1>\n");
	echo("</a>\n");

	if($getCSVMode==1){
		$CSVFileNameSimple = "exportpsn.csv";	//人ごと１行のデータを出力
	}else{
		$CSVFileNameSimple = "export.csv";
	}
	$CSVFileName = $basedir.$CSVFileNameSimple;
	$CSVFilelastModified = 0;
	if(!file_exists($CSVFileName)){
		$CSVFilelastModified = time();
		$exportforce = 1;
	}else{
		$CSVFilelastModified = filemtime($CSVFileName);
	}
	$currentTime = time();
	$outputStringDay = array();
	$lineNumber = 0;
	if(((($currentTime - $CSVFilelastModified)/60) > ICAL_CREATE_INTERVAL)||($exportforce == 1)){
		echo("<h2>CSV出力処理中です</h2>\n");
		echo("CSVファイル作成間隔は".ICAL_CREATE_INTERVAL."分です。");

		$outputStringDay[0] = "";
		$lineCounter = 0;
		$checkFileName = "";
		for($readYY=$startYear;$readYY<=$endYear;$readYY++){
			for($readMM=1;$readMM<=12;$readMM++){
				$currentLastday = date("t", mktime(0, 0, 0, $readMM, 1, $readYY));
				for($readDD = 1; $readDD <= $currentLastday; $readDD++){
					for($j=0;$j<EVENT_MAX;$j++){
						$fNumber = sprintf("%02d", $j);
						$YY = sprintf("%04d",$readYY);
						$MM = sprintf("%02d",$readMM);
						$DD = sprintf("%02d",$readDD);
						$FileID = $YY.$MM.$DD."_".$fNumber;
						$checkFileName = $basedir.$YY."/".$MM."/".$YY.$MM.$DD."_".$fNumber.".dat";
						$checkFileName02 = $YY.$MM.$DD."_".$fNumber.".dat";
						
						$buffer = array();
						$eventOutString = "";
						if(file_exists($checkFileName)){
							$fSize = filesize($checkFileName) + 1;
							$lastModified = filemtime($checkFileName);
							$fileCreatedDate = filectime($checkFileName);
							if(FILE_LOCK)lock($checkFileName);
							$handle = fopen($checkFileName, "r");
							$readCounter = 0;
							if($handle){
								while ($line = fgets($handle, $fSize)) {
									$buffer[$readCounter] = chop($line);
									$readCounter++;
								}
								fclose($handle);
							}
							if(FILE_LOCK)unlock($checkFileName);
							$Member = explode(" ",trim($buffer[5]));
							$startTime = searchStartTime($buffer[1],$hourunit_type);
							$endTime = searchEndTime($buffer[2],$hourunit_type);
							$useHour = calcUseHour($buffer[1], $buffer[2]);
							$outputStringforSearch = "";

							$outputMemberList = "";
							for($k=0;$k<count($Member);$k++){
								$memberMiddle = searchFullMemberList($Member[$k],1);
								if($memberMiddle != ""){
									$outputMemberList .= "[".$memberMiddle."]";
								}
							}

							$genreName = searchGenreArray($buffer[6]);
							$outputGenre = "";
							if($buffer[6] != "999"){
								$outputGenre = "[".trim($genreName)."]";
							}
							$outputStringforSearch .= "____LINEID____";	//LineID
							$outputStringforSearch .= ",";
							$outputStringforSearch .= $FileID;	//FileID
							$outputStringforSearch .= ",";
							$outputStringforSearch .= substr($buffer[0],0,4)."/".substr($buffer[0],4,2)."/".substr($buffer[0],6,2);	//日付
							$outputStringforSearch .= ",";
							if(is_numeric($buffer[1])){
								$outputStringforSearch .= "時間指定";	//時間種別
								$outputStringforSearch .= ",";
								$outputStringforSearch .= substr($buffer[1],0,2).":".substr($buffer[1],2,2);
							}else{
								$outputStringforSearch .= $startTime;	//開始時刻
								$outputStringforSearch .= ",";
								$outputStringforSearch .= "";
							}
							$outputStringforSearch .= ",";	//終了時刻
							$outputStringforSearch .= $endTime;
							$outputStringforSearch .= ",";

							$outputStringforSearch .= str_replace(",","__COMMA__ ",trim($buffer[3])).",";				//イベント情報
							$outputStringforSearch .= $buffer[4].",";					//場所
							$outputStringforSearch .= "____MEMBER____,";				//メンバー
							$outputStringforSearch .= $genreName.",";					//ジャンル
							$outputStringforSearch .= str_replace(",","__COMMA__ ",trim($buffer[10])).",";			//イベント詳細
							$outputStringforSearch .= trim($buffer[7]).",";				//ひっそり
							$outputStringforSearch .= ",";								//拡張用1
							$outputStringforSearch .= ",";								//拡張用2
							$outputStringforSearch .= ",";								//拡張用3
							$outputStringforSearch .= ",";								//拡張用4
							$outputStringforSearch .= ",";								//拡張用5
							$outputStringforSearch .= count($Member).",";				//人数
							$outputStringforSearch .= $useHour.",";						//時間
							$outputStringforSearch .= count($Member)*$useHour.",";		//工数

							if($getCSVMode==1){
								$outputStringforSearchTemp01 = "";
								$outputStringforSearchTemp02 = "";
								for($k=0;$k<count($Member);$k++){
									$outputStringforSearchTemp01 = "";
									$memberMiddle = "";
									$memberMiddle = searchFullMemberList($Member[$k],1);
									if($memberMiddle != ""){
										$outputStringforSearchTemp01 = str_replace('____MEMBER____', $memberMiddle, $outputStringforSearch);
									}else{
										$outputStringforSearchTemp01 = str_replace('____MEMBER____', "", $outputStringforSearch);
									}
									$outputStringforSearchTemp01 = str_replace("____LINEID____", $lineCounter, $outputStringforSearchTemp01);
									$outputStringforSearchTemp02 .= $outputStringforSearchTemp01."\n";
									$lineCounter++;
								}
								$outputStringforSearch = $outputStringforSearchTemp02;
							}else{
								$outputStringforSearch  = trim(str_replace('____MEMBER____', $outputMemberList, $outputStringforSearch));
								$outputStringforSearch  = trim(str_replace('____LINEID____', $lineCounter, $outputStringforSearch));
								$outputStringforSearch  .= "\n";
								$lineCounter++;
							}
							$outputStringDay[$lineCounter] = $outputStringforSearch;
						}
					}
				}
			}
		}
		$outputStringHeader = "No,FileID,日付,時間種別,開始時刻,終了時刻,イベント情報,場所,メンバー,ジャンル,イベント詳細,ひっそり,拡張用1,拡張用2,拡張用3,拡張用4,拡張用5,人数,時間,工数\n";

		if(PERM_CHG){
			set_error_handler("permChangeError");
			chmod($CSVFileName,0666);
		}
		if(FILE_LOCK)lock($CSVFileName);
		$handle = fopen($CSVFileName, 'w');
		if($handle){
			$outputStringHeader = mb_convert_encoding($outputStringHeader, "SJIS", "EUC-JP");
			fwrite($handle, $outputStringHeader);
			for($i=0;$i<$lineCounter;$i++){
				$outputStringDayTemp = mb_convert_encoding($outputStringDay[$i], "SJIS", "EUC-JP");
				fwrite($handle, $outputStringDayTemp);
			}
			fclose($handle);
		}
		if(PERM_CHG)set_error_handler("");
		if(FILE_LOCK)unlock($CSVFileName);

		echo("<br>出力が終わりました。<br><br>\n");
		echo("<a href=\"data/".$CSVFileNameSimple."\">".$CSVFileNameSimple."</a><br><br>");
		echo("このファイルをダウンロードしてください。<br>\n");
	}else{
		echo("<h2>CSVファイル</h2>\n");
		echo("<a href=\"data/".$CSVFileNameSimple."\">".$CSVFileNameSimple."</a><br><br>");
		echo("<br>CSVファイル作成間隔は".ICAL_CREATE_INTERVAL."分です。<br><br>");
		echo("<a href=\"".$phpSelf."?mode=csvexportforce&csvmode=".$getCSVMode."\">再作成する</a>（時間がかかる場合があります。）");
	}	
	echo("</div>\n");
	echo("</body>\n");
	echo("</html>\n");
}


?>
