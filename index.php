<?php

require_once("src/application/controller/Application.php");

$app = new \application\controller\Application();
$page = new \common\viewPage();

$body = $app->init();

echo $page->getPage("Hello Blog!", $body);