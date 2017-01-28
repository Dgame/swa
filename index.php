<?php

use Swa\User\Transfer;
use Swa\User\User;

ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_trans_sid', 0);
session_start();

require_once 'vendor\autoload.php';

$app    = new \Slim\Slim();
$auth   = new \Swa\Controller\Auth($app->response, $app->request);
$render = new \Swa\Controller\Renderer($app, $auth);
$rest   = new \Swa\Controller\Rest($app->response);

$app->get('/', function () use ($render, $auth) {
    if (!$auth->isAuthenticated()) {
        $auth->tryToRemember();
    }

    $render->renderIfAuthenticated('index.php');
});
$app->get('/index', function () use ($render) {
    $render->renderIfAuthenticated('index.php');
});
$app->get('/profile', function () use ($render) {
    $render->renderIfAuthenticated('profile.php');
});
$app->get('/transfer', function () use ($render) {
    $render->renderIfAuthenticated('transfer.php');
});
$app->get('/balance', function () use ($render) {
    $render->renderIfAuthenticated('balance.php');
});
$app->get('/logout', [$auth, 'logout']);

$app->post('/', [$auth, 'login']);
$app->post('/profile/:id', function (int $id) use ($rest) {
    $rest->changeProfile($id, $_POST);
});
$app->post('/profile/pw/:id', function (int $id) use ($rest) {
    $rest->changePassword($id, $_POST);
});
$app->post('/transfer/:id', function (int $id) use ($app) {
    $transfer = new Transfer(new User($id));
    $transfer->transfer(new User($_POST['too']), $_POST['amount']);

    $app->response->redirect('/balance');
});

$app->run();
