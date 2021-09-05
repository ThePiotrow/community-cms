<?php

namespace App\Core;


class Helpers
{

	public static function cleanFirstname($firstname)
	{
		return ucwords(mb_strtolower(trim($firstname)));
	}

	public static function getUrlParam($param)
	{
		$queryString = $_SERVER["QUERY_STRING"];
		parse_str($queryString, $queryParams);

		if (array_key_exists($param, $queryParams))
			return $queryParams[$param];
		return null;
	}
}
