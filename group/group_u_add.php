<?php

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();

//$seq_autho : セッションで受け取った権限グループseqを入れる
if(isset($_GET['id']))
{
	$group_seq = $_GET['id'];
}



?>

<html>
	<head>
		<title>グループ追加</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
		 <link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		 <link rel="stylesheet" type="text/css" href="../css/text_display.css" />
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont">グループユーザ追加</font><hr>
		</div><br><br>
		<form action="group_u_add.php" method="POST">
			<input type="radio" name="q1" value="name" checked>名前
			<input type="radio" name="q1" value="id">ID
			<input type="text" name="query">
			<input class="button4"  type="submit" value="検索">
		</form>
		<div id="list_user">
		<h1>検索リスト</h1>
		<?php
		$sql = "";
		if(isset($_POST['query']))
		{

			if(isset($_POST['q1']) && $_POST['q1'] == "name")
			{
				//チェックボックスを確認
				$user = $_POST['query'];
				$sql = "SELECT * FROM m_user WHERE delete_flg = 0 AND user_name LIKE '%$user%';";
			}
			elseif(isset($_POST['q1']) && $_POST['q1'] == "id")
			{
				$user_id = $_POST['query'];
				$sql = "SELECT * FROM m_user WHERE delete_flg = 0 AND user_seq LIKE '$user_id%';";
			}
		}
		else
		{
			//検索用データ取得
			$sql = "SELECT * FROM m_user WHERE delete_flg = 0;";
		}

		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);

		Dbdissconnect($link);

		for($i = 0; $i < $cnt; $i++)
		{
			$row = mysql_fetch_array($result);
		?>
			<li id="list_user_<?= $row['user_seq'] ?>" data-id="<?= $row['user_seq'] ?>">
				<input type="checkbox" class="checkUser">
				<span id="user_name_<?= $row['user_seq']?>"><?= $row['user_name']?></span>
			</li>
		<?php
			}
		?>
		</div>

		<div id="select_user">
		<h1>選択リスト</h1>
		<!--  //すでに選択されてるデータを表示
          <li id="select_user_'+user_seq+'" data-id="'+user_seq+'">
		  <input type="checkbox" class="deleteUser">
		  <span>ユーザ名</span> ' +
		  </li>'
		-->
		</div>


		<script>
		$(function() {

			//検索結果から権限を追加するための処理
			$(document).on('click', '.checkUser', function() {
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
		        var id = $(this).parent().data('id');
		        //表示しているユーザ名を取得
		        var user_name = $('#user_name_'+id).html();
		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('_ajax_user_add.php', {
		            id: id,
		            gs: <?= $group_seq ?>
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {
			        //選択した要素のIDを指定して削除
		        	$('#list_user_'+id).fadeOut(800);

					//追加して表示する内容を設定
		        	var e = $(
		                    '<li id="select_user_'+rs+'" data-id="'+rs+'">' +
		                    '<input type="checkbox" class="delete_user"> ' +
		                    '<span></span> ' +
		                    '</li>'
		                );
	            	//id=select_userにe要素を追加
	                $('#select_user').append(e).find('li:last span:eq(0)').text(user_name);
		        });
		    });

			//権限を戻すための処理
			$(document).on('click', '.delete_user', function() {
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
		        var id = $(this).parent().data('id');
		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('_ajax_user_reset.php', {
		            id: id,
		            gs: <?= $group_seq ?>
		        		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {
			        //選択した要素のIDを指定して削除
		        	$('#select_user_'+id).fadeOut(800);
		        });
		    });

		});
			</script>
		<form action="group_u_add_comp.php" method="GET">
		<input class="button4" type="submit" value="登録完了">

		</form>
		</div>
	</body>
</html>
