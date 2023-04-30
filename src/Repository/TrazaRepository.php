<?php

namespace App\Repository;

use App\Entity\Traza;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Traza>
 *
 * @method Traza|null find($id, $lockMode = null, $lockVersion = null)
 * @method Traza|null findOneBy(array $criteria, array $orderBy = null)
 * @method Traza[]    findAll()
 * @method Traza[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrazaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Traza::class);
    }

    public function save(Traza $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Traza $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Traza[] Returns an array of Traza objects
    //     */
    public function obtenerYears(): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                'year(t.fecha) as anho',
                'count(t.id) as cant',
                'SUM(t.timeproxy) as milis',
                'SUM(t.lenghtContent) as bytes'
            )
            ->groupBy('anho')
            ->getQuery()
            ->getResult();
    }

    public function obtenerCodigoYears($codigo): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                'year(t.fecha) as anho',
                'count(t.id) as cant',
                'SUM(t.lenghtContent) as bytes',
                'SUM(t.timeproxy) as milis',
            )
            ->where('t.resultCacheCode LIKE :codigo')
            ->groupBy('anho')
            ->setParameter('codigo', '%' . $codigo . '%')
            ->getQuery()
            ->getResult();
    }

    public function obtenerCodigoYear($anho, $codigo): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                'count(t.id) as cant'
            )
            ->where('t.resultCacheCode LIKE :codigo')
            ->andWhere('year(t.fecha) = :anho')
            ->setParameter('codigo', '%' . $codigo . '%')
            ->setParameter('anho', $anho)
            ->getQuery()
            ->getResult();
    }

    public function obtenerMesesYears($anho): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                'month(t.fecha) as mes',
                'monthname(t.fecha) as mesname',
                'count(t.id) as cant',
                'SUM(t.timeproxy) as milis',
                'SUM(t.lenghtContent) as bytes'
            )
            ->where('year(t.fecha) = :anho')
            ->groupBy('mes')
            ->setParameter('anho', $anho)
            ->getQuery()
            ->getResult();
    }

    public function obtenerCodigoMesesYears($anho, $codigo): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                'month(t.fecha) as mes',
                'monthname(t.fecha) as mesname',
                'count(t.id) as cant',
                'SUM(t.lenghtContent) as bytes',
                'SUM(t.timeproxy) as milis',
            )
            ->where('t.resultCacheCode LIKE :codigo')
            ->andwhere('year(t.fecha) = :anho')
            ->groupBy('mes')
            ->setParameter('codigo', '%' . $codigo . '%')
            ->setParameter('anho', $anho)
            ->getQuery()
            ->getResult();
    }


    public function obtenerCodigoTrazaMesYears($anho, $mes, $codigo): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                't.username as usuario',
                'count(t.id) as cant',
                'SUM(t.timeproxy) as milis',
                'SUM(t.lenghtContent) as bytes'
            )
            ->where('year(t.fecha) = :anho')
            ->andWhere('month(t.fecha) = :mes')
            ->andWhere('t.resultCacheCode LIKE :codigo')
            ->groupBy('usuario')
            ->orderBy('cant', 'DESC')
            ->setParameter('anho', $anho)
            ->setParameter('mes', $mes)
            ->setParameter('codigo', '%' . $codigo . '%')
            ->getQuery()
            ->getResult();
    }

    public function obtenerTrazaMesYearsIP($anho, $mes): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                't.ip as ip',
                'count(t.id) as cant',
                'SUM(t.timeproxy) as milis',
                'SUM(t.lenghtContent) as bytes'
            )
            ->where('year(t.fecha) = :anho')
            ->andWhere('month(t.fecha) = :mes')
            ->groupBy('ip')
            ->orderBy('cant', 'DESC')
            ->setParameter('anho', $anho)
            ->setParameter('mes', $mes)
            ->getQuery()
            ->getResult();
    }

    public function obtenerTrazaMesYearsURI($anho, $mes): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                't.url as uri',
                'count(t.id) as cant',
                'SUM(t.timeproxy) as milis',
                'SUM(t.lenghtContent) as bytes'
            )
            ->where('year(t.fecha) = :anho')
            ->andWhere('month(t.fecha) = :mes')
            ->groupBy('uri')
            ->orderBy('cant', 'DESC')
            ->setParameter('anho', $anho)
            ->setParameter('mes', $mes)
            ->getQuery()
            ->getResult();
    }

    public function obtenerTrazaMesYears($anho, $mes): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                't.username as usuario',
                'count(t.id) as cant',
                'SUM(t.timeproxy) as milis',
                'SUM(t.lenghtContent) as bytes'
            )
            ->where('year(t.fecha) = :anho')
            ->andWhere('month(t.fecha) = :mes')
            ->groupBy('usuario')
            ->orderBy('bytes', 'DESC')
            ->setParameter('anho', $anho)
            ->setParameter('mes', $mes)
            ->getQuery()
            ->getResult();
    }

    public function obtenerTrazaMesYearsDias($anho, $mes): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                'day(t.fecha) as dia',
                'count(t.id) as cant',
                'SUM(t.timeproxy) as milis',
                'SUM(t.lenghtContent) as bytes'
            )
            ->where('year(t.fecha) = :anho')
            ->andWhere('month(t.fecha) = :mes')
            ->groupBy('dia')
            ->orderBy('dia', 'ASC')
            ->setParameter('anho', $anho)
            ->setParameter('mes', $mes)
            ->getQuery()
            ->getResult();
    }

    public function obtenerTrazaMesUser($anho, $mes, $user): array
    {
        return $this->createQueryBuilder('t')

            ->where('year(t.fecha) = :anho')
            ->andWhere('month(t.fecha) = :mes')
            ->andWhere('t.username = :user')
            ->setParameter('anho', $anho)
            ->setParameter('mes', $mes)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function obtenerTrazaMesUserAgrupadasURL($anho, $mes, $user): array
    {
        return $this->createQueryBuilder('t')
            ->select(
                't.username as usuario',
                'count(t.id) as cant',
                'SUM(t.timeproxy) as milis',
                'SUM(t.lenghtContent) as bytes',
                't.url as url'
            )
            ->where('year(t.fecha) = :anho')
            ->andWhere('month(t.fecha) = :mes')
            ->andWhere('t.username = :user')
            ->groupBy('url')
            ->setParameter('anho', $anho)
            ->setParameter('mes', $mes)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    public function obtenerTrazaMesUserXURL($anho, $mes, $user,$url): array
    {
        return $this->createQueryBuilder('t')
            
            ->where('year(t.fecha) = :anho')
            ->andWhere('month(t.fecha) = :mes')
            ->andWhere('t.username = :user')
            ->andWhere('t.url = :url')
            ->setParameter('anho', $anho)
            ->setParameter('mes', $mes)
            ->setParameter('user', $user)
            ->setParameter('url', $url)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Traza[] Returns an array of Traza objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Traza
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
