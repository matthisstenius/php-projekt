<?php

require_once("src/application/controller/Application.php");
require_once("src/common/view/Page.php");

$app = new \application\controller\Application();

$body = $app->init();


