function form_create(date,page_num,subject_seq,img_tag_name){
	/////////////////////////////////////////////////
	/*					親フレームの操作			*/
	/////////////////////////////////////////////////

	//tableタグを取得
	var table_ele=parent.document.getElementById("img_table");
	var pa=Number(page_num);

	if(pa%5==0){
		pa--;
	}
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
	var td_name = img_page_num+"_td";
	var td=document.createElement("td");
	td.setAttribute("id",td_name);
	tr_ele.appendChild(td).appendChild(image);
	//タグが必要な時の処理
	if(page_num%8==0){

		/* thを作成して１列分のヘッダーを作成*/
		var tr_=document.createElement("tr");
		var th_val=page_num/8;
		th_val=th_val+1+"_th";
		tr_.setAttribute("id",th_val);
		//tableにヘッダー用のtrを追加
		table_ele.appendChild(tr_);

		var next_th=page_num+1;
		var e="<th width='100'><font size='3'>"+next_th+"</font></th>";
		next_th++;
		for(i=1;i<8;i++){
			e=e+"<th width='100'><font size='3'>"+next_th+"</font></th>";
			next_th++;
		}
		var insert_tr = parent.document.getElementById(th_val);
		$(insert_tr).append(e);


		/*　trを追加して１列を追加する処理　*/
		var tbody=document.getElementsByTagName('tbody');
		var tr_val=page_num/8;
		tr_val=tr_val+1+"_tr";
		var tr_=document.createElement("tr");
		tr_.setAttribute("id",tr_val);

		//tableに追加
		table_ele.appendChild(tr_);
	}

	var page_name=page_num+"_page";
	var page_ele=parent.document.getElementById(page_name);

	//changeのselectboxにページ数の追加
	var change_sel=parent.document.getElementById("page_num_change");

	if(change_sel.options.length==0){

		//select_boxに何もない場合の追加の処理
		change_sel.options[0]=new Option(page_num,page_num);
	}else{
		//通常の追加の処理
		change_sel.options[change_sel.options.length]=new Option(page_num,page_num);
	}

	//deleteのselectboxにページ数の追加
	var delete_sel=parent.document.getElementById("page_num_del");

	if(delete_sel.options.length==0){

		//select_boxに何もない場合の追加の処理
		delete_sel.options[0]=new Option(page_num,page_num);
	}else{

		//通常の追加の処理
		delete_sel.options[delete_sel.options.length]=new Option(page_num,page_num);
	}
	page_num++;
	page_ele.value=page_num;
	page_ele.id=page_num+"_page";
}