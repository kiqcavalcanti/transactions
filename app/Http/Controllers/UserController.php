<?php


namespace App\Http\Controllers;

use App\Domain\Entities\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Transformers\UserTransformer;
use App\Services\UserService;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends BaseController
{
    /**
     * UserController constructor.
     * @param UserService $service
     * @param UserTransformer $transformer
     */
    public function __construct(UserService $service, UserTransformer $transformer)
    {
        $this->authorizeResource(User::class, 'user');

        parent::__construct($service, $transformer);
    }

    public function show(User $user)
    {
        return parent::baseShow($user);
    }

    /**
     * @param UserStoreRequest $request
     * @return mixed
     */
    public function store(UserStoreRequest $request)
    {
        return $this->response($this->getService()->create($request->all()));
    }

    /**
     * @param User $user
     * @param UserUpdateRequest $request
     * @return mixed
     */
    public function update(User $user, UserUpdateRequest $request)
    {
        return $this->response($this->getService()->update($user, $request->all()));
    }

}
