<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//subject_seq,subject_nameを持ってくるＳＱＬ
	$sql = "SELECT subject_seq, subject_name FROM m_subject;";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	$group_sel = "SELECT group_seq,group_name FROM pcp2012.m_group WHERE class_flg =1;";
	$group_result = mysql_query($group_sel);
	$count2 = mysql_num_rows($group_result);
	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/old_lesson_js.js" type = "text/javascript"></script>
		<script src="../javascript/jquery-1.8.2.min.js"></script>
		<link rel="stylesheet" href="../css/old_lesson_canvas_css.css">
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">

		<input type="date" id="date" max="<?= date("Y-m-d") ?>"/>
		<select id="subject_seq">
			<?php
				for ($i = 0; $i < $count; $i++)
				{
					$row = mysql_fetch_array($result);
			?>
    			<option value="<?= $row['subject_seq']?>"><?= $row['subject_name'] ?></option>
			<?php
				}
			?>
		</select>

		<select id="group_seq">
			<?php
				for ($i = 0; $i < $count2; $i++)
				{
					$row2 = mysql_fetch_array($group_result);
			?>
    			<option value="<?= $row2['group_seq']?>"><?= $row2['group_name'] ?></option>
			<?php
				}
			?>
		</select>
		<input type="button" value="決定" id="decision" disabled=disabled>
		<div id="frame">
		</div>
</div>
	</body>
	<script>
	$(function() {//決定ボタンをクリックした後の過去授業の画像を出力する処理

		//ボタンをすべて選択した後に決定ボタンを表示
		$(document).on('change', '#date', function() {
			var decision_ele =document.getElementById("decision");
			decision_ele.disabled=false;
	    });
		//決定ボタンをクリックした後の過去授業の画像を出力する処理
		$(document).on('click', '#decision', function() {

			$('#frame').empty();
			//ボタンを連続で押させないようにする
			var button_ele=document.getElementById('decision');
			button_ele.disabled=true;

			var date_ele=document.getElementById('date');
			var subject_ele=document.getElementById('subject_seq');
			var group_ele=document.getElementById('group_seq');

			//日付と科目を変数に格納
			var date=date_ele.value;
			var subject_seq=subject_ele.value;
			var group_seq=group_ele.value;

			$.post('ajax_canvas_select.php',{
		        date: date,
		        id : subject_seq,
		        group: group_seq
		    },
		    function(rs) {
		    	var parsers = JSON.parse(rs);

		    	if(parsers.length>0){
		    		var e='<div id="chalkboard" style="background:'+parsers[0]['div']+';background-repeat:no-repeat height="440" width="680">'
		    		+'<img src="'+parsers[0]['canvas']+'"id="canvas" height="440" width="680"/>'
		    		+'</div>'
		    		+'<table>'
		    		+'<tr>'
		    		+'<td><input class="button4" id="turn" value="戻る" type="button"></td>'
		    		+'<td><input class="button4" id="next" value="次へ"type="button"></td>'
		    		+'<input type="hidden" value=0 id="page_num"value="0">';
		    		+'</tr>'
		    		+'</table>'
		    		$('#frame').append(e);
		    		//押せなくしたボタンを元に戻す
					var button_ele=document.getElementById('decision');
					button_ele.disabled=false;
		    	}
		    });
	    });

	    $(document).on('click','#next',function(){

	    	var date_ele=document.getElementById('date');
			var subject_ele=document.getElementById('subject_seq');
			var group_ele=document.getElementById('group_seq');
			var date=date_ele.value;
			var subject_seq=subject_ele.value;
			var group_seq=group_ele.value;

	    	var page_ele =document.getElementById('page_num');
	    	var page= Number(page_ele.value);

	    	$.post('ajax_canvas_select.php', {
	            date: date,
	            id : subject_seq,
	            group : group_seq
	        },
	        //戻り値として、user_seq受け取る
	        function(rs) {

	        	var div_ele =document.getElementById('chalkboard');
		    	var canvas_ele =document.getElementById('canvas');
	        	var parsers = JSON.parse(rs);
				page++;
				if(page>parsers.length-1){
					page--;
				}
				canvas_ele.src=parsers[page]['canvas'];
				div_ele.style.background=parsers[page]['div'];
				page_ele.value=page;
	        });
		});

	    $(document).on('click','#turn',function(){

	    	var date_ele=document.getElementById('date');
			var subject_ele=document.getElementById('subject_seq');
			var group_ele=document.getElementById('group_seq');

			var date=date_ele.value;
			var subject_seq=subject_ele.value;
			var group_seq=group_ele.value;
	    	var page_ele =document.getElementById('page_num');
	    	var page= Number(page_ele.value);

	    	$.post('ajax_canvas_select.php', {
	            date: date,
	            id : subject_seq,
	            group : group_seq
	        },
	        function(rs){

	        	var div_ele =document.getElementById('chalkboard');
		    	var canvas_ele =document.getElementById('canvas');
	        	var parsers = JSON.parse(rs);
				page--;
				if(page<0){
					page=0;
				}
				canvas_ele.src=parsers[page]['canvas'];
				div_ele.style.background=parsers[page]['div'];
				page_ele.value=page;
	        });
		});

	});
	</script>
</html>