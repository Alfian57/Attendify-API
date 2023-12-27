<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateProfilePicture(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $token = $user->tokenCan('admin') ? 'admin' : ($user->tokenCan('student') ? 'student' : 'teacher');
        $directory = $token . '-profile-picture';

        if ($user->profile_picture) {
            Storage::delete($directory . '/' . $user->profile_picture);
        }

        if ($request->profile_picture) {
            $user->update([
                'profile_picture' => $request->file('profile_picture')->store($directory),
            ]);
        } else {
            $user->update([
                'profile_picture' => null,
            ]);
        }

        return response()->json(["message" => "success to update profile picture"]);
    }
}
