<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Form\Web\Type\SearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class WelcomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('web/home.html.twig',
            [
                'form' => $this
                    ->createForm(type: SearchForm::class, options: ['action' => $this->generateUrl('app_search_professionals')])
                    ->createView()
            ]
        );
    }
}