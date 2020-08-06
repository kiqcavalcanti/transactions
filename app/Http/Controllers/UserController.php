<?php


namespace App\Http\Controllers;

use App\Domain\Entities\User;
use App\Http\Transformers\UserTransformer;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct(UserService $service, UserTransformer $transformer)
    {
        $this->authorizeResource(User::class, 'user');
        parent::__construct($service, $transformer);
    }

    public function show(User $user)
    {
        return $this->response($user);
    }

    public function store(Request $request)
    {
        return $this->response($this->getService()->create($request->all()));
    }

    public function update(User $user, Request $request)
    {
        return $this->response($this->getService()->update($user, $request->all()));
    }
}
