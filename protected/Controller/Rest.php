<?php

namespace Swa\Controller;

use Slim\Http\Response;
use Swa\User\User;

final class Rest
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function changeProfile(int $user_id, array $data)
    {
        $user                            = new User($user_id);
        $user->birthdate                 = new \DateTime($data['birthdate']);
        $user->email                     = $data['email'];
        $user->telephone                 = $data['tel'];
        $user->bankAccount->bankleitzahl = $data['blz'];
        $user->bankAccount->kontonummer  = $data['ktnr'];
        $user->address->location         = $data['location'];
        $user->save();

        $this->response->redirect('/profile', 200);
    }

    public function changePassword(int $user_id, array $data)
    {
        $user = new User($user_id);
        if ($user->password === md5($data['old_password'])) {
            $user->password = md5($data['new_password']);
            $user->save();
        }

        $this->response->redirect('/profile', 200);
    }
}