<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//lesson_preparation.phpから送られてくるデータ
	$date = $_POST['date'];
	$subject_seq = $_POST['subject'];

	//subjectに対応するsubject_nameをデータベースから持ってくる
	$sql = 'SELECT subject_name FROM m_subject WHEREsubject_seq = '. $subject_seq.';';
	$result = mysql_query($sql);


?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<script src="../javascript/jquery-1.8.2.min.js"></script>
	</head>

	<body>


	<font size="5"><?= $date ?>:<?=$result ?></font>
	<div id="form">
		<input type="hidden" id="date_hidden" value="<?= $date ?>" />
		<input type="hidden" id="subject_seq_hidden" value="<?= $subject_seq ?>" />
		<table border="5" id="img_table">
			<tr id="1_th">
	<?php
				for($i=1;$i<=5;$i++){
					echo "<th width='100'><font size='3'>".$i."<font></th>";
				}
	?>
			</tr>
			<tr id="1_tr">


	<?php
		$sql2 = 'SELECT page_num, div_url FROM board WHERE date ="'.$date .'"AND subject_seq ="'.$subject_seq.'";';
		$result2 = mysql_query($sql2);
		$count2 = mysql_num_rows($result2);
		$page_max = 1;
		if($count2 > 0)
		{
			for ($i = 1; $i <= $count2; $i++)
			{
				$row = mysql_fetch_array($result2);


				$now_page = $i + 1;
				$aaa = substr($row['div_url'],18);
				$bbb = substr($aaa,0,strlen($aaa)-1);
				$img_tag_name = '../../balckboard/public/images/div/'.$bbb;

	?>
			<td id="<?=$i ?>_td"><img border="1" src="<?= $img_tag_name ?>" width="128" height="128" id="<?=$i ?>_image"></td>

	<?php
			if($i%5==0){
				$tr_=$i/5;
				$tr_++;
				$tr_=$tr_."_tr";
				$th_=$tr_."_th";

				//thの中身を整える処理
				$th_in=$i+1;
				$max=$th_in+5;
	?>
			</tr>


			<tr id="<?=$th_ ?>">
	<?php
			for($j=th_in;$j<=$max;$j++){
				echo "<th width='100'><font size='3'>".$j."<font></th>";
			}

	 ?>
	 		</tr>
			<tr id="<?= $tr_ ?>">
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
	</div>
			<form action="test_lesson_upload.php" method="post" enctype="multipart/form-data" target="targetFrame" id="form">
				<input type="hidden" name="date" value="<?= $date ?>" />
				<input type="hidden" name="subject_seq" value="<?= $subject_seq ?>" />
				<input type="file" name="upfile" size="30" />
				<input type="hidden" name="page_num" value="<?= $page_max ?>" id="<?= $page_max ?>_page"/>
				<input type="submit"  value="追加" />
			</form>

			<form action="change_img.php" method="post" enctype="multipart/form-data" target="targetFrame" id="change_form">
				<input type="hidden" name="date" value=" <?= $date ?>" />
				<input type="hidden" name="subject_seq" value=" <?= $subject_seq ?>" />
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
				<input type="file" name="upfile" size="30" />
				<input type="submit" id="change" value="変更" />
			</form>

			<form action="change_img.php" method="post" enctype="multipart/form-data" target="targetFrame" id="delete_form">
				<input type="hidden" name="date" value=" <?= $date ?>" />
				<input type="hidden" name="subject_seq" value=" <?= $subject_seq ?>" />
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
				<input type="button" id="delete" value="削除" onclick="delete_img()"/>
			</form>

		<iframe name="targetFrame" id="targetFrame" ></iframe>
		<!--  style="display:none;"-->

	</body>
	<script>
	$(function() {

	});
	function delete_img(){

		var date_ele=document.getElementById('date_hidden');
		var subject_ele=document.getElementById('subject_seq_hidden');
		var page=document.getElementById('page_num_del');
		var page_val=page.value;
		//日付と科目を変数に格納
		var date=date_ele.value;
		var subject_seq=subject_ele.value;
		$.post('lesson_page_delete.php',{
	        date:date,
	        id:subject_seq,
	        num:page_val
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
			for(i=Number(parsers[0]['delete_page']);i<Number(parsers[0]['max_page']);i++){

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
			var del_im=parsers[0]['max_page']+"td";
			var delete_form=document.getElementById(del_im);
			$(delete_form).remove();

			//要素が１列なtrタグが存在する場合の処理
			if(Number(parsers[0]['max_page'])%5==0){
				var tr_del=Number(parsers[0]['max_page'])/5+1;
				tr_del =tr_del+"_tr";
				var delete_tr=document.getElementById(tr_del);
				//最終列のbrを削除
				$(delete_tr).remove();
			}
			//更新するselectboxのＩＤを生成
			var del_cha=Number(parsers[0]['max_page'])+"_cha";
			var del_del=Number(parsers[0]['max_page'])+"_del";

			//更新するselectboxを取得
			var delete_cha=document.getElementById("page_num_change");
			var delete_del=document.getElementById("page_num_del");

			//selectboxを更新
			delete_cha.options[delete_cha.options.length-1].remove();
			delete_del.options[delete_del.options.length-1].remove();

			//追加ボタンのpage_numを一つ減らす
			var sub_num=Number(parsers[0]['max_page'])+1;
			var sub=sub_num+"_page";
			var page_ele=document.getElementById(sub);
			page_ele.value=sub_num-1;
			page_ele.id=sub_num-1+"_page";
	    });
	}
	</script>

