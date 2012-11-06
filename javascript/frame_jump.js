//通常のジャンプ処理
function jump(url, move){
console.log("bbb");
			//左に表示させたいとき
			if(move == "left")
			{
				//name=leftのＵＲＬを変更
				parent.right.location="../dummy.html";
				parent.left.location=url;

				console.log("left");
				//フレームの比率を３０％、７０％にする処理
				/*$(document).ready(function(){
					console.log("30、70");
					$('#direction,parent.document').attr('cols','30%,70%');
				});
				*/


			}
			//右に表示させたいとき
			else{
				////name=rightのＵＲＬを変更
				parent.right.location=url;

				//フレームの比率を３０％、７０％にする処理
				$(document).ready(function(){
					console.log("30、70");
					$('#direction,parent.document').attr('cols','30%,70%');
				});
			}
}
//topにジャンプする際の処理
function jump_top(){
	console.log("jump_top");

	//フレームの比率を５０％、５０％にする処理
	$(document).ready(function(){
		console.log("50、50");
		$('#direction,parent.document').attr('cols','50%,50%');
	});

	//左右のフレームのＵＲＬを変更
	parent.left.location="../top_left.php";
	parent.right.location="../top_right.php";
	console.log("topＵＲＬ変更");
}

//ログイン画面に飛ぶ際の処理
function sign_in(url1, url2){
	console.log("sign_in1");

	//フレームの比率を０％、１００％にする処理
	$(document).ready(function(){
		console.log("0、100");
		$('#direction,parent.document').attr('cols','50%,50%');
	});
	console.log("sign_in2");
	//左右のフレームのＵＲＬをログイン画面に変更
	parent.right.location=url1;
	parent.left.location=url2;

}
//黒板画面に飛ぶ際の処理
function jump_class(){

}

