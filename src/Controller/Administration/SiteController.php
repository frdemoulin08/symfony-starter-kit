<?php

namespace App\Controller\Administration;

use App\Entity\Site;
use App\Repository\SiteRepository;
use App\Table\TablePaginator;
use App\Table\TableParams;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SiteController extends AbstractController
{
    #[Route('/administration/sites', name: 'app_admin_sites_index')]
    public function index(
        Request $request,
        SiteRepository $siteRepository,
        TablePaginator $tablePaginator
    ): Response {
        $params = TableParams::fromRequest($request, [
            'sort' => 'updatedAt',
            'direction' => 'desc',
            'per_page' => 10,
        ]);

        $qb = $siteRepository->createTableQb($params);
        $pager = $tablePaginator->paginate($qb, $params, ['name', 'city', 'capacity', 'status', 'updatedAt'], 's');

        if ($request->isXmlHttpRequest()) {
            return $this->render('admin/sites/_table.html.twig', [
                'pager' => $pager,
                'params' => $params,
            ]);
        }

        return $this->render('admin/sites/index.html.twig', [
            'pager' => $pager,
            'params' => $params,
        ]);
    }

    #[Route('/administration/sites/{id}', name: 'app_admin_sites_show', requirements: ['id' => '\\d+'])]
    public function show(Site $site): Response
    {
        return $this->render('admin/sites/show.html.twig', [
            'site' => $site,
        ]);
    }

    #[Route('/administration/sites/{id}/edit', name: 'app_admin_sites_edit', requirements: ['id' => '\\d+'])]
    public function edit(Site $site): Response
    {
        return $this->render('admin/sites/edit.html.twig', [
            'site' => $site,
        ]);
    }

    #[Route('/administration/sites/{id}/delete', name: 'app_admin_sites_delete', requirements: ['id' => '\\d+'], methods: ['POST'])]
    public function delete(Request $request, Site $site, SiteRepository $siteRepository): Response
    {
        if (!$this->isCsrfTokenValid('delete_site_' . $site->getId(), (string) $request->request->get('_token'))) {
            return $this->redirectToRoute('app_admin_sites_index');
        }

        $siteRepository->remove($site, true);

        return $this->redirectToRoute('app_admin_sites_index');
    }
}
