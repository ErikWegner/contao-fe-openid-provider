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
use ErikWegner\FeOpenidProvider\Model\UserModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $server = $this->server->getServer();
        try {
            // Validate the HTTP request and return an AuthorizationRequest object.
            // The auth request object can be serialized into a user's session
            $authRequest = $server->validateAuthorizationRequest($request);

            // Once the user has logged in set the user on the AuthorizationRequest
            $authRequest->setUser(new UserModel());

            // Once the user has approved or denied the client update the status
            // (true = approved, false = denied)
            $authRequest->setAuthorizationApproved(true);

            // Return the HTTP redirect response
            return $server->completeAuthorizationRequest($authRequest, $response);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            $body = new Stream('php://temp', 'r+');
            $body->write($exception->getMessage());

            return $response->withStatus(500)->withBody($body);
        }
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
