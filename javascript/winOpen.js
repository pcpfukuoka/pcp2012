// サーバーへのファイル
function upload()
{
		 //別窓の左と上の余白を求める
		  var w = ( screen.width-400 ) / 2;
		  var h = ( screen.height-200) / 2;


		  //オプションパラメーターleftとtopに余白の値を指定
		  window.open("../upload/file_select.html","","width=400,height=200"
		              +",left="+w+",top="+h);

		// -->
}