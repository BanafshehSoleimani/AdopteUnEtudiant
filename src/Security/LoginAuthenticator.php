<?php

namespace App\Security;

use App\Entity\Admin;
use App\Entity\Company;
use App\Entity\Student;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }




        switch ($token->getUser()->getRoles()[0]) {
            case 'ROLE_ADMIN':
                return new RedirectResponse($this->urlGenerator->generate('admin'));
                break;
            case 'ROLE_STUDENT':
                return new RedirectResponse($this->urlGenerator->generate('account_student'));
                break;
            case 'ROLE_COMPANY':
                return new RedirectResponse($this->urlGenerator->generate('account_company'));
                break;

            default:
                return new RedirectResponse($this->urlGenerator->generate('home'));
                break;
        }

        // dd($token->getUser()->getRoles()[0]);

        /*    if($token->getUser()->getRoles()[0] == 'ROLE_ADMIN'){
            
            return new RedirectResponse($this->urlGenerator->generate('admin'));
        }
        elseif($token->getUser()->getRoles()[0]  == 'ROLE_STUDENT'){
            
            return new RedirectResponse($this->urlGenerator->generate('account_student'));
        }
        elseif($token->getUser()->getRoles()[0]  == 'ROLE_COMPANY'){
            
            return new RedirectResponse($this->urlGenerator->generate('account_company'));
        }
        else {
             return new RedirectResponse($this->urlGenerator->generate('home')); 
        }  */


        // return new RedirectResponse($this->urlGenerator->generate('account_student'));

        //  throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}