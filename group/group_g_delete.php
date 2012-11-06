<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる

	$d_group = $_GET['group_name'];
	$sql = "SELECT * FROM m_group WHERE group_seq = $d_group;";
	$result = mysql_query($sql);
	$delete_group = mysql_fetch_array($result);

	Dbdissconnect($dbcon);
?>
<script language="javascript"><!--
	function delete_link() 
	{
		window.opener.location.href = "group_delete_comp.php?dt=<?php echo $delete_group['group_seq']; ?>";
		window.close();
	}
--></script>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>グループ削除</title>
	</head>
	
	<body>
		<div align = "center">
			<font size = "7">確認画面</font>
		
			<hr color = "blue">
			
			グループ「<?= $delete_group['group_name'] ?>」を削除します。
			<br>
			<br>
			本当によろしいでしょうか？
			<form>
				<table>
					<tr>
						<td>
							<input type = "submit" value = "はい" name = "yes" onClick="delete_link()">
						</td>
					
						<td>
							<input type = "submit" value = "いいえ" name = "no" onclick="window.close();">
						</td>
					</tr>
				</table>
			</form>
		</div>	
	</body>
</html>