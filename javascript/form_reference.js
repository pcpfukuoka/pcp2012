//これを使うページでは
//<script src="../javascript/form_reference.js"></script>
//<script src="../javascript/jquery-1.8.2.min.js"></script>
//をHEADに記載すること

//	idは頭に#を加えて引数にすること	commandoは命令を,で区切って引数にすること
//	len_min, len_maxはそ文字数の上下限値を指定、なければ0を引数にすること
//	チェック
function check( id, commando, len_min, len_max)
{
	//	com_array	命令(チェック)用配列
	//	i			ループカウンタ
	//	j			ループカウンタ
	//	k			ループカウンタ
	//	str			テキストボックスのvlue（文字列）
	//	error		エラー内容用配列
	//	error_flg	エラーフラグ(エラーがあればtrue)
	var com_array = commando.split( "," );
	var i = 0;
	var j = 0;
	var k = 0;
	var str = $(id).val();
	var error = new Array();
	var error_flg = false;

	//	命令用配列の中身がある限りループ
	while ( com_array[i] )
	{
		//	命令実行
		//	命令一覧		ic	未入力チェック
		//					nc	入力値チェック(半角数字)
		//					lc	文字数チェック(len_min, len_max)
		//					ac	入力値チェック(半角英字)
		//					fc	フリガナチェック
		//					mc	メールチェック
		//					tc	禁止文字チェック
		//					pc	パスワードチェック

		if ( com_array[i] == "ic" )
		{
			error[i] = inputCheck( str );
		}
		else if ( com_array[i] == "nc" )
		{
			error[i] = numberCheck( str );
		}
		else if ( com_array[i] == "lc" )
		{
			error[i] = lengthCheck( str, len_min, len_max );
		}
		else if ( com_array[i] == "ac" )
		{
			error[i] = alphabetCheck( str );
		}
		else if ( com_array[i] == "fc" )
		{
			error[i] = furiganaCheck( str );
		}
		else if ( com_array[i] == "mc" )
		{
			error[i] = mailCheck( str );
		}
		else if ( com_array[i] == "tc" )
		{
			error[i] = tabooCheck( str );
		}
		else if ( com_array[i] == "pc" )
		{
			error[i] = passwordCheck( str );
		}


		//	カウンタアップ
		i++;
	}

	//	エラー確認
	for ( j; j < error.length; j++ )
	{
		if ( error[j] )
		{
			error_flg = true;
			break;
		}
	}
	//	エラー表示
	if ( error_flg == true )
	{

		var message = "";
		for ( k; k < error.length;k++ )
		{
			if ( error[k] )
			{
				message += error[k] + "\n";
			}
		}

		alert( message );
	}
}


function alert( a )
{
	alert( a );
}

//ユーザー登録用チェック
function userCheck( id, commando, len_min, len_max)
{
	//	com_array	命令(チェック)用配列
	//	i			ループカウンタ
	//	j			ループカウンタ
	//	k			ループカウンタ
	//	str			テキストボックスのvalue（文字列）
	//	error		エラー内容用配列
	//	error_flg	エラーフラグ(エラーがあればtrue)
	var com_array = commando.split( "," );
	var i = 0;
	var j = 0;
	var k = 0;
	var str = id;
	var error = new Array();
	var error_flg = false;

	//	命令用配列の中身がある限りループ
	while ( com_array[i] )
	{
		//	命令実行
		//	命令一覧		ic	未入力チェック
		//					nc	入力値チェック(半角数字)
		//					lc	文字数チェック(len_min, len_max)
		//					ac	入力値チェック(半角英字)
		//					fc	フリガナチェック
		//					mc	メールチェック
		//					tc	禁止文字チェック

		if ( com_array[i] == "ic" )
		{
			error[i] = inputCheck( str );
		}
		else if ( com_array[i] == "nc" )
		{
			error[i] = numberCheck( str );
		}
		else if ( com_array[i] == "lc" )
		{
			error[i] = lengthCheck( str, len_min, len_max );
		}
		else if ( com_array[i] == "ac" )
		{
			error[i] = alphabetCheck( str );
		}
		else if ( com_array[i] == "fc" )
		{
			error[i] = furiganaheck( str );
		}
		else if ( com_array[i] == "mc" )
		{
			error[i] = mailCheck( str );
		}
		else if ( com_array[i] == "tc" )
		{
			error[i] = tabooCheck( str );
		}

		//	カウンタアップ
		i++;
	}

	//	エラー確認
	for ( j; j < error.length; j++ )
	{
		if ( error[j] )
		{
			error_flg = true;
			break;
		}
	}
	//	エラー表示
	if ( error_flg == true )
	{
		var message = "";
		for ( k; k < error.length;k++ )
		{
			if ( error[k] )
			{
				message += error[k] + "\n";
			}
		}

		return massage;
	}
}




//	空白除去(全半角スペース・タブ・改行にも対応)
//	文字列のトリミングを行うので、基本的にどの関数でも使用する。
//	返値はトリミングした文字列
//	トリミング
function trim( str )
{
	return str.replace( /^[  \t\r\n]+|[  \t\r\n]+$/g, "" );
}


//	ret = 返値(テキスト)

//	未入力チェック	ic
function inputCheck( str )
{
	var ret;
	//	トリミングした文字列の長さが0（未入力）ならばエラーを返す。
	if ( trim( str ).length == 0 )
	{
		ret = "文字を入力して下さい。";
		return ret;
	}
}


//	入力値チェック(半角数字)	nc
function numberCheck( str )
{
	var ret;

	if ( trim( str ).match( /[^0-9]+/ ) )
	{
		ret = "半角数字のみで入力して下さい。";
		return ret;
	}
}


//	len_min		引数(指定文字数の下限値)	値が0で下限無し
//	len_max		引数(指定文字数の上限値)	値が0で上限無し
//	文字数指定の場合、len_minとlen_maxが同値にする
//	文字数チェック	lc
function lengthCheck( str, len_min, len_max )
{
	var ret;
	//	下限無しの場合
	if( len_min == 0 )
	{
		if( trim( str ).length >= len_max )
		{
			ret = len_max + "文字以下で入力して下さい。";
			return ret;
		}
	}
	//	上限無しの場合
	else if ( len_max == 0 )
	{
		if( len_min >= trim( str ).length )
		{
			ret = len_min + "文字以上で入力して下さい。";
			return ret;
		}
	}
	//	文字数が指定された場合
	else if ( len_min == len_max  )
	{
		if ( len_min != trim( str ).length )
		{
			ret = len_min + "文字で入力して下さい。";
			return ret;
		}
	}
	//	上限下限有りの場合
	else
	{
		if( ( len_min >= trim( str ).length ) || ( trim( str ).length >= len_max ) )
		{
			ret = len_min + "文字以上" + len_max + "文字以下で入力して下さい。";
			return ret;
		}
	}
}

//	入力値チェック(半角英字 大小文字対応)	ac
function alphabetCheck( str )
{
	var ret;

	if( trim( str ).match( /[^A-Za-z\s.-]+/ ) )
	{
		ret = "半角英字のみで入力して下さい。";
		return ret;
	}
}

//	フリガナチェック(半角カタカナのみ)		fc
function furiganaCheck( str )
{
	var ret;

	if ( trim( str ).match( /[^ｧ-ﾝ\s.-]+/ ) )
	{
		ret = "フリガナは半角「カタカナ」 のみで入力して下さい。";
		return ret;
	}
}


//動作チェック済み//
//	メールアドレスチェックPart.2//
//	mc
//<script type="text/javascript">
/**
* [機 能] 正規表現によるメールアドレス（E-mail）チェック*/
function mailCheck( str )
{
	/* E-mail形式の正規表現パターン */
	/* @が含まれていて、最後が .(ドット)でないなら正しいとする */
	var fromat=/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i;
    var ret;

	/* 入力された値がパターンにマッチするか調べる */
	if( trim( str ).match( format ) )
	{

	}
	else
	{
		ret = "メールアドレスの形式が不正です。\n「xxxx@yyyy.zz」の形式で入力して下さい。";
		return ret;
	}
}


//	禁止文字チェック	tc
function tabooCheck( str )
{
	var ret;

	var taboo = ["@","-"]; //禁止文字の配列
	var regex = new RegExp(taboo.join("|")); //正規表現オブジェクト

	if ( trim( str ).match(regex) != null )
	{
		ret = "禁止文字が含まれています。";
		return ret;
	}
}

//	パスワードチェック(半角英数字のみ)	pk
function passwordCheck( str )
{
	var tet;

	if( trim( str ).match( /[^A-Z a-z 0-9 @ . _ -\s.-]+/ ) )
	{
		ret = "半角英数字と[@],[.],[-],[_]のみで入力して下さい。";
		return ret;
	}

}