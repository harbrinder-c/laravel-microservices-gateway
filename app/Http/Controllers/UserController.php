<?php

namespace App\Http\Controllers;

use App\User;
use App\Traits\ApiResponser;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\Request;
use phpseclib\Crypt\Hash;

class UserController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return the list of users
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return $this->validResponse($users);
    }

    /**
     * Create new user
     * @return Response
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = \Illuminate\Support\Facades\Hash::make($request->password);

        $user = User::create($fields);

        return $this->validResponse($user, Response::HTTP_CREATED);

    }

    /**
     * Obtains and show one user
     * @return Response
     */
    public function show($user)
    {
        $user = User::findOrFail($user);

        return $this->validResponse($user);
    }

    /**
     * Update an existing user
     * @return Response
     */
    public function update(\Illuminate\Http\Request $request, $user)
    {
        $rules = [
            'name' => 'max:255',
            'email' => 'email|unique:users,email,'.$user,
            'password' => 'min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($user);

        $user->fill($request->all());

        if($request->has('password'))
        {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if($user->isClean())
        {
            return $this->errorResponse('At least one change is required', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->validResponse($user, Response::HTTP_CREATED);
    }

    /**
     * delete an user
     * @return Response
     */
    public function destroy($user)
    {
        $user = User::findOrFail($user);

        $user->delete();

        $this->validResponse($user);
    }

    /**
     * Identify user from request
     * @return Response
     */
    public function me(\Illuminate\Http\Request $request)
    {
        return $this->validResponse($request->user());
    }
}
