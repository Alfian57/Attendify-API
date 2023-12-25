<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreClassroomRequest;
use App\Http\Requests\V1\UpdateClassroomRequest;
use App\Http\Resources\V1\ClassroomDetailResource;
use App\Http\Resources\V1\ClassroomListResource;
use App\Models\Classroom;
use Spatie\QueryBuilder\QueryBuilder;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = QueryBuilder::for(Classroom::class)
            ->allowedFilters('name')
            ->defaultSort('name')
            ->allowedSorts('name')
            ->latest()
            ->with('teacher')
            ->jsonPaginate();

        return ClassroomListResource::collection($classrooms)->additional([
            'message' => 'Success to get all classrooms',
        ]);
    }

    public function store(StoreClassroomRequest $request)
    {
        $classroom = Classroom::create($request->validated());

        return (new ClassroomDetailResource($classroom))
            ->additional([
                'message' => 'Success to create classroom',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Classroom $classroom)
    {
        return (new ClassroomDetailResource($classroom))
            ->additional([
                'message' => 'Success to get classroom',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function update(UpdateClassroomRequest $request, Classroom $classroom)
    {
        $classroom->update($request->validated());

        return (new ClassroomDetailResource($classroom))
            ->additional([
                'message' => 'Success to update classroom',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return (new ClassroomDetailResource($classroom))
            ->additional([
                'message' => 'Success to delete classroom',
            ])
            ->response()
            ->setStatusCode(200);
    }
}
