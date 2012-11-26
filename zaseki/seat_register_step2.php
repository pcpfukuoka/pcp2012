<!-- 未完成 -->

<?php
	$class = $_POST['class'];
	$row_max = $_POST['row'];
	$col_max = $_POST['col'];


	$url = "localhost";
	$user = "root";
	$pass = "";
	$db = "pcp2012";

	//mysqlに接続する
	$link = mysql_connect($url,$user,$pass) or die("MySQLへの接続に失敗しました。");

	//データベースを選択する
	$sdb = mysql_select_db($db,$link)or die("データベースの選択に失敗しました。");

	//文字コード設定
	mysql_query("SET NAMES UTF8");


?>


<html>
	<head>
		<script src="../jquery-1.8.2.min.js"></script>
		<script src="./jquery.detail.click.js"></script>
		<script src="jquery.detail.click.min.js"></script>
	</head>
	<body>
	<script>

	var id = 1;
	var name1 = "";
	var name2 = "";
	var attendance_no1 = 0;
	var attendance_no2 = 0;

    $(function() {
    	$(document).bind("contextmenu",function(e){
    		return false;
    	});

    	$('#' + id).attr({"bgcolor": "yellow"});


		$('.list').click(function(){

			$('#' + id).attr({"bgcolor": "white"});
			$('#' + id).children("p").text($(this).children("p").text());
			$(this).children("p").text("");

			id++;
			$('#' + id).attr({"bgcolor": "yellow"});


	    });

		$('.list').rightClick(function() {
			$('#' + id).attr({"bgcolor": "white"});
			$('#' + id).children("p").text($(this).children("p").text());
			$(this).children("p").text("");

			id++;
			$('#' + id).attr({"bgcolor": "yellow"});
		});
    });
    </script>


	<form action="seat_register_add.php" method="POST">
		<table border="1">
<?php

	$seat_id =1;
	for($row = 1; $row <= $row_max; $row++)
	{
		echo "<tr>";
		for($col = 1; $col <= $col_max; $col++)
		{
?>
			<td id="<?=$seat_id ?>" class='seat'width='100'>
			<p>&nbsp</p>
			<input name = user_seq<?= $row?>[<?= $col?>] type="hidden" value = <?= $user_seq ?>>
			</td>
<?php
			$seat_id++;
		}
		echo "</tr>";
	}


?>
		</table>

		<input type="submit" value="登録">
	</form>


	<?php


		$sql = "SELECT  attendance_no.attendance_no,m_user.user_name
					from attendance_no
						inner join m_user on attendance_no.user_seq = m_user.user_seq
					where
						attendance_no.attendance_class_seq = '$class'";

		//echo $sql;

		$result = mysql_query($sql);
		$count = mysql_num_rows($result);


		echo "<table>";
		$list_id = 101;
		while($row = mysql_fetch_array($result))
		{
			echo "<tr>";
?>
			<td id="<?=$list_id ?>"class="list"><p><?=$row['user_name'] ?></p></td>
<?php
			echo "</tr>";
			$list_id++;
		}


		echo "<table>";


		echo "<input name=class type=hidden value=$class>";
		echo "<input name=row_max type=hidden value=$row_max>";
		echo "<input name=col_max type=hidden value=$col_max>";
?>



	</body>
</html>