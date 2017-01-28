<?php

namespace Swa\User;

use Swa\Database\Database;

/**
 * Class BankAccount
 * @package Swa\User
 */
final class BankAccount
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $bankleitzahl;
    /**
     * @var string
     */
    public $kontonummer;
    /**
     * @var int
     */
    public $balance;

    /**
     * BankAccount constructor.
     *
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        if (!empty($id)) {
            $data = Database::instance()->fetch('SELECT * FROM bank_account WHERE id = "%d"', $id);

            $this->id           = (int) $data['id'];
            $this->bankleitzahl = $data['bankleitzahl'];
            $this->kontonummer  = $data['kontonummer'];
            $this->balance      = (int) $data['balance'];
        }
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!empty($this->id)) {
            return Database::instance()->query('UPDATE bank_account SET bankleitzahl = "%s", kontonummer = "%s", balance=%d WHERe id = %d',
                                               $this->bankleitzahl,
                                               $this->kontonummer,
                                               $this->balance,
                                               $this->id);
        }

        $result = Database::instance()->query('INSERT INTO bank_account (bankleitzahl, kontonummer, balance) VALUES("%s", "%s", %d)',
                                              $this->bankleitzahl,
                                              $this->kontonummer,
                                              $this->balance);

        $this->id = Database::instance()->getLastInsertedId();

        return $result;
    }
}
