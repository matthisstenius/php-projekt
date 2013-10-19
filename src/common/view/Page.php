<?php

namespace common\view;

class Page {
	private $headerContent;

	public function getPage($title, $body) {
		$html = "<!DOCTYPE html>
		<html lang='sv'>
		<head>
			<title>$title</title>
			<meta charset='utf-8'>"
			. $this->getStylesheet() .
		"</head>
		<body>
			<div class='wrapper'>
				<header class='header'>

				</header>
				
				<section class='main'>
					$body
				</section>
				
				<footer class='footer'>

				</footer>
			</div>
		</body>
		</html>";

		return $html;
	}

	private function getStylesheet() {
		return "<link href='../public/style.css' rel='stylesheet' type='text/css'>";
	}
}