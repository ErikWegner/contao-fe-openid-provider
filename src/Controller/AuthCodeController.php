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

use ErikWegner\FeOpenidProvider\Entities\UserEntity;
use ErikWegner\FeOpenidProvider\Model\UserModel;
use ErikWegner\FeOpenidProvider\Service\AuthorizationServerService;
use Laminas\Diactoros\Stream;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AuthCodeController extends AbstractController
{
    /**
     * @var PsrHttpFactory PsrHttpFactory
     */
    private $psrHttpFactory;

    /**
     * @var HttpFoundationFactory HttpFoundationFactory
     */
    private $httpFoundationFactory;

    /**
     * @var Psr17Factory Psr17Factory
     */
    private $psr17Factory;

    /**
     * @var AuthorizationServerService AuthorizationServer
     */
    private $server;

    /**
     * @var Security Authorization
     */
    private $security;

    /**
     * @var Security Authorization
     */
    private $uriSigner;

    public function __construct(AuthorizationServerService $server, Security $security, UriSigner $uriSigner)
    {
        $this->server = $server;
        $this->security = $security;
        $this->uriSigner = $uriSigner;
        $psr17Factory = new Psr17Factory();
        $this->psr17Factory = $psr17Factory;
        $this->psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $this->httpFoundationFactory = new HttpFoundationFactory();
    }

    /**
     * @Route("/fe/authorize", name="feopenidprovider.authcode.authorize", methods={"GET"}, defaults={"_scope": "frontend"})
     */
    public function authorize(Request $symfonyRequest): Response
    {
        $feuser = $this->security->getUser();

        if (!$feuser) {
            $uri = $symfonyRequest->getUriForPath('/fe-login.html');
            $signedUri = $this->uriSigner->sign($uri.'?redirect='.urlencode($symfonyRequest->getUri()));

            return $this->redirect($signedUri);
        }

        $request = $this->psrHttpFactory->createRequest($symfonyRequest);
        $server = $this->server->getServer();
        $response = $this->psr17Factory->createResponse();

        try {
            // Validate the HTTP request and return an AuthorizationRequest object.
            // The auth request object can be serialized into a user's session
            $authRequest = $server->validateAuthorizationRequest($request);

            // Once the user has logged in set the user on the AuthorizationRequest
            if ($feuser) {
                $ue = new UserEntity();
                $ue->setIdentifier($feuser->id);
                $authRequest->setUser($ue);
            } else {
                $authRequest->setUser(new UserModel());
            }

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
