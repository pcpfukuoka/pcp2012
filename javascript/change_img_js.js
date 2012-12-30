function change_img(img_url,img_page_num){
	var image_tag = img_page_num + "_image";
	var form_tag = img_page_num + "_form";
	var im = parent.document.getElementById(image_tag);
	im.src = img_url;

}