<?php
function dispKosu($i,$d,$dataDate,$lastMonth,$phpSelf,$dayBuffer,$realMember,$getKosu, $sumHourGenreMember_sumUseHourWeek,$callMode){
	$useHourWeek = 0;
	$useNinHourWeek = 0;
	$membersHour = array();
	$sumHourGenreMember = $sumHourGenreMember_sumUseHourWeek[0];
	$sumUseHourWeek     = $sumHourGenreMember_sumUseHourWeek[1];
	$sumUseNinHourWeek  = $sumHourGenreMember_sumUseHourWeek[2];
	$sumHourGenreMemberAll = array();
	$dispMode = $callMode[0];
	$kosuMode = $callMode[1];
	$MM = $callMode[2];
	$getKosuDet = $callMode[3];
	$hourunit_type = $callMode[4];
	
	if($hourunit_type ==1){
		$roundingString = "%0.2f";  //ex. 1.25 （15分単位では0.25で計算する必要があるため）
	}else{
		$roundingString = "%0.1f";  //ex. 1.5  （30分単位）
	}
	if(is_numeric($MM)&&($MM>=1)&&($MM<=12)&&($kosuMode=="month")){
		$MM = floor($MM);
	}else{
		$kosuMode = "week";
	}
	$fullMemberList = fullMemberList();
	$dispMembers = 0;
	$outputString = "";

	//ヘッダ表示
	$styleString1 = "height: 2em;vertical-align: middle;font-size: 80%;";
	$styleString2 = "font-size: 80%;";
	$styleString3 = "padding: 2px; text-align: right; height: 1em;";
	$styleString4 = "padding: 2px; text-align: right; height: 1em; width: 0px;";
	$outputString .= "\t<tr>\n";
	for($j=0;$j<=10;$j++){	//列ループ（見出し項目）
		switch($j){
			case 7:
				$outputString .= "\t\t<td width=\"100\" style=\"".$styleString1."\" class=\"tdheader1\">ジャンル</td>\n";
				break;
			case 8:
				$outputString .= "\t\t<td width=\"50\" style=\"".$styleString1."\" class=\"tdheader1\">時間</td>\n";
				break;
			case 9:
				$outputString .= "\t\t<td width=\"50\" style=\"".$styleString1."\" class=\"tdheader1\">人時</td>\n";
				break;
			case 10:
				for($k=0;$k<count($fullMemberList);$k++){
					if($fullMemberList[$k][3] == 1){
						$outputString .= "\t\t<td width=\"40\" style=\"".$styleString1."\" class=\"tdheader1\"><span class=\"mem".$fullMemberList[$k][0]."color\" style=\"width: 5px; height: 0.8em; margin: 0px 4px 4px 0px;\">&nbsp;</span>".$fullMemberList[$k][4]."</td>\n";
						$dispMembers++;
					}
				}
				break;
			default :
				if($dispMode == "sum"){
					if($j==0){
						$outputString .= "\t\t<td colspan=7  style=\"height: 1em; width: 0px;\">";
						$outputString .= "</td>\n";
					}
				}else{
					$arrayDispCalendarDay = dispCalendarDay($i,$j,$d,$dataDate, $lastMonth);
					$style           = $arrayDispCalendarDay[0];
					$dispHolidayData = $arrayDispCalendarDay[1];
					$dispDate        = $arrayDispCalendarDay[2];
					$lastMonth       = $arrayDispCalendarDay[3];

					if($kosuMode=="month"){
						if($lastMonth == $MM){
							$outputString .= "\t\t<td width=\"100\" style=\"height: 1em; width: 0px;\">";
							$outputString .= "<div class=\"".$style."\"><a href=\"".$phpSelf."?mode=day&date=".$dataDate[$i*7+$j]."\">".$dispDate."</a></div>";
						}else{
							$outputString .= "\t\t<td width=\"100\" style=\"height: 1em;\" class=\"tdheader1\">";
							$outputString .= "&nbsp;";
						}
					}else{
						$outputString .= "\t\t<td width=\"100\" style=\"height: 1em;\">";
						$outputString .= "<div class=\"".$style."\"><a href=\"".$phpSelf."?mode=day&date=".$dataDate[$i*7+$j]."\">".$dispDate."</a></div>";
					}
					$outputString .= "</td>\n";
				}
				break;
		}
	}
	$outputString .= "\t</tr>\n";
	//集計データ表示
	$genreArray = genreArray();
	$useHourWeekAllGenre = 0;
	$useNinHourWeekAllGenre = 0;
	$firstFlag = 0;
	for($k=0;$k<=count($genreArray);$k++){	//行ループ
		$useHourWeek = 0;
		$useNinHourWeek = 0;

		if(isset($genreArray[$k][2])&&($genreArray[$k][2] == 1)){ //集計対象ならば
			$outputString .= "\t<tr class=\"syukei1\">\n";
			for($j=0;$j<=10;$j++){
				switch($j){
					case 7: //ジャンル名
						$outputString .= "\t\t<td width=\"100\" style=\"".$styleString3."\" class=\"genre".$genreArray[$k][0]."color\" align=\"center\" valign=\"middle\">";
						$outputString .= "<span class=\"c2\">";
						$outputString .= $genreArray[$k][1];
						$outputString .= "</span>";
						$outputString .= "</td>\n";
						break;

					case 8: //時間
						if($dispMode == "sum"){
							$dispUseHourWeek = $sumUseHourWeek[$k];
						}else{
							for($n=0;$n<7;$n++){
								for($p=0;$p<count($dayBuffer[$i*7+$n]);$p++){
									if($dayBuffer[$i*7+$n][$p][6] == $genreArray[$k][0]){	//集計対象ならば
										$useHourWeek = $useHourWeek + $dayBuffer[$i*7+$n][$p][13];
									}
								}
							}
							if(!isset($sumUseHourWeek[$k])){
								$sumUseHourWeek[$k] = 0;
							}
							$sumUseHourWeek[$k] = $sumUseHourWeek[$k] + $useHourWeek;
							
							$dispUseHourWeek = $useHourWeek;
						}
						if($dispUseHourWeek != 0){
							$dispUseHourWeek = sprintf($roundingString,$dispUseHourWeek);
						}else{
							$dispUseHourWeek = "&nbsp;";
						}
						$outputString .= "\t\t<td style=\"".$styleString3."\" class=\"c3\">";
						$outputString .= "<div class=\"numeric\">".$dispUseHourWeek."</div>";
						$outputString .= "</td>\n";
						break;
					case 9://人時
						if($dispMode == "sum"){
							$dispUseNinHourWeek = $sumUseNinHourWeek[$k];
						}else{
							for($n=0;$n<7;$n++){
								for($p=0;$p<count($dayBuffer[$i*7+$n]);$p++){
									if($dayBuffer[$i*7+$n][$p][6] == $genreArray[$k][0]){	//集計対象ならば
										if($genreArray[$k][2] == 1){
											$useNinHourWeek = $useNinHourWeek + $dayBuffer[$i*7+$n][$p][15];
										}
									}
								}
							}
							if(!isset($sumUseNinHourWeek[$k])){
								$sumUseNinHourWeek[$k] = 0;
							}
							$sumUseNinHourWeek[$k] = $sumUseNinHourWeek[$k] + $useNinHourWeek;
							$dispUseNinHourWeek = $useNinHourWeek;
						}
						if($dispUseNinHourWeek != 0){
							$dispUseNinHourWeek = sprintf($roundingString,$dispUseNinHourWeek);
						}else{
							$dispUseNinHourWeek = "&nbsp;";
						}
						$outputString .= "\t\t<td style=\"".$styleString3."\" class=\"c3\">";
						$outputString .= "<div class=\"numeric\">".$dispUseNinHourWeek."</div>";
						$outputString .= "</td>\n";
						break;
					case 10:
						$membersCounter = 0;
						for($m=0;$m<count($fullMemberList);$m++){
							$sumHourMemberDay = 0;
							if($fullMemberList[$m][3] == 1){	//凡例に表示しているメンバーならば
								if($dispMode == "sum"){
									if(!isset($sumHourGenreMemberAll[$m])){
										$sumHourGenreMemberAll[$m] = 0;
									}
									if(!isset($dispSumHourMemberDay)){
										$dispSumHourMemberDay = 0;
									}
									$sumHourGenreMemberAll[$m] = $sumHourGenreMemberAll[$m] + $dispSumHourMemberDay;
									$dispSumHourMemberDay = $sumHourGenreMember[$k][$m];
								}else{
									for($n=0;$n<7;$n++){
										for($p=0;$p<count($dayBuffer[$i*7+$n]);$p++){
											for($q=0;$q<count($dayBuffer[$i*7+$n][$p][5]);$q++){
												if($dayBuffer[$i*7+$n][$p][6] == $genreArray[$k][0]){	//集計対象ならば
												//if(($dayBuffer[$i*7+$n][$p][6] == $genreArray[$k][0]) && ($genreArray[$k][2] == 1))
													if($dayBuffer[$i*7+$n][$p][5][$q] == $fullMemberList[$m][0]){	//メンバー名一致ならば
														if($fullMemberList[$m][3] == 1){ //凡例に表示しているメンバーならば
															if(!isset($dayBuffer[$i*7+$n][$p][13])){
																$dayBuffer[$i*7+$n][$p][13] = 0;
															}
															$sumHourMemberDay = $sumHourMemberDay + $dayBuffer[$i*7+$n][$p][13];
															if(!isset($sumHourGenreMember[$k][$m])){
																$sumHourGenreMember[$k][$m] = 0;
															}
															$sumHourGenreMember[$k][$m] = $sumHourGenreMember[$k][$m] + $dayBuffer[$i*7+$n][$p][13]; //ジャンル別メンバー別の合計
														}
													}
												}
											}
										}
									}
									if(!isset($membersHour[$membersCounter])){
										$membersHour[$membersCounter] = 0;
									}
									$membersHour[$membersCounter] = $membersHour[$membersCounter] + $sumHourMemberDay;
									$membersCounter++;
									$dispSumHourMemberDay = $sumHourMemberDay;
								}
								
								if(isset($dispSumHourMemberDay)&&($dispSumHourMemberDay != 0)){
									$dispSumHourMemberDay = sprintf($roundingString,$dispSumHourMemberDay);
								}else{
									$dispSumHourMemberDay = "&nbsp;";
								}
								$outputString .= "\t\t<td style=\"".$styleString3."\">";
								$outputString .= "<span class=\"numeric\">".$dispSumHourMemberDay."</span>";
								$outputString .= "</td>\n";
							}
						}
						break;
					default :
						if($dispMode == "sum"){
							if(($j==0)&&($firstFlag==0)){
								$dispGenres = 0;
								for($m=0;$m<count($genreArray);$m++){
									if($genreArray[$m][2]==1){
										$dispGenres++;
									}
								}
								$outputString .= "\t\t<td width=\"100\" style=\"height: 1em;width: 0px;\" colspan=7 rowspan=\"".$dispGenres."\">";
								$outputString .= "</td>\n";
								$firstFlag = 1;
							}
						}else{
							$outputString .= "\t\t<td width=\"100\" style=\"height: 1em;\">";
							$outputString .= "<span class=\"c1\">";

							foreach($dayBuffer[$i*7+$j] as $key => $value){
								if($dayBuffer[$i*7+$j][$key][6] == $genreArray[$k][0]){
									$outputString .= $dayBuffer[$i*7+$j][$key][16];
								}
							}

							$outputString .= "</span>";
							$outputString .= "</td>\n";
							break;
						}
				}
			}
			$outputString .= "\t</tr>\n";
			$useHourWeekAllGenre = $useHourWeekAllGenre + $useHourWeek;
			$useNinHourWeekAllGenre = $useNinHourWeekAllGenre + $useNinHourWeek;
		}else{
			if($k==count($genreArray)){
				$styleSyukugiri = "border-bottom: 2px #D15656 solid; height: 2em; vertical-align: middle; padding: 2px;";
				$styleSyukugiri2 = "border-bottom: 2px #D15656 solid; height: 2em; vertical-align: middle; text-align: right; padding: 2px;";
				$outputString .= "\t<tr>\n";
				if($dispMode == "sum"){
					for($m=0;$m<count($sumUseHourWeek);$m++){
						if(!isset($sumUseHourWeek[$m])){
							$sumUseHourWeek[$m] = 0;
						}
						$useHourWeekAllGenre = $useHourWeekAllGenre + $sumUseHourWeek[$m];
					}
					for($m=0;$m<count($sumUseNinHourWeek);$m++){
						if(!isset($sumUseNinHourWeek[$m])){
							$sumUseNinHourWeek[$m] = 0;
						}
						$useNinHourWeekAllGenre = $useNinHourWeekAllGenre + $sumUseNinHourWeek[$m];
					}
					$outputString .= "\t\t<td colspan=\"7\"  style=\"".$styleSyukugiri."\">&nbsp;</td>\n";

					if($kosuMode == "month"){
						$dispGokeiCaption = "月間合計";
					}else{
						$dispGokeiCaption = "表示週合計";
					}
					$outputString .= "\t\t<td style=\"".$styleSyukugiri."\"><span class=\"numeric\">".$dispGokeiCaption."</span></td>\n";
					$outputString .= "\t\t<td style=\"".$styleSyukugiri2."\"><span class=\"numeric\">".sprintf($roundingString,$useHourWeekAllGenre)."</span></td>\n";
					$outputString .= "\t\t<td style=\"".$styleSyukugiri2."\"><span class=\"numeric\">".sprintf($roundingString,$useNinHourWeekAllGenre)."</span></td>\n";

					for($m=0;$m<count($genreArray);$m++){
						for($n=0;$n<count($fullMemberList);$n++){
							if(!isset($dispSumHourGenreMember[$n])){
								$dispSumHourGenreMember[$n] = 0;
							}
							if(!isset($sumHourGenreMember[$m][$n])){
								$sumHourGenreMember[$m][$n] = 0;
							}
							$dispSumHourGenreMember[$n] = $dispSumHourGenreMember[$n] + $sumHourGenreMember[$m][$n];
						}
					}
					for($n=0;$n<count($fullMemberList);$n++){
						if($fullMemberList[$n][3] == 1){
							if(isset($dispSumHourGenreMember[$n])&&($dispSumHourGenreMember[$n]!=0)){
								$dispSumHourGenreMember[$n] = sprintf($roundingString,$dispSumHourGenreMember[$n]);
							}else{
								$dispSumHourGenreMember[$n] = "&nbsp;";
							}
							$outputString .= "\t\t<td  style=\"".$styleSyukugiri2."\"><span class=\"numeric\">".$dispSumHourGenreMember[$n]."</span></td>\n";
						}
					}
				}else{
					$outputString .= "\t\t<td colspan=\"7\"  style=\"".$styleSyukugiri."\">&nbsp;</td>\n";
					$outputString .= "\t\t<td style=\"".$styleSyukugiri."\"><span class=\"numeric\">週合計</span></td>\n";
					$outputString .= "\t\t<td style=\"".$styleSyukugiri2."\"><span class=\"numeric\">".sprintf($roundingString,$useHourWeekAllGenre)."</span></td>\n";
					$outputString .= "\t\t<td style=\"".$styleSyukugiri2."\"><span class=\"numeric\">".sprintf($roundingString,$useNinHourWeekAllGenre)."</span></td>\n";
					
					for($m=0;$m<count($membersHour);$m++){
						if(isset($membersHour[$m])&&($membersHour[$m]!=0)){
							$dispMembersHour[$m] = sprintf($roundingString,$membersHour[$m]);
						}else{
							$dispMembersHour[$m] = "&nbsp;";
						}

						$outputString .= "\t\t<td  style=\"".$styleSyukugiri2."\"><span class=\"numeric\">".$dispMembersHour[$m]."</span></td>\n";
					}
				}
				$outputString .= "\t</tr>\n";
			}
		}
	}
	if(($getKosuDet == 1)||($dispMode == "sum")||($kosuMode == "week")){
		echo($outputString);
	}
	return(Array($membersHour, $sumHourGenreMember,$sumUseHourWeek,$sumUseNinHourWeek));
}
?>