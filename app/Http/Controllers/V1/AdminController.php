<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreAdminRequest;
use App\Http\Requests\V1\UpdateAdminRequest;
use App\Http\Resources\V1\AdminDetailResource;
use App\Http\Resources\V1\AdminListResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class AdminController extends Controller
{
    public function index()
    {
        $admins = QueryBuilder::for(Admin::class)
            ->allowedFilters('name', 'email', 'gender')
            ->defaultSort('name')
            ->allowedSorts('name', 'email')
            ->latest()
            ->jsonPaginate();

        return AdminListResource::collection($admins)->additional([
            'message' => 'Success to get all admins',
        ]);
    }

    public function store(StoreAdminRequest $request)
    {
        $validatedData = $request->validated();

        $dateOfBirth = strtotime($request->date_of_birth);
        $validatedData['password'] = date('dmY', $dateOfBirth);

        if ($request->profile_picture) {
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('admin-profile-picture');
        }

        $admin = Admin::create($validatedData);

        return (new AdminDetailResource($admin))
            ->additional([
                'message' => 'Success to create admin',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function show(Admin $admin)
    {
        return (new AdminDetailResource($admin))
            ->additional([
                'message' => 'Success to get admin',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $validatedData = $request->validated();

        if ($admin->profile_picture) {
            Storage::delete('admin-profile-picture/'.$admin->profile_picture);
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('admin-profile-picture');
        }

        $admin->update($validatedData);

        return (new AdminDetailResource($admin))
            ->additional([
                'message' => 'Success to update admin',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Admin $admin)
    {
        if ($admin->profile_picture) {
            Storage::delete('admin-profile-picture/'.$admin->profile_pic);
        }

        $admin->delete();

        return (new AdminDetailResource($admin))
            ->additional([
                'message' => 'Success to delete admin',
            ])
            ->response()
            ->setStatusCode(200);
    }
}
