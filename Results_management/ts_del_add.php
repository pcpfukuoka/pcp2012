<html>
	<head>
		<title>削除画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
		<meta http-equiv="Content-Style-Type" content="text/css"></meta>
	</head>
	<body>
		<?php
		require_once("../lib/dbconect.php");
		//$link = DbConnect();
		$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		mysql_select_db("pcp2012");
		
		?>
			<div align = "center">
				<font size = "6">先生削除画面</font>
			</div><br><br>
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
		<?php 
		
		$sql = "SELECT teacher_seq, subject_seq, user_seq FROM m_teacher WHERE delete_flg = 0";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		?>
		
				<form action="ts_del_add.php" method="POST">
			<input type="radio" name="q1" value="name" checked>名前
			<input type="radio" name="q1" value="group">グループ
			<input type="text" name="query">
			<input class="button4" type="submit" value="検索">
		</form>
		
		
		<form action="ts_del_com.php" method="POST">
		<?php 
		if(isset($_POST['query']))
		{
			
			if(isset($_POST['q1']) && $_POST['q1'] == "name")
			{
				//チェックボックスを確認
				$user = $_POST['query'];
				$sql = "SELECT * FROM m_user WHERE delete_flg = 0 AND user_name LIKE '%$user%';";
			}
			elseif(isset($_POST['q1']) && $_POST['q1'] == "group")
			{
				$user_id = $_POST['query'];
				$sql = "SELECT * FROM m_user WHERE delete_flg = 0 AND user_seq LIKE '$user_id%';";
			}
		}
		
				$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		
		?>
		
		<!-- テーブルの作成 -->
		<table border="1" width="100%"><!-- テーブル作成 -->
			<tr>
				<th width="50%">教師名</th>
				<th width="30%">担当教科</th>
				<th width="20%">チェック</th>
			</tr>
			<?php 
			
			for($i = 0; $i < $count; $i++)//先生ID分ループ
			{
				$row = mysql_fetch_array($result);
				
				$subject_seq = $row['subject_seq'];
				$user_seq = $row['user_seq'];
				
				//m_teacherを元に名前　担当教科取り出しまた貼り付け
				
				$sql = "SELECT user_name, user_seq FROM m_user WHERE delete_flg = 0 AND user_seq = $user_seq";
				$res_use = mysql_query($sql);
				$user_name = mysql_fetch_array($res_use);
				
				$sql = "SELECT subject_name FROM m_subject WHERE delete_flg = 0 AND subject_seq = $subject_seq";
				$res_subj = mysql_query($sql);
				$subject_name = mysql_fetch_array($res_subj);
				?>
					<tr>
							<td align = "center"><?= $user_name['user_name'] ?></td>
							<td align = "center"><?= $subject_name['subject_name'] ?></td>
							<td align = "center">
							<input type="checkbox" class="checkUser" data-id="<?= $user_seq ?>">
							<input type="hidden" name="subj_ID" data-id="<?= $subject_seq ?>">
							</td>
							
					</tr>
				<?php
			}
			?>
			</table><br>
				<script>
		$(function() {

			//検索結果から権限を追加するための処理
			$(document).on('click', '.checkUser', function() {
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
		        var id = $(this).data('id');
		        //表示しているユーザ名を取得
		        var subj = $(this).next().data('id')
		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('ajax_ts_del_add.php', {
		            id: id
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {
			        //選択した要素のIDを指定して削除
		        	$('#list_user_'+id).fadeOut(800);
		        });
		    });
		});
		</script>
		
		
		
		
			
			<br><hr>
			<?php 
			$sql = "SELECT subject_name, subject_seq FROM m_subject WHERE delete_flg = 0";
			$result = mysql_query($sql);
			
			$count = mysql_num_rows($result);
			
			?>
			
			<div align = "center">
			<font size = "6">教科削除画面</font></div><br>
			<?php 
			
			
			?>
			<table border="1" width="70%"><!-- 教科のテーブル  -->
				<tr>
					<th width="50%">教科一覧</th>
					<th width="20%">チェック</th>
				</tr>
				<?php 
				for($i = 0; $i < $count; $i++)//教科分データ取り出し
				{
					$row = mysql_fetch_array($result);
					$subj_ID = $row['subject_seq'];
					
/*					$subj_sql = "SELECT  subject_seq FROM m_teacher WHERE delete_flg = 0 AND subject_seq = $subj_ID";
					$subj_res = mysql_query($subj_sql);
					$subj_row = mysql_fetch_array($subj_res);
					if(!isset($subj_row))
					{
	*/				
						?>
						<tr>
						<td align = "center"><?= $row['subject_name'] ?></td>
						<td align = "center"><input type="checkbox" name = "subject_<?= $row['subject_seq'] ?>">
						</td>
						</tr>
					<?php 
//					}
				}
				?>
				</table><br>
			
			<?php 
			Dbdissconnect($link);
			?>
			<input type = "submit" value = "確認">&nbsp;&nbsp;
			<input type = "reset" value="クリア"><br><br>
			</form>
	</body>
</html>
