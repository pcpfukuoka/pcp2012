＜script type="text/javascript">


//空白除去
//・半角スペース
//・全角スペース
//・タブ
//・改行（CR, LF）
function trim(str) {
	return str.replace(/^[ 　\t\r\n]+|[ 　\t\r\n]+$/g, "");
}


// ret = 返値(真偽)
// 未入力チェック
function inputCheck( str )
{
	var ret;

	if ( trim( str ).length == 0 )
	{
		ret = false;
		alert( "未入力です" );
		return false;
	}
	else
	{
		ret = true;
		return ret;
	}
}


// 入力値チェック(数字)
function valueCheck_jp( str )
{
	var ret;

	if ( !val.match( /[0-9]/ ) )
	{
		ret = false;
		alert( "入力値が間違っています" );
		return ret;
	}
	else
	{
		ret = true;
		return ret;
	}
}



// len_min = 引数(指定文字数の最低値)
// len_max = 引数(指定文字数の最大値)
// 文字数チェック
function lengthCheck( str , len_min , len_max )
{
	var ret;
	if( !len_min <= str.length <= len_max )
	{
		ret = false;
		alert("len_min" + "文字以上" + "len_max" + "文字以上ではありません");
		return ret;
	}
	else
	{
		ret = true;
		return ret;
	}
}




//パスワードなどに使えます。
/* 半角英文字チェック */
function AlphabetCheck() {
var str = document.iform.EnglishText.value;
if( str.match( /[^A-Za-z¥s.-]+/ ) ) {
alert("英語名は、半角英文字のみで入力して下さい。");
return 1;
}
return 0;
}

//電話番号やパスワードなどに使えます。
/* 半角数字チェック */
function NumberCheck() {
var str = document.iform.AgeText.value;
if( str.match( /[^0-9]+/ ) ) {
alert("年齢は、半角数字のみで入力して下さい。");
return 1;
}
return 0;
}


/* ふりがなチェック */
function FuriganaCheck() {
var str = document.iform.FuriganaText.value;
if( str.match( /[^ぁ-んァ-ン　¥s]+/ ) ) {
alert("ふりがなは、「ひらがな」・「カタカナ」のみで入力して下さい。");
return 1;
}
return 0;
}



/* 上の３つまとめてチェック */
function AllCheck() {
var check = 0;
check += FuriganaCheck();
check += AlphabetCheck();
check += NumberCheck();
if( check > 0 ) {
return false;
}
return check;
}


//メールアドレスチェック
var emailfilter=/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/

	function checkmail(e){
	  var returnval=emailfilter.test(e.value)
	  if (returnval==false){
	    alert("正しいメールアドレスを入力してください!")
	    e.select()
	  }
	  return returnval
	}


//入力文字をチェック
function formCheck(){
    var flag = 0;

    // 入力文字数をチェック
    var input_text_1_length = document . Form1 . InputText1 . value . length; // 入力文字数を、変数に格納
    if ( input_text_1_length < 6 ){ // 入力文字数が不足している場合
        flag = 1;
        document . getElementById( 'notice-input-text-1' ) . innerHTML = 6 - input_text_1_length + "文字不足しています。";
        document . getElementById( 'notice-input-text-1' ) . style . display = "block";
    }
    if ( input_text_1_length  > 20 ){ // 入力文字数が超過している場合
        flag = 1;
        document . getElementById( 'notice-input-text-1' ) . innerHTML = input_text_1_length - 20 + "文字オーバーしています。";
        document . getElementById( 'notice-input-text-1' ) . style . display = "block";
    }

    if( flag ){ // 入力文字数が、不足もしくは超過している場合
        window . alert( '入力内容に不備があります。' ); // アラートを表示
        return false; // 送信中止
    }else{ // 入力文字数が、不足もしくは超過していない場合
        document . getElementById( 'notice-input-text-1' ) . style . display = "none";
        return true; // 送信実行
    }

}


//禁止文字チェック
var badWords = ["バカ","ハゲ"]; //禁止文字の配列
var regex = new RegExp(badWords.join("|")); //正規表現オブジェクト
function test(val) {
if (val.match(regex) != null) {
alert("禁止文字が含まれています");
return false;
}
return true;
}



</script>
