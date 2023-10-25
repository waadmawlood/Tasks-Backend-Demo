<?php

namespace App\Properties\Workspace;

use Nicolaslopezj\Searchable\SearchableTrait;

trait WorkspacePropertable
{
    use SearchableTrait;


    public $hidden_override = ['deleted_at'];


    public $casts_override = [
        'is_active' => 'boolean',
        'is_custom_status' => 'boolean',
    ];


    public $fillable_override = [
        'name',
        'description',
        'image',
        'is_active',
        'is_custom_status',
        'storage',
        'user_id',
    ];

    /** attributes allowed sort from db by request parameter */
    public $sortable = [
        'id',
        'name',
        'description',
        'image',
        'is_active',
        'is_custom_status',
        'storage',
        'user_id',
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
        'description',
        'image',
        'is_active',
        'is_custom_status',
        'storage',
        'user_id',
        'owner.name',
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
            'work_sapaces.name' => 10,
            'work_sapaces.description' => 10,
            'users.name' => 5,
        ],
        'joins' => [
            'users' => ['work_sapaces.user_id', 'users.id'],
        ],
    ];
}
