<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Teacher;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository responsible for retrieval data about teachers.
 */
class TeacherRepository extends EntityRepository
{
    /**
     * Builds query used to retrieve all teachers.
     *
     * @return QueryBuilder
     */
    public function getAllQuery()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Teacher')->from('AppBundle\Entity\Teacher', 'Teacher');

        $query->orderBy('Teacher.id', 'DESC');

        return $query;
    }

    /**
     * Retrieves all teachers.
     *
     * @return Teacher[]
     */
    public function getAll()
    {
        $query = $this->getAllQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve teacher by id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Teacher')->from('AppBundle\Entity\Teacher', 'Teacher');

        $query->andWhere('Teacher.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query;
    }

    /**
     * Retrieves teacher by id.
     *
     * @param integer $id
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return Teacher | null
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
