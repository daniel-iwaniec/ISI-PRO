<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Overridden vendor controller from FOSUserBundle.
 */
class SecurityController extends BaseController
{
    /**
     * Authenticated users do not have access to this route.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function loginAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        $router = $this->container->get('router');

        if ($securityContext->isGranted('ROLE_USER')) {
            return new RedirectResponse($router->generate('index'), 307);
        }

        return parent::loginAction($request);
    }
}
