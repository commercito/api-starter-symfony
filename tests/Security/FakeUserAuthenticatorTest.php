<?php

namespace App\Tests\Security;

use Symfony\Component\HttpFoundation\Request;
use App\Security\FakeUser;
use App\Security\FakeUserProvider;
use App\Security\FakeUserAuthenticator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * @covers \App\Security\FakeUserAuthenticator
 * Fake User Authenticator Test
 *
 * @package App\Tests\Security
 * @author Pavel Vasin <reiterus@yandex.ru>
 */
class FakeUserAuthenticatorTest extends TestCase
{
    private FakeUserAuthenticator $object;
    private Request $request;

    /**
     * @covers \App\Security\FakeUserAuthenticator::authenticate
     * @dataProvider tokensProvider
     * @param $token
     * @return void
     */
    public function testAuthenticate($token): void
    {
        $this->request->headers->set('Authorization', $token);

        try {
            $actual = $this->object->authenticate($this->request);
            $this->assertInstanceOf(Passport::class, $actual);
        } catch (CustomUserMessageAuthenticationException $ex) {
            $haystack = ['No API token provided', 'Wrong token'];
            $this->assertContains($ex->getMessage(), $haystack);
        }
    }

    /**
     * @covers \App\Security\FakeUserAuthenticator::supports
     * @dataProvider tokensProvider
     * @param $token
     * @return void
     */
    public function testSupports($token): void
    {
        $this->request->headers->set('Authorization', $token);
        $actual = $this->object->supports($this->request);

        if ($token) {
            $this->assertIsBool($actual);
        } else {
            $this->assertNull($actual);
        }
    }

    /**
     * @covers \App\Security\FakeUserAuthenticator::onAuthenticationFailure
     * @return void
     */
    public function testOnAuthenticationFailure(): void
    {
        $exception = new AuthenticationException('Some Message');
        $actual = $this->object->onAuthenticationFailure($this->request, $exception);
        $this->assertInstanceOf(Response::class, $actual);
    }

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function tokensProvider(): array
    {
        return [
            [null],
            [''],
            ['Bearer bad.fake.user.token'],
            ['Bearer good.fake.user.token'],
        ];
    }

    /**
     * @codeCoverageIgnore
     * @return void
     */
    protected function setUp(): void
    {
        $user = new FakeUser();
        $provider = new FakeUserProvider();
        $this->object = new FakeUserAuthenticator($user, $provider);
        $this->request = new Request();
    }
}
