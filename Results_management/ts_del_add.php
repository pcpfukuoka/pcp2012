<html>
	<head>
		<title>削除画面</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
		<meta http-equiv="Content-Style-Type" content="text/css"></meta>
	</head>
	<body>
		<?php
		
		require_once("../lib/dbconect.php");
		$link = DbConnect();
		//$link = mysql_connect("tamokuteki41", "root", "");//練習用サーバ
		//mysql_select_db("pcp2012");
		
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
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				$user = $row['user_seq'];
				$sql = "SELECT * FROM m_teacher WHERE delete_flg = 0 AND user_seq = '$user';";
				
			}
			elseif(isset($_POST['q1']) && $_POST['q1'] == "group")
			{
				$group = $_POST['query'];
				$sql =  "SELECT m_user.user_seq
		 		FROM group_details
		 		LEFT JOIN m_group ON group_details.group_seq = m_group.group_seq
		 		LEFT JOIN m_user ON group_details.user_seq = m_user.user_seq
		 		WHERE group_details.delete_flg = 0 AND m_group.delete_flg = 0 AND m_group.group_name LIKE '$group%'";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				$user = $row['user_seq'];
				$sql = "SELECT * FROM m_teacher WHERE delete_flg = 0 AND user_seq = '$user';";
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
		        var subj = $(this).next().data('id');
		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('ajax_ts_del_add.php', {
		            id: id,
		            subj : subj
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {
			        //選択した要素のIDを指定して削除
		        	//$('#list_user_'+id).fadeOut(800);
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
					$chk = 0;
					$row = mysql_fetch_array($result);
					$subj_ID = $row['subject_seq'];
					
					$sql = "SELECT subject_seq
					FROM m_teacher
					WHERE delete_flg = 0
					GROUP BY subject_seq;";
						
					
					$result_user = mysql_query($sql);
					$count_user = mysql_num_rows($result_user);
						
					for ($j = 0; $j < $count_user; $j++)
					{
						$teacher = mysql_fetch_array($result_user);
					
						if ($teacher['subject_seq'] == $subj_ID)
						{
							$chk = 1;
							break;
						}
					}
					if ($chk == 0)
					{
					
						?>
						<tr>
						<td align = "center"><?= $row['subject_name'] ?></td>
						<td align = "center"><input type="checkbox" name = "<?= $row['subject_seq'] ?>">
						</td>
						</tr>
					<?php 
					}
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
<?php


