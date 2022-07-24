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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException as AuthException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

/**
 * Fake User Authenticator
 *
 * @package App\Security
 * @author Pavel Vasin <reiterus@yandex.ru>
 */
class FakeUserAuthenticator extends AbstractAuthenticator
{
    private const AUTH = 'authorization';

    private FakeUser $fakeUser;
    private FakeUserProvider $provider;

    /**
     * @codeCoverageIgnore
     * @param FakeUser $fakeUser
     * @param FakeUserProvider $provider
     */
    public function __construct(
        FakeUser         $fakeUser,
        FakeUserProvider $provider
    )
    {
        $this->fakeUser = $fakeUser;
        $this->provider = $provider;
    }

    /**
     * Authenticator support
     *
     * @param Request $request
     *
     * @return bool|null
     */
    public function supports(Request $request): ?bool
    {
        return $this->getActualToken($request);
    }

    /**
     * Create a passport for the current request
     *
     * @param Request $request
     *
     * @return Passport
     */
    public function authenticate(Request $request): Passport
    {
        $token = $this->getActualToken($request);

        if (null === $token) {
            throw new AuthException('No API token provided');
        }

        $token = trim(substr($token, 6));

        if ($token != $this->fakeUser->getToken()) {
            throw new AuthException('Wrong token');
        }

        // @codeCoverageIgnoreStart
        $userLoader = function () use ($token) {
            return $this->provider->loadUserByIdentifier($token);
        };
        // @codeCoverageIgnoreEnd

        return new SelfValidatingPassport(
            new UserBadge($token, $userLoader)
        );
    }

    /**
     * @codeCoverageIgnore
     * Called when authentication executed and was successful
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $firewallName
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(
        Request        $request,
        TokenInterface $token,
        string         $firewallName
    ): ?Response
    {
        return null;
    }

    /**
     * Called when authentication executed,
     * but failed (e.g. wrong username password)
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(
        Request                 $request,
        AuthenticationException $exception
    ): ?Response
    {
        $data = [
            'message' => $exception->getMessage()
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Get actual token from request
     *
     * @param Request $request
     *
     * @return string|null
     */
    protected function getActualToken(Request $request): ?string
    {
        $token = $request->headers->get(self::AUTH);

        return $token == '' ? null : $token;
    }
}
