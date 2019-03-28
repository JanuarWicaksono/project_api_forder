<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

require_once('app/api/menus.php');
require_once('app/api/tables.php');
require_once('app/api/orders.php');

$app->run();