<?php
namespace App\Http\Controllers;

use App\UserRepository;
use Framework\Http\BaseController;

class UsersController extends BaseController
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $users = $this->repo->all();
        $this->jsonResponse($users);
    }

    public function show($id)
    {
        $user = $this->repo->find($id);
        $this->jsonResponse($user);
    }
}
