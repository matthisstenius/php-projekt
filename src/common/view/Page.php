<?php

namespace common\view;

class Page {
	private $headerContent;

	public function getPage($title, $projects, $body = null) {
		$html = "<!DOCTYPE html>
		<html lang='sv'>
		<head>
			<title>$title</title>
			<meta charset='utf-8'>"
			. $this->getStylesheet() .
		"</head>
		<body>
			<div class='wrapper'>"
				
				. $this->getHeader($projects) .

				"<section class='main pad'>
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
		return "<link href='/php-projekt/src/public/css/main.css' rel='stylesheet' type='text/css'>
				<link href='http://fnt.webink.com/wfs/webink.css/?project=32484cd2-12cb-4f4f-8e39-262d03e82d1c&fonts=
				A5D15588-A18E-DC95-62EC-9A4E98DE136A:f=MuseoSans-300,E10DC5A5-6E69-88A0-32FF-0256CBA64855:
				f=ProximaNovaSoft-Regular,0D47B8E9-3C6E-CE3D-89C8-57E788336980:f=RooneyWeb-Regular' rel='stylesheet' 
				type='text/css'/>";
	}

	/**
	 * @return string HTML
	 */
	private function getHeader($projects) {
		return "<header class='header pad'>
					<a href='/php-projekt' class='logo'>Bloggen</a>
					<p>Denna blogg är representerar projektet i kursen Webbutveckling med PHP</p>

					<nav class='main-nav'>
						<ul>
							<li><a href='posts'>Inlägg</a></li>
							<li><a href='add'>Skapa nytt inlägg</a></li>
						</ul>

						$projects
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