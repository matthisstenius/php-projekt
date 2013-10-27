<?php

namespace common\view;

class Page {
	private $headerContent;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;
	public function __construct() {
		$this->navigationView = new Navigation();
	}

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
	 * @param string $projects HTML containing all projects
	 */
	private function getHeader($projects) {
		$homeSrc = $this->navigationView->getHomeSrc();
		$newProjectSrc = $this->navigationView->getAddNewProjectSrc();

		return "<header class='header pad'>
					<a href='$homeSrc' class='logo'>Bloggen</a>
					<p>Denna blogg är representerar projektet i kursen Webbutveckling med PHP</p>

					<nav class='main-nav'>
						<ul>
							<li><a href='$newProjectSrc'>Create new project</a></li>
						</ul>
						
						<h3>My Projects</h3>
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