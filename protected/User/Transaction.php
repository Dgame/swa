<?php

namespace Swa\User;

class Transaction
{
    public $user;
    public $date;
    public $amount;

    public function __construct(int $user_id, string $date, int $amount)
    {
        $this->user   = new User($user_id);
        $this->date   = new \DateTime($date);
        $this->amount = $amount;
    }
}