

		function delete_img(page_num){

			var date_ele=document.getElementById('date');
			var subject_ele=document.getElementById('subject_seq');
			var page = page_num;
			//日付と科目を変数に格納
			var date=date_ele.value;
			var subject_seq=subject_ele.value;
			$.post('lesson_page_delete.php',{
		        date: date,
		        id : subject_seq
		        num : page
		    },
		    function(rs) {
			    //ＦＯＲＭを削除
		    	var delete_page = page_num+"_form";
		    	delete_page.remove();
		    	page_num++;
		    });
		}

