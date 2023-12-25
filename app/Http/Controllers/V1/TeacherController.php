<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTeacherRequest;
use App\Http\Requests\V1\UpdateTeacherRequest;
use App\Http\Resources\V1\TeacherDetailResource;
use App\Http\Resources\V1\TeacherListResource;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = QueryBuilder::for(Teacher::class)
            ->allowedFilters('name', 'email', 'gender')
            ->defaultSort('name')
            ->allowedSorts('name', 'email')
            ->latest()
            ->jsonPaginate();

        return TeacherListResource::collection($teachers)->additional([
            'message' => 'Success to get all teachers',
        ]);
    }

    public function store(StoreTeacherRequest $request)
    {
        $validatedData = $request->validated();

        $dateOfBirth = strtotime($request->date_of_birth);
        $validatedData['password'] = date('dmY', $dateOfBirth);

        if ($request->profile_picture) {
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('teacher-profile-picture');
        }

        $teacher = Teacher::create($validatedData);

        return (new TeacherDetailResource($teacher))
            ->additional([
                'message' => 'Success to create teacher',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function show(Teacher $teacher)
    {
        return (new TeacherDetailResource($teacher))
            ->additional([
                'message' => 'Success to get teacher',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $validatedData = $request->validated();

        if ($teacher->profile_picture) {
            Storage::delete('teacher-profile-picture/'.$teacher->profile_picture);
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('teacher-profile-picture');
        }

        $teacher->update($validatedData);

        return (new TeacherDetailResource($teacher))
            ->additional([
                'message' => 'Success to update teacher',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->profile_picture) {
            Storage::delete('teacher-profile-picture/'.$teacher->profile_pic);
        }
        $teacher->delete();

        return (new TeacherDetailResource($teacher))
            ->additional([
                'message' => 'Success to delete teacher',
            ])
            ->response()
            ->setStatusCode(200);
    }
}
