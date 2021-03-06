<?php

namespace PasaiakoUdala\AuthBundle\Controller;

use LogicException;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    protected $container;
    protected AuthenticationUtils $authenticationUtils;

    public function __construct(ContainerInterface $container, AuthenticationUtils $authenticationUtils)
    {
        $this->container = $container;
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(): Response
    {
//         if ($this->getUser()) {
//             return $this->redirectToRoute('target_path');
//         }

        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();


        return $this->render('@PasaiakoUdalaAuth/user/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
