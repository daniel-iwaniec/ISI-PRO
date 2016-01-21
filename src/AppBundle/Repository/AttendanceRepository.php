<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Attendance;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;


/**
 * Repository responsible for retrieval data about attendance.
 */
class AttendanceRepository extends EntityRepository
{
    /**
     * Builds query used to retrieve all attendances.
     *
     * @return QueryBuilder
     */
    public function getAllQuery()
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Attendance')->from('AppBundle\Entity\Attendance', 'Attendance');

        $query->orderBy('Attendance.id', 'DESC');

        return $query;
    }

    /**
     * Retrieves all attendances.
     *
     * @return Attendance[]
     */
    public function getAll()
    {
        $query = $this->getAllQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * Builds query used to retrieve attendance by id.
     *
     * @param integer $id
     * @return QueryBuilder
     */
    public function getByIdQuery($id)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('Attendance')->from('AppBundle\Entity\Attendance', 'Attendance');

        $query->andWhere('Attendance.id = :id')->setParameter('id', $id);
        $query->setMaxResults(1);

        return $query;
    }

    /**
     * Retrieves attendance by id.
     *
     * @param integer $id
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @return Attendance | null
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
     * Counts attendance by student's presence.
     *
     * @param boolean $present
     * @return int
     */
    public function countAttendanceByPresence($present)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $query = $queryBuilder->select('count(Attendance.id)')->from('AppBundle\Entity\Attendance', 'Attendance');

        $query->andWhere('Attendance.present = :present')->setParameter('present', $present);

        return $query->getQuery()->getSingleScalarResult();
    }
}
