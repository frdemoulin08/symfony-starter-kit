<?php

namespace App\Controller\Administration;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administration', name: 'app_admin_')]
class UserController extends AbstractController
{
    #[Route('/users', name: 'users_index')]
    public function index(): Response
    {
        return $this->render('admin/users/index.html.twig');
    }
}
