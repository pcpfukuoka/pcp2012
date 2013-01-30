
//空白除去
//・半角スペース
//・全角スペース
//・タブ
//・改行（CR, LF）
function trim(str) {
	return str.replace(/^[ 　\t\r\n]+|[ 　\t\r\n]+$/g, "");
}


//作動チェック済み//
// ret = 返値(真偽)
// 未入力チェック
// ic
function inputCheck( str )
{
	var ret;

	if ( trim( str ).length == 0 )
	{
		ret = "未入力です";
		return ret;
	}
	else
	{
		ret = true;
		return ret;
	}
}


//作動チェック済み//
// 入力値チェック(数字)
// vc
function valueCheck_jp( str )
{
	var ret;

	if ( str.match(  /[^0-9]+/ ))
	{
		ret = "入力値が間違っています";
		return ret;
	}
	else
	{
		ret = true;
		return ret;
	}
}


//作動チェック済み//
//文字数チェック//
//c
function check(str)
{
	//txt = document.myFORM.myTEXT.value;
	//alert(n);
	n = str.length;

	if (n <= 4)
	{
		alert("５文字以上にしてください");
	}
	else
	{
		alert("使用できます");
	}

}


// len_min = 引数(指定文字数の最低値)
// len_max = 引数(指定文字数の最大値)
// 文字数チェック
// lc
function lengthCheck( str , len_min , len_max )
{
	var ret;
	if((len_min <= str.length) && (str.length <= len_max))
	{
		ret = "len_min" + "文字以上" + "len_max" + "文字以下ではありません";
		return ret;
	}
	else
	{
		ret = true;
		return ret;
	}
}


//動作チェック済み//
//パスワードなどに使えます。
/* 半角英文字チェック */
//ac
function AlphabetCheck(str)
{
	var ret = true;
	if( str.match( /[^A-Za-z¥s.-]+/ ) )
	{
		ret = "英語名は、半角英文字のみで入力して下さい";
		return ret;
	}
	return ret;
}


//動作チェック済み//
//電話番号やパスワードなどに使えます。
/* 半角数字チェック */
//nc
function NumberCheck(str)
{
	var ret = true;

	if( str.match( /[^0-9]+/ ) )
	{
		ret = "年齢は、半角数字のみで入力して下さい";
		return ret;
	}
	return ret;
}


//動作チェック済み//
/* ふりがなチェック */
//fc
function FuriganaCheck(str)
{
	var ret = true;

	if( str.match( /[^ぁ-ん　¥s]+/ ) )
	{
		ret = "ふりがなは、「ひらがな」 のみで入力して下さい";
		return ret;
	}
	return ret;
}


//動作チェック済み//
//メールアドレスチェックPart.2//
//cE
//<script type="text/javascript">
/**
* [関数名] chkRegEmail
* [機　能] 正規表現によるメールアドレス（E-mail）チェック
* [引　数]
* @param str 入力された文字列
* [返り値]
* @return true(E-mail形式である場合) | false(E-mail形式でない場合)
*/
function chkRegEmail(str)
{
	/* E-mail形式の正規表現パターン */
	/* @が含まれていて、最後が .(ドット)でないなら正しいとする */

	var Seiki=/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i;
    var ret;

	/* 入力された値がパターンにマッチするか調べる */
	if(str!="")
	{
		if(str.match(Seiki))
		{
			ret = str.match(Seiki)+"\n\nメールアドレスの形式は正しいです";
			return ret;
		}
		else
		{
			ret = "メールアドレスの形式が不正です";
			return ret;
		}
	}
	else
	{
		ret = "メールアドレスを入力してください";
		/* 何も入力されていない場合はアラート表示 */
		return ret;
	}
}


//入力文字をチェック
foc
function formCheck()
{
	var flag = 0;
	var ret;

    // 入力文字数をチェック
	var input_text_1_length = document . Form1 . InputText1 . value . length; // 入力文字数を、変数に格納
	if ( input_text_1_length < 6 ) // 入力文字数が不足している場合
	{
		flag = 1;
		document . getElementById( 'notice-input-text-1' ) . innerHTML = 6 - input_text_1_length + "文字不足しています。";
		document . getElementById( 'notice-input-text-1' ) . style . display = "block";
	}
    if ( input_text_1_length  > 10 ) // 入力文字数が超過している場合
    {
    	flag = 1;
    	document . getElementById( 'notice-input-text-1' ) . innerHTML = input_text_1_length - 20 + "文字オーバーしています。";
    	document . getElementById( 'notice-input-text-1' ) . style . display = "block";
    }

    if( flag ) // 入力文字数が、不足もしくは超過している場合
    {
    	ret = "入力内容に不備があります"; // アラートを表示
    	return ret; // 送信中止
    }
    else // 入力文字数が、不足もしくは超過していない場合
    {
    	ret = true;
    	document . getElementById( 'notice-input-text-1' ) . style . display = "none";
    	return ret; // 送信実行
    }
}


//動作チェック済み//
//禁止文字チェック
//tc
var badWords = ["@","-"]; //禁止文字の配列
var regex = new RegExp(badWords.join("|")); //正規表現オブジェクト

function tabooCheck(val)
{
	var ret = true;

	if (val.match(regex) != null)
	{
		ret = "禁止文字が含まれています";
		return ret;
	}

	return ret;
}