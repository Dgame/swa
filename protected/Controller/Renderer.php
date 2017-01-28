<?php

namespace Swa\Controller;

use Slim\Slim;

final class Renderer
{
    private $app;
    private $auth;

    public function __construct(Slim $app, Auth $auth)
    {
        $this->app  = $app;
        $this->auth = $auth;
    }

    private function isAuthenticated(): bool
    {
        if ($this->auth->isAuthenticated()) {
            return true;
        }

        return $this->auth->tryToRemember();
    }

    public function render(string $template)
    {
        $data = $this->isAuthenticated() ? ['user' => $this->auth->getUser()] : [];

        $this->app->render('header.php', $data);
        $this->app->render($template, $data);
        $this->app->render('footer.php');
    }

    public function renderIfAuthenticated(string $template)
    {
        if ($this->isAuthenticated()) {
            $this->render($template);
        } else {
            $this->render('login.php');
        }
    }
}
