<?php
//セッションの開始
session_start();

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();

//グループ名とseqを持ってきて、数を数える
$sql = "SELECT group_seq, group_name
		FROM m_group
		WHERE delete_flg = 0";

$result_group = mysql_query($sql);
$count_group = mysql_num_rows($result_group);



//$seq_autho : セッションで受け取った権限グループseqを入れる
if(isset($_GET['id']))
{
$_SESSION['autho_sel'] = $_GET['id'];
}
$autho_seq = $_SESSION['autho_sel'];


$sql = "SELECT autho_name FROM m_autho WHERE autho_seq = $autho_seq
AND delete_flg = 0;";
$result = mysql_query($sql);
$name = mysql_fetch_array($result);
$name = $name['autho_name'];

?>

<html>
	<head>
		<title>権限アカウント追加</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<meta http-equiv="Content-Style-Type" content="text/css">
	 	<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont">権限登録検索</font><hr color="blue">
		</div>
		名前 :<font class="Cubicfont3"> <?= $name ?></font>
		
		
		<form action="autho_reg.php" method="POST">
			<input type="radio" name="q1" value="name" checked>名前
			<input type="radio" name="q1" value="id">ID
			
					<select name = "group">
						<option value = "-1" selected>選択なし</option>
						<?php
						for ($i = 0; $i < $count_group; $i++)
						{
						$group = mysql_fetch_array($result_group);
						?>
							<option value = "<?= $group['group_seq'] ?>"><?= $group['group_name'] ?></option>
						<?php
						}
						?>
						</select>グループ選択
			<input type="text" name="query">
			
			<input class="button4" type="submit" value="検索">
		</form>
		<div id="list_user">
		<h1>検索リスト</h1>
		<?php
		$group_sql = "SELECT
				m_user.user_name,
				m_user.user_id,
				group_details.group_seq
				FROM group_details
				LEFT JOIN m_user ON group_details.user_seq = m_user.user_seq
				AND m_user.delete_flg = 0";
		
		if(isset($_POST['group']) && $_POST['group'] >= 0 ) 
		{
			$group_seq = $_POST['group'];
			//グループ検索がある場合
			if(isset($_POST['query'] ) && $_POST['q1'] == "name")
			{
				$user_name = $_POST['query'];
				//名前検索
				$sql = $group_sql . 
				" WHERE group_details.group_seq = $group_seq
				 AND m_user.user_name LIKE '%$user_name%';";
			}
			else
			{
				$user_id = $_POST['query'];
				//ID検索
				$sql = $group_sql . 
				" WHERE group_details.group_seq = $group_seq
				 AND m_user.user_id LIKE '%$user_id%';";
			}
		}
		elseif(isset($_POST['query']))
		{
			//グループ選択なし、テキスト検索のみ
			if($_POST['q1'] == "name")
			{
				//名前検索の場合
				$user = $_POST['query'];
				$sql = "SELECT * FROM m_user WHERE delete_flg = 0 AND autho_seq != '$autho_seq' AND user_name LIKE '%$user%';";
				
			}
			else 
			{
				//ID検索の場合
				$user_id = $_POST['query'];
				$sql = "SELECT * FROM m_user WHERE delete_flg = 0 AND autho_seq != '$autho_seq' AND user_id LIKE '%$user_id%';";
			}
		}
		else 
		{
			//初期の表示の場合
			//検索用データ取得
			$sql = "SELECT * FROM m_user WHERE delete_flg = 0 AND autho_seq != '$autho_seq';"; 
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
		        $.post('_ajax_autho_add.php', {
		            id: id
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
		        $.post('after_ajax_autho_add.php', {
		            id: id
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {
			        //選択した要素のIDを指定して削除
		        	$('#select_user_'+id).fadeOut(800);
		        });
		    });

		});
		</script>
		登録してよろしかったら登録ボタンを押してください。登録しなければ必ず選択リストを空にしてください。
		<form action="auho_reg_com.php" method="GET">
		<input class="button4" type="submit" value="登録">
		</form>

	</div>
	</body>
</html>
