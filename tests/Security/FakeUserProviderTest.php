<?php

namespace App\Tests\Security;

use App\Security\FakeUser;
use App\Security\FakeUserProvider;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @covers \App\Security\FakeUserProvider
 * Fake User Provider Test
 *
 * @package App\Tests\Security
 * @author Pavel Vasin <reiterus@yandex.ru>
 */
class FakeUserProviderTest extends TestCase
{
    private FakeUserProvider $object;

    /**
     * @covers \App\Security\FakeUserProvider::loadUserByIdentifier
     * @return void
     */
    public function testLoadUserByIdentifier(): void
    {
        $actual = $this->object->loadUserByIdentifier('token');
        $this->assertInstanceOf(FakeUser::class, $actual);
    }

    /**
     * @covers \App\Security\FakeUserProvider::supportsClass
     * @return void
     */
    public function testSupportsClass(): void
    {
        $actual = $this->object->supportsClass(FakeUser::class);
        $this->assertIsBool($actual);
    }

    /**
     * @covers \App\Security\FakeUserProvider::refreshUser
     * @dataProvider usersProvider
     * @param $user
     * @return void
     */
    public function testRefreshUser($user): void
    {
        try {
            $actual = $this->object->refreshUser($user);
            $this->assertInstanceOf(FakeUser::class, $actual);
        } catch (Exception $exception) {
            $this->assertInstanceOf(
                UnsupportedUserException::class,
                $exception
            );
        }
    }

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function usersProvider(): array
    {
        return [
            [new FakeUser()],
            [$this->getMockBuilder(User::class)
                ->disableOriginalConstructor()
                ->getMock()],
        ];
    }

    /**
     * @codeCoverageIgnore
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new FakeUserProvider();
    }
}
