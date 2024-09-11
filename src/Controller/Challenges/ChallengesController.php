<?php

namespace App\Controller\Challenges;

use App\Entity\Challenge;
use App\Entity\User;
use App\Repository\ChallengeRepository;
use App\Repository\Challenges\CamouflageChallengeRepository;
use App\Repository\Challenges\CampaignChallengeRepository;
use App\Repository\Challenges\MultiplayerChallengeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChallengesController extends AbstractController
{
    public function __construct(
        private readonly CamouflageChallengeRepository  $camouflageRepository,
        private readonly CampaignChallengeRepository    $campaignRepository,
        private readonly MultiplayerChallengeRepository $multiplayerRepository,
        private readonly ChallengeRepository            $challengeRepository,
        private readonly EntityManagerInterface         $entityManager,
    )
    {
    }

    #[Route('/challenges/complete', name: 'challenges_complete', methods: ['POST'])]
    public function challenges_complete(Request $request): Response
    {
        if (!$user = $this->getUser()) {
            return new Response('', Response::HTTP_FORBIDDEN);
        }

        $postData = $request->request->all();

        if ($user instanceof User
            && isset($postData['challenges'])) {
            $postCompletedChallenges = $postData['challenges'];
            $postCompletedChallenges = $this->challengeRepository->findBy([
                'id' => $postCompletedChallenges,
            ]);
            if (empty($postCompletedChallenges)) {
                return new Response('', Response::HTTP_BAD_REQUEST);
            }

            // We check if user already has those completed challenges.
            $userCompletedChallenges = $user->getCompletedChallenges();
            $userCompletedChallenges = $userCompletedChallenges->isEmpty()
                ? []
                : $userCompletedChallenges->map(function ($obj) {
                    return $obj->getId();
                })->getValues();

            $postUncompletedChallenges = array_filter($postCompletedChallenges, function (Challenge $challenge) use ($userCompletedChallenges) {
                return !in_array($challenge->getId(), $userCompletedChallenges);
            });

            // We add uncompleted challenges to current user.
            foreach ($postUncompletedChallenges as $challenge) {
                $user->addCompletedChallenge($challenge);
            }

            $this->entityManager->flush();
        }

        return new Response('', Response::HTTP_OK);
    }

    #[Route('/challenges/remove', name: 'challenges_remove', methods: ['POST'])]
    public function challenges_remove(Request $request): Response
    {
        if (!$user = $this->getUser()) {
            return new Response('', Response::HTTP_FORBIDDEN);
        }

        $postData = $request->request->all();

        if ($user instanceof User
            && isset($postData['challenges'])) {
            $postUncompletedChallenges = $postData['challenges'];
            $postUncompletedChallenges = $this->challengeRepository->findBy([
                'id' => $postUncompletedChallenges,
            ]);
            if (empty($postUncompletedChallenges)) {
                return new Response('', Response::HTTP_BAD_REQUEST);
            }

            // We check if user already has those completed challenges.
            $userCompletedChallenges = $user->getCompletedChallenges();
            $userCompletedChallenges = $userCompletedChallenges->isEmpty()
                ? []
                : $userCompletedChallenges->map(function ($obj) {
                    return $obj->getId();
                })->getValues();

            $postCompletedChallenges = array_filter($postUncompletedChallenges, function (Challenge $challenge) use ($userCompletedChallenges) {
                return in_array($challenge->getId(), $userCompletedChallenges);
            });

            // We add uncompleted challenges to current user.
            foreach ($postCompletedChallenges as $challenge) {
                $user->removeCompletedChallenge($challenge);
            }

            $this->entityManager->flush();
        }

        return new Response('', Response::HTTP_OK);
    }

    #[Route('/challenges/camouflages', name: 'challenges_camouflages')]
    public function challenges_camouflages(): Response
    {
        $camouflagesChallenges = $this->camouflageRepository->findByWeapon($this->getUser());

        return $this->render('challenges/camouflages.html.twig', [
            'title' => 'Camouflages challenges',
            'camouflagesChallenges' => $camouflagesChallenges,
        ]);
    }

    #[Route('/challenges/campaign', name: 'challenges_campaign')]
    public function challenges_campaign(): Response
    {
        $campaignChallenges = $this->campaignRepository->findByDifficultyOrdered($this->getUser());

        return $this->render('challenges/campaign.html.twig', [
            'title' => 'Campaign challenges',
            'campaignChallenges' => $campaignChallenges,
        ]);
    }

    #[Route('/challenges/multiplayer', name: 'challenges_multiplayer')]
    public function challenges_multiplayer(): Response
    {
        $multiplayerChallenges = $this->multiplayerRepository->findByCategoryOrdered($this->getUser());

        return $this->render('challenges/multiplayer.html.twig', [
            'title' => 'Multiplayer challenges',
            'multiplayerChallenges' => $multiplayerChallenges,
        ]);
    }
}
