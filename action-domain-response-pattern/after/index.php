<?php

include_once 'actions/DefaultAction.php';
include_once 'actions/NumberViewAction.php';
include_once 'domains/Number.php';
include_once 'responders/DefaultResponse.php';
include_once 'responders/NumberViewResponse.php';

$action = isset($_GET['a']) ? $_GET['a'] : 'view';
$domain = isset($_GET['m']) ? $_GET['m'] : '';
$id     = isset($_GET['id']) ? $_GET['id'] : '';

switch($domain) {
    case 'number':
        $action = new NumberViewAction();
        break;
    default:
        $action = new DefaultAction();
}

$action->run($id);
