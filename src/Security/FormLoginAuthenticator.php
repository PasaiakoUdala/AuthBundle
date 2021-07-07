<?php

namespace PasaiakoUdala\AuthBundle\Security;

use PasaiakoUdala\AuthBundle\Repository\UserRepository;
use PasaiakoUdala\AuthBundle\Service\PasaiaLdapService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class FormLoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;
    private UserRepository $userRepository;
    private PasaiaLdapService $pasaiaLdapSrv;
    private UrlGeneratorInterface $urlGenerator;
    private String $route_after_successfull_login;

    public const LOGIN_ROUTE = 'pasaiakoudala_auth_login';

    public function __construct(
        UserRepository $userRepository,
        PasaiaLdapService $pasaiaLdapSrv,
        UrlGeneratorInterface $urlGenerator,
        string $route_after_successfull_login
    )
    {
        $this->userRepository   = $userRepository;
        $this->pasaiaLdapSrv    = $pasaiaLdapSrv;
        $this->urlGenerator = $urlGenerator;
        $this->route_after_successfull_login = $route_after_successfull_login;
        dump($route_after_successfull_login);
    }

    public function authenticate(Request $request): PassportInterface
    {
        $password = $request->request->get('password');
        $username = $request->request->get('username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $result =  $this->pasaiaLdapSrv->checkCredentials($username, $password);

        if ( $result ) {
            $dbUser = $this->userRepository->findOneBy(['username' => $username]);

            if (!$dbUser) {
                // User is not present in the Database, let's create it
                $this->pasaiaLdapSrv->createDbUserFromLdapData($username);
            }
            // The User exists in the database, let's update it's data
            $this->pasaiaLdapSrv->updateDbUserDataFromLdapByUsername($username);
        } else {
            throw new UserNotFoundException();
        }

        return new SelfValidatingPassport(new UserBadge($username));

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate($this->route_after_successfull_login));

    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
