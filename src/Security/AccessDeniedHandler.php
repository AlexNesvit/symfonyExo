<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $urlGenerator;
    private $requestStack;

    public function __construct(UrlGeneratorInterface $urlGenerator, RequestStack $requestStack)
    {
        $this->urlGenerator = $urlGenerator;
        $this->requestStack = $requestStack;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $session = $this->requestStack->getSession();
        $session->getFlashBag()->add('danger', '💀💀💀 Vous n’avez pas les droits nécessaires pour accéder à cette page. 💀💀💀');

        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }
}
