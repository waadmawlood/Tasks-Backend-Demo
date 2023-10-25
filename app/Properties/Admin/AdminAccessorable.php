<?php

namespace App\Properties\Admin;

trait AdminAccessorable
{

    /**
     * Set attribute to body request
     * @var array $appends_override
     **/
    protected $appends_override = [];


    /** +-----------+------------+------------+------------+ **/
    /**     Accessor     Function      Get      Value        **/
    /** +-----------+------------+------------+------------+ **/


    // public function getFirstNameAttribute()
    // {
    //     return ucfirst($this->attributes['first_name']);
    // }

    // public function getLastNameAttribute()
    // {
    //     return ucfirst($this->attributes['last_name']);
    // }

    // get full name in appends
    // public function getFullNameAttribute()
    // {
    //     return ucfirst($this->attributes['first_name']) . ' ' . ucfirst($this->attributes['last_name']);
    // }

}
