<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\SchoolClassTeacher;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository responsible for retrieval data about
 * relation between teacher and school's class.
 */
class SchoolClassTeacherRepository extends EntityRepository
{
    /**
     * Builds query used to retrieve relation between teacher and school's class by id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('SchoolClassTeacher')->from('AppBundle\Entity\SchoolClassTeacher', 'SchoolClassTeacher');

        $query->andWhere('SchoolClassTeacher.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query;
    }

    /**
     * Retrieves relation between teacher and school's class by id.
     *
     * @param integer $id
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return SchoolClassTeacher | null
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
     * Builds query used to retrieve relation between teacher and school's class
     * by school's class id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getBySchoolClassIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('SchoolClassTeacher')->from('AppBundle\Entity\SchoolClassTeacher', 'SchoolClassTeacher');

        $query->leftJoin('SchoolClassTeacher.class', 'class');
        $query->andWhere('class.id = :id')->setParameter('id', $id);

        return $query;
    }

    /**
     * Retrieves relation between teacher and school's class
     * by school's class id.
     *
     * @param integer $id
     * @return SchoolClassTeacher | null
     */
    public function getBySchoolClassId($id)
    {
        $query = $this->getBySchoolClassIdQuery($id);

        try {
            return $query->getQuery()->getResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * Builds query used to retrieve relation between teacher and school's class
     * by teacher id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByTeacherIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('SchoolClassTeacher')->from('AppBundle\Entity\SchoolClassTeacher', 'SchoolClassTeacher');

        $query->leftJoin('SchoolClassTeacher.teacher', 'teacher');
        $query->andWhere('teacher.id = :id')->setParameter('id', $id);

        return $query;
    }

    /**
     * Retrieves relation between teacher and school's class
     * by teacher id.
     *
     * @param integer $id
     * @return SchoolClassTeacher | null
     */
    public function getByTeacherId($id)
    {
        $query = $this->getByTeacherIdQuery($id);

        try {
            return $query->getQuery()->getResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * Builds query used to retrieve relation between teacher and school's class
     * by subject id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getBySubjectIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('SchoolClassTeacher')->from('AppBundle\Entity\SchoolClassTeacher', 'SchoolClassTeacher');

        $query->leftJoin('SchoolClassTeacher.subject', 'subject');
        $query->andWhere('subject.id = :id')->setParameter('id', $id);

        return $query;
    }

    /**
     * Retrieves relation between teacher and school's class
     * by subject id.
     *
     * @param integer $id
     * @return SchoolClassTeacher | null
     */
    public function getBySubjectId($id)
    {
        $query = $this->getBySubjectIdQuery($id);

        try {
            return $query->getQuery()->getResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * Builds query used to retrieve relation between teacher and school's class
     * by class id and teacher id.
     *
     * @param $classId
     * @param $teacherId
     * @return QueryBuilder
     */
    public function getByClassIdAndTeacherIdQuery($classId, $teacherId)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('SchoolClassTeacher')->from('AppBundle\Entity\SchoolClassTeacher', 'SchoolClassTeacher');

        $query->leftJoin('SchoolClassTeacher.class', 'class');
        $query->leftJoin('SchoolClassTeacher.teacher', 'teacher');
        $query->andWhere('class.id = :class_id')->setParameter('class_id', $classId);
        $query->andWhere('teacher.id = :teacher_id')->setParameter('teacher_id', $teacherId);

        return $query;
    }

    /**
     * Retrieves relation between teacher and school's class
     * by class id and teacher id.
     *
     * @param $classId
     * @param $teacherId
     * @return SchoolClassTeacher|null
     */
    public function getByClassIdAndTeacherId($classId, $teacherId)
    {
        $query = $this->getByClassIdAndTeacherIdQuery($classId, $teacherId);

        try {
            return $query->getQuery()->getResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
