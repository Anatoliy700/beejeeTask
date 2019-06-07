<?php

declare(strict_types = 1);

namespace app\services;

use app\models\entity\User;
use app\models\repositories\Users;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Security
{
    private const SESSION_USER_IDENTITY = 'userId';

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @return User|null
     * @throws \Exception
     */
    public function getUser(): ?User
    {
        $userId = $this->session->get(self::SESSION_USER_IDENTITY);

        return $userId ? ($this->getUserRepository())->getById($userId) : null;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isLogged(): bool
    {
        return $this->getUser() instanceof User;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    public function authentication(string $username, string $password): bool
    {
        $user = $this->getUserRepository()->getByUsername($username);

        if ($user === null) {
            return false;
        }

        if (!$this->validatePassword($password, $user->getPasswordHash())) {
            return false;
        }

        $this->session->set(self::SESSION_USER_IDENTITY, $user->getId());

        return true;
    }

    /**
     *
     */
    public function logout(): void
    {
        $this->session->set(self::SESSION_USER_IDENTITY, null);
    }


    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    protected function validatePassword($password, $hash): bool
    {
        return password_verify($password, $hash);
    }


    /**
     * @return Users
     */
    protected function getUserRepository(): Users
    {
        return new Users();
    }
}
