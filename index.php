<?php

require_once("src/application/controller/Application.php");
require_once("src/common/view/Page.php");

session_start();

$app = new \application\controller\Application();

$body = $app->init();


