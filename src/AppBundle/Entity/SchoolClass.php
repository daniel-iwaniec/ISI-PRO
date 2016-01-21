<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Student;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * School's class entity.
 */
class SchoolClass
{
    /** @var integer */
    private $number;

    /** @var string */
    private $letter;

    /** @var integer */
    private $id;

    /** @var \Doctrine\Common\Collections\Collection */
    private $students;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    /**
     * Return string representation of an entity.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->number . $this->letter;
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
     * Set number
     *
     * @param integer $number
     * @return SchoolClass
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set letter
     *
     * @param string $letter
     * @return SchoolClass
     */
    public function setLetter($letter)
    {
        $this->letter = $letter;

        return $this;
    }

    /**
     * Get letter
     *
     * @return string
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * Add students
     *
     * @param Student $students
     * @return SchoolClass
     */
    public function addStudent(Student $students)
    {
        $this->students[] = $students;

        return $this;
    }

    /**
     * Remove students
     *
     * @param Student $students
     */
    public function removeStudent(Student $students)
    {
        $this->students->removeElement($students);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $school_class_teacher;


    /**
     * Add school_class_teacher
     *
     * @param \AppBundle\Entity\SchoolClassTeacher $schoolClassTeacher
     * @return SchoolClass
     */
    public function addSchoolClassTeacher(\AppBundle\Entity\SchoolClassTeacher $schoolClassTeacher)
    {
        $this->school_class_teacher[] = $schoolClassTeacher;

        return $this;
    }

    /**
     * Remove school_class_teacher
     *
     * @param \AppBundle\Entity\SchoolClassTeacher $schoolClassTeacher
     */
    public function removeSchoolClassTeacher(\AppBundle\Entity\SchoolClassTeacher $schoolClassTeacher)
    {
        $this->school_class_teacher->removeElement($schoolClassTeacher);
    }

    /**
     * Get school_class_teacher
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchoolClassTeacher()
    {
        return $this->school_class_teacher;
    }
}
