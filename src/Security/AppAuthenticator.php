<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->getPayload()->getString('email');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Récupérez l'utilisateur
        $user = $token->getUser();
        
        // Vérifiez si l'email de l'utilisateur est vérifié
        if (!$user->isVerified()) {
            // Ajoutez un message flash pour informer l'utilisateur de vérifier son e-mail
            $request->getSession()->getFlashBag()->add('warning', 'Veuillez confirmer votre adresse e-mail.');

            // Redirigez l'utilisateur vers la page d'accueil
            return new RedirectResponse($this->urlGenerator->generate('app_home')); // Remplacez 'home_route' par le nom de votre route d'accueil
        }

        // Récupérez les rôles de l'utilisateur
        $roles = $token->getUser()->getRoles();

        // Redirigez les utilisateurs en fonction de leurs rôles
        if (in_array('ROLE_ADMIN', $roles, true)) {
            return new RedirectResponse($this->urlGenerator->generate('admin'));  // Remplacez 'admin_route' par le nom de votre route admin
        } elseif (in_array('ROLE_USER', $roles, true)) {
            return new RedirectResponse($this->urlGenerator->generate('app_profile'));  // Remplacez 'profile_route' par le nom de votre route profil
        } else {
            throw new \Exception('No route found for user role.');
        }
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
