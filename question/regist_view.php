<?php
session_start();

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
		$sql = "SELECT * FROM m_group WHERE delete_flg = 0;";
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);
		?>
		
		<form method ="post" action="regist.php">
		タイトル:<input type="text" name="question_title"><br>
		期間：<input type="date" name="start_date">〜<input type="date" name="end_date"><br>
		対象グループ：
		<select name = "target_group_seq" size = "1">
			<option value = "-1">選択</option>
				<option value = "0">全員</option>			
			<?php 
			for($i = 0; $i < $cnt; $i++)
			{
				$row = mysql_fetch_array($result);
				?>
				<option value = "<?=  $row['group_seq'] ?>"><?= $row['group_name'] ?></option>			
		<?php 
			}
			?>
		</select><br>
		内容：<input type="text" name="question_description"><br>
		<input type="button" class="questionAdd" value="追加" id="aaaaa">
		<div id="question_details">
		</div>
		<div id="input_section">
		</div>
		<input class="button4"type="submit" value ="登録">
		</form>		
	</body>
		<script>
		$(function() {
			$(document).on('click', '.questionAdd', function() {
				//今までの要素を無効化
				//$('.questionAdd').attr('disabled', true);
				$("*[name=question_title]").attr('disabled', true);
				$("*[name=start_date]").attr('disabled', true);
				$("*[name=end_date]").attr('disabled', true);
				$("*[name=target_group_seq]").attr('disabled', true);
				$("*[name=question_description]").attr('disabled', true);
				
				//入力した値を取得
		        var question_title = $("*[name=question_title]").val();
		        var start_date = $("*[name=start_date]").val();
		        var end_date = $("*[name=end_date]").val();
		        var question_description = $("*[name=question_description]").val();
		        $.post('question_answer_list_add.php', {
		            id: question_title
		                },
		        function(rs) {

		    		        //次に入力するために必要な要素を追加
			                $('#input_section').append('質問内容：<input type="text" name="user_address"><br>');
			                $('#input_section').append('回答区分：<select name = "target_group_seq" size = "1"><option value = "-1">選択</option><option value = "1">複数</option><option value = "2">単一</option><br>');
			                $('#input_section').append('<br>回答内容：<input type="text" name="input_question_lsit_name"><input type="button" value="追加" class="questionListAdd"><br>');
			                $('#input_section').append('<div id="question_awnser_lsit">');
			                $('#input_section').append('</div>');
			                $('#input_section').append('<input type="button" value="追加" class="questionDetailsAdd">');
			                
                	  });
		    });
			
			$(document).on('click', '.questionListAdd', function() {
		        var question_name = $("*[name=input_question_lsit_name]").val();
		        $.post('question_answer_list_add.php', {
		            id: question_name
		                },
		        function(rs) {
		                	$("*[name=input_question_lsit_name]").val("");
		        	var e = $(
		                    '<li>' +
		                    '<input type="text" value="'+question_name+'" readonly name = "question_list_name[]" >' +
		                    '</li>'
		                );
	                $('#question_awnser_lsit').append(e);
		        });
		    });

			$(document).on('click', '.questionDetailsAdd', function() {
		        var question_name = $("*[name=input_question_lsit_name]").val();
				var i = 0;
		        $("[name='question_list_name[]']").each(function() {
	                var data1 = $("[name='question_list_name[]']").eq(i).val();
	                i++;
	            });
		        $.post('question_answer_list_add.php', {
		            id: question_name
		                },
		        function(rs) {
 	              	$('#input_section').empty();
    		        //次に入力するために必要な要素を追加
	                $('#input_section').append('質問内容：<input type="text" name="user_address"><br>');
	                $('#input_section').append('回答区分：<select name = "target_group_seq" size = "1"><option value = "-1">選択</option><option value = "1">複数</option><option value = "2">単一</option><br>');
	                $('#input_section').append('<br>回答内容：<input type="text" name="input_question_lsit_name"><input type="button" value="追加" class="questionListAdd"><br>');
	                $('#input_section').append('<div id="question_awnser_lsit">');
	                $('#input_section').append('</div>');
	                $('#input_section').append('<input type="button" value="追加" class="questionDetailsAdd">');
				                			                	 
		        });
		    });
		});
		</script>
	
</html>