<?php

namespace App\Core;

class FormBuilder
{
	public static function render($config, $show = true)
	{

		$html = "<form 
				method='" . ($config["config"]["method"] ?? "GET") . "' 
				action='" . ($config["config"]["action"] ?? "") . "'
				class='" . ($config["config"]["class"] ?? "") . "'
				id='" . ($config["config"]["id"] ?? "") . "'
				>";

		$html .= "<input type='hidden' name='csrfToken' value='" . self::setCsrfToken() . "'>";


		foreach ($config["inputs"] as $name => $configInput) {
			$html .= "<label for='" . ($configInput["id"] ?? $name) . "'>" . ($configInput["label"] ?? "") . " </label><br>";

			if ($configInput['type'] == 'textarea') {
				$html .= "<textarea name='" . $name . "'
				" . (!empty($configInput["required"]) ? "required='required'" : "") . ">" . ($configInput["value"] ?? "") . "</textarea><br>";
			} else {

				$html .= "<input 
										type='" . ($configInput["type"] ?? "text") . "'
										name='" . $name . "'
										placeholder='" . ($configInput["placeholder"] ?? "") . "'
										class='" . ($configInput["class"] ?? "") . "'
										id='" . ($configInput["id"] ?? $name) . "'
										" . (!empty($configInput["required"]) ? "required='required'" : "") . "
										" . ($configInput["type"] == "checkbox" ? ($configInput["value"] == 1 ? "checked" : "") : "") . "
										value='" . ($configInput["value"] ?? "") . "'
										><br>";
			}
		}




		$html .= "<br><input type='submit' value=\"" . ($config["config"]["submit"] ?? "Valider") . "\">";
		$html .= "</form>";


		if ($show) {
			echo $html;
		} else {
			return $html;
		}
	}

	public static function setCsrfToken()
	{
		if (session_status() == PHP_SESSION_NONE)
			session_start();

		$token = uniqid(uniqid());
		$_SESSION['csrfToken'] = $token;

		return $token;
	}
}
