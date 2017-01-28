<?php

namespace Swa\User;

use Swa\Database\Database;

class Transfer
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Transaction[]
     */
    public function getTransfersFrom(): array
    {
        $result = Database::instance()->fetchAll('SELECT * FROM transfer WHERE sender = %d', $this->user->id);
        if (!is_array($result)) {
            return [];
        }

        $transactions = [];
        foreach ($result as $item) {
            $transactions[] = new Transaction($item['receiver'], $item['transfer_date'], $item['amount']);
        }

        return $transactions;
    }

    /**
     * @return Transaction[]
     */
    public function getTransfersToo(): array
    {
        $result = Database::instance()->fetchAll('SELECT * FROM transfer WHERE receiver = %d', $this->user->id);
        if (!is_array($result)) {
            return [];
        }

        $transactions = [];
        foreach ($result as $item) {
            $transactions[] = new Transaction($item['sender'], $item['transfer_date'], $item['amount']);
        }

        return $transactions;
    }

    public function transfer(User $receiver, int $amount)
    {
        $date = (new \DateTime())->format('d.m.Y H:i:s');

        if ($receiver !== $this->user) {
            $this->user->bankAccount->balance -= $amount;
        }

        $receiver->bankAccount->balance += $amount;

        $this->user->save();
        $receiver->save();

        Database::instance()->query('INSERT INTO transfer (sender, receiver, amount, transfer_date) VALUES(%d, %d, %d, "%s")', $this->user->id, $receiver->id, $amount, $date);
    }
}