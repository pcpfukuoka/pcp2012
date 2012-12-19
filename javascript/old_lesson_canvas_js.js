function turn(div,canvas){
	var page =document.getElementById('page_num');
	var div =document.getElementById('chalkboard');
	var canvas =document.getElementById('canvas');


	var div_list=div.split(",");
	var canvas_list=canvas.split(",");

	//戻ったためひとつ前にカーソルをそろえる
	page=page-1;

	if(page==0){
		page=0;
	}

	div.style.background=div_list[page];


	canvas.src=canvas_list[page];

	page.value=page;
}

function next(div,canvas){

	var page =document.getElementById('page_num');
	var div =document.getElementById('chalkboard');
	var canvas =document.getElementById('canvas');


	var div_list=div.split(",");
	var canvas_list=canvas.split(",");
	var list_num=div_list.length;

	//戻ったためひとつ前にカーソルをそろえる
	page=page+1;

	if(page > list_num-1){
		page=list_num-1;
	}

	div.style.background=div_list[page];
	canvas.src=canvas_list[page];

	page.value=page;
}