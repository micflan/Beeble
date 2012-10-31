<?php

namespace Hello\Model;

/**
* User class
*/
class User
{
	protected $users = array();

	function __construct($argument=null)
	{
		$this->users[] = 'Michael';
		$this->users[] = 'Marco';
	}

	public function is_valid_name($name = null)
	{
		if (in_array($name, $this->users))
		{
			return true;
		}

		return false;
	}
}