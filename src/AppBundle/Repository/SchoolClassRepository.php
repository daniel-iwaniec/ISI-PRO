<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\SchoolClass;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository responsible for retrieval data about school's classes.
 */
class SchoolClassRepository extends EntityRepository
{
    /**
     * Builds query used to retrieve all school's classes.
     *
     * @return QueryBuilder
     */
    public function getAllQuery()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('SchoolClass')->from('AppBundle\Entity\SchoolClass', 'SchoolClass');

        $query->addOrderBy('SchoolClass.number', 'ASC')->addOrderBy('SchoolClass.letter', 'ASC');

        return $query;
    }

    /**
     * Retrieves all school's classes.
     *
     * @return SchoolClass[]
     */
    public function getAll()
    {
        $query = $this->getAllQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve school's class by id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('SchoolClass')->from('AppBundle\Entity\SchoolClass', 'SchoolClass');

        $query->andWhere('SchoolClass.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query;
    }

    /**
     * Retrieves school's class by id.
     *
     * @param integer $id
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return SchoolClass | null
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
     * Counts all students in a specified class.
     *
     * @param integer $classId
     * @return integer
     */
    public function countStudentsForClass($classId)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('count(Student.id)')->from('AppBundle\Entity\Student', 'Student');

        $query->leftJoin('Student.class', 'class');
        $query->andWhere('class.id = :class_id')->setParameter('class_id', $classId);

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * Counts all students by school's class.
     *
     * @return integer
     */
    public function countStudentsByClass()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('count(Student.id)', 'class.id')->from('AppBundle\Entity\Student', 'Student');

        $query->leftJoin('Student.class', 'class');
        $query->groupBy('class.id');

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve all school's classes for teacher.
     *
     * @param integer $teacherId
     * @return QueryBuilder
     */
    public function getAllForTeacherQuery($teacherId)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('SchoolClass')->from('AppBundle\Entity\SchoolClass', 'SchoolClass');

        $query->leftJoin('SchoolClass.school_class_teacher', 'SchoolClassTeacher');
        $query->leftJoin('SchoolClassTeacher.teacher', 'Teacher');
        $query->andWhere('Teacher.id = :teacher_id')->setParameter('teacher_id', $teacherId);

        $query->addOrderBy('SchoolClass.number', 'ASC')->addOrderBy('SchoolClass.letter', 'ASC');

        return $query;
    }
}
