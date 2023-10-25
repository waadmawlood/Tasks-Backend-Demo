<?php

namespace App\Properties\Task;

use App\Enums\TaskPriority;
use Nicolaslopezj\Searchable\SearchableTrait;

trait TaskPropertable
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
    // protected $table_override = 'tasks';

    /**
     * Primary key column
     * @var string $primary_override
     **/
    // public $primary_override = 'id';

    /**
     * Status timestamps
     * @var bool $timestamps_override
     **/
    // public $timestamps_override = false;

    /**
     * Auto incrementing primary key
     * @var bool $incrementing_override
     **/
    // public $incrementing_override = false;

    /**
     * Type data of primary key
     * @var string $keyType_override
     **/
    // public $keyType_override = "int";


    public $hidden_override = ['deleted_at'];


    public $casts_override = [

    ];


    // protected $guarded_override = [];
    public $fillable_override = [
        'title',
        'description',
        'project_id',
        'user_id',
        'status_id',
        'task_id',
        'priority',
        'expiration',
    ];

    /** attributes allowed sort from db by request parameter */
    public $sortable = [
        'id',
        'title',
        'description',
        'project_id',
        'user_id',
        'status_id',
        'task_id',
        'priority',
        'expiration',
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
        'title',
        'description',
        'project_id',
        'user_id',
        'status_id',
        'task_id',
        'priority',
        'expiration',
        'created_at',
        'updated_at',
        'user.name',
        'users.name',
        'project.name',
        'project.workspace.name',
        'status.name',
        'status.is_test',
        'status.is_done',
        'subtasks.name',
        'subtasks.description',
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
            'tasks.name' => 10,
            'tasks.phone' => 10,
            'tasks.email' => 5,
        ],
        'joins' => [
            'posts' => ['tasks.id', 'posts.user_id'],
        ],
    ];
}
