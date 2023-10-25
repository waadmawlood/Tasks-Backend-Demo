<?php

namespace App\Properties\User;

trait UserAccessorable
{

    /**
     * Set attribute to body request
     * @var array $appends_override
     **/
    protected $appends_override = ['avatar'];


    /** +-----------+------------+------------+------------+ **/
    /**     Accessor     Function      Get      Value        **/
    /** +-----------+------------+------------+------------+ **/


    public function getAvatarAttribute()
    {
        return $this->media?->getAttribute('url');
    }
}
