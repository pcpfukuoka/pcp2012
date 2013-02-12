<?php
session_start();

unset($_SESSION["details"]);
unset($_SESSION["question_info[question_title]"]);
unset($_SESSION["question_info[start_date]"]);
unset($_SESSION["question_info[end_date]"]);
unset($_SESSION["question_info[target_group]"]);
unset($_SESSION["question_info[question_description]"]);

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		 <script src="../javascript/jquery-1.8.2.min.js"></script>
		 <script src="../javascript/form_reference.js"></script>
	</head>
		  <style>
			textarea {
				border:1px solid #ccc;
			}

			.animated {
				vertical-align: top;
				-webkit-transition: height 0.2s;
				-moz-transition: height 0.2s;
				transition: height 0.2s;
			}

		</style>

		<script src='../javascript/autosize.js'></script>


		<script>
			$(function(){
				$('#normal').autosize();
				$('.animated').autosize({append: "\n"});
			});
		</script>
	
	
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">新規登録</font>
			</div>
		<hr color="blue"><br><br>



			<?php
			require_once("../lib/dbconect.php");
			$dbcon = DbConnect();
			$sql = "SELECT * FROM m_group WHERE delete_flg = 0;";
			$result = mysql_query($sql);
			$cnt = mysql_num_rows($result);
			?>

			<form method ="post" action="regist.php"  onSubmit="return check()" >
			<table class="table_01" >
			<tr>
				<td>
					タイトル:
				</td>
				<td>
					<textarea class="animated" id="question_title"  name="question_title" rows="2" cols="50"></textarea>
				</td>
			</tr>
			<tr>
				<td>期間：</td>
				<td><input type="date" name="start_date">〜<input type="date" name="end_date"></td>
			</tr>
			<tr>
				<td>
					対象グループ：
				</td>
				<td>
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
					</select>
				</td>
			</tr>
			<tr>
				<td>
					内容：
				</td>
					<td>
					<textarea class="animated" name="question_description" rows="2" cols="50"></textarea>
				</td>
			</tr>
			<tr>
			
				<td style="background-color:transparent" ></td>
				<td align="right" >
					<input type="button"class="button5"id="questionAdd" value="確定">
				</td>
			</tr>
			</table>
			
			<div id="question_details">
			</div>					
			<div id="input_section">
			</div>
			<table>
			<tr>
				<td>
					<input style="display: none;" id="sub" class="button4" type="submit" value ="登録">
				</td>
			</tr>
			</table>
			</form>
			
		</div>

	</body>
		<script>

		function trim(str) {
			return str.replace(/^[ 　\t\r\n]+|[ 　\t\r\n]+$/g, "");
		}
						
		
		function chengefocus()
		{
			//ボタン有効化
			var str = $('#input_question_lsit_name_text').val();
			str = trim(str);
			if(str == "")
			{
				$('#questionListAdd').css("display","none");
			}
			else
			{
				$('#questionListAdd').css("display","");
				$("#questionListAdd").focus();
			}
		};

		
		$(function() {
			kbn = new Array("","複数", "単一");
			//質問内容追加
			$(document).on('click', '#questionAdd', function() {
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
		    		        var e = $('<table class="table_01" >'+
		    		        '<tr><td>質問内容：</td><td><input type="text" name="input_question_details_description"></td></tr>'+
		    		        '<tr><td>回答区分：</td><td><select name = "answer_kbn" size = "1"><option value = "-1">選択</option><option value = "1">複数</option><option value = "2">単一</option></select></td></tr>'+
		    		        '<tr><td>回答内容：</td><td><input  onblur="chengefocus();" type="text" id="input_question_lsit_name_text" name="input_question_lsit_name"></td><td><input type="button" class="button5" value="追加" id="questionListAdd"  style="display: none;"></td></tr>'+
		    		        '<tr><td style="background-color:transparent" ></td><td style="display: none;" id="show_div" ><div id="question_awnser_lsit">'+
		    		        '</div></td></tr>'+
		    		        '<tr><td><input type="button"class="button5" value="確定" id="questionDetailsAdd" style="display: none;"></td></tr>'+
		    		        '</table>');
			                $('#input_section').append(e);

                	  });
		    });

			//回答内容個別追加
			$(document).on('click', '#questionListAdd', function() {
				$('#show_div').css("display","");
		        var question_name = $("*[name=input_question_lsit_name]").val();
		                	$("*[name=input_question_lsit_name]").val("");
		        	var e = $(
		                    '<li>' +
		                    '<input type="text" value="'+question_name+'" readonly name = "question_list_name[]" >' +
		                    '</li>'
		                );
	                $('#question_awnser_lsit').append(e);

					//ボタン有効化
					$('#questionDetailsAdd').css("display","");
					$('#questionListAdd').css("display","none");
	                
	                
		    });			
			
			//回答一覧追加
			$(document).on('click', '#questionDetailsAdd', function() {

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
				    var list_str_html = "";
	                i = 0;
	                $("[name='question_list_name[]']").each(function() {
		                var name = $("[name='question_list_name[]']").eq(i).val();
		                name = '<li>'+ name+'</li>';
		                list_str_html += name;
		                i++;
		            });


					var one = "";
					var tow = "";

					if(answer_kbn == "1")
					{
						one = "selected";
					}
					if(answer_kbn == "2")
					{
						tow = "selected";
					}
						
	                
		    		//今入力した内容をquestion_detailsに追加
		    		var e = $('<table class="table_01" >'+
		    		        '<tr><td>質問内容：</td><td><input type="text" name="comp_question_details_description" disabled value="'+ question_details_description +'" ></td></tr>'+
		    		        '<tr><td>回答区分：</td><td><select disabled name = "answer_kbn_selected" size = "1"><option value = "-1">選択</option><option value = "1" '+one+' >複数</option><option value = "2" '+tow+'>単一</option></select></td></tr>'+
		    		        '<tr><td>回答内容：</td><td>'+ list_str_html +'</td></tr>'+
		    		        '</table>');
			                $('#question_details').append(e);
	                $('#input_section').empty();
    		        //次に入力するために必要な要素を追加
    		        e = $('<table class="table_01" >'+
    	    		        '<input type="hidden" name="seq" value = "'+ seq +'"><br>'+
		    		        '<tr><td>質問内容：</td><td><input type="text" name="input_question_details_description"></td></tr>'+
		    		        '<tr><td>回答区分：</td><td><select name = "answer_kbn" size = "1"><option value = "-1">選択</option><option value = "1">複数</option><option value = "2">単一</option></select></td></tr>'+
		    		        '<tr><td>回答内容：</td><td><input onblur="chengefocus();" type="text" id="input_question_lsit_name_text" name="input_question_lsit_name"></td><td><input type="button"  class="button5"  value="追加" id="questionListAdd"  style="display: none;"></td></tr>'+
		    		        '<tr><td style="background-color:transparent" ></td><td><div id="question_awnser_lsit">'+
		    		        '</div></td></tr>'+
		    		        '<tr><td><input type="button" class="button5" value="確定" id="questionDetailsAdd"  style="display: none;" ></td></tr>'+
		    		        '</table>');
			                $('#input_section').append(e);
	                
							//ボタン有効化
							$('#sub').css("display","");
		        });
		    });
		});
		function check(){
			if(window.confirm('登録してよろしいですか？')){ // 確認ダイアログを表示
				return true; // 「OK」時は送信を実行
			}
			else{ // 「キャンセル」時の処理
				return false; // 送信を中止
			}
		}
		
		</script>
</html>