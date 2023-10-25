<?php

namespace App\Properties\User;

use Nicolaslopezj\Searchable\SearchableTrait;

trait UserPropertable
{
    use SearchableTrait;

    public $hidden_override = [
        'deleted_at',
        'password',
        'remember_token',
    ];


    public $casts_override = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_ban' => 'boolean',
    ];

    // protected $guarded_override = [];
    public $fillable_override = [
        'name',
        'email',
        'password',
        'gender',
        'last_active',
        'timezone',
        'is_ban'
    ];

    /** attributes allowed sort from db by request parameter */
    public $sortable = [
        'id',
        'name',
        'email',
        'gender',
        'last_active',
        'timezone',
        'is_ban',
        'created_at',
        'updated_at',
    ];


    /**
     *  attributes allowed filters with related from db by request parameter
     *  ex : `example.com/api/posts?filter[name]=newcars&filter[post.title]=users` `filter` (use Like operator for search)
     *  ex : `example.com/api/posts?find[name]=eq:newcars&find[post.views]=gre:users` `find`
     *      (
     *          use `eq:=`,`gr:>`,`gre:>=`,`lse:<=`, `ls:<`, `neq:!=`, `nl:IS Null`, `nnl:IS NOT Null`,
     *          `in: or[1,2]`, `nin: not or[1,2]`  operator for search
     *      )
     */
    public $filterable = [
        'id',
        'name',
        'email',
        'gender',
        'last_active',
        'timezone',
        'is_ban',
        'created_at',
    ];


    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.name' => 10,
            'users.email' => 10,
            'users.gender' => 5,
        ],
        'joins' => [],
    ];
}
