<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    public function __construct(
        private readonly AuthenticationUtils $authenticationUtils,
    ) {}

    #[Route('/admin/login', name: 'app_admin_login')]
    public function login(
        #[CurrentUser] ?User $currentUser,
        Request $request,
    ): Response {
        // Check if the "_remember_me" parameter is present in the request
        $rememberMe = (bool) $request->get('_remember_me');

        // Check if the "REMEMBERME" cookie is present
        $hasRememberMeCookie = $request->cookies->has('REMEMBERME');
        if ($currentUser || $hasRememberMeCookie) {
            return $this->redirectToRoute('admin_dashboard');
        }

        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();
        return $this->render('@EasyAdmin/page/login.html.twig', [
            // parameters usually defined in Symfony login forms
            'error' => $error,
            'last_username' => $lastUsername,

            // OPTIONAL parameters to customize the login form:

            // the string used to generate the CSRF token. If you don't define
            // this parameter, the login form won't include a CSRF token
            'csrf_token_intention' => 'authenticate',
            'remember_me' => $rememberMe,

            // the URL users are redirected to after the login (default: '/admin')
            'target_path' => $this->generateUrl('admin_dashboard'),
        ]);
    }
}