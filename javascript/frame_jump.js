//通常のジャンプ処理
function jump(url, move){
			//左に表示させたいとき
			if(move == "left")
			{
				//name=leftのＵＲＬを変更
				parent.right.location="../Top/dummy.html";
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
	parent.left.location="../Top/top_left.php";
	parent.right.location="../Top/top_right.php";
}


function leftreload()
{
	parent.left.location.reload();
}


//TOPメニューから書くリンクに移動する処理
//左に左用右に右用のURLを引数として渡す。
function menu_jump(left_url,right_url)
{	
	parent.left.location=left_url;
	parent.right.location=right_url;
}





