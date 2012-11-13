<?php
/**********************************
 * グループ選択画面
 **********************************/

$test_seq = $_POST['test_seq'];

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//$link = mysql_connect("tamokuteki41", "root", "");
//mysql_select_db("pcp2012");

$sql = "SELECT group_seq, group_name 
		FROM m_group 
		WHERE delete_flg = 0;";
$result_group = mysql_query($sql);
$count_group = mysql_num_rows($result_group);
?>

