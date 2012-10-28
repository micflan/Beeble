<?php

namespace Hello\Model;

/**
* User class
*/
class User
{
	function __construct($argument=null)
	{
	}

	public function is_valid_name($name = null)
	{
		if ($name === 'Michael')
		{
			return true;
		}

		return false;
	}
}