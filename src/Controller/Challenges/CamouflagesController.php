<?php

namespace App\Controller\Challenges;

use App\Repository\CamouflageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CamouflagesController extends AbstractController
{
    public function __construct(
        private readonly CamouflageRepository $camouflageRepository,
    )
    {
    }

    #[Route('/challenges/camouflages', name: 'challenges_camouflages')]
    public function challenges_camouflages(): Response
    {
        $camouflages = $this->camouflageRepository->findByWeapon();

        return $this->render('challenges/camouflages.html.twig', [
            'title' => 'Camouflages',
            'camouflages' => $camouflages,
        ]);
    }
}
