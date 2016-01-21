<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Actor;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;


/**
 * Repository responsible for retrieval data about actors.
 */
class ActorRepository extends EntityRepository
{
    /**
     * Builds query used to retrieve all actors.
     *
     * @return QueryBuilder
     */
    public function getAllQuery()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Actor')->from('AppBundle\Entity\Actor', 'Actor');

        $query->orderBy('Actor.id', 'DESC');

        return $query;
    }

    /**
     * Retrieves all administrators.
     *
     * @return Actor[]
     */
    public function getAll()
    {
        $query = $this->getAllQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve actor by id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Actor')->from('AppBundle\Entity\Actor', 'Actor');

        $query->andWhere('Actor.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query;
    }

    /**
     * Retrieves actor by id.
     *
     * @param integer $id
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return Actor | null
     */
    public function getById($id)
    {
        $query = $this->getByIdQuery($id);

        try {
            return $query->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
