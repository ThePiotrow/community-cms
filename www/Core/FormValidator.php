<?php

namespace App\Core;

class FormValidator
{

	public static function check($config, $data)
	{
		$errors = [];


		if (count($data) != count($config["inputs"])) {
			$errors[] = "Tentative de HACK - Faille XSS";
		} else {

			foreach ($config["inputs"] as $name => $configInputs) {

				strip_tags($data[$name], ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'p']);

				if (
					!empty($configInputs["minLength"])
					&& is_numeric($configInputs["minLength"])
					&& strlen($data[$name]) < $configInputs["minLength"]
				) {

					$errors[] = $configInputs["error"];
				}
			}
		}

		return $errors;
	}
}
