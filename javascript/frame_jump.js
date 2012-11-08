//通常のジャンプ処理
function jump(url, move){
			//左に表示させたいとき
			if(move == "left")
			{
				//name=leftのＵＲＬを変更
				parent.right.location="../dummy.html";
				parent.left.location=url;

			}
			//右に表示させたいとき
			else{
				////name=rightのＵＲＬを変更
				parent.right.location=url;

			}
}
//topにジャンプする際の処理
function jump_top(){

	//左右のフレームのＵＲＬを変更
	parent.left.location="../top_left.php";
	parent.right.location="../top_right.php";
}

//ログイン画面に飛ぶ際の処理
function sign_in(url1, url2){

	//左右のフレームのＵＲＬをログイン画面に変更
	parent.right.location=url1;
	parent.left.location=url2;

}
//黒板画面に飛ぶ際の処理
function jump_class(){

}

