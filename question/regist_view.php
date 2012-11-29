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
			kbn = new Array("","単一", "複数");
			//質問内容追加
			$(document).on('click', '.questionAdd', function() {
				//今までの要素を無効化
				$('.questionAdd').attr('disabled', true);
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
		        var target_group = $("*[name=target_group_seq]").val();
		        $.post('question_add.php', {
		            title: question_title,
		            start_date: start_date,
		            end_date: end_date,
		            question_description: question_description,
		            target_group: target_group		            
		                },
		        function(rs) {
		    		        //次に入力するために必要な要素を追加
			                $('#input_section').append('<input type="hidden" name="seq" value = "'+ rs +'"><br>');
		    		        $('#input_section').append('質問内容：<input type="text" name="input_question_details_description"><br>');
			                $('#input_section').append('回答区分：<select name = "answer_kbn" size = "1"><option value = "-1">選択</option><option value = "1">複数</option><option value = "2">単一</option><br>');
			                $('#input_section').append('<br>回答内容：<input type="text" name="input_question_lsit_name"><input type="button" value="追加" class="questionListAdd"><br>');
			                $('#input_section').append('<div id="question_awnser_lsit">');
			                $('#input_section').append('</div>');
			                $('#input_section').append('<input type="button" value="追加" class="questionDetailsAdd">');
			                
                	  });
		    });

			//回答内容個別追加
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

			//回答一覧追加
			$(document).on('click', '.questionDetailsAdd', function() {

				var seq = $("*[name=seq]").val();
		        var question_details_description = $("*[name=input_question_details_description]").val();
				var answer_kbn = $("*[name=answer_kbn]").val();
				var i = 0;
				var question_name = new Array();
		        $("[name='question_list_name[]']").each(function() {
	                 question_name[question_name.length] = $("[name='question_list_name[]']").eq(i).val();
	                i++;
	            });
		        $.post('question_answer_list_add.php', {
		            "name_list[]": question_name,
		            answer_kbn : answer_kbn,
		            seq : seq,
		            question_details_description : question_details_description
		                },
		        function(rs) {
		    		        
		    		//今入力した内容をquestion_detailsに追加
    		        $('#question_details').append('質問内容：<input type="text" name="comp_question_details_description"readonly=on value="'+ question_details_description +'" ><br>');
	                $('#question_details').append('回答区分：<input type="text" name="comp_question_kbn"readonly=on value="'+ kbn[answer_kbn] +'" ><br>');
	                $('#question_details').append('回答内容：');
	                i = 0;
	                $('#question_details').append('<ul>');
	                $("[name='question_list_name[]']").each(function() {
		                var name = $("[name='question_list_name[]']").eq(i).val();
		                $('#question_details').append('<li>'+ name+'</li>');		                    
		                i++;
		            });
	                $('#question_details').append('</ul>');
	                
	                $('#input_section').empty();
    		        //次に入力するために必要な要素を追加
	                $('#input_section').append('<input type="hidden" name="seq" value = "'+ seq +'"><br>');
    		        $('#input_section').append('質問内容：<input type="text" name="input_question_details_description"><br>');
	                $('#input_section').append('回答区分：<select name = "answer_kbn" size = "1"><option value = "-1">選択</option><option value = "1">複数</option><option value = "2">単一</option><br>');
	                $('#input_section').append('<br>回答内容：<input type="text" name="input_question_lsit_name"><input type="button" value="追加" class="questionListAdd"><br>');
	                $('#input_section').append('<div id="question_awnser_lsit">');
	                $('#input_section').append('</div>');
	                $('#input_section').append('<input type="button" value="追加" class="questionDetailsAdd">');
    		        				                			                	 
		        });
		    });
		});
		</script>
	
</html>