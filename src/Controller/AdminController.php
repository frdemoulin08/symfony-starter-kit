<?php

namespace App\Controller;

use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/administration', name: 'app_admin_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/administration/sites', name: 'app_admin_sites_index')]
    public function sites(): Response
    {
        return $this->render('admin/sites/index.html.twig');
    }

    #[Route('/administration/sites/donnees', name: 'app_admin_sites_data')]
    public function sitesData(Request $request, SiteRepository $siteRepository): JsonResponse
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $size = max(1, (int) $request->query->get('size', 10));
        $sorters = $request->query->all('sorters');
        $filters = $request->query->all('filters');

        if (!is_array($sorters)) {
            $sorters = [];
        }

        if (!is_array($filters)) {
            $filters = [];
        }

        $result = $siteRepository->findForTabulator($page, $size, $sorters, $filters);
        $total = $result['total'];
        $lastPage = (int) ceil($total / $size);

        $paged = array_map(static function ($site): array {
            return [
                'id' => $site->getId(),
                'name' => $site->getName(),
                'city' => $site->getCity(),
                'capacity' => $site->getCapacity(),
                'status' => $site->getStatus(),
                'updated_at' => $site->getUpdatedAt()->format('d/m/Y'),
            ];
        }, $result['data']);

        return new JsonResponse([
            'data' => $paged,
            'last_page' => $lastPage,
            'total' => $total,
        ]);
    }
}
