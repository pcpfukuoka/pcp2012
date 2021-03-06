/* 指定したcookieを取得する関数 */
	function GetCookie(name)
	{
	    var result = null;

	    var cookieName = name + '=';
	    var allcookies = document.cookie;

	    var position = allcookies.indexOf( cookieName );
	    if( position != -1 )
	    {
	        var startIndex = position + cookieName.length;

	        var endIndex = allcookies.indexOf( ';', startIndex );
	        if( endIndex == -1 )
	        {
	            endIndex = allcookies.length;
	        }

	        result = decodeURIComponent(
	            allcookies.substring( startIndex, endIndex ) );
	    }

	    return result;
	}


function table() {

		var room=GetCookie('room');
		//クラステーブルを生成する処理
		$.post('http://49.212.201.99/pcp2012/lib/student_list.php', {
	        id : room
	    },
	    //戻り値として、user_seq受け取る
	    function(rs) {

	    	var parsers = JSON.parse(rs);

	    	//縦と横の最大数を格納
	    	var row_max=Number(parsers["row_max"]);
	    	var col_max=Number(parsers["col_max"]);

	    	//一列ごとに配列に格納
	    	var seq_rows =parsers["seq"].split("r");
	    	var name_rows =parsers["name"].split("r");

	    	var seq_cols;
	    	var name_cols;

	    	var  e='<table border="4" align="center" bgcolor="#FFE7CE" bordercolor="#DC143C">';

	    	//１列目（教卓を追加する処理）
	    	for(i =0;i<row_max;i++)
	    	{
	    		e=e+'<tr>';
	    		//識別子ごとに配列を分割
	    		seq_cols =seq_rows[i].split("n");
		    	name_cols =name_rows[i].split("n");

	    		for(j =0;j<col_max;j++)
	    		{
	    			if(seq_cols[j] == "null")
	    			{
	    				//空席の場合の処理
	    				e=e+"<td class='sample'width='100'></td>";
	    			}
	    			else
	    			{
	    				//通常の座席の処理
	    				e=e+'<td>'+name_cols[j]+'</td>';
	    			}
	    		}
	    		e=e+'</tr>';
	    	}
	    	e=e+'</table>';

	    	$('body').append(e);
	    });
}
