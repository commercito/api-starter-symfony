<?php

/*
 * This file is part of the Reiterus package.
 *
 * (c) Pavel Vasin <reiterus@yandex.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Fake User Model
 *
 * @package App\Security
 * @author Pavel Vasin <reiterus@yandex.ru>
 */
class FakeUser implements UserInterface
{
    private string $token = 'good.fake.user.token';

    /**
     * Get fake user token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * A visual identifier that represents this user
     *
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->token;
    }

    /**
     * @codeCoverageIgnore
     * @deprecated since Symfony 5.3
     * use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return $this->token;
    }

    /**
     * Returns the roles granted to the user
     *
     * @return string[]
     */
    public function getRoles(): array
    {
        return ['FAKE_USER'];
    }

    /**
     * @codeCoverageIgnore
     * Returns the password used to authenticate the user
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return null;
    }

    /**
     * @codeCoverageIgnore
     * Returns the salt that was originally used to hash the password
     *
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @codeCoverageIgnore
     * Removes sensitive data from the user
     *
     * @return void|null
     */
    public function eraseCredentials()
    {
        return null;
    }
}
