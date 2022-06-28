<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/blog', name: 'blog_list')]
    public function list()
    {
        return new Response(
            '<html><body>Hi !</body></html>'
        );
    }
}
