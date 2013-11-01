<?php

namespace common\view;

class Page {
	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @var user\model\Login
	 */
	private $loginHandeler;

	/**
	 * @var project\conroller\Projects
	 */
	private $projectsController;

	/**
	 * @param login\model\Login           $loginHandeler
	 * @param project\controller\Projects $projectsController
	 */
	public function __construct(\login\model\Login $loginHandeler, \project\controller\Projects $projectsController) {
		$this->navigationView = new Navigation();
		$this->loginHandeler = $loginHandeler;
		$this->projectsController = $projectsController;
	}

	/**
	 * @param  string $title
	 * @param  string $body  HTML
	 * @return string        HTML
	 */
	public function getPage($title, $body) {
		$html = "<!DOCTYPE html>
		<html lang='sv'>
		<head>
			<meta charset='utf-8'>
			<title>$title</title>"
			. $this->getStylesheet() .
		"</head>
		<body>
			<div class='wrapper'>"
				
				. $this->getHeader() .

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
		return "<link href='/php-projekt/src/public/css/main.css' rel='stylesheet' type='text/css'>";
		
				// <link href='http://fnt.webink.com/wfs/webink.css/?project=32484cd2-12cb-4f4f-8e39-262d03e82d1c&fonts=
				// A5D15588-A18E-DC95-62EC-9A4E98DE136A:f=MuseoSans-300,E10DC5A5-6E69-88A0-32FF-0256CBA64855:
				// f=ProximaNovaSoft-Regular,0D47B8E9-3C6E-CE3D-89C8-57E788336980:f=RooneyWeb-Regular' rel='stylesheet' 
				// type='text/css'/>";
	}

	/**
	 * @return string HTML
	 */
	private function getHeader() {
		$homeSrc = $this->navigationView->getHomeSrc();
		$projectsSrc = $this->navigationView->getProjectsSrc();

		$html = "<header class='header pad'>
					<a href='$homeSrc' class='logo'>Bloggen</a>
					<p>Denna blogg är representerar projektet i kursen Webbutveckling med PHP</p>

					<nav class='main-nav'>
						<ul>";
							
						if ($this->loginHandeler->isUserLoggedIn()) {
							$newProjectSrc = $this->navigationView->getAddNewProjectSrc();
							$logoutSrc = $this->navigationView->getLogoutSrc();

							$html .= $this->getUserDetails();
							$html .= "<a href='$logoutSrc'>Logout</a>";
							$html .= "<li><a href='$newProjectSrc'>Create new project</a></li>";
							$html .= "<a href='$projectsSrc'><h3>My Projects</h3></a>";
							$html .= $this->projectsController->showProjectsList();	
						}

						else {
							$loginSrc = $this->navigationView->getLoginSrc();
							$registerSrc = $this->navigationView->getRegisterSrc();

							$html .= "<li><a href='$loginSrc'>Login</a>";
							$html .= "<li><a href='$registerSrc'>Register</a>";
						}

						$html .= "</ul>
					 </nav>
				</header>";

		return $html;
	}

	/**
	 * @return string HTML
	 */
	private function getUserDetails() {
		$user = $this->loginHandeler->getLoggedInUser();
		$userPageSrc = $this->navigationView->getUserPageSrc($user->getUserID(), $user->getUsername());

		return "<a href='$userPageSrc'>" . $user->getUsername() . "</a>";
	}

	/**
	 * @return string HTML
	 */
	private function getFooter() {
		return "<footer class='footer'>

				</footer>";
	}
}