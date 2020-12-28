<?php

declare(strict_types=1);

/*
 * This file is part of fe-openid-provider.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\FeOpenidProvider\Controller;

use ErikWegner\FeOpenidProvider\Service\AuthorizationServerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Terminal42\ServiceAnnotationBundle\Annotation\ServiceTag;

/**
 * @ServiceTag("controller.service_arguments")
 */
class AuthCodeController
{
    /**
     * @var ErikWegner\FeOpenidProvider\Service\AuthorizationServerService AuthorizationServer
     */
    private $server;

    public function __construct(AuthorizationServerService $server)
    {
        $this->server = $server;
    }

    /**
     * @Route("/fe/authorize", name="feopenidprovider.authcode.authorize", methods={"GET"})
     */
    public function authorize(Request $request): Response
    {
        $array = [];
        $array['d'] = 'GET OK';
        $response = new Response(json_encode($array), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/fe/access_token", name="feopenidprovider.authcode.access_token", methods={"POST"})
     */
    public function access_token(Request $request): Response
    {
        $array = [];
        $array['d'] = 'GET OK';
        $response = new Response(json_encode($array), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
