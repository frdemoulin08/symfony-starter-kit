<?php

namespace App\Repository;

use App\Entity\AuthenticationLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuthenticationLog>
 */
class AuthenticationLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthenticationLog::class);
    }

    public function purgeOlderThan(\DateTimeImmutable $cutoff): int
    {
        return $this->createQueryBuilder('log')
            ->delete()
            ->where('log.occurredAt < :cutoff')
            ->setParameter('cutoff', $cutoff)
            ->getQuery()
            ->execute();
    }
}
