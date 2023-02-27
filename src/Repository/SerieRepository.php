<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    const SERIE_LIMIT = 50;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function save(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//Attention ancienne fonction en dessous
    public function findBestSeries(int $page){


        //page 1 -> 0 - 49
        //page 2 -> 50 - 99

        //offset = depart
        $offset = ($page - 1) * self::SERIE_LIMIT;

        $qb = $this->createQueryBuilder('s');
        $qb

            ->addOrderBy('s.popularity','DESC')
            //a partir de combien
            ->setFirstResult($offset)
            //combien j'en récupère
            ->setMaxResults(self::SERIE_LIMIT);

        //renvoie instance de query
        $query = $qb->getQuery();

        return $query->getResult();
    }

}
/*  public function findBestSeries(){
        //En Dql
        //Récupérer serie vote superieur a 8 et un popularité sup a 100
        //Ordonnee par popularite
     $dql ="SELECT s FROM App\Entity\Serie AS s
            WHERE s.vote > 8
            AND s.popularity > 100
            ORDER BY s.popularity DESC";

        //recupere manager pour utiliser la methode createQuery
        //transorme le string en objet de requete
        $query = $this->getEntityManager()->createQuery($dql);

        //maintenant acces aux méthodes de query
        //limite le nombre de resultat obtenu par lla requete a 50
        $query->setMaxResults(50);

        //retourne le resultat
        return $query->getResult();

//En queryBuilder
$qb = $this->createQueryBuilder('s');
$qb
    ->addOrderBy('s.popularity','DESC')
    //->andWhere('s.vote > 8')
    //->andWhere('s.popularity > 100')
    ->setMaxResults(50);

//renvoie instance de query
$query = $qb->getQuery();

return $query->getResult();
}*/