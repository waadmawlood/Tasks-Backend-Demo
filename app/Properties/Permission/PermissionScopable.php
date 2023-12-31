<?php

namespace App\Properties\Permission;

use Waad\Repository\Traits\HasScopeable;

trait PermissionScopable
{
    /** +-----------+------------+------------+------------+ **/
    /**      Scope     Function     Query        Builde      **/
    /** +-----------+------------+------------+------------+ **/


    /**
    * trait including scope except of select
    */
    use HasScopeable;


    // scope to return records created in today
    // eg : User::today()->get();
    // public function scopeToday($query)
    // {
    //     return $query->whereDate('created_at', \Carbon\Carbon::today());
    // }


    // scope to return records Owner User
    // eg : User::owner(5)->get();
    // public function scopeOwner($query, $user_id)
    // {
    //     return $query->where('user_id', $user_id);
    // }

}
