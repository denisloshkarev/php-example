<?php

namespace App\Http\Controllers;


use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserProfileResource;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return response()->json(new UserProfileResource(auth()->user()));
    }

    public function update(UpdateProfileRequest $request)
    {
        auth()->user()->update($request->validated());
        return response()->json(new UserProfileResource(auth()->user()));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        if(!Hash::check($request->get('old_password'), auth()->user()->password)) {
            throw new \Exception('Invalid old password');
        }

        auth()->user()->update([
            'password' => $request->get('new_password')
        ]);

        return response()->json([
            'status' => 'success'
        ]);

    }
}
