<?php

namespace App\Core;


class Helpers
{

	public static function cleanFirstname($firstname)
	{
		return ucwords(mb_strtolower(trim($firstname)));
	}

	public static function prepareInputs($inputsArray)
	{
		foreach ($inputsArray as $key => $input) {
			$inputsArray[$key] = trim(htmlentities($input));
		}

		return $inputsArray;
	}

	public static function troncate($string, $length)
	{
		if (strlen($string) > $length)
			return substr($string, 0, $length) . " ...";
		else
			return $string;
	}

	public static function redirect($url)
	{
		header('Location: ' . $url);
		die();
	}
}
