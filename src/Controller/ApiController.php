<?php

/*
 * This file is part of the Reiterus package.
 *
 * (c) Pavel Vasin <reiterus@yandex.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @codeCoverageIgnore
 * API controller
 *
 * @package App\Controller
 * @author Pavel Vasin <reiterus@yandex.ru>
 */
class ApiController extends AbstractController
{
    /**
     * Public API route
     *
     * @Route("/api", name="app_api")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Free access method',
        ]);
    }

    /**
     * API Route only for fake user
     *
     * @Route("/api/fake", name="app_api_fake")
     */
    public function fake(): JsonResponse
    {
        return $this->json([
            'message' => 'Method only for Fake User',
        ]);
    }
}
