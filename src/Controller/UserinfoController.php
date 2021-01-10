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

use Contao\MemberModel;
use ErikWegner\FeOpenidProvider\Service\ResourceServerService;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserinfoController extends AbstractController
{
    /**
     * @var ResourceServerService ResourceServerService
     */
    private $resService;

    public function __construct(ResourceServerService $resService)
    {
        $this->resService = $resService;
    }

    /**
     * @Route("/fe/userinfo", name="feopenidprovider.userinfo", methods={"GET"})
     */
    public function authorize(Request $symfonyRequest): Response
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $request = $psrHttpFactory->createRequest($symfonyRequest);
        $response = $psr17Factory->createResponse();

        $server = $this->resService->getServer();

        try {
            $authenticatedRequest = $server->validateAuthenticatedRequest($request);
            $userid = $authenticatedRequest->getAttribute('oauth_user_id');
            $r['user'] = $userid;
            $member = MemberModel::findById($userid);

            if ($member) {
                $r['username'] = $member->username;
                $r['given_name'] = $member->firstname;
                $r['family_name'] = $member->lastname;
                $r['email'] = $member->email;
                $groups = $member->getRelated('groups');
                $r['groups'] = array_map(
                    static function ($g) {
                        return $g->name;
                    },
                    $groups->getModels()
                );
            }

            $response = new Response(json_encode($r), 200);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        } catch (OAuthServerException $exception) {
            $httpFoundationFactory = new HttpFoundationFactory();

            return $httpFoundationFactory->createResponse($exception->generateHttpResponse($response));
        }
    }
}
