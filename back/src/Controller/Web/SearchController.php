<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Entity\Professional;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('/search', name: 'app_search_professionals')]
    public function index(Request $request): Response
    {
        return $this->render(
            'web/search/result.html.twig',
            [
                'professionals' => $this->em->getRepository(Professional::class)->findAll()
            ]
        );
    }
}