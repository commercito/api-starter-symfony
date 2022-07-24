<?php

/*
 * This file is part of the Reiterus package.
 *
 * (c) Pavel Vasin <reiterus@yandex.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Security;

use App\Security\FakeUser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Security\FakeUser
 * Fake User Model Test
 *
 * @package App\Tests\Security
 * @author Pavel Vasin <reiterus@yandex.ru>
 */
class FakeUserTest extends TestCase
{
    private FakeUser $object;

    /**
     * @covers \App\Security\FakeUser::getToken
     * @return void
     */
    public function testGetToken(): void
    {
        $actual = $this->object->getToken();
        $this->assertIsString($actual);
    }

    /**
     * @covers \App\Security\FakeUser::getUserIdentifier
     * @return void
     */
    public function testGetUserIdentifier(): void
    {
        $actual = $this->object->getUserIdentifier();
        $this->assertIsString($actual);
    }

    /**
     * @covers \App\Security\FakeUser::getRoles
     * @return void
     */
    public function testGetRoles(): void
    {
        $actual = $this->object->getRoles();
        $this->assertIsArray($actual);
        $this->assertEquals('FAKE_USER', current($actual));
    }

    /**
     * @codeCoverageIgnore
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new FakeUser();
    }
}
