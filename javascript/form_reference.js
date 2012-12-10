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



//電話番号やパスワードなどに使えます。
//半角ならtrue、全角ならfalseが返ります。
// 半角英数チエック
function hanCheck($str)
{
    //magic_quotes_gpcがONの時は、エスケープを解除する
    if (get_magic_quotes_gpc())
    {
        $str = stripslashes($str);
    }

    if (strlen($str) == mb_strlen($str))
    {
        return true;
    }
    else
    {
        return false;
    }
}



//例として「< > & " '」を禁止する場合です。
//禁止文字があればfalse、なければtrueが返ります。
// 禁止文字チエック「< > & " '」
function NGCharCheck($str)
{
    //スペースは対象外
    if (!strlen($str))
    {
        return true;
    }

    if(ereg("[<>\"\'&]", $str))
    {
        return false;
    }
    else
    {
        return true;
    }
}


//メールアドレスチェック
//正しい書式のメールアドレスの場合は、1 を返します
function valid_mail($email)
{
        $rs = ereg("^[0-9,a-z,A-Z,_,\.,-]+@[0-9,A-Z,a-z][0-9,a-z,A-Z,_,\.,-]+\.(af|al|dz|as|ad|ao|ai|aq|ag|ar|am|aw|ac|au|at|az|bh|bd|bb|by|bj|bm|bt|bo|ba|bw|br|io|bn|bg|bf|bi|kh|cm|ca|cv|cf|td|gg|je|cl|cn|cx|cc|co|km|cg|cd|ck|cr|ci|hr|cu|cy|cz|dk|dj|dm|do|tp|ec|eg|sv|gq|er|ee|et|fk|fo|fj|fi|fr|gf|pf|tf|fx|ga|gm|ge|de|gh|gi|gd|gp|gu|gt|gn|gw|gy|ht|hm|hn|hk|hu|is|in|id|ir|iq|ie|im|il|it|jm|jo|kz|ke|ki|kp|kr|kw|kg|la|lv|lb|ls|lr|ly|li|lt|lu|mo|mk|mg|mw|my|mv|ml|mt|mh|mq|mr|mu|yt|mx|fm|md|mc|mn|ms|ma|mz|mm|na|nr|np|nl|an|nc|nz|ni|ne|ng|nu|nf|mp|no|om|pk|pw|pa|pg|py|pe|ph|pn|pl|pt|pr|qa|re|ro|ru|rw|kn|lc|vc|ws|sm|st|sa|sn|sc|sl|sg|sk|si|sb|so|za|gs|es|lk|sh|pm|sd|sr|sj|sz|se|ch|sy|tw|tj|tz|th|bs|ky|tg|tk|to|tt|tn|tr|tm|tc|tv|ug|ua|ae|uk|us|um|uy|uz|vu|va|ve|vn|vg|vi|wf|eh|ye|yu|zm|zw|com|net|org|gov|edu|int|mil|biz|info|name|pro|jp)$",$email);
        return $rs;
}


