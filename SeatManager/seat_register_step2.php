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
	<style>
		.seat_table {
 			border-collapse: separate;
 			border: 1px solid #cccccc;
 			margin: 10px;
		}
		.seat_table td {
 			border: 1px solid #0066ff;
		}
		td.show01 {
 			empty-cells: show;
		}

		.list_table {
 			border-collapse: separate;
 			border: 1px solid #cccccc;
 			margin: 10px;
		}
		.list_table td {
 			border: 1px solid #0066ff;
		}

		.left_box{
			float:left;
		}
		.right_box{
			float:left;
		}

	</style>
	</head>
	<body>
	<script>

	var seat_id = 1;
	var list_id = 101;
	var mode = "";	//"add"or"change"

	//退避用変数
	var seat_id_evc = "";
	var list_id_evc = "";
	var name_evc = "";
	var user_seq_evc ="";
	var evc_flg = 0;	//	”0:退避用変数に値がない”or ”1：退避用変数に値がある”

    $(function() {

		//追加ボタンを押せるようにする
		$('#add').removeAttr("disabled");

    	//入れ替えボタンを押せなくする
		$('#change').attr("disabled", "disabled");

		$('#add').click(function(){

			//追加ボタンを押せなくする
			$('#add').attr("disabled", "disabled");

			//入れ替えボタンを押せるようにする
			$('#change').removeAttr("disabled");

			//セルの背景色をすべて戻す
			$('.seat').attr({"bgcolor": "white"});

			//一番最初の空白の背景色を変える
			for(var i = 1; i <= 100; i++)
			{
				seat_id = i;
				if($('#'+seat_id).children('p').text() == "")
				{
					$('#'+seat_id).attr({"bgcolor": "red"});
					break;
				}
			}

			//リストから座席表に追加できるようにする
			mode ="add";
	    });

		$('#change').click(function(){

			//追加ボタンを押せるようにする
			$('#add').removeAttr("disabled");

			//入れ替えボタンを押せなくする
			$('#change').attr("disabled", "disabled");

			//セルの背景色をすべて戻す
			$('.seat').attr({"bgcolor": "white"});
			mode ="change";

			//退避用変数のクリア
			seat_id_evc = "";
			list_id_evc = "";
			name_evc = "";
			user_seq_evc ="";
			evc_flg = 0;
	    });

		$('.list').click(function(){

			if(mode == "add")
			{
				if($(this).children("p").text() != "-")
				{
					//セルの背景色を戻す
					$('.seat').attr({"bgcolor": "white"});

					//選択されているセルにクリックした名前を挿入する
					$('#' + seat_id).children("p").text($(this).children("p").text());

					//選択されているセルにクリックした名前に対応したuser_seqを挿入する
					$('#' + seat_id).children('input:eq(0)').val($(this).children('input:eq(0)').val());

					//クリックしたリストの位置を記憶しておく
					$('#' + seat_id).children('input:eq(1)').val($(this).attr("id"));

					//クリックしたリストの名前を消す
					$(this).children("p").text('-');


					//次の空白セルへ移動し色を変える
					seat_id++;
					for(seat_id; seat_id <= 100; seat_id++)
					{
						if($('#'+seat_id).children('p').text() == "")
						{
							$('#'+seat_id).attr({"bgcolor": "red"});
							break;
						}
					}
				}
			}


	    });

		$('.seat').click(function(){

			//追加ボタンが押されている時
			if(mode == "add")
			{
				if($(this).children("p").text() != "")
				{
					//セルをクリアしてリストの元の位置に戻す
					list_id = $(this).children('input:eq(1)').val();
					$('#'+list_id).children('p').text($(this).children("p").text());
					$(this).children('p').text("");
					$(this).children('input:eq(0)').val("");
					$(this).children('input:eq(1)').val("");
				}
				else
				{
					//クリックしたセルを選択状態にする
					$('.seat').attr({"bgcolor": "white"});
					seat_id = $(this).attr("id");
					$(this).attr({"bgcolor": "red"});
				}

			}
			//入れ替えボタンが押されている時
			else if(mode == "change")
			{
				if(evc_flg == 0)
				{
						//一回目にクリックしたセルのデータを退避させる
						seat_id_evc = $(this).attr("id");
						list_id_evc = $(this).children('input:eq(1)').val();
						name_evc = $(this).children("p").text();
						user_seq_evc = $(this).children('input:eq(0)').val();

						//一回目にクリックしたセルの色を変える
						$(this).attr({"bgcolor": "yellow"});

						//退避フラグをONにする
						evc_flg = 1;
			    }
				else
				{

						//一回目にクリックしたセルに二回目にクリックしたデータを移す
						$('#' + seat_id_evc).children("p").text($(this).children("p").text());
						$('#' + seat_id_evc).children('input:eq(0)').attr({"value": $(this).children('input:eq(0)').val()});
						$('#' + seat_id_evc).children('input:eq(1)').attr({"value": $(this).children('input:eq(1)').val()});

						//二回目にクリックしたセルに一回目に退避したデータを移す
						$(this).children("p").text(name_evc);
						$(this).children('input:eq(0)').attr({"value": user_seq_evc});
						$(this).children('input:eq(1)').attr({"value": list_id_evc});


						//セルの色を戻す
						$('#' + id_evc).attr({"bgcolor": ""});

						seat_id_evc = 0;
						list_id_evc = 0;
						name_evc = "";
						user_seq_evc = "";
						evc_flg = 0;
				}
			}
	    });
    });
    </script>

<div class="left_box">
	<form action="seat_register_add.php" method="POST">
		<table class="seat_table">
<?php

	for($row = 1; $row <= $row_max; $row++)
	{
		echo "<tr>";
		$seat_id = $row;
		for($col = 1; $col <= $col_max; $col++)
		{
?>
			<td id="<?=$seat_id?>" class='seat'width='100' height='50'>
			<p></p>
			<input name = user_seq<?= $row?>[<?= $col?>] type="hidden" value = "">
			<input type="hidden" value="">
			</td>
<?php
			$seat_id = $seat_id + $row_max;
		}
		echo "</tr>";
	}


?>
		</table>
		<input id="add" type="button" value="追加・戻す">
		<input id="change" type="button" value="移動">
		<input type="submit" value="登録" >



<?php
		echo "<input name=group type=hidden value=$group>";
		echo "<input name=row_max type=hidden value=$row_max>";
		echo "<input name=col_max type=hidden value=$col_max>";
?>
	</form>
</div>

<div class="right_box">
	<?php


		$sql = "SELECT m_user.user_seq,m_user.user_name
					from group_details,m_user
						where group_details.group_seq = '$group'
							and group_details.user_seq = m_user.user_seq";


		//echo $sql;

		$result = mysql_query($sql);
		$count = mysql_num_rows($result);


		echo "<table class='list_table'>";
		$list_id = 101;
		while($gyo = mysql_fetch_array($result))
		{
			echo "<tr>";
?>
			<td id="<?=$list_id ?>"class="list">
				<p><?=$gyo['user_name'] ?></p>
				<input type="hidden" value = "<?=$gyo['user_seq'] ?>">
			</td>
<?php
			echo "</tr>";
			$list_id++;
		}


		echo "</table>";



?>
</div>


	</body>
</html>