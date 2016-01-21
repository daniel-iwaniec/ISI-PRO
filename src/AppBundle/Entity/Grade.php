<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Student;
use AppBundle\Entity\Subject;
use AppBundle\Entity\Teacher;
use Doctrine\ORM\Mapping as ORM;

/**
 * Grade entity.
 */
class Grade
{
    /** @var integer */
    private $id;

    /** @var integer */
    private $grade;

    /** @var Teacher */
    private $teacher;

    /** @var Subject */
    private $subject;

    /** @var Student */
    private $student;

    /**
     * Return string representation of an entity.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->grade;
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
     * Set grade
     *
     * @param integer $grade
     * @return Grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return integer
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set teacher
     *
     * @param Teacher $teacher
     * @return Grade
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
     * @return Grade
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

    /**
     * Set student
     *
     * @param Student $student
     * @return Grade
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
