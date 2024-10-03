<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function save(Message $message): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($message);
        $entityManager->flush();
    }

    public function remove(Message $message): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($message);
        $entityManager->flush();
    }

    public function findExpiredMessages(): array
    {
        $currentDateTime = new \DateTime();

        return $this->createQueryBuilder('m')
            ->where('m.expiryAt IS NOT NULL')
            ->andWhere('m.expiryAt < :now')
            ->setParameter('now', $currentDateTime)
            ->getQuery()
            ->getResult();
    }
}
