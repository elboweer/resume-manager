<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Feedback;
use App\Entity\Summary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Feedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    /**
     * @return Feedback[]
     */
    public function getAll(): array
    {
        return $this->createQueryBuilder('f')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Summary $summary
     * @return array
     */
    public function getUnavailableCompanyIdsBySummary(Summary $summary)
    {
        $records = $this->createQueryBuilder('f')
            ->select('company.id')
            ->innerJoin('f.company', 'company')
            ->where('f.summary = :summary')
            ->setParameter('summary', $summary)
            ->addGroupBy('company.id')
            ->getQuery()
            ->getResult();

        return array_map(function ($item) {
            return $item['id'];
        }, $records);
    }
}
