function delete_img(page_num){

	var date_ele=document.getElementById('date');
	var subject_ele=document.getElementById('subject_seq');

	//日付と科目を変数に格納
	var date=date_ele.value;
	var subject_seq=subject_ele.value;
	var id_name=page_num+"_delete";
	$(id_name).remove();
	$.post('ajax_canvas_select.php',{
        date: date,
        id : subject_seq
        num : page_num
    },
    function(rs) {
    	var parsers = JSON.parse(rs);
    	$('#frame').append(e);
    });
}