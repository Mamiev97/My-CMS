<?php

declare(strict_types=1);

namespace App\Model;

use App\Repositories\UserRepository;
use DateTime;

class User
{
    private int $id;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;
    private DateTime $dateCreated;
    private DateTime $dateUpdated;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return void
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return void
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPasswordHash(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return DateTime
     */
    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @return void
     */
    public function setDateCreated(): void
    {
        $this->dateCreated = new DateTime('now');
    }

    /**
     * @return DateTime
     */
    public function getDateUpdated(): DateTime
    {
        return $this->dateUpdated;
    }

    /**
     * @return void
     */
    public function setDateUpdated(): void
    {
        $this->dateUpdated = new DateTime('now');
    }
}
