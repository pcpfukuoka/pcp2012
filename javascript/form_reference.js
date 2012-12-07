// str = 引数(文字列)
// ret_str = 返値(文字列)

// 前後スペース削除(全角半角対応)
function strTtimmng( str )
{
	var ret_str = str;
	ret_str = ret.replace( /^[\s]*/, "" );
	ret_str = ret.replace( /[\s]*$/, "" );
	return ret_str;
}


// ret = 返値(真偽)

// 未入力チェック
function inputCheck( str )
{
	var ret;

	if ( strTtimmng( str ).length == 0 )
	{
		ret = false;
		alert( "未入力です" );
		return ret;
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