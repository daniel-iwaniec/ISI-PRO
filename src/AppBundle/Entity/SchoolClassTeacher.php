<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\SchoolClass;
use AppBundle\Entity\Subject;
use AppBundle\Entity\Teacher;

/**
 * Relation between teacher and school's class.
 */
class SchoolClassTeacher
{
    /** @var integer */
    private $id;

    /** @var SchoolClass */
    private $class;

    /** @var Teacher */
    private $teacher;

    /** @var Subject */
    private $subject;

    /**
     * Return string representation of an entity.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->teacher . ', ' . $this->subject;
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
     * Set class
     *
     * @param SchoolClass $class
     * @return SchoolClassTeacher
     */
    public function setClass(SchoolClass $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return SchoolClass
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set teacher
     *
     * @param Teacher $teacher
     * @return SchoolClassTeacher
     */
    public function setTeacher(Teacher $teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set subject
     *
     * @param Subject $subject
     * @return SchoolClassTeacher
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
