<?php

namespace App\Service;

use App\Entity\Group;
use App\Entity\UserGroup;
use Doctrine\ORM\EntityManagerInterface;

class GroupService
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function getGroupsOfUser($user): ?array{
        $groupRepository = $this->em->getRepository(Group::class);
        $userGroupRepository = $this->em->getRepository(UserGroup::class);

        $userGroups = $userGroupRepository->findBy(
            ['user' => $user]
        );

        $groupIds = array_map(function($userGroup) {
            return $userGroup->getGroup()->getId();
        }, $userGroups);

        if (!empty($groupIds)) {
            $groups = $groupRepository->createQueryBuilder('g')
                ->where('g.id IN (:ids)')
                ->setParameter('ids', $groupIds)
                ->orderBy('g.created_at', 'DESC')
                ->getQuery()
                ->getResult();

            return $groups;
        }

        return null;
    }

    public function isUserInGroup($user, $group){
        $userGroupRepository = $this->em->getRepository(UserGroup::class);

        $userGroups = $userGroupRepository->findBy(
            [
                'user' => $user,
                'group' => $group
            ]
        );

        if (!empty($userGroups)) {
            return true;
        }
        else{
            return false;
        }
    }
}
