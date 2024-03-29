<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersController extends ApiController
{
    public function __construct()
    {
        $this->middleware("client.credentials")->only(["index", "store", "show", "resend"]);
        $this->middleware("auth:api")->only(["update", "destroy"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerficationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'email' => 'email|unique:users,email,'.$user->id,
            'password' => 'min:8|confirmed',
            'admin' => 'in:'. User::REGULAR_USER . ',' . User::ADMIN_USER,
        ];

        $this->validate($request, $rules);

        if($request->has('name')) {
            $user->name = $request->name;
        }

        if($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if($request->has('email')) {
            if($request->email != $user->email) {
                $user->email = $request->email;
                $user->verified = User::UNVERIFIED_USER;
                $user->verification_token = User::generateVerficationCode();
                $user->admin = User::REGULAR_USER;
            }
        }

        if($request->has('admin')) {
            if(!$user->isVerified()) {
                return $this->errorResponse('Only verified user can be admins!', 409);
            }
        }

        if(!$user->isDirty()) {
            return $this->errorResponse('You need to update some data!', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user, 204);
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();
        return $this->showMessage("The account has been verified!");
    }

    public function resend(User $user)
    {
        if($user->isVerified()) {
            return $this->errorResponse('You are already verified!', 409);
        }

        retry(5, function () use($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 250);

        return $this->showMessage('Email Sent!');
    }
}
