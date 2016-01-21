<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Actor;
use AppBundle\Entity\Grade;
use AppBundle\Entity\SchoolClass;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Student entity.
 */
class Student extends Actor
{
    /** @var SchoolClass */
    private $class;

    /** @var ArrayCollection */
    private $grades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grades = new ArrayCollection();
    }

    /**
     * Set class
     *
     * @param SchoolClass $class
     * @return Student
     */
    public function setClass(SchoolClass $class = null)
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
     * Add grades
     *
     * @param Grade $grades
     * @return Student
     */
    public function addGrade(Grade $grades)
    {
        $this->grades[] = $grades;

        return $this;
    }

    /**
     * Remove grades
     *
     * @param Grade $grades
     */
    public function removeGrade(Grade $grades)
    {
        $this->grades->removeElement($grades);
    }

    /**
     * Get grades
     *
     * @return ArrayCollection
     */
    public function getGrades()
    {
        return $this->grades;
    }
}
