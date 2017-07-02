<?php
namespace App;

use Framework\DB\Repository;

/**
 * A repository for retrieving and persisting User models from the database
 */
class UserRepository extends Repository
{
    /**
     * The name of the MySql table
     */
    public $table = 'users';

    /**
     * The class of model that this repository deals with
     */
    public $modelClass = User::class;
}
