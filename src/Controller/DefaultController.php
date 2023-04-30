<?php

namespace App\Controller;

use App\Repository\TrazaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/index', name: 'app_default')]
    public function index(TrazaRepository $trazaRepository): Response
    {
      
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'years' => $trazaRepository->obtenerYears(),
            'denegados' => $trazaRepository->obtenerCodigoYears('DENIED'),
            'perdidas' => $trazaRepository->obtenerCodigoYears('MISS'),
        ]);
    }
}
