<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//subject_seq,subject_nameを持ってくるＳＱＬ
	$sql = "SELECT subject_seq, subject_name FROM m_subject;";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	/* セッションをもとに自分のクラスしか参加できないようにする */
	//SESSIONでユーザIDの取得
	session_start();
	$user_seq = $_SESSION['login_info[user]'];
	$flg = $_SESSION['position_flg'];

	if($flg == "teacher")/* 先生だったら */
	{
		//全てのクラスの過去授業をみれるようにする
		$class_select = "SELECT group_seq,group_name FROM pcp2012.m_group WHERE class_flg =1;";
	}
	else if($flg == 0)/* 生徒だったら */
	{
		//自分が所属してるgroup_seqを持ってくるSQL
		$class_select ="SELECT m_group.group_seq,m_group.group_name FROM group_details LEFT JOIN pcp2012.m_group
					ON group_details.group_seq=m_group.group_seq
					WHERE group_details.user_seq =".$user_seq." AND m_group.class_flg = '1';";
	}

	$class_select_result = mysql_query($class_select);
	$count3 = mysql_num_rows($class_select_result);

	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/old_lesson_js.js" type = "text/javascript"></script>
		<script src="../javascript/jquery-1.8.2.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/old_lesson_canvas_css.css" />
	</head>

	<body>
		<!-- <img class="bg" src="../images/blue-big.jpg" alt="" /> -->
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
				for ($i = 0; $i < $count3; $i++)
				{
					$row2 = mysql_fetch_array($class_select_result);
			?>
    			<option value="<?= $row2['group_seq']?>"><?= $row2['group_name'] ?></option>
			<?php
				}
			?>
		</select>
		<select id="time_table">
    			<option value="1">１時間目</option>
    			<option value="2">２時間目</option>
    			<option value="3">３時間目</option>
    			<option value="4">４時間目</option>
    			<option value="5">５時間目</option>
    			<option value="6">６時間目</option>
		</select>
		<input type="button" value="決定" id="decision" disabled=disabled>
		<input type="button" value="閲覧終了" id="end">
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

		//閲覧終了ボタンを押した際に、windowを閉じる
		$(document).on('click', '#end', function() {
			window.close();
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
			var time_table_ele=document.getElementById('time_table');

			//日付と科目を変数に格納
			var date=date_ele.value;
			var subject_seq=subject_ele.value;
			var group_seq=group_ele.value;
			var time_table=time_table_ele.value;

			$.post('ajax_canvas_select.php',{
		        date: date,
		        id : subject_seq,
		        group: group_seq,
		        time_table:time_table
		    },
		    function(rs) {
		    	var parsers = JSON.parse(rs);

		    	if(parsers.length>0){
		    		var e='<div id="chalkboard" style="background:'+parsers[0]['div']+';background-repeat:no-repeat; height="600" width="900">'
		    		+'<img src="'+parsers[0]['canvas']+'"id="canvas" height="600" width="900"/>'
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
		    	else{
			    	var nothing_alart = '<font class="Cubicfont">その授業はありません。</font>';
			    	$('#frame').append(nothing_alart);
			    	var button_ele=document.getElementById('decision');
					button_ele.disabled=false;

			    }
		    });
	    });

	    $(document).on('click','#next',function(){

	    	var date_ele=document.getElementById('date');
			var subject_ele=document.getElementById('subject_seq');
			var group_ele=document.getElementById('group_seq');
			var time_table_ele=document.getElementById('time_table');
			var date=date_ele.value;
			var subject_seq=subject_ele.value;
			var group_seq=group_ele.value;
			var time_table=time_table_ele.value;

	    	var page_ele =document.getElementById('page_num');
	    	var page= Number(page_ele.value);

	    	$.post('ajax_canvas_select.php', {
	            date: date,
	            id : subject_seq,
	            group : group_seq,
	            time_table:time_table
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
				div_ele.style.background-Repeat='no-repeat';
				page_ele.value=page;
	        });
		});

	    $(document).on('click','#turn',function(){

	    	var date_ele=document.getElementById('date');
			var subject_ele=document.getElementById('subject_seq');
			var group_ele=document.getElementById('group_seq');
			var time_table_ele=document.getElementById('time_table');

			var date=date_ele.value;
			var subject_seq=subject_ele.value;
			var group_seq=group_ele.value;
			var time_table=time_table_ele.value;
	    	var page_ele =document.getElementById('page_num');
	    	var page= Number(page_ele.value);

	    	$.post('ajax_canvas_select.php', {
	            date: date,
	            id : subject_seq,
	            group : group_seq,
	            time_table : time_table
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
				div_ele.style.backgroundAttachment='fixed';
				page_ele.value=page;
	        });
		});

	});
	</script>
</html>