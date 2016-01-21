<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Student;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository responsible for retrieval data about students.
 */
class StudentRepository extends EntityRepository
{
    /**
     * Builds query used to retrieve all students.
     *
     * @return QueryBuilder
     */
    public function getAllQuery()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Student')->from('AppBundle\Entity\Student', 'Student');

        $query->orderBy('Student.id', 'DESC');

        return $query;
    }

    /**
     * Retrieves all students.
     *
     * @return Student[]
     */
    public function getAll()
    {
        $query = $this->getAllQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve student by id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Student')->from('AppBundle\Entity\Student', 'Student');

        $query->andWhere('Student.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query;
    }

    /**
     * Retrieves student by id.
     *
     * @param integer $id
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return Student | null
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
     * Builds query used to retrieve all students for teacher.
     *
     * @param integer $teacherId
     * @return QueryBuilder
     */
    public function getAllForTeacherQuery($teacherId)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Student')->from('AppBundle\Entity\Student', 'Student');

        $query->leftJoin('Student.class', 'SchoolClass');
        $query->leftJoin('SchoolClass.school_class_teacher', 'SchoolClassTeacher');
        $query->leftJoin('SchoolClassTeacher.teacher', 'Teacher');
        $query->andWhere('Teacher.id = :teacher_id')->setParameter('teacher_id', $teacherId);

        $query->orderBy('Student.id', 'DESC');

        return $query;
    }
}
