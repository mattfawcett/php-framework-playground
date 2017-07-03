<?php
namespace App\Http\Controllers;

use App\User;
use App\UserRepository;
use Framework\Http\BaseController;
use Framework\Http\Response;
use Framework\Http\Request;

/**
 * A controller for handling CRUD operations on users. All responses are
 * returned as Json
 */
class UsersController extends BaseController
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * List all users
     * GET /users
     */
    public function index() : Response
    {
        $users = $this->repo->all();
        return $this->jsonResponse($users);
    }

    /**
     * Show a single user
     * GET /users/:id
     *
     * @param int $id The id of the user in the database
     */
    public function show($id) : Response
    {
        $user = $this->repo->findOrFail($id);
        return $this->jsonResponse($user);
    }

    /**
     * Create a new user
     * POST /users
     *
     * @param Framework\Http\Request object containing the post parameters
     */
    public function store(Request $request) : Response
    {
        $user = new User;
        $user->fill($request->all());
        if ($user->isValid()) {
            $this->repo->create($user);
            return $this->jsonResponse($user, 201);
        } else {
            return $this->jsonResponse([
                'errors' => $user->getErrors(),
            ], 422);
        }
    }

    /**
     * Update an existing user
     * PATCH /users/:id
     *
     * @param int $id The id of the user in the database
     * @param Framework\Http\Request object containing the patch parameters
     */
    public function update($id, Request $request) : Response
    {
        $user = $this->repo->findOrFail($id);
        $user->fill($request->all());
        if ($user->isValid()) {
            $this->repo->update($user);
            return $this->jsonResponse($user);
        } else {
            return $this->jsonResponse([
                'errors' => $user->getErrors(),
            ], 422);
        }
    }

    /**
     * Delete an existing user
     * DELETE /users/:id
     *
     * @param int $id The id of the user in the database
     */
    public function destroy($id) : Response
    {
        $this->repo->remove($id);
        return $this->jsonResponse([], 204);
    }
}
