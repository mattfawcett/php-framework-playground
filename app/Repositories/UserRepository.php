<?php

namespace App;

use Framework\DB\Repository;

class UserRepository extends Repository
{
    public $table = 'users';
    public $modelClass = User::class;
}
