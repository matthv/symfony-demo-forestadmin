<?php

namespace App\Controller;

use ForestAdmin\AgentPHP\Agent\Facades\JsonApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountCustomController extends AbstractController
{
    #[Route('/count-custom', name: 'count_custom')]
    public function index(): Response
    {
        return JsonApi::deactivateCountResponse();
    }
}
