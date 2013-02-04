<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//lesson_preparation.phpから送られてくるデータ
	$date = $_POST['date'];
	$subject_seq = $_POST['subject'];
	$group_seq = $_POST['group'];

	//subjectに対応するsubject_nameをデータベースから持ってくる
	$sql = 'SELECT subject_name FROM m_subject WHERE subject_seq = '. $subject_seq.';';
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	//group_seqに対応するgroup_nameをデータベースから持ってくる
	$group_sel = "SELECT group_name FROM pcp2012.m_group WHERE group_name=".$group_seq.";";
	$group_result = mysql_query($group_sel);
	$row2 = mysql_fetch_array($group_result);



?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<script src="../javascript/jquery-1.8.2.min.js"></script>
		<link href='https://xxx/bootstrap.min.css' rel='stylesheet' type='text/css'/>
				<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />

	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont"><?= $date ?>:<?=$row['subject_name'] ?>:<?=$row2['group_name'] ?></font>
			</div>
			<hr color="blue"></hr>
	<br>
	<div id="form">
		<input type="hidden" id="date_hidden" value="<?= $date ?>" />
		<input type="hidden" id="subject_seq_hidden" value="<?= $subject_seq ?>" />
		<input type="hidden" id="group_seq_hidden" value="<?= $group_seq ?>" />
	<?php
		$sql2 = 'SELECT page_num, div_url FROM board WHERE date ="'.$date .'"AND subject_seq ="'.$subject_seq.'" AND class_seq="'.$group_seq.'" AND end_flg="0";';
		$result2 = mysql_query($sql2);
		$count2 = mysql_num_rows($result2);
		$page_max = $count2+1;
	?>
	<table border="0">
		<tr>
			<td>追加</td>
			<td></td>
			<td>
				<form action="test_lesson_upload.php" method="post" enctype="multipart/form-data" target="targetFrame" id="form">
					<input type="hidden" name="date" value="<?= $date ?>" />
					<input type="hidden" name="subject_seq" value="<?= $subject_seq ?>" />
					<input type="hidden" name="group_seq" value="<?= $group_seq ?>" />
					<input type="file" name="upfile" size="30" id="upload_file" style="display: none;"/>
					<span id="div_dummy" class="input-append">
						<img src="../images/kamera_sum.png" id="dummy_img"onclick="$('#upload_file').click();" class="btn btn-primary">
						<input id="cover" class="input-xlarge" type="text" placeholder="select file" autocomplete="off" style="readonly;"class="input-large">
					</span>
			</td>
			<td>
					<input type="hidden" name="page_num" value="<?= $page_max ?>" id="page_num"/>
					<input class="button4" type="submit"  value="追加" disabled=disabled id="upload_decision"/>
				</form>
			</td>
		</tr>
		<tr>
			<td>変更</td>
			<td>
				<form action="change_img.php" method="post" enctype="multipart/form-data" target="targetFrame" id="change_form">
					<input type="hidden" name="date" value=" <?= $date ?>" />
					<input type="hidden" name="subject_seq" value=" <?= $subject_seq ?>" />
					<input type="hidden" name="group_seq" value=" <?= $group_seq ?>" />
					<select id="page_num_change" name="page_num_change">
					<?php
			   			for ($i=1; $i<=$count2; $i++)
			   			{
		  			?>
		    			<option value="<?=$i?>" id="<?=$i?>_cha"><?=$i?></option>
		  			<?php
		    			}
		  			?>
					</select>
			</td>
			<td>
					<input type="file" name="upfile" size="30" id="change_file" style="display: none;"/>
					<span id="div_dummy" class="input-append">
						<img src="../images/kamera_sum.png" id="dummy_img"onclick="$('#change_file').click();" class="btn btn-primary">
						<input id="change_cover" class="input-xlarge" type="text" placeholder="select file" autocomplete="off" style="readonly;"class="input-large">
					</span>
			</td>
			<td>
					<input class="button4" type="submit"  value="変更"  disabled=disabled id="change_decision"/>
				</form>
			<td>
		</tr>
		<tr>
			<td>削除</td>
			<td>
				<form action="change_img.php" method="post" enctype="multipart/form-data" target="targetFrame" id="delete_form">
					<input type="hidden" name="date" value=" <?= $date ?>" />
					<input type="hidden" name="subject_seq" value=" <?= $subject_seq ?>" />
					<input type="hidden" name="group_seq" value=" <?= $group_seq ?>" />
					<select name="page_num_del" id="page_num_del">
					<?php
			   			for ($i=1; $i<=$count2; $i++)
			   			{
		  			?>
		    			<option value="<?=$i?>"id="<?=$i ?>_del"><?=$i?></option>
		  			<?php
		   				}
		  			?>
					</select>
			</td>
			<td></td>
			<td>
					<input  class="button4" type="button"  value="削除" onclick="delete_img()" id="delete_decision" disabled=disabled/>
				</form>
			</td>
		</tr>
	</table>

		<table border="5" id="img_table" style="position: absolute;top:30%;left:42%;">
			<tr id="1_th">
	<?php
				for($i=1;$i<=5;$i++){
					echo "<th width='90'><font size='3'>".$i."<font></th>";
				}
	?>
			</tr>
			<tr id="1_tr">
	<?php

		$sql3 = 'SELECT page_num, div_url FROM board WHERE date ="'.$date .'"AND subject_seq ="'.$subject_seq.'"AND class_seq='.$group_seq.' AND end_flg="0";';
		$result3 = mysql_query($sql3);
		$count3 = mysql_num_rows($result3);

		$page_max = 1;
		if($count3 > 0)
		{
			for ($i = 1; $i <= $count3; $i++)
			{
				$row = mysql_fetch_array($result3);


				$now_page = $i + 1;
				$aaa = substr($row['div_url'],18);
				$bbb = substr($aaa,0,strlen($aaa)-1);
				$img_tag_name = '../../balckboard/public/images/div/'.$bbb;

	?>
			<td id="<?=$i ?>_td"><img border="1" src="<?= $img_tag_name ?>" width="90" height="90" id="<?=$i ?>_image"></td>

	<?php
			if($i%5==0){
				$tr_=$i/5;
				$tr_++;
				$tr_id=$tr_."_tr";
				$th_id=$tr_."_th";

				//次の行の最初のｔｈの値
				$th_in=$i+1;
				//thの一列の最大値
				$max=$th_in+5;
	?>
			</tr>


			<tr id="<?=$th_id ?>">
	<?php
			//headerを一列分出力
			for($j=$th_in;$j<$max;$j++){
				echo "<th width='90'><font size='3'>".$j."<font></th>";
			}

	 ?>
	 		</tr>
			<tr id="<?= $tr_id ?>">
	<?php
			}

			$page_max = $row['page_num'];
			}
			$page_max++;
		}




		//データベースを閉じる
		Dbdissconnect($dbcon);
	?>
			</tr>
		</table>

			<form action="using_change.php" method="post" enctype="multipart/form-data" >
			<input type="hidden" name="date" value=" <?= $date ?>" />
			<input type="hidden" name="subject_seq" value="<?= $subject_seq ?>" />
			<input type="hidden" name="group_seq" value="<?= $group_seq ?>" />
			<input class="button3" type="submit" value="授業開始" id="lesson_start" onsubmit="return check()">
		</form>
	</div>
		<iframe name="targetFrame" id="targetFrame" style="display:none;"></iframe>
</div>
	</body>
	<script>
	$(function() {

		function check(){
			var page_num=document.getElementById("page_num");
			if(Number(page_num.value)<1){
				 alert("画像を１枚以上準備してください");
                 return false;
			}
		}

		$('#upload_file').change(function(){
			//ファイルの名前をテキストに反映
			 $('#cover').val($(this).val());
	    });

		$('#change_file').change(function(){
			//ファイルの名前をテキストに反映
			 $('#change_cover').val($(this).val());
	    });
		//画像が１まいでもある時に授業開始ボタンを押せるようにする
		//アップロードする画像を決めたとき(追加)
		$(document).on('change', '#upload_file', function() {

			//画像の追加ボタンを押せるようにする
			var upload_ele=document.getElementById("upload_decision");
			upload_ele.disabled=false;
	    });

		//アップロードする画像を決めたとき（変更）
		$(document).on('change', '#change_file', function() {

			//画像の変更ボタンを押せるようにする
			var change_ele=document.getElementById("change_decision");
			change_ele.disabled=false;
	    });

		//背景画像するために画像を選択したとき
		$(document).on('change', '#change_file', function() {
			var change_ele=document.getElementById("change_decision");
			change_ele.disabled=false;
	    });

		//画像を追加ボタンを押したとき
		$(document).on('click', '#upload_decision', function() {

			//画像の削除をおせるようにする
			var delete_ele=document.getElementById("delete_decision");
			delete_ele.disabled=false;
	    });

	});
	//画像を削除する関数
	function delete_img(){

		//postするデータをとってくる
		var date_ele=document.getElementById('date_hidden');
		var subject_ele=document.getElementById('subject_seq_hidden');
		var group_ele=document.getElementById('group_seq_hidden');
		var page=document.getElementById('page_num_del');
		var page_val=page.value;

		//日付と科目を変数に格納
		var date=date_ele.value;
		var subject_seq=subject_ele.value;
		var group_seq=group_ele.value;
		$.post('lesson_page_delete.php',{
	        date:date,
	        id:subject_seq,
	        num:page_val,
	        group_seq:group_seq
	    },
	    function(rs) {
		    var parsers=JSON.parse(rs);

		    //parsers[0]['delete_page'] => 削除するページ　parsers[0]['max_page'] => 削除前のページ数

			//削除するページのタグＩＤ
			var del=parsers[0]['delete_page']+"_image";

			var after_image;
			var before_image;
			var after_ele;
			var after_ele;
			//画像urlの繰り上げ処理
			for(i=Number(parsers[0]['delete_page']);i<Number(parsers[0]['max_page'][0]);i++){

				//取得するidの形成
				after_image=i+"_image";
				before_image=i+1+"_image";

				//画像を取得
				after_ele=document.getElementById(after_image);
				before_ele=document.getElementById(before_image);

				//urlを繰り上げ処理
				after_ele.src=before_ele.src;
			}
			//一番最後の要素を削除
			var del_im=parsers[0]['max_page'][0]+"_td";
			var delete_form=document.getElementById(del_im);
			$(delete_form).remove();

			//要素が１列なくtrタグが存在する場合の処理
			if(Number(parsers[0]['max_page'][0])%5==0){
				var tr_del=Number(parsers[0]['max_page'][0])/5+1;
				var th_del=Number(parsers[0]['max_page'][0])/5+1;
				tr_del =tr_del+"_tr";
				th_del =th_del+"_th";

				var delete_tr=document.getElementById(tr_del);
				var delete_th=document.getElementById(th_del);
				//最終列のtrを削除
				$(delete_tr).remove();
				$(delete_th).remove();
			}
			//更新するselectboxのＩＤを生成
			var del_cha=Number(parsers[0]['max_page'][0])+"_cha";
			var del_del=Number(parsers[0]['max_page'][0])+"_del";

			//更新するselectboxを取得
			var delete_cha=document.getElementById("page_num_change");
			var delete_del=document.getElementById("page_num_del");

			//selectboxを更新
			delete_cha.options[delete_cha.options.length-1].remove();
			delete_del.options[delete_del.options.length-1].remove();

			//追加ボタンのpage_numを一つ減らす
			var sub_num=Number(parsers[0]['max_page'][0])+1;
			var page_ele=document.getElementById("page_num");
			page_ele.value=sub_num-1;
	    });
	}
	</script>


