<?php

namespace App\Controller\Administration;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administration', name: 'app_admin_')]
class LogUserController extends AbstractController
{
    #[Route('/log-users', name: 'log_users_index')]
    public function index(): Response
    {
        return $this->render('admin/log_users/index.html.twig');
    }
}
