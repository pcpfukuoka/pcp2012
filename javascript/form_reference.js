//	これを使うページでは
//	<script src="../javascript/form_reference.js"></script>
//	<script src="../javascript/jquery-1.8.2.min.js"></script>
//	をHEADに記載すること

//	idは頭に#を加えて引数にすること	commandoは命令を,で区切って引数にすること
//	len_min, len_maxはそ文字数の上下限値を指定、なければ0を引数にすること

function check( id, commando, len_min, len_max, span)
{
	var id_array =	id.split( "," );
	var cmd_array = commando.split( "/" );
	var min_array = len_min.split( "," );
	var max_array = len_max.split( "," );
	var spn_array = span.split( "," );
	var i = 0;
	var j = 0;
	var check_flg = "";
	var error = false;

	for ( i; i < id_array.length; i++ )
	{
		var str = $("#" + id_array[i] + "").val();
		var cmd_query = cmd_array[i].split( "," );
		var message = "";
		j = 0;

		//	命令用配列の中身がある限りループ
		while ( cmd_query[j] )
		{

			if ( cmd_query[j] == "ic" )
			{
			 	check_flg = inputCheck( str );
			}
			else if ( cmd_query[j] == "nc" )
			{
				check_flg = numberCheck( str );
			}
			else if ( cmd_query[j] == "lc" )
			{
				check_flg = lengthCheck( str, min_array[i], max_array[i] );
			}
			else if ( cmd_query[j] == "ac" )
			{
				check_flg = alphabetCheck( str );
			}
			else if ( cmd_query[j] == "fc" )
			{
				check_flg = furiganaCheck( str );
			}
			else if ( cmd_query[j] == "mc" )
			{
				//check_flg = mailCheck( str );
			}
			else if ( cmd_query[j] == "pc" )
			{
				check_flg = passwordCheck( str );				
			}
			//	スパンメッセージ格納
			if ( check_flg != "true" )
			{
				message += "※"　+ check_flg + "\n";
				error = true;
			}

			//	カウンタアップ
			j++;
		}
		//	スパン表示
		$("#" + spn_array[i] + "").text(message);
	}

	if ( error == true )
	{
		return false;
	}
	else
	{
		return true;
	}


}

function scoreCheck( id, span )
{
	var id_array = id.split( "," );
	var spn_array = span.split( "," );
	var i = 0;
	var check_1 = "";
	var check_2 = "";
	var error_flg = false;
	var str = "";

	for ( i; i < id_array.length; i++ )
	{
		str = $("#" + id_array[i] + "").val();
		check_1 = inputcheck( str );
		check_2 = pointCheck( str );

		if ( (check_1 != "true") || (check_2 != "true") )
		{
			$("#" + spn_array[i] + "").text("※");
			error_flg = true;
		}
	}

	if ( error_flg == true )
	{
		alert("入力に不備があります。\n0~100の数値を入力して下さい。");
		return false;
	}
	else
	{
		return true;
	}
}


//空白除去(全半角スペース・タブ・改行にも対応)
//文字列のトリミングを行うので、基本的にどの関数でも使用する。
//返値はトリミングした文字列
//トリミング
function trim( str )
{
	ret = str.replace(/^[ \t\r\n]+/, '');
	ret = str.replace(/[ \t\r\n]+$/, '');
	return ret;
	//return str.replace( /^[  \t\r\n]+|[  \t\r\n]+$/g, "" );
}

//ret = 返値(テキスト)
//未入力チェック	ic
function inputCheck( str )
{
	var ret = "true";
	//	トリミングした文字列の長さが0（未入力）ならばエラーを返す。
	if ( trim( str ).length == 0 )
	{
		ret = "文字を入力して下さい。";
		return ret;
	}
	return ret;
}

//ダミー
function inputcheck( str )
{
	var ret = "true";
	//	トリミングした文字列の長さが0（未入力）ならばエラーを返す。
	if ( str.length == 0 )
	{
		ret = "文字を入力して下さい。";
		return ret;
	}
	return ret;
}

//入力値チェック(半角数字)	nc
function numberCheck( str )
{
	var ret = "true";

	if ( trim( str ).match( /[^0-9]+/ ) )
	{
		ret = "半角数字のみで入力して下さい。";
		return ret;
	}
	return ret;
}

//len_min		引数(指定文字数の下限値)	値が0で下限無し
//len_max		引数(指定文字数の上限値)	値が0で上限無し
//文字数指定の場合、len_minとlen_maxが同値にする
//文字数チェック	lc
function lengthCheck( str, len_min, len_max )
{
	var ret = "true";
	
	//	文字数が指定された場合
	if ( ( len_min == len_max ) && ( len_min != "0" ) )
	{
		if ( len_min != trim( str ).length )
		{
			ret = len_min + "文字で入力して下さい。";
			return ret;
		}
	}
	//	下限無しの場合
	else if ( ( len_min == "0" ) && ( len_max != "0" ) )
	{
		if( trim( str ).length > len_max )
		{
			ret = len_max + "文字以下で入力して下さい。";
			return ret;
		}
	}
	//	上限無しの場合
	else if ( ( len_max == "0" ) && ( len_min != "0" ) )
	{
		if( len_min > trim( str ).length )
		{
			ret = len_min + "文字以上で入力して下さい。";
			return ret;
		}
	}	
	//	上限下限有りの場合
	else
	{
		if( ( len_min > trim( str ).length ) || ( trim( str ).length > len_max ) )
		{
			ret = len_min + "文字以上" + len_max + "文字以下で入力して下さい。";
			return ret;
		}
	}

	return ret;
}

//	入力値チェック(半角英字 大小文字対応)	ac
function alphabetCheck( str )
{
	var ret = "true";

	if( trim( str ).match( /[^A-Za-z\s.-]+/ ) )
	{
		ret = "半角英字のみで入力して下さい。";
		return ret;
	}
	return ret;
}

//	フリガナチェック(半角カタカナのみ)		fc
function furiganaCheck( str )
{
	var ret = "true";

	if ( trim( str ).match( /[^ｧ-ﾝﾞﾟ\s.-]+/ ) )
	{
		ret = "フリガナは半角「カタカナ」 のみで入力して下さい。";
		return ret;
	}
	return ret;
}

//	メールアドレスチェック	mc
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
	var ret = "ture";

	var taboo = [ "!", "?" ]; //禁止文字の配列
	var regex = new RegExp(taboo.join("|")); //正規表現オブジェクト

	if ( trim( str ).match(regex) != null )
	{
		ret = "禁止文字が含まれています。";
		return ret;
	}
	return ret;
}

//	パスワードチェック(半角英数字のみ)	pc
function passwordCheck( str )
{
	var ret = "true";

	if( trim( str ).match( /[^A-Z a-z 0-9 @ . _ -\s.-]+/ ) )
	{
		ret = "半角英数字と[@],[.],[-],[_]のみで入力して下さい。";
		return ret;
	}
	return ret;

}

//	点数チェック
function pointCheck( str )
{
	var ret = "true";

	if ( ( str < 0 ) || ( str > 100 ) )
	{
		ret = "0~100で入力して下さい。";
		return ret;
	}
	return ret;
}