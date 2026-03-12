<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;


class UserController extends Controller
{
    public function store(UserRequest $request)
    {

        $validation = $request->user()->fill($request->validated());

        if ($validation) {

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return response()->json(['status' => 'store success']);

        }




    }

    public function show()
    {
        // return response()->json(['message' => 'get all users ✔️']);
    }

    public function getById()
    {
        return 'get user by id ✔️';
    }
    public function update()
    {
        return 'user is updated ✔️';
    }
    public function delete()
    {
        return 'user is deleted ✔️';
    }
}
