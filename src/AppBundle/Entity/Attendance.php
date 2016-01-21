<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Student;
use Doctrine\ORM\Mapping as ORM;

/**
 * Attendance
 */
class Attendance
{
    /** @var integer */
    private $id;

    /** @var \DateTime */
    private $check_date;

    /** @var boolean */
    private $present;

    /** @var Student */
    private $student;

    /**
     * Return string representation of an entity.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->check_date->format('Y-m-d') . ' ' . $this->student . ' ' . $this->present ? 'obecny' : 'nieobecny';
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set check_date
     *
     * @param \DateTime $checkDate
     * @return Attendance
     */
    public function setCheckDate($checkDate)
    {
        $this->check_date = $checkDate;

        return $this;
    }

    /**
     * Get check_date
     *
     * @return \DateTime
     */
    public function getCheckDate()
    {
        return $this->check_date;
    }

    /**
     * Set present
     *
     * @param boolean $present
     * @return Attendance
     */
    public function setPresent($present)
    {
        $this->present = $present;

        return $this;
    }

    /**
     * Get present
     *
     * @return boolean
     */
    public function getPresent()
    {
        return $this->present;
    }

    /**
     * Set student
     *
     * @param Student $student
     * @return Attendance
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }
}
