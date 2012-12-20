function turn(div,canvas){
	//
	var page_ele =document.getElementById('page_num');
	var div_ele =document.getElementById('chalkboard');
	var canvas_ele =document.getElementById('canvas');
	var page= Number(page_ele.value);


	var div_list=div.split("あ");
	var canvas_list=canvas.split("あ");

	//戻ったためひとつ前にカーソルをそろえる
	page=page-1;

	if(page==-1){
		page=0;
	}

	div_ele.style.background=div_list[page];


	canvas_ele.src=canvas_list[page];

	page_ele.value=page;
}

function next(div,canvas){

	var page_ele =document.getElementById('page_num');
	var div_ele =document.getElementById('chalkboard');
	var canvas_ele =document.getElementById('canvas');
	var page= Number(page_ele.value);

	var div_list=div.split("あ");
	var canvas_list=canvas.split("あ");
	var list_num=div_list.length;

	//進んだためひとつ後にカーソルをそろえる
	page=page+1;

	if(page > list_num-1){
		page=list_num-1;
	}

	div_ele.style.background=div_list[page];
	canvas_ele.src=canvas_list[page];

	page_ele.value=page;
}