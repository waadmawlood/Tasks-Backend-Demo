<?php

namespace App\Properties\Project;

use Nicolaslopezj\Searchable\SearchableTrait;

trait ProjectPropertable
{
    use SearchableTrait;


    /**
     * Connection database
     * @var string $connection_override
     **/
    // public $connection_override = 'mysql';

    /**
     * Customize name of table
     * @var string $table_override
     **/
    // protected $table_override = 'projects';

    /**
     * Primary key column
     * @var string $primary_override
     **/
    public $primary_override = 'id';

    /**
     * Status timestamps
     * @var bool $timestamps_override
     **/
    // public $timestamps_override = false;

    /**
     * Auto incrementing primary key
     * @var bool $incrementing_override
     **/
    public $incrementing_override = false;

    /**
     * Type data of primary key
     * @var string $keyType_override
     **/
    public $keyType_override = "string";


    public $hidden_override = ['deleted_at'];


    public $casts_override = [
        'is_active' => 'boolean',
        'is_archive' => 'boolean',
    ];


    // protected $guarded_override = [];
    public $fillable_override = [
        'name',
        'description',
        'image',
        'is_active',
        'is_archive',
        'user_id',
        'workspace_id',
    ];

    /** attributes allowed sort from db by request parameter */
    public $sortable = [
        'id',
        'name',
        'description',
        'image',
        'is_active',
        'is_archive',
        'user_id',
        'workspace_id',
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
        'is_archive',
        'user_id',
        'workspace_id',
        'created_at',
        'updated_at',
        'owner.name',
        'users.name',
        'workspace.name',
        'workspace.owner.name',
        'workspace.users.name',
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
            'projects.name' => 10,
            'projects.description' => 10,
            'projects.email' => 5,
            'users.name' => 10,
            'users.project_users' => 10,
            'workspaces.name' => 10,
        ],
        'joins' => [
            'users' => ['projects.user_id', 'users.id'],
            'project_user' => ['projects.id', 'project_user.project_id'],
            'project_users' => ['project_user.user_id', 'users.id'],
            'workspaces' => ['projects.workspace_id', 'workspaces.id'],
        ],
    ];
}
