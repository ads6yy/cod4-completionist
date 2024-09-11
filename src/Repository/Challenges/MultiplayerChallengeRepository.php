<?php

namespace App\Repository\Challenges;

use App\Constantes\Challenge\Multiplayer\MultiplayerCategory;
use App\Entity\Challenge;
use App\Entity\Challenges\MultiplayerChallenge;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MultiplayerChallenge>
 */
class MultiplayerChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MultiplayerChallenge::class);
    }

    public function findByCategoryOrdered(User $user = NULL): array
    {
        $userCompletedChallenges = $user instanceof User ? $user->getCompletedChallenges() : new ArrayCollection();

        $multiplayerChallenges = [];
        $allMultiplayerChallenges = $this->findBy([], ['unlock_level' => 'ASC']);

        $multiplayerChallengesByCategory = [];
        foreach ($allMultiplayerChallenges as $multiplayerChallenge) {
            $multiplayerChallengeCategory = $multiplayerChallenge->getCategory()->value;
            $multiplayerChallengeName = $multiplayerChallenge->getName();

            $checkedChallenge = $userCompletedChallenges->exists(function ($key, Challenge $challenge) use ($multiplayerChallenge) {
                return $multiplayerChallenge->getId() === $challenge->getId();
            });

            $multiplayerChallengesByCategory[$multiplayerChallengeCategory][$multiplayerChallengeName]['entity'] = $multiplayerChallenge;
            $multiplayerChallengesByCategory[$multiplayerChallengeCategory][$multiplayerChallengeName]['checked'] = $checkedChallenge;
        }

        foreach (MultiplayerCategory::categoryOrder() as $category) {
            if (isset($multiplayerChallengesByCategory[$category])) {
                $multiplayerChallenges[$category] = $multiplayerChallengesByCategory[$category];
            }
        }

        return $multiplayerChallenges;
    }
}
