function form_create(date,page_num,subject_seq){

	var par = parent.document.getElementById('form')

	var  form = document.createElement("FORM");
	form.setAttribute("action","lesson_upload.php");
	form.setAttribute("method","post");
	form.setAttribute("enctype","multipart/form-data");
	form.setAttribute("target","targetFrame");


	var input1 = document.createElement("INPUT");
	input1.setAttribute("type","hidden");
	input1.setAttribute("name","date");
	input1.setAttribute("value",date);

	console.log("日付は：");
	console.log(date);

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


	form.appendChild(input1);


	form.appendChild(input2);
	form.appendChild(input3);
	form.appendChild(input4);
	form.appendChild(input5);

	par.appendChild(form);
}