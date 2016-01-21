<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * User bundle containing user related code.
 */
class UserBundle extends Bundle
{
    /**
     * This bundle extends FOSUserBundle.
     *
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
