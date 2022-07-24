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

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Fake User Provider
 *
 * @package App\Security
 * @author Pavel Vasin <reiterus@yandex.ru>
 */
class FakeUserProvider implements UserProviderInterface
{
    /**
     * Loads the user for the given user identifier
     *
     * @param string $identifier
     *
     * @return UserInterface
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return new FakeUser();
    }

    /**
     * @codeCoverageIgnore
     * @deprecated since Symfony 5.3
     * loadUserByIdentifier() is used instead
     */
    public function loadUserByUsername(string $username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }

    /**
     * Refreshes the user after being reloaded from the session
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof FakeUser) {
            $message = sprintf(
                'Invalid user class "%s".',
                get_class($user)
            );

            throw new UnsupportedUserException($message);
        }

        return $user;
    }

    /**
     * Tells Symfony to use this provider for this User class
     */
    public function supportsClass(string $class): bool
    {
        return FakeUser::class === $class
            || is_subclass_of($class, FakeUser::class);
    }
}
