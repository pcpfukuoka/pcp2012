function limitMaxLength(target, len, err)
{
	if( target.value.length > len )
	{
		target.value = target.value.substr(0, len);
		if( "undefined" != typeof(err) )
		{
			alert(err);
		}
	}
}

