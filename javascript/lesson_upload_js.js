$(function(){

	//親オブジェクト = document.getElementByID("ID名");
	parent = parent.document.getElementById('form')
	//<form action="lesson_upload.php" method="post" enctype="multipart/form-data" target="targetFrame">
	//<input type="hidden" name="date" value=" <?= $date ?>" />

		//		<input type= "hidden" name="page_num" value= "1" />
			//	ファイル：<br/>
				//<input type="file" name="upfile" size="30" />


				//<input type="submit" value="追加" />
	form = document.createElement("form");
	form.setAtrribute("action","lesson_upload.php");
	form.setAtrribute("method","post");
	form.setAtrribute("enctype","multipart/form-data");
	form.setAtrribute("target","targetFrame");


	input1 = document.createElement("input");
	input1.setAtrribute("type","hidden");
	input1.setAtrribute("name","date");
	input1.setAtrribute("value","<?= $date ?>");


	input2 = document.createElement("input");
	input2.setAtrribute("type","hidden");
	input2.setAtrribute("name","page_num");
	input2.setAtrribute("value","");


	input3 = document.createElement("input");
	input3.setAtrribute("type","file");
	input3.setAtrribute("name","upfile");
	input3.setAtrribute("size","30");


	input4 = document.createElement("input");
	input4.setAtrribute("type","submit");
	input4.setAtrribute("value","追加");


	form.appendChild(input1);



	form.appendChild(input3);
	form.appendChild(input4);

	parent.appendChild(form);

})