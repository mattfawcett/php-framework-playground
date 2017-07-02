<?php
namespace App\Http\Controllers;

use App\User;
use App\UserRepository;
use Framework\Http\BaseController;
use Framework\Http\Response;
use Framework\Http\Request;

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

    public function store(Request $request) : Response
    {
        $user = new User;
        $user->fill($request->all());
        if($user->isValid()) {
            $this->repo->create($user);
            return $this->jsonResponse($user, 201);
        } else {
            return $this->jsonResponse([
                'errors' => $user->getErrors(),
            ], 422);
        }
    }

    public function update($id, Request $request) : Response
    {
        $user = $this->repo->findOrFail($id);
        $user->fill($request->all());
        if($user->isValid()) {
            $this->repo->update($user);
            return $this->jsonResponse($user);
        } else {
            return $this->jsonResponse([
                'errors' => $user->getErrors(),
            ], 422);
        }
    }

    public function destroy($id) : Response
    {
        $this->repo->remove($id);
        return $this->jsonResponse([], 204);
    }
}
