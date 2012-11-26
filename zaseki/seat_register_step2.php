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
	</head>
	<body>
	<script>

	var id = "";
	var name1 = "";
	var name2 = "";
	var attendance_no1 = 0;
	var attendance_no2 = 0;

    $(function() {
	    $('.seat').click(function(){
		if(add_flg == 0 && id == "")
		{
				//一回目にクリックしたセルのデータを保存
				id = $(this).attr("id");
				name1 = $(this).children("p").text();
				attendance_no1 = $(this).children().val();

				//一回目にクリックしたセルの色を変える
				$(this).attr({"bgcolor": "yellow"});

	    }
		else
		{

				//二回目にクリックしたセルのデータを保存
				name2 = $(this).children("p").text();
				attendance_no2 = $(this).children().val();

				//データの交換
				$(this).children("p").text(name1);
				$('#' + id).children("p").text(name2);

				$(this).children().attr({"value": attendance_no1});
				$('#' + id).children().attr({"value": attendance_no2});

				//セルの色を戻す
				$('#' + id).attr({"bgcolor": ""});

				id = 0;
				name1 = "";
				name2 = "";
				attendance_no1 = "";
				attendance_no2 = "";

		}

		if(add_flg == 1)
		{
			$(this).children("p").text(name);
			add_flg = 0;
			name = "";
		}

	    });

    $('.list').click(function(){
    	$(this).attr({"bgcolor": "yellow"});
		var flg = 0;
    	name = $(this).children("p").text();
    	add_flg = 1;

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
			<td id="$seat<?=$seat_id ?>" class='seat'width='100'>
			<p> </p>
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
		$list_id = 1;
		while($row = mysql_fetch_array($result))
		{
			echo "<tr>";
?>
			<td id="list<?=$list_id ?>"class="list"><p><?=$row['user_name'] ?></p></td>
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