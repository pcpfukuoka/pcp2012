<?php
session_start();

//GETで値がなければこのページには遷移させない
//今はテスト用にその処理は欠かないけど最終的には追加する

$question_seq = $_GET['id'];
$user_seq = $_SESSION['login_info[user]'];

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	</head>
	<body>		
		<?php 
		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();
		$sql = "SELECT question_title, question_description FROM question WHERE question_seq = $question_seq;";
		$question_result = mysql_query($sql);
		$question_row = mysql_fetch_array($question_result);
		
		
		?>
		
		<form method ="post" action="answer_regist.php">
		<input type="hidden" name="question_seq" value="<?= $question_seq ?>">
		タイトル:<?= $question_row['question_title'] ?><br>
		内容：<?= $question_row['question_description'] ?><br>
		<?php 
		//質問数を取得してその数ループで回答欄を作成
		$sql = "SELECT question_details_seq, quesion_details_description,question_division.division_type  FROM question_details  LEFT JOIN question_division ON question_details.quesion_division = question_division.division_seq WHERE question_seq = $question_seq";
		$details_result = mysql_query($sql);
		$details_cnt = mysql_num_rows($details_result);
		
		//Details_seqを使って回答内容を取得してそれを元に回答欄を作成
		for($i=0;$i<$details_cnt;$i++)
		{
			$details_row = mysql_fetch_array($details_result);
			$details_seq = $details_row['question_details_seq'];
			$sql = "SELECT * FROM question_awnser_list WHERE question_details_seq = $details_seq";
			$awnser_resutl = mysql_query($sql);
			$awnser_cnt = mysql_num_rows($awnser_resutl);?>
			回答内容:<?= $details_row['quesion_details_description'] ?>
<?php 
			for($j=0; $j < $awnser_cnt;$j++)
			{
				$awnser_row = mysql_fetch_array($awnser_resutl);
				?>
				<input type="<?= $details_row['division_type']?>" name="question_<?= $i + 1 ?>[]" value="<?= $awnser_row['question_awnser_list_seq'] ?>"><?= $awnser_row['awnser_name'] ?>				
				<?php 
			}?>
			その他：<input type="checkbox" class="etc_input" id="etc_input_<?= $i + 1 ?>" data-id="<?= $i + 1 ?>">
				  <input type="text" name="etc_<?= $i + 1 ?>" disabled="true">
			<input type="hidden" name="details_seq[]" value="<?= $details_row['question_details_seq']?>">
			<br>
	<?php 	
		}
		?>
		<input class="button4"type="submit" value ="回答を送信">
		</form>		
	</body>
	
			<script>
		$(function() {
			//検索結果から権限を追加するための処理
			$(document).on('click', '.etc_input', function() {
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
				
		        var id = $(this).data('id');
				var chk_str = 'etc_input_'+id;
				var txt_str = 'etc_'+id;
				if(document.getElementById(chk_str).checked)
				{
					$("*[name="+txt_str+"]").attr('disabled', false);
								
				}
				else
				{
					$("*[name="+txt_str+"]").attr('disabled', true);
								
				}
			});
		});
			</script>
	
	
	
</html>