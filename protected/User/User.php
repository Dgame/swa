<?php

namespace Swa\User;

use Swa\Database\Database;

/**
 * Class User
 * @package Swa\User
 */
final class User
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $password;
    /**
     * @var \DateTime
     */
    public $birthdate;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $telephone;
    /**
     * @var Address
     */
    public $address;
    /**
     * @var BankAccount
     */
    public $bankAccount;

    /**
     * User constructor.
     *
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        if (!empty($id)) {
            $data = Database::instance()->fetch('SELECT * FROM user WHERE id = "%d"', $id);

            $this->id          = (int) $data['id'];
            $this->name        = $data['username'];
            $this->birthdate   = new \DateTime($data['birthdate']);
            $this->email       = $data['email'];
            $this->telephone   = $data['telephone'];
            $this->password    = $data['passwort'];
            $this->address     = new Address($data['address']);
            $this->bankAccount = new BankAccount($data['bank_account']);
        }
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if ($this->address instanceof Address) {
            $this->address->save();
        }

        if ($this->bankAccount instanceof BankAccount) {
            $this->bankAccount->save();
        }

        if (!empty($this->id)) {
            return Database::instance()->query('UPDATE user SET username = "%s", passwort="%s", birthdate = "%s", email="%s", telephone="%s", address=%d, bank_account=%d WHERE id = %d',
                                               $this->name,
                                               $this->password,
                                               $this->birthdate->format('d.m.Y'),
                                               $this->email,
                                               $this->telephone,
                                               $this->address->id,
                                               $this->bankAccount->id,
                                               $this->id);
        }

        $result = Database::instance()->query('INSERT INTO user (username, passwort, birthdate, email, telephone, address, bank_account) VALUES("%s", "%s", ""%s", "%s", "%s", %d, %d)',
                                              $this->name,
                                              $this->password,
                                              $this->birthdate->format('d.m.Y'),
                                              $this->email,
                                              $this->telephone,
                                              $this->address->id,
                                              $this->bankAccount->id);

        $this->id = Database::instance()->getLastInsertedId();

        return $result;
    }

    /**
     * @return User[]
     */
    public function other(): array
    {
        $result = Database::instance()->fetchAll('SELECT id FROM user WHERE id != %d', $this->id);

        return self::invokeUser($result);
    }

    /**
     * @param array $result
     *
     * @return User[]
     */
    private static function invokeUser(array $result): array
    {
        if (empty($result)) {
            return [];
        }

        $users = [];
        foreach ($result as $value) {
            $users[] = new User($value['id']);
        }

        return $users;
    }

    /**
     * @return User[]
     */
    public static function all(): array
    {
        $result = Database::instance()->fetchAll('SELECT id FROM user');

        return self::invokeUser($result);
    }
}
