<?php

namespace application\controller;

require_once("src/common/view/Router.php");

class Application {
	public function __construct() {
		$this->router = new \common\view\Router();
	}

	public function init() {
		$this->router->get('/', function() {
			return "Hello index!";
		});

		$this->router->get('/contact/:name', function($name) {
			return "Hello $name";
		});

		$this->router->notFound("/404", function() {
			return "404";
		});

		$this->router->match();
	}
}