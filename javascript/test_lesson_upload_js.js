function form_create(date,page_num,subject_seq,img_tag_name){
	/////////////////////////////////////////////////
	/*					親フレームの操作			*/
	/////////////////////////////////////////////////

	//divタグを取得
	var di=parent.document.getElementById("form");
	var pa=page_num-1;
	//brタグが必要な時の処理
	if(pa%5==0){
		pa=pa/5;
		pa=pa+"_br";
		var br_=document.createElement("br");
		br_.setAttribute("id",pa);
		di.appendChild(br_);
	}

	var img_page_num = page_num;
	var image_tag = img_page_num + "_image";

	im.src = img_tag_name;
	var im = page_num + "_image";
	var image=document.createElement("img");
	image.setAttribute("src",img_tag_name);
	image.setAttribute("width","128");
	image.setAttribute("height","128");
	image.setAttribute("id",im);
	//作成した属性の付与
	di.appendChild(image);
}