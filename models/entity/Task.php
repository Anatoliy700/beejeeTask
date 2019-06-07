<?php

namespace app\models\entity;

class Task
{
    const STATUS_DONE = 1;
    const STATUS_IN_WORK = 0;

    /**
     * @var int | null
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $status;


    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $id
     * @return Task
     */
    public function setId(int $id): Task
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $username
     * @return Task
     */
    public function setUsername(string $username): Task
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $email
     * @return Task
     */
    public function setEmail(string $email): Task
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $description
     * @return Task
     */
    public function setDescription(string $description): Task
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param int $status
     * @return Task
     */
    public function setStatus(int $status): Task
    {
        $this->status = $status;

        return $this;
    }


}
