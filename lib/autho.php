<?php
/**************************************************
 * 権限グループseqとページseqに対応した権限を取得するための関数  
 * 												  
 * 配列を返すためにクラスを使用							  
 * 
 * 使い方
 * 例）require_once("../lib/autho.php");
 * 	  $a = new autho_class();
 *    $b = $a -> autho_Pre();
 * 
 **************************************************/

/**************************************************
 * $autho_seq   : 権限を参照したい権限グループseq
 * $page_seq    : 権限を参照したいページseq
 * $count_autho : SQLで取得したデータの件数
 * $use_autho   : SQLで取得したデータを入れる配列
 **************************************************/

class autho_class
{
	function autho_Pre($autho_seq, $page_seq)
	{
		
		//DBに接続ڑ
		require_once("dbconect.php");
		$link = DbConnect();
		
		//権限seqとページseqに対応した権限を取得するSQL文
		$sql = "SELECT read_flg, write_flg, delete_flg, update_flg, delivery_flg 
				FROM m_access_autho 
				WHERE page_seq = '$page_seq' 
				AND autho_seq = '$autho_seq';";
		
		//echo $sql;
		//SQL���̎の実行
		$result = mysql_query($sql);
		
		//取り出した件数を数える
		$count_autho = mysql_num_rows($result);
		
		//権限を配列に入れる
		for ($i = 0; $i < $count_autho; $i++)
		{
			$use_autho = mysql_fetch_array($result);
		}
		
// 		echo $page_seq;
// 		echo "<br>";
// 		echo "read_flg :". $use_autho['read_flg']."<br>";
// 		echo "delete_flg :". $use_autho['delete_flg']."<br>";
// 		echo "write_flg :". $use_autho['write_flg']."<br>";
// 		echo "update_flg :". $use_autho['update_flg']."<br>";
// 		echo "delivery_flg :". $use_autho['delivery_flg']."<br>";
		
		Dbdissconnect($link);
		
		return $use_autho;
	}
}
?>
