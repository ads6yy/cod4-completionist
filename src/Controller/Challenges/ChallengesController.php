<?php

namespace App\Controller\Challenges;

use App\Repository\Challenges\CamouflageChallengeRepository;
use App\Repository\Challenges\CampaignChallengeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChallengesController extends AbstractController
{
    public function __construct(
        private readonly CamouflageChallengeRepository $camouflageRepository,
        private readonly CampaignChallengeRepository   $campaignRepository,
    )
    {
    }

    #[Route('/challenges/camouflages', name: 'challenges_camouflages')]
    public function challenges_camouflages(): Response
    {
        $camouflagesChallenges = $this->camouflageRepository->findByWeapon();

        return $this->render('challenges/camouflages.html.twig', [
            'title' => 'Camouflages challenges',
            'camouflagesChallenges' => $camouflagesChallenges,
        ]);
    }

    #[Route('/challenges/campaign', name: 'challenges_campaign')]
    public function challenges_campaign(): Response
    {
        $campaignChallenges = $this->campaignRepository->findByDifficultyOrdered();

        return $this->render('challenges/campaign.html.twig', [
            'title' => 'Campaign challenges',
            'campaignChallenges' => $campaignChallenges,
        ]);
    }
}
