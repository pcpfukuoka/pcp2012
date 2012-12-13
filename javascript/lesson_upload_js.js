function form_create(date,page_num,subject_seq,img_tag_name){
	/////////////////////////////////////////////////
	/*					親フレームの操作			*/
	/////////////////////////////////////////////////

	var img_page_num = page_num -1;
	var image_tag = img_page_num + "_image";
	var im = parent.document.getElementById(image_tag);
	im.src = img_tag_name;
	//divタグを取得
	var sub = page_num + "_submit";
	var fo = page_num + "_form";
	var im = page_num + "_image";

	var par = parent.document.getElementById('form');

	var  form = document.createElement("FORM");
	form.setAttribute("action","lesson_upload.php");
	form.setAttribute("method","post");
	form.setAttribute("enctype","multipart/form-data");
	form.setAttribute("target","targetFrame");
	form.setAttribute("id",fo);

	var image=document.createElement("img");
	image.setAttribute("src","../../balckboard/public/images/kokuban.jpg");
	image.setAttribute("width","128");
	image.setAttribute("height","128");
	image.setAttribute("id",im);

	var input1 = document.createElement("INPUT");
	input1.setAttribute("type","hidden");
	input1.setAttribute("name","date");
	input1.setAttribute("value",date);


	var input2 = document.createElement("INPUT");
	input2.setAttribute("type","hidden");
	input2.setAttribute("name","subject_seq");
	input2.setAttribute("value",subject_seq);

	var input3 = document.createElement("INPUT");
	input3.setAttribute("type","hidden");
	input3.setAttribute("name","page_num");
	input3.setAttribute("value",page_num);


	var input4 = document.createElement("INPUT");
	input4.setAttribute("type","file");
	input4.setAttribute("name","upfile");
	input4.setAttribute("size","30");


	var input5 = document.createElement("INPUT");
	input5.setAttribute("type","submit");
	input5.setAttribute("value","追加");
	input5.setAttribute("id",sub);

	//作成した属性の付与
	form.appendChild(input1);
	form.appendChild(input2);
	form.appendChild(input3);
	form.appendChild(input4);
	form.appendChild(image);
	form.appendChild(input5);

	par.appendChild(form);

	page_num = page_num -1;

	sub = page_num + "_submit";
	fo = page_num + "_form";

	var change_sub = parent.document.getElementById(sub);
	var change_fo = parent.document.getElementById(fo);


	change_fo.action="change_img.php";
	change_sub.value= "変更";
}