<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\Professional;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SearchController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('/search', name: 'app_search_professionals')]
    public function index(Request $request, PaginatorInterface $paginator,): Response
    {
        $qb = $this->em->getRepository(Professional::class)->createQueryBuilder('p');

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render(
            'web/search/result.html.twig',
            [
                'pagination' => $pagination
            ]
        );
    }
}