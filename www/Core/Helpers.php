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
		if (strlen($string) > $length)
			return substr($string, 0, $length) . " ...";
		else
			return $string;
	}

	public static function convertToGoodData(&$data, $allowedTags = [])
	{
		foreach ($data as $key => $value)
			if (is_string($value))
				$data[$key] = strip_tags(trim($value), $allowedTags);
	}

	public static function redirect($url)
	{
		header('Location: ' . $url);
		die();
	}

	public static function allowedTags()
	{
		return ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'p', 'ul', 'ol', 'li', 'img'];
	}
}
