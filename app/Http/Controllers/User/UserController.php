<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return $this->showAll($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ];

        $this->validate($request,$rules);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['admin'] = User::REGULAR_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $user = User::creat($data);
        return $this->showOne($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::findOrFail($id);
        return $this->showOne($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::findOrFail($id);
        $rules = [
            'email'=>'email|unique:users,email,'.$user->id,
            'password'=>'min:6|confirmed',
            'admin'=>'in:' .User::REGULAR_USER.','.User::ADMIN_USER,
        ];


        if($request->has('name'))
        {
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email != $request->email)
        {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if($request->has('password'))
        {
            $user->password = bcrypt($request->password);
        }

        if($request->has('admin'))
        {
            if(!$user->isVerified())
            {
                return  $this->errorResponse('Only verified user can update admin filed');
            }
            $user->admin = $request->admin;
        }

        if(!$user->isDirty())
        {
            return $this->errorResponse('You need to specify a different value to update.');
        }
        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['data'=>$user],200);
    }

    public function verify($token)
    {
        $user = User::where('verification_token',$token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();

        return $this->showMessage('The account has been verified.');
    }

    public function resend(User $user)
    {
        if($user->isVerified())
        {
            return $this->showMessage('User is already verified');
        }

        retry(5,function ()use ($user){Mail::to($user)->send(new UserCreated($user));
        },100);
        return $this->showMessage('Verification sent.');
    }
}
