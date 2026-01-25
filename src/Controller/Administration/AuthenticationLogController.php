<?php

namespace App\Controller\Administration;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administration', name: 'app_admin_')]
class AuthenticationLogController extends AbstractController
{
    #[Route('/authentication-logs', name: 'authentication_logs_index')]
    public function index(): Response
    {
        return $this->render('admin/authentication_logs/index.html.twig');
    }
}
