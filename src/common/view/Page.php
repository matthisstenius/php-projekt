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
			<div class='wrapper'>"
				
				. $this->getHeader() .

				"<section class='main'>
					$body
				</section>"
				
				. $this->getFooter() . 
				
			"</div>
		</body>
		</html>";

		return $html;
	}

	/**
	 * @return string HTML
	 */
	private function getStylesheet() {
		return "<link href='src/public/main.css' rel='stylesheet' type='text/css'>";
	}

	/**
	 * @return string HTML
	 */
	private function getHeader() {
		return "<header class='header'>
					<a href='/' class='logo'>Bloggen</a>
					<p>Denna blogg är representerar projektet i kursen Webbutveckling med PHP</p>

					<nav class='main-nav'>
						<ul>
							<li>Inlägg</li>
							<li>Skapa nytt inlägg</li>
						</ul>
					</nav>
				</header>";
	}

	/**
	 * @return string HTML
	 */
	private function getFooter() {
		return "<footer class='footer'>

				</footer>";
	}
}