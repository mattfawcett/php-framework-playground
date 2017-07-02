<?php
namespace App\Http\Controllers;

use App\UserRepository;
use Framework\Http\BaseController;
use Framework\Http\Response;

class UsersController extends BaseController
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index() : Response
    {
        $users = $this->repo->all();
        return $this->jsonResponse($users);
    }

    public function show($id) : Response
    {
        $user = $this->repo->findOrFail($id);
        return $this->jsonResponse($user);
    }
}
