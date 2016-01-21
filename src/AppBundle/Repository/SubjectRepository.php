<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Subject;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository responsible for retrieval data about subjects.
 */
class SubjectRepository extends EntityRepository
{
    /**
     * Builds query used to retrieve all subjects.
     *
     * @return QueryBuilder
     */
    public function getAllQuery()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Subject')->from('AppBundle\Entity\Subject', 'Subject');

        $query->orderBy('Subject.id', 'DESC');

        return $query;
    }

    /**
     * Retrieves all subjects.
     *
     * @return Subject[]
     */
    public function getAll()
    {
        $query = $this->getAllQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve subject by id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Subject')->from('AppBundle\Entity\Subject', 'Subject');

        $query->andWhere('Subject.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query;
    }

    /**
     * Retrieves subject by id.
     *
     * @param integer $id
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return Subject | null
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
     * Builds query used to retrieve subject for certain teacher and class.
     *
     * @param $classId
     * @param $teacherId
     * @return QueryBuilder
     */
    public function getForTeacherAndClassQuery($classId, $teacherId)
    {
        $mainQuery = $this->_em->createQueryBuilder();
        $subQuery = $this->_em->createQueryBuilder();

        $mainQuery->select('Subject')->from('AppBundle\Entity\Subject', 'Subject');
        $mainQuery->orderBy('Subject.name', 'ASC');

        $subjectIds = $subQuery->select('SchoolClassTeacher')->from('AppBundle\Entity\SchoolClassTeacher', 'SchoolClassTeacher')
            ->leftJoin('SchoolClassTeacher.class', 'class')
            ->leftJoin('SchoolClassTeacher.teacher', 'teacher')
            ->andWhere('class.id = :class_id')->setParameter('class_id', $classId)
            ->andWhere('teacher.id = :teacher_id')->setParameter('teacher_id', $teacherId)
            ->getQuery()->getResult();

        $subjectIdsInteger = [0];
        foreach ($subjectIds as $subjectId) {
            $subjectIdsInteger[] = $subjectId->getSubject()->getId();
        }

        $mainQuery->where($mainQuery->expr()->in('Subject.id', $subjectIdsInteger));

        return $mainQuery;
    }

    /**
     * Retrieves subject for certain teacher and class.
     *
     * @param $classId
     * @param $teacherId
     * @return Subject[]
     */
    public function getForTeacherAndClass($classId, $teacherId)
    {
        $query = $this->getForTeacherAndClassQuery($classId, $teacherId);

        try {
            return $query->getQuery()->getResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
