<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Grade;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository responsible for retrieval data about grades.
 */
class GradeRepository extends EntityRepository
{
    /**
     * Builds query used to retrieve all grades.
     *
     * @return QueryBuilder
     */
    public function getAllQuery()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Grade')->from('AppBundle\Entity\Grade', 'Grade');

        $query->orderBy('Grade.id', 'DESC');

        return $query;
    }

    /**
     * Retrieves all grades.
     *
     * @return Grade[]
     */
    public function getAll()
    {
        $query = $this->getAllQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve all grades for certain student.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getAllForStudentQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Grade')->from('AppBundle\Entity\Grade', 'Grade');

        $query->leftJoin('Grade.student', 'student');
        $query->andWhere('student.id = :id')->setParameter('id', $id);

        $query->orderBy('Grade.id', 'DESC');

        return $query;
    }

    /**
     * Retrieves all grades for certain student.
     *
     * @param integer $id
     * @return Grade[]
     */
    public function getAllForStudent($id)
    {
        $query = $this->getAllForStudentQuery($id);

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve grade by id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Grade')->from('AppBundle\Entity\Grade', 'Grade');

        $query->andWhere('Grade.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query;
    }

    /**
     * Retrieves grade by id.
     *
     * @param integer $id
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return Grade | null
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

    /**
     * Counts grades by grade.
     *
     * @param integer $grade
     * @return int
     */
    public function countGradesByGrade($grade)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('count(Grade.id)')->from('AppBundle\Entity\Grade', 'Grade');

        $query->andWhere('Grade.grade = :grade')->setParameter('grade', $grade);

        return $query->getQuery()->getSingleScalarResult();
    }
}
