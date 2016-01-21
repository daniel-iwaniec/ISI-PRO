<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use AppBundle\Entity\Actor;

/**
 * User entity for edu management.
 */
class User extends BaseUser
{
    /** @var integer */
    protected $id;

    /** @var Actor */
    private $actor;

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
     * Set actor
     *
     * @param Actor $actor
     * @return User
     */
    public function setActor(Actor $actor = null)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return Actor
     */
    public function getActor()
    {
        return $this->actor;
    }
}
