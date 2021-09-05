<?php

namespace App\Core;


class Helpers
{

	public static function cleanFirstname($firstname)
	{
		return ucwords(mb_strtolower(trim($firstname)));
	}

	public static function troncate($string, $length)
	{
		return substr($string, 0, $length);
	}
}
