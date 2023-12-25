<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateProfileRequest;
use Storage;

class ProfileController extends Controller
{
    public function updateProfilePicture(UpdateProfileRequest $request)
    {
        if ($request->user()->profile_picture) {
            if ($request->user()->tokenCan('admin')) {
                Storage::delete('admin-profile-picture/'.$request->user()->profile_picture);
                $request->user()->update([
                    'profile_picture' => $request->file('profile_picture')->store('admin-profile-picture'),
                ]);
            }

            if ($request->user()->tokenCan('student')) {
                Storage::delete('student-profile-picture/'.$request->user()->profile_picture);
                $request->user()->update([
                    'profile_picture' => $request->file('profile_picture')->store('student-profile-picture'),
                ]);
            }

            if ($request->user()->tokenCan('teacher')) {
                Storage::delete('teacher-profile-picture/'.$request->user()->profile_picture);
                $request->user()->update([
                    'profile_picture' => $request->file('profile_picture')->store('teacher-profile-picture'),
                ]);
            }
        }
    }
}
