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


		foreach ($config["inputs"] as $name => $configInput) {
			$html .= "<label for='" . ($configInput["id"] ?? $name) . "'>" . ($configInput["label"] ?? "") . " </label>";

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




		$html .= "<input type='submit' value=\"" . ($config["config"]["submit"] ?? "Valider") . "\">";
		$html .= "</form>";


		if ($show) {
			echo $html;
		} else {
			return $html;
		}
	}
}
