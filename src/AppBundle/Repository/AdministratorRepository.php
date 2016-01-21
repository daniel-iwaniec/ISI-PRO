<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Administrator;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository responsible for retrieval data about administrators.
 */
class AdministratorRepository extends EntityRepository
{
    /**
     * Builds query used to retrieve all administrators.
     *
     * @return QueryBuilder
     */
    public function getAllQuery()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Administrator')->from('AppBundle\Entity\Administrator', 'Administrator');

        $query->orderBy('Administrator.id', 'DESC');

        return $query;
    }

    /**
     * Retrieves all administrators.
     *
     * @return Administrator[]
     */
    public function getAll()
    {
        $query = $this->getAllQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve administrator by id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Administrator')->from('AppBundle\Entity\Administrator', 'Administrator');

        $query->andWhere('Administrator.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query;
    }

    /**
     * Retrieves administrator by id.
     *
     * @param integer $id
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return Administrator | null
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
