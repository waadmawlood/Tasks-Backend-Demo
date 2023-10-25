<?php

namespace App\Properties\Status;

use Nicolaslopezj\Searchable\SearchableTrait;

trait StatusPropertable
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
    // protected $table_override = 'statuses';

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
        'is_test' => 'boolean',
        'is_done' => 'boolean',
    ];


    // protected $guarded_override = [];
    public $fillable_override = [
        'workspace_id',
        'user_id',
        'name',
        'color',
        'position',
        'is_test',
        'is_done',
    ];

    /** attributes allowed sort from db by request parameter */
    public $sortable = [
        'id',
        'workspace_id',
        'user_id',
        'name',
        'color',
        'position',
        'is_test',
        'is_done',
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
        'workspace_id',
        'user_id',
        'name',
        'color',
        'position',
        'is_test',
        'is_done',
        'user.name',
        'workspace.name',
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
            'statuses.name' => 10,
            'statuses.phone' => 10,
            'statuses.email' => 5,
        ],
        'joins' => [
            'posts' => ['statuses.id', 'posts.user_id'],
        ],
    ];
}
