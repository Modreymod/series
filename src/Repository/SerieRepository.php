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


    public function findBestSeries(){
        //En Dql
        //Récupérer serie vote superieur a 8 et un popularité sup a 100
        //Ordonnee par popularite
    /* $dql ="SELECT s FROM App\Entity\Serie AS s
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
        return $query->getResult();*/

        //En queryBuilder
        $qb = $this->createQueryBuilder('s');
        //Peut importe l'ordre des requetes il s'en arrange
        $qb
            ->addOrderBy('s.popularity','DESC')
            ->andWhere('s.vote > 8')
            ->andWhere('s.popularity > 100')
            ->setMaxResults(50);

        //renvoie instance de query
        $query = $qb->getQuery();

        return $query->getResult();


    }

}
