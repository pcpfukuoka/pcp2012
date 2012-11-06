<?php
//-------------------------------------------------------------------------------------
// User Setting Area
//-------------------------------------------------------------------------------------

define('KEIJI_MODE', true);			//掲示板モード有効：利用者が善人の場合のみtrue推奨
define('NEWICONDISP_DAYS', 1);		//NEWアイコンを表示する日数（この日数経過後は表示しない）
define('STARTYEAR', 2005);			//西暦何年から表示するか
define('ENDYEAR',date('Y')+2);		//西暦何年まで表示するか。2015などの定数を指定しても良い。
define('EVENT_SORTORDER', 4);		//カレンダー内の表示順
									//0:ファイル番号順 (default)
									//1:ジャンル順
									//2:ファイル生成日時順（今のところ3の場合と同一）
									//3:ファイル最終修正日順（新しい物ほど後）
									//4:予定の開始時刻順
define('DISP_WEEK',1);				//カレンダーの上部に曜日を表示する(0:しない，[1:する])
define('DISP_GENRE_FLAT',0);		//ジャンルの凡例を表示する(0:しない,[1:する])
define('DISP_NAVI_MONTH',1);		//年度内の月ナビゲーションを表示する（0:しない,[1:する]）
define('TIMEZONENAME','Asia/Tokyo');//タイムゾーン名
define('TIMEZONEHOUR',-9);			//タイムゾーン時差
define('ICAL_CREATE_INTERVAL',30);	//どの間隔以上でiCalendarファイルを再作成するか（単位：分。なるべく5以上にしてください。）
define('SETTIME_LIMIT',90);			//実行タイムアウト時間。iCalnedarファイル生成時にタイムアウトする場合に大きくしてみてください。（最大300程度）
define('FILE_LOCK',true);			//ファイルロック処理を行うか。環境によってエラーが発生する場合はfalseにしてください。
define('PERM_CHG',true);			//ファイルパーミション処理でエラーになる場合falseにしてください。
define('EVENT_MAX',50);				//1日あたり登録できるイベント（予定）の最大数。最大50程度。
define('CUSTOM_LINK',false);		//別サイトへのリンクを張る場合，true。張らない場合false。
define('CUSTOM_LINK_URI','http://www.unicale.com/');		//別サイトへのリンク先（CUSTOM_LINKがtrueの場合有効）
define('CUSTOM_LINK_NAME','UNICALE公式サイトへ');			//別サイトへのリンクの名前
define('LOGO_DISP',true);			//ロゴ表示

define('KOSU_ALL1',8);				//時刻設定欄で「（未定）」を選択したイベントの時間数
define('KOSU_ALL2',8);				//時刻設定欄で「終日」を選択したイベントの時間数
define('KOSU_AM',3);				//時刻設定欄で「午前」を選択したイベントの時間数
define('KOSU_PM',4);				//時刻設定欄で「午後」を選択したイベントの時間数
define('KOSU_STARTONLY_HOUR',2);	//時刻設定欄で開始時刻だけを選択した場合の時間数

define('HOUR_UNIT_TYPE',0);			//リストボックスで選択できる開始時刻の単位。（[0]:30分，1:15分）


?>

