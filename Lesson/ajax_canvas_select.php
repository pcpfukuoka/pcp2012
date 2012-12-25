<?php
//要求された日付・教科のcanvasとdivの背景画像の取得

$date = $_POST['date'];
$subject_seq = $_POST['id'];

//データベースの呼出
require_once("../lib/dbconect.php");
$dbcon = DbConnect();

//授業の画像を抽出するＳＱＬ
$sql = "SELECT div_url, canvas_url FROM board WHERE date='". $date ."' AND subject_seq=15;";
$result = mysql_query($sql);
$count = mysql_num_rows($result);
$result_1 = array();

for($i = 0;$i < $count;$i++){
	$row = mysql_fetch_array($result);

	$aaa = substr($row['div_url'],30);
	$div = "url(../../balckboard/public/".$aaa;
	$canvas = $row['canvas_url'];

	//送信するデータを配列に追加
	$result_1[] = array('div'=>$div,'canvas'=>$canvas);
}
Dbdissconnect($dbcon);


$test = json_encode($result_1);
echo $test;

?>