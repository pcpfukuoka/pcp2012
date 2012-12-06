<!-- 未完成 -->

<?php
	$group = $_POST['group'];
	$row_max = $_POST['row'];
	$col_max = $_POST['col'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

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

			if($(this).children("p").text() != "-")
			{
				$('#' + id).children('input:eq(1)').val($(this).attr("id"));
				$('#' + id).attr({"bgcolor": "white"});
				$('#' + id).children("p").text($(this).children("p").text());
				$(this).children("p").text('-');


				id++;
				$('#' + id).attr({"bgcolor": "yellow"});
			}


	    });

		$('.seat').click(function(){

			if($(this).children("p").text() != "")
			{
				id = $(this).children('input:eq(1)').val();
				$('#'+id).children('p').text($(this).children("p").text());
				$(this).children('p').text("");
			}
	    });
    });
    </script>


	<form action="seat_register_add.php" method="POST">
		<table border="1">
<?php

	for($row = 1; $row <= $row_max; $row++)
	{
		echo "<tr>";
		$seat_id = $row;
		for($col = 1; $col <= $col_max; $col++)
		{
?>
			<td id="<?=$seat_id?>" class='seat'width='100'>
			<p>&nbsp</p>
			<input name = user_seq<?= $row?>[<?= $col?>] type="hidden" value = <?= $user_seq ?>>
			<input type="hidden" value="">
			</td>
<?php
			$seat_id = $seat_id + $row_max;
		}
		echo "</tr>";
	}


?>
		</table>

		<input type="submit" value="登録">
	</form>


	<?php


		$sql = "SELECT m_user.user_seq,m_user.user_name
					from group_details,m_user
						where group_details.group_seq = '$group'
							and group_details.user_seq = m_user.user_seq";


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


		echo "<input name=group type=hidden value=$group>";
		echo "<input name=row_max type=hidden value=$row_max>";
		echo "<input name=col_max type=hidden value=$col_max>";
?>



	</body>
</html>