<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Feedback;
use App\Entity\Summary;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Exception;
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

    /**
     * @return array
     */
    public function getAcceptedAndDeclinedSummariesCountByDates(): array
    {
        return $this->createQueryBuilder('f')
            ->select("DATE(f.sendAt) as sendAt")
            ->addSelect("(SUM(CASE WHEN f.decision like 'accepted' THEN 1 ELSE 0 END)) AS accepted")
            ->addSelect("(SUM(CASE WHEN f.decision like 'declined' THEN 1 ELSE 0 END)) AS declined")
            ->groupBy("sendAt")
            ->orderBy('sendAt', 'DESC')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Summary $summary
     * @return array
     */
    public function getAcceptedAndDeclinedSummariesCountByDatesBySummary(Summary $summary): array
    {
        return $this->createQueryBuilder('f')
            ->select("DATE(f.sendAt) as sendAt")
            ->addSelect("(SUM(CASE WHEN f.decision like 'accepted' THEN 1 ELSE 0 END)) AS accepted")
            ->addSelect("(SUM(CASE WHEN f.decision like 'declined' THEN 1 ELSE 0 END)) AS declined")
            ->andWhere('f.summary = :summary')
            ->setParameter('summary', $summary)
            ->groupBy("sendAt")
            ->orderBy('sendAt', 'DESC')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult();
    }
}
