function form_create(date,page_num,subject_seq,img_tag_name){
	/////////////////////////////////////////////////
	/*					親フレームの操作			*/
	/////////////////////////////////////////////////

	//divタグを取得
	var di=parent.document.getElementById("form");
	var pa=page_num;


	var img_page_num = page_num;
	var image_tag = img_page_num + "_image";
	var im = page_num + "_image";
	var image=document.createElement("img");
	image.setAttribute("src",img_tag_name);
	image.setAttribute("width","128");
	image.setAttribute("height","128");
	image.setAttribute("id",im);
	//作成した属性の付与
	di.appendChild(image);
	//brタグが必要な時の処理
	if(pa%5==0){
		var br_val=pa/5;
		br_val=pa+"_br";
		var br_=document.createElement("br");
		br_.setAttribute("id",br_val);
		di.appendChild(br_);
	}
	var page_name=pa+"_page";
	var page_ele=parent.document.getElementById(page_name);

	//selectboxにページ数の追加
	var change_sel=parent.document.getElementById("page_num_change");
	var option='<option value="'+pa+'" id="'+pa+'_op">'+pa+'</option>'
	change_sel.appendChild(option);
	pa++;
	page_ele.value=pa;
	page_ele.id=pa+"_page";
}