<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        $request->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(["message" => "success to change password"]);
    }
}
