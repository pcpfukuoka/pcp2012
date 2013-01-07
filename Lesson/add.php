<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$date = $_POST['date'];
	echo $date;
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



	<?php
		$sql2 = 'SELECT page_num, div_url FROM board WHERE date ="'.$date .'"AND subject_seq ="'.$subject_seq.'";';
		$result2 = mysql_query($sql2);
		$count2 = mysql_num_rows($result2);
		$page_max = 1;
		if($count2 > 0)
		{
			for ($i = 0; $i < $count2; $i++)
			{
				$row = mysql_fetch_array($result2);


				$now_page = $i + 1;
				echo "now_page:";
				echo $now_page;
				echo "/";

				echo $row['page_num'];
				echo "/";
				echo $row['div_url'];

				$aaa = substr($row['div_url'],18);

				$bbb = substr($aaa,0,strlen($aaa)-1);
				$img_tag_name = '../../balckboard/public/images/div/'.$bbb;

	?>
				<form action="change_img.php" method="post" enctype="multipart/form-data" target="targetFrame" id="<?= $now_page ?>_form">
					<input type="hidden" id="date" value=" <?= $date ?>" />
					<input type="hidden" id="subject_seq" value=" <?= $subject_seq ?>" />
					<input type= "hidden" name="page_num" value= "<?= $row['page_num'] ?>" id="<?= $row['page_num'] ?>_page"/>
					<input type="file" name="upfile" size="30" />
					<img border="1" src="<?= $img_tag_name ?>" width="128" height="128" id="<?=$now_page ?>_image">

					<input type="submit"  id="<?= $now_page?>_submit" value="変更" />
					<input type="button"  id="<?= $now_page?>_delete" value="削除" onclick="delete_img(<?= $now_page?>)"/>
				</form>

	<?php

			$page_max = $row['page_num'];
			}
			$page_max++;
		}




		//データベースを閉じる
		Dbdissconnect($dbcon);
	?>


			<form action="lesson_upload.php" method="post" enctype="multipart/form-data" target="targetFrame" id="<?= $page_max ?>_form">
				<input type="hidden" name="date" value="<?= $date ?>" />
				<input type="hidden" name="subject_seq" value="<?= $subject_seq ?>" />
				<input type= "hidden" name="page_num" value="<?= $page_max ?>" id="<?= $page_max ?>_page"/>
				ファイル：<br/>
				<input type="file" name="upfile" size="30" />
				<img border="1" src="../../balckboard/public/images/kokuban.jpg" width="128" height="128" id="<?=$page_max ?>_image">
				<input type="submit" id="<?= $page_max ?>_submit" value="追加" />
			</form>
		</div>
		<iframe name="targetFrame" id="targetFrame" ></iframe>
		<!--  style="display:none;"-->

	</body>
	<script>
	$(function() {

		$(document).on('click', '.img_', function() {

	        $.post('', {
	            id : group_seq
	        });
	    });
	});
	function delete_img(page_num){

		var date_ele=document.getElementById('date_hidden');
		var subject_ele=document.getElementById('subject_seq_hidden');
		var page = page_num;
		//日付と科目を変数に格納
		var date=date_ele.value;
		var subject_seq=subject_ele.value;
		$.post('lesson_page_delete.php',{
	        date:date,
	        id:subject_seq,
	        num:page
	    },
	    function(rs) {
		    var parsers=JSON.parse(rs);

			//要素の削除
			var fo=parsers[0]['delete_page']+"_form";
			var delete_form=document.getElementById(fo);
			var aaa="#"+delete_form;
			$(aaa).remove();




		    //for文内で使う変数を宣言
		    var select_num;
			var pa;
			var img;
			var sub;
			var form_ele;
			var page_ele;
			var img_ele;
			var submit_ele;
			var del;
			var del_button_ele;
			//要素のＩＤの更新
			for(i=Number(parsers[0]['delete_page']);i<=Number(parsers[0]['max_page']);i++){
				if(i<parsers[0]['max_page']){
					select_num=i+1;
					//取得するidを生成
					fo=select_num+"_form";
					pa=select_num+"_page";
					img=select_num+"_image";
					sub=select_num+"_submit";
					del=select_num+"_delete";

					//更新するidの取得
					form_ele=document.getElementById(fo);
					page_ele=document.getElementById(pa);
					img_ele=document.getElementById(img);
					submit_ele=document.getElementById(sub);
					del_button_ele=document.getElementById(del);


					//idを１マイナスして、新しいidとする
					fo=i+"_form";
					pa=i+"_page";
					img=i+"_image";
					sub=i+"_submit";
					del=i+"_delete";
					form_ele.id=fo;
					page_ele.id=pa;
					img_ele.id=img;
					submit_ele.id=sub;
					del_button_ele.id=del;
				}
				else if(i==Number(parsers[0]['max_page'])){
					select_num=i+1;
					//取得するidを生成
					fo=select_num+"_form";
					pa=select_num+"_page";
					img=select_num+"_image";
					sub=select_num+"_submit";

					//更新するidの取得
					form_ele=document.getElementById(fo);
					page_ele=document.getElementById(pa);
					img_ele=document.getElementById(img);
					submit_ele=document.getElementById(sub);

					//idを１マイナスして、新しいidとする
					fo=i+"_form";
					pa=i+"_page";
					img=i+"_image";
					sub=i+"_submit";
					form_ele.id=fo;
					page_ele.id=pa;
					img_ele.id=img;
					submit_ele.id=sub;
				}
			}

	    });
	}
	</script>

</html>