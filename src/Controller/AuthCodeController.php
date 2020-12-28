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

use Laminas\Diactoros\Stream;
use ErikWegner\FeOpenidProvider\Service\AuthorizationServerService;
use ErikWegner\FeOpenidProvider\Model\UserModel;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthCodeController
{
    /**
     * @var Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory PsrHttpFactory
     */
    private $psrHttpFactory;

    /**
     * @var Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory HttpFoundationFactory
     */
    private $httpFoundationFactory;

    /**
     * @var Nyholm\Psr7\Factory\Psr17Factory Psr17Factory
     */
    private $psr17Factory;
    /**
     * @var ErikWegner\FeOpenidProvider\Service\AuthorizationServerService AuthorizationServer
     */
    private $server;

    public function __construct(AuthorizationServerService $server)
    {
        $this->server = $server;
        $psr17Factory = new Psr17Factory();
        $this->psr17Factory = $psr17Factory;
        $this->psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $this->httpFoundationFactory = new HttpFoundationFactory();
    }

    /**
     * @Route("/fe/authorize", name="feopenidprovider.authcode.authorize", methods={"GET"})
     */
    public function authorize(Request $symfonyRequest): Response
    {
        $request = $this->psrHttpFactory->createRequest($symfonyRequest);
        $server = $this->server->getServer();
        $response = $this->psr17Factory->createResponse();
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
            return $this->httpFoundationFactory->createResponse($server->completeAuthorizationRequest($authRequest, $response));
        } catch (OAuthServerException $exception) {
            return $this->httpFoundationFactory->createResponse($exception->generateHttpResponse($response));
        } catch (\Exception $exception) {
            $body = new Stream('php://temp', 'r+');
            $body->write($exception->getMessage());

            return $this->httpFoundationFactory->createResponse($response->withStatus(500)->withBody($body));
        }
    }

    /**
     * @Route("/fe/access_token", name="feopenidprovider.authcode.access_token", methods={"POST"})
     */
    public function access_token(Request $symfonyRequest): Response
    {
        $request = $this->psrHttpFactory->createRequest($symfonyRequest);
        $server = $this->server->getServer();
        $response = $this->psr17Factory->createResponse();
        try {
            return $this->httpFoundationFactory->createResponse($server->respondToAccessTokenRequest($request, $response));
        } catch (OAuthServerException $exception) {
            return $this->httpFoundationFactory->createResponse($exception->generateHttpResponse($response));
        } catch (\Exception $exception) {
            $body = new Stream('php://temp', 'r+');
            $body->write($exception->getMessage());

            return $this->httpFoundationFactory->createResponse($response->withStatus(500)->withBody($body));
        }
    }
}
