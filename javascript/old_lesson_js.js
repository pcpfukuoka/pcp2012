

function decision_click(){
	var date_ele=document.getElementById('date');
	var subject_ele=document.getElementById('subject_seq');

	var date=date_ele.value;
	console.log(date);
	var subject_seq=subject_ele.value;
	console.log(subject_seq);
	var str='old_lesson_canvas.php?date='+date+'&id='+subject_seq;
	window.open(str, "old_lesson", "width=1000,height=1000");
}
