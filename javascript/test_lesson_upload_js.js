function form_create(date,page_num,subject_seq,img_tag_name){
	/////////////////////////////////////////////////
	/*					親フレームの操作			*/
	/////////////////////////////////////////////////

	//tableタグを取得
	var table_ele=parent.document.getElementById("img_table");
	var pa=Number(page_num);

	//imageを追加するtrタグを取得
	var insert_tr=Math.floor(pa/5)+1;
	var tr_name=insert_tr+"_tr";
	var tr_ele=parent.document.getElementById(tr_name);

	var img_page_num = page_num;
	var image_tag = img_page_num + "_image";
	var im = page_num + "_image";
	var image=document.createElement("img");
	image.setAttribute("src",img_tag_name);
	image.setAttribute("width","128");
	image.setAttribute("height","128");
	image.setAttribute("id",im);
	//作成した属性の付与
	table_ele.appendChild(image);
	//タグが必要な時の処理
	if(pa%5==0){
		var br_val=pa/5;
		br_val=br_val+1+"_br";
		var br_=document.createElement("tr");
		br_.setAttribute("id",br_val);
		table_ele.appendChild(br_);
	}

	var page_name=pa+"_page";
	var page_ele=parent.document.getElementById(page_name);

	//changeのselectboxにページ数の追加
	var change_sel=parent.document.getElementById("page_num_change");
	if(change_sel.options.length==0){
		change_sel.options[0]=new Option(pa,pa);
	}else{
		change_sel.options[change_sel.options.length]=new Option(pa,pa);
	}

	//deleteのselectboxにページ数の追加
	var delete_sel=parent.document.getElementById("page_num_del");
	if(delete_sel.options.length==0){
		delete_sel.options[0]=new Option(pa,pa);
	}else{
		delete_sel.options[delete_sel.options.length]=new Option(pa,pa);
	}
	pa++;
	page_ele.value=pa;
	page_ele.id=pa+"_page";
}