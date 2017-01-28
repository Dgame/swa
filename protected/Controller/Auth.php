<?php

namespace Swa\Controller;

use Slim\Http\Response;
use Swa\Database\Database;
use Swa\User\User;

final class Auth
{
    /**
     * @var Response
     */
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    final public function isAuthenticated(): bool
    {
        if (!empty($_SESSION['user_id'])) {
            return true;
        }

        return false;
    }

    final public function login()
    {
        $user = Database::instance()->fetch(
            'SELECT id FROM user WHERE username = "%s" AND paswort = MD5("%s")',
            $_POST['username'],
            $_POST['passwort']
        );

        if (!empty($user)) {
            $this->setUserSession($user['id']);

            if (!empty($_POST['remember-me'])) {
                setcookie('swa_remember', $this->getUser()->name);
            }

            return $this->response->redirect('/index', 200);
        }

        return $this->response->redirect('/', 200);
    }

    final public function logout()
    {
        $_SESSION = [];
        setcookie('swa_remember', '');

        $this->response->redirect('/');
    }

    final public function getUser(): User
    {
        if ($this->isAuthenticated()) {
            $id = (int) $_SESSION['user_id'];

            return new User($id);
        }

        throw new \Exception('Kein User vorhanden');
    }

    private function setUserSession(int $id)
    {
        $_SESSION['user_id'] = $id;
    }

    private function getUserDataOf(string $username): array
    {
        return Database::instance()->fetch(
            'SELECT id, passwort FROM user WHERE username = "%s"',
            $username
        );
    }

    public function tryToRemember(): bool
    {
        if (!empty($_COOKIE['swa_remember'])) {
            $user = $this->getUserDataOf($_COOKIE['swa_remember']);
            if (!empty($user)) {
                $this->setUserSession($user['id']);

                return true;
            }
        }

        return false;
    }
}
