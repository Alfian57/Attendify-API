<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreStudentRequest;
use App\Http\Requests\V1\UpdateStudentRequest;
use App\Http\Resources\V1\StudentDetailResource;
use App\Http\Resources\V1\StudentListResource;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class StudentController extends Controller
{
    public function index()
    {
        $students = QueryBuilder::for(Student::class)
            ->allowedFilters('name', 'email', 'gender')
            ->defaultSort('name')
            ->allowedSorts('name', 'email')
            ->latest()
            ->jsonPaginate();

        return StudentListResource::collection($students)->additional([
            'message' => 'Success to get all students',
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        $validatedData = $request->validated();

        $dateOfBirth = strtotime($request->date_of_birth);
        $validatedData['password'] = date('dmY', $dateOfBirth);

        if ($request->profile_picture) {
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('student-profile-picture');
        }

        $student = Student::create($validatedData);

        return (new StudentDetailResource($student))
            ->additional([
                'message' => 'Success to create student',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function show(Student $student)
    {
        return (new StudentDetailResource($student))
            ->additional([
                'message' => 'Success to get student',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validatedData = $request->validated();

        if ($student->profile_picture) {
            Storage::delete('student-profile-picture/'.$student->profile_picture);
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('student-profile-picture');
        }

        $student->update($validatedData);

        return (new StudentDetailResource($student))
            ->additional([
                'message' => 'Success to update student',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Student $student)
    {
        if ($student->profile_picture) {
            Storage::delete('student-profile-picture/'.$student->profile_picture);
        }
        $student->delete();

        return (new StudentDetailResource($student))
            ->additional([
                'message' => 'Success to delete student',
            ])
            ->response()
            ->setStatusCode(200);
    }
}
