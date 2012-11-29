<?php
session_start();

$user_seq = $_SESSION['login_info[user]'];

require_once("../lib/dbconect.php");
$dbcon = DbConnect();

//自分のクラスの授業が今やっているか
//時間割りができたら教科も検索条件に追加すること
$sql = "SELECT class_seq,subject_seq 
		FROM board
		INNER JOIN group_details ON board.class_seq = group_details.group_seq
		WHERE board.date = DATE_FORMAT(now(),'%Y-%m-%d')  AND group_details.user_seq = 1  ";

$result = mysql_query($sql);
$cnt = mysql_num_rows($result);

if($cnt == 0)
{
	echo "a";
	//別ベージに飛ばして授業が行われてないことを知らせる。
}
else
{
	$row = mysql_fetch_array($result);
	$class_seq = $row['class_seq'];
	//黒板ページに飛ばす
	header("Location: 49.212.201.99:3000?id=$class_seq");

	?>	
<?php 

}
?>









