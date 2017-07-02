<?php
namespace App\Http\Controllers;

use App\UserRepository;

class UsersController
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $users = $this->repo->all();
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function show($id)
    {
        $user = $this->repo->find($id);
        header('Content-Type: application/json');
        echo json_encode($user);
    }
}
