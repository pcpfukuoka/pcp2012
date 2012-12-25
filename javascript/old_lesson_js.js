

function decision_click(){
	var date_ele=document.getElementById('date');
	var subject_ele=document.getElementById('subject_seq');

	//日付と科目を変数に格納
	var date=date_ele.value;
	var subject_seq=subject_ele.value;

	$('frame').empty();
	$.post('ajax_canvas_select.php', {
        date: date,
        id : subject_seq
    },
    //戻り値として、user_seq受け取る
    function(rs) {

    	var parsers = JSON.parse(rs);
    	append_tag(parsers);
    });
}

function append_tag(parsers){
	var e='<div id="chalkboard" style="background:'+parsers[0][div]+';background-repeat:no-repeat">'
	+'<img src="'+parsers[0][div]+'"id="canvas" />'
	+'</div>'
	+'<input id="turn" value="戻る" type="button">'
	+'<input id="next" value="次へ"type="button">'
	+'<input type="hidden" value=0 id="page_num"value="0">';


	$('#frame').append(e);
}
