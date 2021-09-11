<?php

namespace App\Core;

class FormValidator
{

	public static function check($config, $data)
	{
		$errors = [];

		if (self::checkCsrf($data)) {

			if (count($data) != count($config["inputs"])) {
				$errors[] = "Tentative de HACK - Faille XSS";
			} else {

				foreach ($config["inputs"] as $name => $configInputs) {

					if (!empty($configInputs["minLength"]) && is_numeric($configInputs["minLength"]) && strlen($data[$name]) < $configInputs["minLength"]) {
						$errors[] = $configInputs["error"];
					}
				}
			}
		} else {
			$errors[] = "Tentative de HACK - Faille CSRF";
		}

		return $errors;
	}

	public static function checkEmail($email, &$error)
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			if (is_array($error))
				$error[] = "L'adresse mail n'est pas valide";
			else
				$error = "L'adresse mail n'est pas valide";
	}

	public static function checkCsrf(&$data)
	{
		if (session_status() == PHP_SESSION_NONE)
			session_start();

		if (!isset($_SESSION['csrfToken']) || !isset($data['csrfToken']) || $_SESSION['csrfToken'] != $data['csrfToken']) {
			return 0;
		} else {
			unset($data['csrfToken']);
			return 1;
		}
	}
}
