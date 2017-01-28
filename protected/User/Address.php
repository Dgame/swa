<?php

namespace Swa\User;

use Swa\Database\Database;

/**
 * Class Address
 * @package Swa\User
 */
final class Address
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $location;
    /**
     * @var string
     */
    public $plz;

    /**
     * Address constructor.
     *
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        if (!empty($id)) {
            $data = Database::instance()->fetch('SELECT * FROM address WHERE id = "%d"', $id);

            $this->id       = (int) $data['id'];
            $this->location = $data['location'];
            $this->plz      = $data['plz'];
        }
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!empty($this->id)) {
            return Database::instance()->query('UPDATE address SET location = "%s", plz = "%s" WHERE id = %d',
                                               $this->location, $this->plz, $this->id);
        }

        $result = Database::instance()->query('INSERT INTO address (location, plz) VALUES("%s", "%s")',
                                              $this->location,
                                              $this->plz);

        $this->id = Database::instance()->getLastInsertedId();

        return $result;
    }
}
