<?php

namespace App\Properties\Admin;

use App\Models\User;
use Waad\Repository\Traits\ConstructorableModel;

trait AdminRelatable
{

    /** constructor : do not remove that */
    use ConstructorableModel;

    // attributes allowed include join from db by request parameter
    // ex : `example.com/api/posts?include=users,comments,likes.user`
    public $includeable = [
        'users',
    ];


    /** always return relationship with any request of this model */
    public $with_override = [];


    /** always return count records of relationship with any request of this model */
    public $withCount_override = [];


    /** +-----------+------------+------------+------------+ **/
    /**      Related     Function     with      model        **/
    /** +-----------+------------+------------+------------+ **/


    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

}
